
<?php 
include 'includes/session.php';
$error = '';
$sql = "SELECT * FROM votes GROUP BY voters_id";
$query = $conn->query($sql);

$data = $query->num_rows;


echo json_encode($data);

?>