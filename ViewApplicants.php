<?php session_start(); include 'connect.php'; if ($_SESSION["user"]!="emplr") header("Location: index.php");?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/jobsConnect.svg" type="image/x-icon">
    <title> View Applicants </title>
    <link href="css/simpleGridTemplate.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/Animate.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
    <link href="css/Animate.css" rel="stylesheet" type="text/css">
    <link href="css/animate.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Kodchasan" rel="stylesheet">
    <!--FONTS-->
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@200&display=swap" rel="stylesheet">
    <style>
        .tiltContain {
            margin-top: 0%;
        }

        .btnTilt {
            height: 75px;
            background: rgba(225, 225, 225, 0.2);
            color: white;
            font-family: Comfortaa;
        }

        .textDarkShadow {
            text-shadow: 0px 0px 3px #000, 3px 3px 5px #003333;
        }

        .pc {
            animation-name: pc;
            animation-duration: 3s;
            animation-iteration-count: infinite;
            animation-timing-function: ease-in-out;
            margin-left: 30px;
            margin-top: 5px;
        }
        @keyframes pc {
            0% {
                transform: translate(0, 0px);
            }

            50% {
                transform: translate(0, 15px);
            }

            100% {
                transform: translate(0, -0px);
            }
        }
    </style>

    <script>
        function acceptRecord(recordId) {
            $.ajax({
                url: 'acceptApplication.php',
                method: 'POST',
                data: { recordId: recordId },
                success: function(response) {
                    alert('Record accepted successfully');
                    location.reload();
                },
                error: function() {
                    alert('Error accepting record');
                }
            });
        }

        function rejectRecord(recordId) {
            $.ajax({
                url: 'rejectApplication.php',
                method: 'POST',
                data: { recordId: recordId },
                success: function(response) {
                    alert('Record rejected successfully');
                    location.reload();
                },
                error: function() {
                    alert('Error rejecting record');
                }
            });
        }
    </script>
    <script>
        function showJSKDetails(mail) {
            $.ajax({
                url: 'get_jsk_details.php',
                method: 'GET',
                data: { mail: mail },
                success: function(response) {
                    var jskDetails = JSON.parse(response);
                    showModal(jskDetails, mail);
                },
                error: function() {
                    alert('Error retrieving job seeker details.');
                }
            });
        }
        function showModal(jskDetails, mail) {
          var modalContent = '<div id="myModal" class="modal">';
          modalContent += '<div class="modal-content" style="max-width: 400px; top: 50%; left: 50%; transform: translate(-50%, -50%);">';
          modalContent += '<span class="close" style="font-size: 48px;">&times;</span>';
          modalContent += '<h2>Job Seeker Details</h2>';

          for (var key in jskDetails) {
            modalContent += '<p><strong>' + key + ': </strong>' + jskDetails[key] + '</p>';
          }

          document.body.innerHTML += modalContent;
          var closeBtn = document.getElementsByClassName("close")[0];

          closeBtn.onclick = function () {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
            modal.remove();
          };

          var modal = document.getElementById("myModal");
          modal.style.display = "block";

          window.onclick = function (event) {
            if (event.target == modal) {
              modal.style.display = "none";
              modal.remove();
            }
          };
        }
    </script>
</head>

<body onload="logoBeat()" style="font-family: 'Sora', sans-serif;">
    <?php include 'navBar.php';?>
    <div class="container-fluid" style="background-color: #a0c4ff; padding-left: 50px; padding-right: 50px;">
        <?php
        $your_email = $_SESSION['email'];
        $query = "SELECT * FROM employer WHERE email = '$your_email'";
        $result = pg_query($conn, $query);
        $row = pg_fetch_assoc($result);
        $name = $row["empname"];
        ?>
        <div class="hero">
            <div style="width: 100%; padding-left: 50px; padding-right: 50px; " class="row">
                <div style=" height: 100vh; padding-top: 0px; " class="col-md-12">
                    <div>
                        <h3>.</h3>
                    </div>
                    <div><h1 style="padding-bottom: 30px;"><b> Applications </b></h1></div>
                            <?php
                            $query = 'SELECT id as "ID", L.job_title as "Job Title", A.email AS "Contact", A.applied_date AS "Applied Date", L.close_at AS "Close At", A.status AS "Status" FROM jobapp AS A JOIN joblist AS L ON A.jid=L.jid '; $query.="WHERE L.email = '"; $query.=$_SESSION["email"]; $query.="'";
                            $result = pg_query($conn, $query) or die();
                            $num_rows = pg_num_rows($result);
                            $total = pg_fetch_all($result);
                            echo '<span style="color:white; background-color:black;"><b>'.$num_rows.' result(s) returned.</b></span><br>';
                            $thead = '<thead><tr>';
                            $num=0;
                            foreach ($total[0] as $key => $value) {
                                $thead.='<th>'.$key.'</th>';
                            }
                            $thead.='</tr></thead>';
                            $tbody = '<tbody>';
                            foreach ($total as $key => $value) {
                                $tbody .= '<tr>';
                                foreach ($value as $k => $v) {
                                    if ($k=="Status" && $v=="Pending"){
                                        $tbody .= '<td style="border: 1px solid black; padding: 8px; font-weight: bold; color:white; height: 36px;"> Pending <br>
                                        <button onclick="acceptRecord('.$value['ID'].')"> [Accept] </button><br>
                                        <button onclick="rejectRecord('.$value['ID'].')"> [Reject] </button><br>
                                        </td>';
                                    }
                                    else if ($k=="Contact"){
                                        $tbody .= '<td style="border: 1px solid black; padding: 8px; font-weight: bold; color:white; height: 36px;">
                                        <button onclick="showJSKDetails(\''.$value['Contact'].'\')"><b> Click </b></button></td>';
                                    }
                                    else $tbody .= '<td style="border: 1px solid black; padding: 8px; font-weight: bold; color:white; height: 36px;">'.$v.'</td>';
                                }
                                $tbody .= '</tr>';
                            }
                            $tbody .= '</tbody>';
                            $tableStyle = 'style="color:white; border-collapse: collapse; border: 2px solid black; background-color: black; width: 100%;"';
                            $thStyle = 'style="border: 1px solid black; padding: 8px; font-weight: bold; color: black;"';
                            $tdStyle = 'style="border: 1px solid black; padding: 8px; color: black;"';
                            $table = '<table id="myTable" '.$tableStyle.'>'.$thead.$tbody.'</table>';
                            echo $table; 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="js/tilt.jquery.min.js"></script>
    <script src="js/signinModal.js"></script>
    <!-- <script>
        $(document).ready(function() {
            $('#jobappliedTable').DataTable();
        });
    </script> -->
</body>
</html>
