<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include 'connect.php';
    if ($_SESSION['user']=="jobsk"){
        $fullname = pg_escape_string($_POST['fullname']);
        $email = pg_escape_string($_POST['email']);
        $gender = pg_escape_string($_POST['gender']);
        $dob = pg_escape_string($_POST['dob']);
        $phonenum = pg_escape_string($_POST['phonenum']);
        $address = pg_escape_string($_POST['address']);
        $selfintro = pg_escape_string($_POST['selfintro']);
        $industry = pg_escape_string($_POST['industry']); 
        $isprivate = pg_escape_string($_POST['isprivate']);

        $query = "UPDATE jobseeker SET fullname = '$fullname', gender = '$gender', dob = '$dob', phonenum = '$phonenum', address = '$address', selfintro = '$selfintro', industry = '$industry', isprivate = '$isprivate' WHERE email = '{$_SESSION['email']}'";
        
        $result = pg_query($conn, $query);
        header('Location: dashboard.php');
    }
    else if ($_SESSION['user']=="emplr"){
        $empname = pg_escape_string($_POST['empname']);
        $email = pg_escape_string($_POST['email']);
        $address = pg_escape_string($_POST['address']);
        $phonenum = pg_escape_string($_POST['phonenum']);
        $website = pg_escape_string($_POST['website']);
        $industry = pg_escape_string($_POST['industry']); 
        $selfintro = pg_escape_string($_POST['selfintro']);

        $query = "UPDATE employer SET empname = '$empname', address = '$address', phonenum = '$phonenum', website = '$website', industry = '$industry', selfintro = '$selfintro' WHERE email = '{$_SESSION['email']}'";
        
        $result = pg_query($conn, $query);
        header('Location: dashboard.php');
    } else header('Location: signin.php');
?>
