<?php
include 'includes/conn.php';
$sql = "SELECT * FROM party";
$query = $conn->query($sql);

$data = [];

if ($query->num_rows > 0) {
    while($row = $query->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

?>