<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		$sql = "DELETE FROM votes WHERE voters_id = '$id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Vote cleared successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
		$sql = "UPDATE voters SET voted = false WHERE id = '$id'" ;
		$query= $conn->query($sql);
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

	header('location: votes.php');
	
?>