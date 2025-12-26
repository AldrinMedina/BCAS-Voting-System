<?php
// voters/process_csv_upload.php (Alternative to Excel - no Composer required)
include 'includes/session.php';

header('Content-Type: application/json');

// Check if user is logged in as admin
if (!isset($_SESSION['admin'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit();
}

if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
    $error_message = 'No file uploaded or upload error.';
    if (isset($_FILES['csv_file']['error'])) {
        $error_codes = [
            UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize',
            UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE',
            UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'File upload stopped by extension'
        ];
        $error_message .= ' Error: ' . ($error_codes[$_FILES['csv_file']['error']] ?? 'Unknown error');
    }
    echo json_encode(['success' => false, 'message' => $error_message]);
    exit();
}

$uploadedFile = $_FILES['csv_file']['tmp_name'];
$defaultPassword = isset($_POST['default_password']) ? $_POST['default_password'] : '123456';

try {
    // IMPROVED: Better CSV reading with proper UTF-8 encoding handling
    $fileContent = file_get_contents($uploadedFile);
    if ($fileContent === false) {
        echo json_encode(['success' => false, 'message' => 'Could not read the uploaded file.']);
        exit();
    }

    // Remove BOM if present
    $fileContent = str_replace("\xEF\xBB\xBF", '', $fileContent);
    
    // Convert to UTF-8 if needed
    $encoding = mb_detect_encoding($fileContent, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
    if ($encoding && $encoding !== 'UTF-8') {
        $fileContent = mb_convert_encoding($fileContent, 'UTF-8', $encoding);
    }
    
    // Split into lines and parse CSV
    $lines = preg_split('/\r\n|\r|\n/', $fileContent);
    $csvData = [];
    
    foreach ($lines as $line) {
        if (trim($line) !== '') {
            $csvData[] = str_getcsv($line);
        }
    }
    
    if (empty($csvData)) {
        echo json_encode(['success' => false, 'message' => 'The CSV file is empty.']);
        exit();
    }

    // Get header row and find column indices
    $headers = array_map('trim', array_map('strtolower', $csvData[0]));
    
    $requiredColumns = ['voters_id', 'firstname', 'lastname', 'year', 'course'];
    $columnIndices = [];
    
    foreach ($requiredColumns as $col) {
        $index = array_search($col, $headers);
        if ($index === false) {
            echo json_encode(['success' => false, 'message' => "Required column '$col' not found. Please check your CSV file headers."]);
            exit();
        }
        $columnIndices[$col] = $index;
    }
    
    // Optional password column
    $passwordIndex = array_search('password', $headers);
    
    // Get years and courses for validation
    $years_stmt = $conn->prepare("SELECT id, description, y_level FROM years");
    $years_stmt->execute();
    $result = $years_stmt->get_result();

    $years = [];
    while ($row = $result->fetch_assoc()) {
        $years[] = $row;
    }
    $years_stmt->close();

    $year_map = [];
    foreach ($years as $year) {
        $normalizedKey = strtolower(trim($year['y_level']));
        $year_map[$normalizedKey] = $year;
    }

    $courses_stmt = $conn->prepare("SELECT id, description FROM course");
    $courses_stmt->execute();
    $result = $courses_stmt->get_result();

    $courses = [];
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
    $courses_stmt->close();

    $course_map = [];
    foreach ($courses as $course) {
        $course_map[strtolower(trim($course['description']))] = $course;
    }
    
    // Get existing voter IDs for duplicate checking
    $existing_stmt = $conn->prepare("SELECT voters_id FROM voters");
    $existing_stmt->execute();
    $result = $existing_stmt->get_result();

    $existing_ids = [];
    while ($row = $result->fetch_assoc()) {
        $existing_ids[] = strtolower($row['voters_id']);
    }
    $existing_stmt->close();

    $validData = [];
    $errors = [];
    $duplicateCount = 0;
    
    // Process data rows (skip header)
    for ($i = 1; $i < count($csvData); $i++) {
        $row = $csvData[$i];
        $rowNumber = $i + 1;
        $rowErrors = [];
        
        // Skip empty rows
        if (empty(array_filter($row))) {
            continue;
        }
        
        // Extract data with proper UTF-8 handling
        $votersId = isset($row[$columnIndices['voters_id']]) ? trim($row[$columnIndices['voters_id']]) : '';
        $firstname = isset($row[$columnIndices['firstname']]) ? trim($row[$columnIndices['firstname']]) : '';
        $lastname = isset($row[$columnIndices['lastname']]) ? trim($row[$columnIndices['lastname']]) : '';
        $yearText = isset($row[$columnIndices['year']]) ? trim($row[$columnIndices['year']]) : '';
        $courseText = isset($row[$columnIndices['course']]) ? trim($row[$columnIndices['course']]) : '';
        $password = ($passwordIndex !== false && isset($row[$passwordIndex]) && trim($row[$passwordIndex])) ? 
                   trim($row[$passwordIndex]) : $defaultPassword;
        $otp = random_int(100000, 999999);
        
        // DEBUG: Log the names to check encoding
        error_log("Processing names - First: '$firstname', Last: '$lastname'");
        error_log("First name bytes: " . bin2hex($firstname));
        error_log("Last name bytes: " . bin2hex($lastname));
        
        // Validate required fields
        if (empty($votersId)) {
            $rowErrors[] = 'Voter ID is required';
        }
        if (empty($firstname)) {
            $rowErrors[] = 'First name is required';
        }
        if (empty($lastname)) {
            $rowErrors[] = 'Last name is required';
        }
        if (empty($yearText)) {
            $rowErrors[] = 'Year is required';
        }
        if (empty($courseText)) {
            $rowErrors[] = 'Course is required';
        }
        
        // Validate year
        $yearId = null;
        $yearName = '';
        if (!empty($yearText)) {
            $yearKey = strtolower(trim($yearText));
            if (isset($year_map[$yearKey])) {
                $yearId = $year_map[$yearKey]['id'];
                $yearName = $year_map[$yearKey]['description'];
                $year_level = $year_map[$yearKey]['y_level'];
            } else {
                $rowErrors[] = "Year '$yearText' not found in system";
            }
        }
        
        // Validate course
        $courseId = null;
        $courseName = '';
        if (!empty($courseText)) {
            $courseKey = strtolower(trim($courseText));
            if (isset($course_map[$courseKey])) {
                $courseId = $course_map[$courseKey]['id'];
                $courseName = $course_map[$courseKey]['description'];
            } else {
                $rowErrors[] = "Course '$courseText' not found in system";
            }
        }
        
        // Check for duplicate voter ID
        $isDuplicate = in_array(strtolower($votersId), $existing_ids);
        if ($isDuplicate) {
            $duplicateCount++;
        }
        
        // Validate voter ID format
        if (!empty($votersId) && !preg_match('/^[a-zA-Z0-9\-_]+$/', $votersId)) {
            $rowErrors[] = 'Voter ID contains invalid characters (only letters, numbers, hyphens, and underscores allowed)';
        }
        
        // IMPROVED: More comprehensive name validation that accepts Unicode letters
        if (!empty($firstname)) {
            // Allow Unicode letters, spaces, dots, hyphens, apostrophes
            if (!preg_match('/^[\p{L}\p{M}\s\.\-\']+$/u', $firstname)) {
                $rowErrors[] = "First name '$firstname' contains invalid characters";
                error_log("First name validation failed for: '$firstname'");
            }
        }
        if (!empty($lastname)) {
            // Allow Unicode letters, spaces, dots, hyphens, apostrophes
            if (!preg_match('/^[\p{L}\p{M}\s\.\-\']+$/u', $lastname)) {
                $rowErrors[] = "Last name '$lastname' contains invalid characters";
                error_log("Last name validation failed for: '$lastname'");
            }
        }
        
        if (!empty($rowErrors)) {
            $errors[] = [
                'row' => $rowNumber,
                'message' => implode(', ', $rowErrors)
            ];
        } else {
            $validData[] = [
                'voters_id' => $votersId,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'year' => $yearId,
                'year_name' => $yearName,
                'course' => $courseId,
                'course_name' => $courseName,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'is_duplicate' => $isDuplicate,
                'row_number' => $rowNumber,
                'otp'=> $otp
            ];
        }
    }
    
    // Store data in session for later import
    $sessionId = uniqid('import_', true);
    $_SESSION['import_data'][$sessionId] = [
        'valid_data' => $validData,
        'timestamp' => time()
    ];
    
    // Clean up old import sessions
    if (isset($_SESSION['import_data'])) {
        foreach ($_SESSION['import_data'] as $key => $data) {
            if (time() - $data['timestamp'] > 3600) { // 1 hour
                unset($_SESSION['import_data'][$key]);
            }
        }
    }
    
    $summary = [
        'total_rows' => count($csvData) - 1,
        'valid_records' => count($validData),
        'invalid_records' => count($errors),
        'duplicates' => $duplicateCount
    ];
    
    echo json_encode([
        'success' => true,
        'data' => [
            'summary' => $summary,
            'errors' => $errors,
            'valid_data' => $validData,
            'session_id' => $sessionId
        ]
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => 'Error processing file: ' . $e->getMessage()
    ]);
}
?>