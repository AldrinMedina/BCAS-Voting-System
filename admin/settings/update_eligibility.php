<?php
// settings/update_eligibility.php
include '../includes/session.php';

if(isset($_POST['save_eligibility'])){
    // Check if user is super admin
    if (!isset($_SESSION['superAdmin']) || trim($_SESSION['superAdmin']) == '') {
        $_SESSION['error'] = 'Unauthorized access. Please sign in as super admin.';
        header('location: ../settings.php');
        exit();
    }

    try {
        $conn->beginTransaction();

        // Handle year restrictions
        $year_restriction = $_POST['year_restriction'];
        if ($year_restriction === 'all') {
            $allowed_years = 'all';
        } else {
            if (!isset($_POST['allowed_years']) || empty($_POST['allowed_years'])) {
                throw new Exception('Please select at least one year level.');
            }
            $allowed_years = json_encode($_POST['allowed_years']);
        }

        // Handle course restrictions
        $course_restriction = $_POST['course_restriction'];
        if ($course_restriction === 'all') {
            $allowed_courses = 'all';
        } else {
            if (!isset($_POST['allowed_courses']) || empty($_POST['allowed_courses'])) {
                throw new Exception('Please select at least one course.');
            }
            $allowed_courses = json_encode($_POST['allowed_courses']);
        }

        // Update the voting restrictions
        $stmt = $conn->prepare("UPDATE voting_restrictions SET allowed_years = ?, allowed_courses = ?, updated_by = ?, updated_at = NOW() WHERE id = 1");
        $stmt->execute([$allowed_years, $allowed_courses, $_SESSION['superAdmin']]);

        // Log the changes for audit trail
        $log_message = "Voting eligibility updated - Years: " . ($year_restriction === 'all' ? 'All' : 'Specific') . 
                      ", Courses: " . ($course_restriction === 'all' ? 'All' : 'Specific');
        
        // You can add audit logging here if needed
        // $audit_stmt = $conn->prepare("INSERT INTO audit_log (admin_id, action, details, timestamp) VALUES (?, 'eligibility_update', ?, NOW())");
        // $audit_stmt->execute([$_SESSION['admin'], $log_message]);

        $conn->commit();

        // Calculate affected voters
        $count_query = "SELECT COUNT(*) as total FROM voters WHERE status = 1";
        $conditions = [];
        $params = [];

        if ($allowed_years !== 'all') {
            $year_ids = json_decode($allowed_years, true);
            $placeholders = str_repeat('?,', count($year_ids) - 1) . '?';
            $conditions[] = "year IN ($placeholders)";
            $params = array_merge($params, $year_ids);
        }

        if ($allowed_courses !== 'all') {
            $course_ids = json_decode($allowed_courses, true);
            $placeholders = str_repeat('?,', count($course_ids) - 1) . '?';
            $conditions[] = "course IN ($placeholders)";
            $params = array_merge($params, $course_ids);
        }

        if (!empty($conditions)) {
            $count_query .= " AND " . implode(' AND ', $conditions);
        }

        $count_stmt = $conn->prepare($count_query);
        $count_stmt->execute($params);
        $eligible_count = $count_stmt->fetch()['total'];

        $_SESSION['success'] = "Voting eligibility updated successfully! $eligible_count students are now eligible to vote.";

    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error'] = $e->getMessage();
    }
} else {
    $_SESSION['error'] = 'Invalid request.';
}

header('location: ../settings.php');
exit();
?>