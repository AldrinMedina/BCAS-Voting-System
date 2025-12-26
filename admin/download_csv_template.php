<?php
include 'includes/session.php';

// Check if user is logged in as admin
if (!isset($_SESSION['admin']) || trim($_SESSION['admin']) == '') {
    header('location: index.php');
    exit;
}

try {
    // Get years from DB
    $years_stmt = $conn->prepare("SELECT description FROM years ORDER BY description LIMIT 3");
    $years_stmt->execute();
    $years_stmt->bind_result($year_desc);
    $years = [];
    while ($years_stmt->fetch()) {
        $years[] = $year_desc;
    }
    $years_stmt->close();

    // Get courses from DB
    $courses_stmt = $conn->prepare("SELECT description FROM course ORDER BY description LIMIT 3");
    $courses_stmt->execute();
    $courses_stmt->bind_result($course_desc);
    $courses = [];
    while ($courses_stmt->fetch()) {
        $courses[] = $course_desc;
    }
    $courses_stmt->close();

    // Generate filename with timestamp
    $filename = 'voters_import_template_' . date('Y-m-d_H-i-s') . '.csv';

    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Create file pointer connected to the output stream
    $output = fopen('php://output', 'w');

    // Add headers
    fputcsv($output, ['voters_id', 'firstname', 'lastname', 'year', 'course', 'password']);

    // Add sample data
    // $sampleData = [
    //     ['2024001', 'John', 'Doe', $years[0] ?? '1st Year', $courses[0] ?? 'Computer Science', '123456'],
    //     ['2024002', 'Jane', 'Smith', $years[1] ?? '2nd Year', $courses[1] ?? 'Information Technology', 'password123'],
    //     ['2024003', 'Mike', 'Johnson', $years[0] ?? '1st Year', $courses[2] ?? 'Business Administration', '']
    // ];

    // Add dynamic sample data based on fetched years and courses
    $maxRows = min(count($years), count($courses)); // Ensure aligned pairing
    for ($i = 0; $i < $maxRows; $i++) {
        $voterId = '2024' . str_pad($i + 1, 3, '0', STR_PAD_LEFT); // e.g., 2024001
        $firstname = 'SampleFirst' . ($i + 1);
        $lastname = 'SampleLast' . ($i + 1);
        $year = $years[$i];
        $course = $courses[$i];
        $password = 'samplepass' . ($i + 1);

        fputcsv($output, [$voterId, $firstname, $lastname, $year, $course, $password]);
    }

    // foreach ($sampleData as $row) {
    //     fputcsv($output, $row);
    // }

    // Close the file pointer
    fclose($output);

} catch (Exception $e) {
    $_SESSION['error'] = 'Error generating template: ' . $e->getMessage();
    header('location: bulk_import.php');
    exit();
}
?>
