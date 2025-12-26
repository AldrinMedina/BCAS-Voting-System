<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$description = $_POST['partylist'];

		$sql = "SELECT * FROM party";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		
		$sql = "INSERT INTO party (partylist) VALUES ('$description')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Party List added successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}

	}
	else{
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: partylist.php');
?>