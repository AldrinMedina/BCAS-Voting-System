<?php
// settings/update_voting_status.php
include '../includes/session.php';

header('Content-Type: application/json');

// Check if user is logged in as admin
if (!isset($_SESSION['admin'])) {
    echo json_encode(['error' => 'Unauthorized access.']);
    exit();
}

if (isset($_POST['status'])) {
    $status = (int)$_POST['status'];
    
    try {
        // Update the voting status
        $stmt = $conn->prepare("UPDATE voting_restrictions SET is_active = ?, updated_by = ?, updated_at = NOW() WHERE id = 1");
        $stmt->execute([$status, $_SESSION['admin']]);
        
        if ($stmt->rowCount() > 0) {
            $status_text = $status == 1 ? 'activated' : 'deactivated';
            echo json_encode(['success' => "Voting has been $status_text successfully."]);
        } else {
            echo json_encode(['error' => 'No changes were made.']);
        }
        
    } catch (Exception $e) {
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request.']);
}
?>