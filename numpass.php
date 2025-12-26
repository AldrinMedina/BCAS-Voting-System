<?php
    session_start();
    include 'includes/conn.php';

    if(isset($_POST['login'])){
		$numpass = $_POST['psw'];
        $voter = $_SESSION['voter'];
    
    $stmnt = $conn->prepare ("SELECT * FROM voters WHERE id = ?");
    $stmnt->bind_param("s", $voter);
    $stmnt->execute();
    $query = $stmnt->get_result();

			$row = $query->fetch_assoc();
            if ($numpass == $row['otp']) {
                // Set a session variable indicating OTP success
                $_SESSION['otp_verified'] = true;
                // Redirect back to home.php
                header('Location: home.php');
                exit();
            } else {
                $_SESSION['error'] = 'Incorrect OTP';
                header('Location: logout.php');
                exit();
            }
		}
	else{
		$_SESSION['error'] = 'Input voter credentials first';
	}
?>