<?php
// includes/voting_eligibility.php
// Include this file in your voting pages to check eligibility

/**
 * Check if voting is currently active
 */
function isVotingActive($conn) {
    try {
        $stmt = $conn->prepare("SELECT is_active FROM voting_restrictions WHERE id = 1");
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? (bool)$result['is_active'] : false;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Check if a voter is eligible based on current restrictions
 */
function isVoterEligible($conn, $voter_id) {
    try {
        // Get voter information
        $voter_stmt = $conn->prepare("SELECT year, course, status FROM voters WHERE id = ? AND status = 1");
        $voter_stmt->execute([$voter_id]);
        $voter = $voter_stmt->fetch();
        
        if (!$voter) {
            return ['eligible' => false, 'reason' => 'Voter not found or inactive'];
        }

        // Get voting restrictions
        $restrictions_stmt = $conn->prepare("SELECT * FROM voting_restrictions WHERE id = 1");
        $restrictions_stmt->execute();
        $restrictions = $restrictions_stmt->fetch();
        
        if (!$restrictions) {
            return ['eligible' => false, 'reason' => 'Voting system not configured'];
        }

        // Check if voting is active
        if (!$restrictions['is_active']) {
            return ['eligible' => false, 'reason' => 'Voting is currently inactive'];
        }

        // Check year eligibility
        if ($restrictions['allowed_years'] !== 'all') {
            $allowed_years = json_decode($restrictions['allowed_years'], true);
            if (!in_array($voter['year'], $allowed_years)) {
                return ['eligible' => false, 'reason' => 'Your year level is not eligible to vote'];
            }
        }

        // Check course eligibility
        if ($restrictions['allowed_courses'] !== 'all') {
            $allowed_courses = json_decode($restrictions['allowed_courses'], true);
            if (!in_array($voter['course'], $allowed_courses)) {
                return ['eligible' => false, 'reason' => 'Your course is not eligible to vote'];
            }
        }

        return ['eligible' => true, 'reason' => 'Eligible to vote'];

    } catch (Exception $e) {
        return ['eligible' => false, 'reason' => 'System error: ' . $e->getMessage()];
    }
}

/**
 * Get detailed eligibility information for display
 */
function getEligibilityInfo($conn) {
    try {
        $restrictions_stmt = $conn->prepare("SELECT * FROM voting_restrictions WHERE id = 1");
        $restrictions_stmt->execute();
        $restrictions = $restrictions_stmt->fetch();
        
        if (!$restrictions) {
            return null;
        }

        $info = [
            'is_active' => (bool)$restrictions['is_active'],
            'allowed_years' => [],
            'allowed_courses' => [],
            'year_text' => '',
            'course_text' => ''
        ];

        // Get year information
        if ($restrictions['allowed_years'] === 'all') {
            $info['year_text'] = 'All year levels are eligible';
            $years_stmt = $conn->prepare("SELECT * FROM years ORDER BY description");
            $years_stmt->execute();
            $info['allowed_years'] = $years_stmt->fetchAll();
        } else {
            $allowed_years = json_decode($restrictions['allowed_years'], true);
            if (!empty($allowed_years)) {
                $placeholders = str_repeat('?,', count($allowed_years) - 1) . '?';
                $years_stmt = $conn->prepare("SELECT * FROM years WHERE id IN ($placeholders) ORDER BY description");
                $years_stmt->execute($allowed_years);
                $info['allowed_years'] = $years_stmt->fetchAll();
                
                $year_names = array_column($info['allowed_years'], 'description');
                $info['year_text'] = 'Eligible year levels: ' . implode(', ', $year_names);
            }
        }

        // Get course information
        if ($restrictions['allowed_courses'] === 'all') {
            $info['course_text'] = 'All courses are eligible';
            $courses_stmt = $conn->prepare("SELECT * FROM course ORDER BY description");
            $courses_stmt->execute();
            $info['allowed_courses'] = $courses_stmt->fetchAll();
        } else {
            $allowed_courses = json_decode($restrictions['allowed_courses'], true);
            if (!empty($allowed_courses)) {
                $placeholders = str_repeat('?,', count($allowed_courses) - 1) . '?';
                $courses_stmt = $conn->prepare("SELECT * FROM course WHERE id IN ($placeholders) ORDER BY description");
                $courses_stmt->execute($allowed_courses);
                $info['allowed_courses'] = $courses_stmt->fetchAll();
                
                $course_names = array_column($info['allowed_courses'], 'description');
                $info['course_text'] = 'Eligible courses: ' . implode(', ', $course_names);
            }
        }

        return $info;

    } catch (Exception $e) {
        return null;
    }
}

/**
 * Display eligibility status message
 */
function displayEligibilityMessage($conn, $voter_id) {
    $eligibility = isVoterEligible($conn, $voter_id);
    $info = getEligibilityInfo($conn);
    
    if (!$info) {
        return '<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> Voting system configuration error.</div>';
    }
    
    if (!$info['is_active']) {
        return '<div class="alert alert-warning">
                    <i class="fa fa-clock-o"></i> 
                    <strong>Voting is currently inactive.</strong><br>
                    Please check back later when voting opens.
                </div>';
    }
    
    if (!$eligibility['eligible']) {
        $message = '<div class="alert alert-danger">
                        <i class="fa fa-ban"></i> 
                        <strong>You are not eligible to vote.</strong><br>
                        Reason: ' . $eligibility['reason'] . '<br><br>
                        <small>
                            <strong>Current voting restrictions:</strong><br>
                            ' . $info['year_text'] . '<br>
                            ' . $info['course_text'] . '
                        </small>
                    </div>';
        return $message;
    }
    
    return '<div class="alert alert-success">
                <i class="fa fa-check"></i> 
                <strong>You are eligible to vote!</strong><br>
                Please proceed to cast your ballot.
            </div>';
}
?>