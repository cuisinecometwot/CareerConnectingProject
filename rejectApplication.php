<?php
session_start();
include 'connect.php';
if ($_SESSION["user"] != "emplr") header('Location: signin.php');
if (isset($_POST["recordId"])) {
    $recordId = $_POST['recordId'];
    $query = "UPDATE jobapp SET status = 'Rejected' WHERE id = $recordId";
    $result = pg_query($conn, $query);
    if ($result) header("Location: ViewApplicants.php?msg=success");
    else header("Location: ViewApplicants.php?msg=failed");
}
?>
