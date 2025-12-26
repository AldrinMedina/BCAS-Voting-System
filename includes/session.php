<?php
	include 'includes/conn.php';
	session_start();

	if(isset($_SESSION['voter'])){
    $stmnt = $conn->prepare ("SELECT v.*, y.y_level AS y_lvl FROM voters v JOIN years y ON v.year=y.id  WHERE v.id = ?");
    $stmnt->bind_param("s", $_SESSION['voter']);
    $stmnt->execute();
    $query = $stmnt->get_result();

		//$sql = "SELECT * FROM voters WHERE id = '".$_SESSION['voter']."'";
		//$query = $conn->query($sql);
		$voter = $query->fetch_assoc();
	}
	else{
		header('location: index.php');
		exit();
	}

?>