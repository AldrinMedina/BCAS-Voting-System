<?php
	include 'includes/session.php';

	$sql = "DELETE FROM candidates";
	if($conn->query($sql)){
		$_SESSION['success'] = "Deleted successfully";
	}
	else{
		$_SESSION['error'] = "Something went wrong in deleting candidates";
	}
    $sql = "DELETE FROM party";
	if($conn->query($sql)){
		$_SESSION['success'] = "Deleted successfully";
	}
	else{
		$_SESSION['error'] = "Something went wrong in deleting party";
	}
	header('location: settings.php');

?>