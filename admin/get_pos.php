<?php 
include 'includes/session.php';
$error = '';
$sql = "SELECT * FROM positions ORDER BY priority ASC";
$query = $conn->query($sql);

$data = [];

if ($query->num_rows > 0) {
    while($row = $query->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

?>