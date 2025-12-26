<?php
include 'includes/session.php';
if(isset($_POST["id"])){
    $id = $_POST['id'];
    $sql = "SELECT * FROM candidates WHERE position_id = '$id'";
    $query = $conn->query($sql);
    $data = [];

    if ($query->num_rows > 0) {
        while($row = $query->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
}

?>