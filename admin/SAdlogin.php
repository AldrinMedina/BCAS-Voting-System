<?php
include 'includes/session.php'; // Ensure this file sets up the $conn variable correctly

if(isset($_POST['Slogin'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM sad WHERE username = '$username'";
    $query = $conn->query($sql);

    if($query->num_rows < 1){
        $_SESSION['error'] = 'Cannot find account with the username';
    }
    else{
        $row = $query->fetch_assoc();
        if(password_verify($password, $row['password'])){
            $_SESSION['superAdmin'] = $row['firstname'].' '.$row['lastname'];
            $_SESSION['success'] = $_SESSION['superAdmin']. ' has signed in.';
            header('location:settings.php');
        }
        else{
            $_SESSION['error'] = 'Incorrect password';
            header('location:settings.php');
        }
    }
    
}
else{
    $_SESSION['error'] = 'Input admin credentials first';
    header('location:settings.php');
}
?>
