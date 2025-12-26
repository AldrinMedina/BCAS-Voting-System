<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// Log the start of the script
error_log("=== Import Voters Process Started ===");
error_log("POST data: " . print_r($_POST, true));

try {
    // Include session file
    include 'includes/session.php';
    
    header('Content-Type: application/json');
    
    // Check if user is logged in as admin
    if (!isset($_SESSION['admin'])) {
        error_log("ERROR: Unauthorized access attempt");
        echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
        exit();
    }
    
    error_log("User authorized. Checking request parameters...");
    
    if (!isset($_POST['session_id']) || !isset($_POST['import_type'])) {
        error_log("ERROR: Missing required parameters");
        echo json_encode(['success' => false, 'message' => 'Invalid request parameters.']);
        exit();
    }
    
    $sessionId = $_POST['session_id'];
    $importType = $_POST['import_type']; // 'new_only' or 'all'
    
    error_log("Session ID: $sessionId, Import Type: $importType");
    
    // Get import data from session
    if (!isset($_SESSION['import_data'][$sessionId])) {
        error_log("ERROR: Import session not found. Available sessions: " . print_r(array_keys($_SESSION['import_data'] ?? []), true));
        echo json_encode(['success' => false, 'message' => 'Import session expired. Please upload the file again.']);
        exit();
    }
    
    $importData = $_SESSION['import_data'][$sessionId];
    $validData = $importData['valid_data'];
    
    error_log("Found import data with " . count($validData) . " valid records");
    
    if (empty($validData)) {
        error_log("ERROR: No valid data to import");
        echo json_encode(['success' => false, 'message' => 'No valid data to import.']);
        exit();
    }
    
    // Check database connection
    if (!isset($conn) || $conn === null) {
        error_log("ERROR: Database connection not available");
        echo json_encode(['success' => false, 'message' => 'Database connection error.']);
        exit();
    }
    
    error_log("Starting database transaction...");
    $conn->autocommit(FALSE); // Start transaction for MySQLi
    
    $imported = 0;
    $updated = 0;
    $skipped = 0;
    
    // Prepare statements - FIXED: Corrected parameter binding
    $insertStmt = $conn->prepare("
        INSERT INTO voters (voters_id, password, firstname, lastname, year, course, voted, status, otp) 
        VALUES (?, ?, ?, ?, ?, ?, 0, 1, ?)
    ");
    
    if (!$insertStmt) {
        error_log("ERROR: Failed to prepare insert statement: " . $conn->error);
        throw new Exception("Failed to prepare insert statement: " . $conn->error);
    }
    
    $updateStmt = $conn->prepare("
        UPDATE voters 
        SET password = ?, firstname = ?, lastname = ?, year = ?, course = ?, status = 1, otp = ?
        WHERE voters_id = ?
    ");
    
    if (!$updateStmt) {
        error_log("ERROR: Failed to prepare update statement: " . $conn->error);
        throw new Exception("Failed to prepare update statement: " . $conn->error);
    }
    
    $checkExistingStmt = $conn->prepare("SELECT id FROM voters WHERE voters_id = ?");
    
    if (!$checkExistingStmt) {
        error_log("ERROR: Failed to prepare check existing statement: " . $conn->error);
        throw new Exception("Failed to prepare check existing statement: " . $conn->error);
    }
    
    error_log("Processing " . count($validData) . " records...");
    
    foreach ($validData as $index => $voter) {
        error_log("Processing voter " . ($index + 1) . ": " . $voter['voters_id']);
        
        // Check if voter exists
        $checkExistingStmt->bind_param("s", $voter['voters_id']);
        if (!$checkExistingStmt->execute()) {
            error_log("ERROR: Failed to execute check existing query for voter: " . $voter['voters_id']);
            throw new Exception("Database query failed");
        }
        
        $result = $checkExistingStmt->get_result();
        $exists = $result->fetch_assoc();
        
        if ($exists) {
            // Voter exists
            if ($importType === 'all') {
                // Update existing voter - FIXED: Corrected parameter count and types
                $updateStmt->bind_param("ssssiss", 
                    $voter['password'],
                    $voter['firstname'],
                    $voter['lastname'],
                    $voter['year'],
                    $voter['course'],
                    $voter['otp'],
                    $voter['voters_id']
                );
                
                if (!$updateStmt->execute()) {
                    error_log("ERROR: Failed to update voter: " . $voter['voters_id'] . " - " . $updateStmt->error);
                    throw new Exception("Failed to update voter: " . $voter['voters_id']);
                }
                
                $updated++;
                error_log("Updated voter: " . $voter['voters_id']);
            } else {
                // Skip existing voter
                $skipped++;
                error_log("Skipped existing voter: " . $voter['voters_id']);
            }
        } else {
            // Insert new voter - FIXED: Corrected parameter count and types
            $insertStmt->bind_param("ssssiss",
                $voter['voters_id'],
                $voter['password'],
                $voter['firstname'],
                $voter['lastname'],
                $voter['year'],
                $voter['course'],
                $voter['otp']
            );
            
            if (!$insertStmt->execute()) {
                error_log("ERROR: Failed to insert voter: " . $voter['voters_id'] . " - " . $insertStmt->error);
                throw new Exception("Failed to insert voter: " . $voter['voters_id']);
            }
            
            $imported++;
            error_log("Inserted new voter: " . $voter['voters_id']);
        }
    }
    
    error_log("Committing transaction...");
    $conn->commit();
    
    // Clean up session data
    unset($_SESSION['import_data'][$sessionId]);
    error_log("Cleaned up session data");
    
    // Log the import activity
    $logMessage = "Bulk import completed - Imported: $imported, Updated: $updated, Skipped: $skipped";
    error_log($logMessage);
    
    echo json_encode([
        'success' => true,
        'message' => 'Import completed successfully.',
        'imported' => $imported,
        'updated' => $updated,
        'skipped' => $skipped
    ]);
    
} catch (Exception $e) {
    error_log("EXCEPTION: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
    
    if (isset($conn) && $conn !== null) {
        try {
            $conn->rollback();
            error_log("Transaction rolled back");
        } catch (Exception $rollbackException) {
            error_log("ERROR: Failed to rollback transaction: " . $rollbackException->getMessage());
        }
    }
    
    echo json_encode([
        'success' => false, 
        'message' => 'Import failed: ' . $e->getMessage()
    ]);
} catch (Error $e) {
    error_log("FATAL ERROR: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
    
    if (isset($conn) && $conn !== null) {
        try {
            $conn->rollback();
        } catch (Exception $rollbackException) {
            error_log("ERROR: Failed to rollback transaction: " . $rollbackException->getMessage());
        }
    }
    
    echo json_encode([
        'success' => false, 
        'message' => 'Fatal error during import: ' . $e->getMessage()
    ]);
}

error_log("=== Import Voters Process Ended ===");
?>