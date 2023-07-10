<?php
session_start();
include 'connect.php';
if ($_SESSION["user"]!="emplr") header("Location: index.php");

if (isset($_POST["ID"])){
    $ID = $_POST["ID"];
    $query = "DELETE FROM joblist WHERE id = $ID";
    pg_query($conn, $query);
}

?>
