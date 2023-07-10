<?php
session_start();
include 'connect.php';
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET["mail"])) {
        $mail = $_GET["mail"];
        $query = "SELECT * FROM jobseeker WHERE email = '$mail'"; // change to detailed list VIEW
        $result = pg_query($conn, $query);

        if (pg_num_rows($result) > 0) {
            $jskDetails = pg_fetch_assoc($result);
            echo json_encode($jskDetails); // Trả về kết quả dưới dạng JSON
        } else echo "No job detail found.";
    } else echo "Invalid request.";
}

?>
