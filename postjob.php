<?php session_start(); include 'connect.php'; if ($_SESSION["user"]!="emplr") header("Location: index.php");
// can them 2 ham updateRecord va deleteRecord Javascript
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/jobsConnect.svg" type="image/x-icon">
    <title> Post A Job </title>
    <link href="css/simpleGridTemplate.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/Animate.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
    <script type="text/javascript">
        bkLib.onDomLoaded(function() {
             new nicEditor().panelInstance('textbox');
        }); // Thay thế text area có id là textbox trở thành WYSIWYG editor sử dụng nicEditor
    </script>
    <script>
        function sortTable(n) {
          var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
          table = document.getElementById("myTable");
          switching = true;
          dir = "asc";
          while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
              shouldSwitch = false;
              x = rows[i].getElementsByTagName("TD")[n];
              y = rows[i + 1].getElementsByTagName("TD")[n];
              if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                  shouldSwitch = true;
                  break;
                }
              } 
                else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                  shouldSwitch = true;
                  break;
                }
              }
            }
            if (shouldSwitch) {
              rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
              switching = true;
              switchcount ++;
            } 
            else {
              if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
              }
            }
          }
        }
    </script>

    <link href="css/Animate.css" rel="stylesheet" type="text/css">
    <link href="css/animate.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Kodchasan" rel="stylesheet">
    <!--FONTS-->
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@200&display=swap" rel="stylesheet">
    <style>
        table {
            border-collapse: collapse;
            border-spacing: 0;
            border: 1px solid #ddd;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
            
        th {
            cursor: pointer;
        }
        th:hover {
            background-color: #524a4a;
        }
        .tiltContain {
          margin-top: 0%;
        }
        .btnTilt {
          height: 75px;
          background: rgba(225, 225, 225, 0.2);
          color: white;
          font-family: Sora;
        }
        .textDarkShadow {
          text-shadow: 0px 0px 3px #000, 3px 3px 5px #003333;
        }
        .btn {
          cursor: pointer;
          transition: 0.8s;
        }
        .btn:hover {
          transform: scale(1.1);
        }
        .dm {
          padding-top: 100px;
        }
        .mbbtn {
          width: 120px;
          height: 40px;
          background-color: #e9c46a;
          color: black;
          transition: 0.4s;
        }

        .mbbtn:hover {
          transform: scale(1.08);
          background-color: #e9c46a;
          color: black;
        }
        .floating {
          animation-name: floating;
          animation-duration: 3s;
          animation-iteration-count: infinite;
          animation-timing-function: ease-in-out;
          margin-left: 30px;
          margin-top: 5px;
        }
        @keyframes floating {
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
        .crd {
          height: 320px;
          width: 460px;
          border-radius: 20px;
          cursor: pointer;
          transition: 0.8s;
        }
        .crd:hover {
          transform: scale(1.05);
        }
        .pc {
            animation-name: pc;
            animation-duration: 3s;
            animation-iteration-count: infinite;
            animation-timing-function: ease-in-out;
            margin-left: 30px;
            margin-top: 5px;
        }
        .pstjb {
            width: 400px;
        }

        .bbb {
            padding-top: 30px;
        }
  </style>
<body onload="logoBeat()" style="font-family: 'Sora', sans-serif;">
    <?php
    include 'navBar.php';
    ?>
    <div class="container-fluid" style="background-color: #e9c46a;">
         <div class="hero">
                        <h3 class="pc" style="padding-top: 120px; font-size: 90px; text-align: center; color:white; text-shadow: -2px 0 black, 0 2px black, 2px 0 black, 0 -2px black;"><b> YOU ARE CURRENTLY HIRING: </b></h3>
            <div class="container" style="padding-left:50px; padding-top:50px; padding-bottom:50px;">
                <?php 
                $query = 'SELECT jid as "ID", industry AS "Industry", job_title AS "Job Title", salary_demand AS "Salary Demand", location AS "Location", close_at "Application Close", status AS "Status" FROM joblist WHERE Status = \'Hiring\' AND email = \''.$_SESSION["email"]."'";
                $result = pg_query($conn, $query) or die();
                $num_rows = pg_num_rows($result);
                $total = pg_fetch_all($result);
                echo '<span style="color:white; background-color:black;"><b>'.$num_rows.' result(s) returned.</b></span><br>';
                $thead = '<thead><tr>';
                $num=0;
                foreach ($total[0] as $key => $value) {
                    $thead.='<th style="color:white" onclick="sortTable('.$num++.')">'.$key.'</th>';
                }
                $thead.='</tr></thead>';

                $tbody = '<tbody>';
                foreach ($total as $key => $value) {
                    $tbody .= '<tr>';
                    foreach ($value as $k => $v) {
                        $tbody .= '<td style="border: 1px solid black; padding: 8px; font-weight: bold; color:white; height: 36px;">'.$v.'</td>';
                    }
                    $tbody .= '</tr>';
                }
                $tbody .= '</tbody>';
                $tableStyle = 'style="border-collapse: collapse; border: 2px solid black; background-color: black; width: 100%;"';
                $thStyle = 'style="border: 1px solid black; padding: 8px; font-weight: bold; color: black;"';
                $tdStyle = 'style="border: 1px solid black; padding: 8px; color: black;"';
                $table = '<table id="myTable" '.$tableStyle.'>'.$thead.$tbody.'</table>';
                echo $table;?>
                </div>
            <h3 class="pc" style="padding-top: 120px; font-size: 90px; text-align: center; color:white; text-shadow: -2px 0 black, 0 2px black, 2px 0 black, 0 -2px black;"><b>POST A NEW JOB!</b></h3>
            <div class="container contact-form" style=" background-color: #2a9d8f; width: 700px; height: 1100px; box-shadow: 0px 0px 25px #1e1e1e; 
                 align-items: center; justify-content: center; display: flex; padding: 0px; ">
                <form action="post_job.php" method="post">
                    <div class="row">
                        <div class="col"> 
                            <div class="form-group">
                                <label for="job_title"> Job Title </label>
                                <input type="text" name="job_title" class="form-control" style="border-radius:0px; height: 50px;" placeholder="Job Title" autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <label for="industry"> Industry </label>
                                <select type="text" name="industry" class="form-control" style="border-radius:0px; height: 50px;" placeholder="Industry" autocomplete="off"> <?php include 'industryOptions.php'; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exp_required"> Experience Required </label>
                                <input type="text" name="exp_required" class="form-control" style="border-radius:0px; height: 50px;" placeholder="100 years of EXP" autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <label for="academic_required"> Academic Required </label>
                                <input type="text" name="academic_required" class="form-control" style="border-radius:0px; height: 50px;" placeholder="PhD, MsC, etc" autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <label for="location"> Location </label>
                                <input type="text" name="location" class="form-control" style="border-radius:0px; height: 50px;" placeholder="Workplace" autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <label for="job_description"> Job Description </label>
                                <input type="text" name="job_description" class="form-control" id="textbox" style="border-radius:0px; height: 50px;" placeholder="Lorem ipsum..." autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <label for="salary_demand"> Salary Demand </label>
                                <select type="text" name="salary_demand" class="form-control" style="border-radius:0px; height: 50px;">
                                    <option> Less than 10M </option>
                                    <option> 10M-20M </option>
                                    <option> 20M-30M </option>
                                    <option> 30M-40M </option>
                                    <option> 40M-50M </option>
                                    <option> More than 50M </option>
                                    <option> Negotiable </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="close_at"> Close At</label>
                                <input type="date" name="close_at" class="form-control" style="border-radius:0px; height: 50px;" placeholder="Format YYYY-MM-DD"/>
                            </div>
                            <div class="form-group bbb">
                                <button type="submit" name="submitPost" class="btn" style="background-color: #001219; color: #e9d8a6;
                            box-shadow: none; border-radius: 0px; height: 50px; width: 500px;"> <b> POST A JOB </b> </button>
                                <div style="font-family: Sora; font-size: 15px; color: #ffd6a5; padding-top: 15px;">
                                    <b><?php echo $msg; ?></b>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="js/tilt.jquery.min.js"></script>
    <script src="js/signinModal.js"></script>
</body>
</html>
