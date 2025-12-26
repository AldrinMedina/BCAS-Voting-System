<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../includes/session.php';

if (isset($_POST['status'])) {
    $sql = "SELECT * FROM system";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $new_status = $row['status'] == 1 ? 0 : 1; // Toggle the status

            // Update the voter status
            $update_sql = "UPDATE system SET status = ?";
            if ($update_stmt = $conn->prepare($update_sql)) {
                $update_stmt->bind_param("i", $new_status);
                $update_stmt->execute();

                if ($update_stmt->affected_rows > 0) {
                    $_SESSION['success'] = "The status has been changed successfully.";
                    echo json_encode(["success" => "Status updated successfully."]);
                } else {
                    echo json_encode(["error" => "Failed to update status."]);
                }
                $update_stmt->close();
            } else {
                echo json_encode(["error" => "Failed to prepare update SQL statement."]);
            }
        } else {
            echo json_encode(["error" => "No records found for the given ID."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["error" => "Failed to prepare SQL statement."]);
    }
} else {
    echo json_encode(["error" => "ID not set in POST request."]);
}
?>
