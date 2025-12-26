<?php
include 'includes/session.php';
if(isset($_POST['id'])){
    $id = $_POST['id'];
    $sql = "SELECT * FROM votes WHERE candidate_id = '$id'";
    $query = $conn->query($sql);
    $data = $query -> num_rows;
    
    echo json_encode($data);
}

?>