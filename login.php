<?php
	session_start();
	include 'includes/conn.php';

	if(isset($_POST['login'])){
		$voter = $_POST['voter'];
		$password = $_POST['password'];
    
		$stmnt = $conn->prepare("SELECT * FROM voters WHERE voters_id = ?");
		$stmnt->bind_param("s", $voter);
		$stmnt->execute();
		$query = $stmnt->get_result();

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Cannot find voter with the ID';
		}
		else{
			$row = $query->fetch_assoc();
			
			// Method 1: Using mb_strtoupper for proper Unicode handling
			if(mb_strtoupper($password, 'UTF-8') == mb_strtoupper($row['lastname'], 'UTF-8')){
				if($row['status'] == false){
					$_SESSION['error'] = 'Your account has been disabled. Please contact your local admin.';
				} else {
					$_SESSION['voter'] = $row['id'];
				}
			}
			
			// Alternative Method 2: Case-insensitive comparison with Unicode support
			/*
			if(strcasecmp($password, $row['lastname']) === 0){
				if($row['status'] == false){
					$_SESSION['error'] = 'Your account has been disabled. Please contact your local admin.';
				} else {
					$_SESSION['voter'] = $row['id'];
				}
			}
			*/
			
			// Alternative Method 3: Direct comparison without case conversion
			/*
			// This allows exact case matching including ñ/Ñ differences
			if($password === $row['lastname']){
				if($row['status'] == false){
					$_SESSION['error'] = 'Your account has been disabled. Please contact your local admin.';
				} else {
					$_SESSION['voter'] = $row['id'];
				}
			}
			*/
			else{
				$_SESSION['error'] = 'Incorrect password';
			}
		}
	}
	else{
		$_SESSION['error'] = 'Input voter credentials first';
	}

	header('location: index.php');
?>