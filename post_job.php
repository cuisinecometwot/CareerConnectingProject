<?php
session_start(); include 'connect.php';
if (isset($_POST['job_title']) && isset($_POST['industry']) && isset($_POST['exp_required']) && isset($_POST['academic_required']) && isset($_POST['location']) && isset($_POST['job_description']) && isset($_POST['salary_demand']) && isset($_POST['close_at'])) {
    echo $job_title = pg_escape_string($_POST['job_title']);
    echo $industry = pg_escape_string($_POST['industry']);
    echo $exp_required = pg_escape_string($_POST['exp_required']);
    echo $academic_required = pg_escape_string($_POST['academic_required']);
    echo $location = pg_escape_string($_POST['location']);
    echo $job_description = pg_escape_string($_POST['job_description']);
    echo $salary_demand = pg_escape_string($_POST['salary_demand']);
    echo $close_at = pg_escape_string($_POST['close_at']);
    $email = $_SESSION['email'];
    $query = "CALL add_job_advertisement('$email', '$industry', '$job_title', '$job_description', '$salary_demand', '$exp_required', '$academic_required', '$location', '$close_at')";
    $result = pg_query($conn, $query);
    if ($result) header("Location: postjob.php?=msg=success");
    else header("Location: postjob.php?=msg=failed");
} else header("Location: postjob.php?=msg=failed");
?>
