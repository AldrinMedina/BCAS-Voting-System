<?php
	include 'includes/session.php';
	$_SESSION['success'] =$_SESSION['superAdmin'].' has signed out.';
	$_SESSION['superAdmin']='';

	header('location: settings.php');
?>