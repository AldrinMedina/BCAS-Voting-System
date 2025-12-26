<?php
// settings/get_eligible_voters.php
include '../includes/session.php';

header('Content-Type: application/json');

// Check if user is logged in as admin
if (!isset($_SESSION['admin'])) {
    echo json_encode(['error' => 'Unauthorized access.']);
    exit();
}

try {
    // Get current voting restrictions
    $stmt = $conn->prepare("SELECT * FROM voting_restrictions WHERE id = 1");
    $stmt->execute();
    $restrictions = $stmt->fetch();

    if (!$restrictions) {
        echo json_encode(['error' => 'Voting restrictions not found.']);
        exit();
    }

    // Build the base query for eligible voters
    $conditions = ["v.status = 1"]; // Only active voters
    $params = [];

    // Add year restrictions
    if ($restrictions['allowed_years'] !== 'all') {
        $allowed_years = json_decode($restrictions['allowed_years'], true);
        if (!empty($allowed_years)) {
            $placeholders = str_repeat('?,', count($allowed_years) - 1) . '?';
            $conditions[] = "v.year IN ($placeholders)";
            $params = array_merge($params, $allowed_years);
        }
    }

    // Add course restrictions
    if ($restrictions['allowed_courses'] !== 'all') {
        $allowed_courses = json_decode($restrictions['allowed_courses'], true);
        if (!empty($allowed_courses)) {
            $placeholders = str_repeat('?,', count($allowed_courses) - 1) . '?';
            $conditions[] = "v.course IN ($placeholders)";
            $params = array_merge($params, $allowed_courses);
        }
    }

    $where_clause = implode(' AND ', $conditions);

    // Get total eligible voters
    $eligible_query = "SELECT COUNT(*) as total FROM voters v WHERE $where_clause";
    $eligible_stmt = $conn->prepare($eligible_query);
    $eligible_stmt->execute($params);
    $total_eligible = $eligible_stmt->fetch()['total'];

    // Get total registered students
    $total_query = "SELECT COUNT(*) as total FROM voters WHERE status = 1";
    $total_stmt = $conn->prepare($total_query);
    $total_stmt->execute();
    $total_students = $total_stmt->fetch()['total'];

    // Calculate percentage
    $percentage = $total_students > 0 ? round(($total_eligible / $total_students) * 100, 2) : 0;

    // Get year level breakdown
    $year_breakdown = [];
    $years_query = "SELECT y.id, y.description FROM years y ORDER BY y.description";
    $years_stmt = $conn->prepare($years_query);
    $years_stmt->execute();
    $years = $years_stmt->fetchAll();

    foreach ($years as $year) {
        // Total students in this year
        $year_total_query = "SELECT COUNT(*) as total FROM voters WHERE year = ? AND status = 1";
        $year_total_stmt = $conn->prepare($year_total_query);
        $year_total_stmt->execute([$year['id']]);
        $year_total = $year_total_stmt->fetch()['total'];

        // Eligible students in this year
        $year_conditions = $conditions;
        $year_params = $params;
        
        // If year is not already filtered, add it
        if ($restrictions['allowed_years'] === 'all') {
            $year_conditions[] = "v.year = ?";
            $year_params[] = $year['id'];
        } else {
            $allowed_years = json_decode($restrictions['allowed_years'], true);
            if (in_array($year['id'], $allowed_years)) {
                // This year is allowed, get eligible count
                $year_eligible_query = "SELECT COUNT(*) as total FROM voters v WHERE " . implode(' AND ', $conditions) . " AND v.year = ?";
                $year_eligible_stmt = $conn->prepare($year_eligible_query);
                $year_eligible_stmt->execute(array_merge($params, [$year['id']]));
                $year_eligible = $year_eligible_stmt->fetch()['total'];
            } else {
                $year_eligible = 0;
            }
        }

        if ($restrictions['allowed_years'] === 'all') {
            $year_eligible_query = "SELECT COUNT(*) as total FROM voters v WHERE " . implode(' AND ', $year_conditions);
            $year_eligible_stmt = $conn->prepare($year_eligible_query);
            $year_eligible_stmt->execute($year_params);
            $year_eligible = $year_eligible_stmt->fetch()['total'];
        }

        $year_breakdown[] = [
            'id' => $year['id'],
            'description' => $year['description'],
            'eligible' => $year_eligible,
            'total' => $year_total
        ];
    }

    // Get course breakdown
    $course_breakdown = [];
    $courses_query = "SELECT c.id, c.description FROM course c ORDER BY c.description";
    $courses_stmt = $conn->prepare($courses_query);
    $courses_stmt->execute();
    $courses = $courses_stmt->fetchAll();

    foreach ($courses as $course) {
        // Total students in this course
        $course_total_query = "SELECT COUNT(*) as total FROM voters WHERE course = ? AND status = 1";
        $course_total_stmt = $conn->prepare($course_total_query);
        $course_total_stmt->execute([$course['id']]);
        $course_total = $course_total_stmt->fetch()['total'];

        // Eligible students in this course
        if ($restrictions['allowed_courses'] === 'all') {
            $course_conditions = $conditions;
            $course_conditions[] = "v.course = ?";
            $course_params = array_merge($params, [$course['id']]);
            
            $course_eligible_query = "SELECT COUNT(*) as total FROM voters v WHERE " . implode(' AND ', $course_conditions);
            $course_eligible_stmt = $conn->prepare($course_eligible_query);
            $course_eligible_stmt->execute($course_params);
            $course_eligible = $course_eligible_stmt->fetch()['total'];
        } else {
            $allowed_courses = json_decode($restrictions['allowed_courses'], true);
            if (in_array($course['id'], $allowed_courses)) {
                $course_eligible_query = "SELECT COUNT(*) as total FROM voters v WHERE " . implode(' AND ', $conditions) . " AND v.course = ?";
                $course_eligible_stmt = $conn->prepare($course_eligible_query);
                $course_eligible_stmt->execute(array_merge($params, [$course['id']]));
                $course_eligible = $course_eligible_stmt->fetch()['total'];
            } else {
                $course_eligible = 0;
            }
        }

        $course_breakdown[] = [
            'id' => $course['id'],
            'description' => $course['description'],
            'eligible' => $course_eligible,
            'total' => $course_total
        ];
    }

    // Format filter settings for display
    $filter_settings = [
        'is_active' => (bool)$restrictions['is_active']
    ];

    // Format years display
    if ($restrictions['allowed_years'] === 'all') {
        $filter_settings['years'] = 'All Year Levels';
    } else {
        $allowed_years = json_decode($restrictions['allowed_years'], true);
        $year_names = [];
        foreach ($years as $year) {
            if (in_array($year['id'], $allowed_years)) {
                $year_names[] = $year['description'];
            }
        }
        $filter_settings['years'] = implode(', ', $year_names);
    }

    // Format courses display
    if ($restrictions['allowed_courses'] === 'all') {
        $filter_settings['courses'] = 'All Courses';
    } else {
        $allowed_courses = json_decode($restrictions['allowed_courses'], true);
        $course_names = [];
        foreach ($courses as $course) {
            if (in_array($course['id'], $allowed_courses)) {
                $course_names[] = $course['description'];
            }
        }
        $filter_settings['courses'] = implode(', ', $course_names);
    }

    // Return the response
    echo json_encode([
        'total_eligible' => $total_eligible,
        'total_students' => $total_students,
        'percentage' => $percentage,
        'year_breakdown' => $year_breakdown,
        'course_breakdown' => $course_breakdown,
        'filter_settings' => $filter_settings
    ]);

} catch (Exception $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>