<?php
$host = "localhost";
$db = "jobconnect";

// connect depends on session

$guest = "guest"; // guest
$guest_pwd = "nanika"; // nanika

$jobsk = "jobsk";
$jobsk_pwd = "s3cur3p455w0rd";

$emplr = "emplr";
$emplr_pwd = "d0ntm1ndm3";
session_start();
if ($_SESSION['user']=="jobsk") $conn = pg_connect("host=$host dbname=$db user=$jobsk password=$jobsk_pwd") or die();
else if ($_SESSION['user']=="emplr") $conn = pg_connect("host=$host dbname=$db user=$emplr password=$emplr_pwd") or die();
else $conn = pg_connect("host=$host dbname=$db user=$guest password=$guest_pwd") or die();
if(!$conn) exit();

?>

