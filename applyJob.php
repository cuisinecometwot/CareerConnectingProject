<?php
    session_start();
    include 'connect.php';
    if ($_SESSION['user'] == "jobsk") {
        $jobId = $_GET["jobId"];
        $email = $_SESSION['email'];
        echo $query = "SELECT * FROM jobapp WHERE jid = $jobId AND email = '$email' AND status != 'Rejected'";
        
        $result = pg_query($conn, $query);
        if (pg_num_rows($result) > 0) {
            header('Location: jobs.php?apply=duplicate');
            die();
        }
        
        $query = "INSERT INTO jobapp(jid, email) VALUES ('$jobId', '$email')";
        if (pg_query($conn, $query)) {
            header('Location: jobs.php?apply=success');
        } else {
            header('Location: jobs.php?apply=failed');
        }
    } else header('Location: signin.php');
?>

