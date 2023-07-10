<?php
session_start();
include 'connect.php';
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["jobId"])) {
        $jobId = $_GET["jobId"];
        $query = "SELECT * FROM joblist WHERE jid = '$jobId'"; // change to detailed list VIEW
        $result = pg_query($conn, $query);

        if (pg_num_rows($result) > 0) {
            $jobDetails = pg_fetch_assoc($result);
            echo json_encode($jobDetails); // Trả về kết quả dưới dạng JSON
        } else echo "No detail found.";
    } else echo "Invalid request.";
}

?>

