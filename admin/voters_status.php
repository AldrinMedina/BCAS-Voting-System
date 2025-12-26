<?php
include 'includes/session.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Fetch the current status of the voter
    $sql = "SELECT * FROM voters WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $new_status = $row['status'] == 1 ? 0 : 1; // Toggle the status

            // Update the voter status
            $update_sql = "UPDATE voters SET status = ? WHERE id = ?";
            if ($update_stmt = $conn->prepare($update_sql)) {
                $update_stmt->bind_param("ii", $new_status, $id);
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
