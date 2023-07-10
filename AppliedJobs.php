<?php session_start(); echo "hello"; include 'connect.php'; if ($_SESSION["user"]!="jobsk") header("Location: index.php");?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/logo.svg" type="image/x-icon">
    <title> Jobs Applied </title>
    <link href="css/simpleGridTemplate.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/Animate.css" rel="stylesheet" type="text/css">
    <link type="text/css" rel="css/bootstrap.min.css">
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/dataTables.bootstrap.min.js"></script>
    <link href="css/Animate.css" rel="stylesheet" type="text/css">
    <link href="css/animate.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/kodchasan.css" rel="stylesheet">
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

    /*-------------------------------------------*/
    .btn {
      cursor: pointer;
      transition: 0.8s;
    }

    .btn:hover {
      transform: scale(1.1);
    }

    /*-------------------------------------------------*/
    .dm {
      padding-top: 100px;
    }

    /*------------------------------------------------------*/
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
    /*------------------------------------------------------------*/
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
    /* ---------------------------------------------------------------------*/
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
    </style>
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
</head>
<body onload="logoBeat()" style="font-family: 'Sora', sans-serif;">
    <?php
    include 'navBar.php'; ?>
    <div class="container-fluid" style="background-color: #FFDAB9;">
        <?php
            $query = "SELECT * from jobapp where email = '".$_SESSION['email']."'"; // Create a better, informative VIEW
            $result = pg_query($conn, $query) or die();
            $num_rows = pg_num_rows($result);
            $total = pg_fetch_all($result);
        ?>
        <div class="hero">
            <div style="width: 100%; padding-left: 50px; padding-right: 50px; " class="row">
                <div style=" height: 100vh; margin-top:0%;" class="col-md-12"><br><br>
                    <div>
                        <h1 style=" padding-bottom: 30px; color:white"><b>Jobs Applied by you: </b></h3>
                    </div>
                    <!-- <table class="table table-hover table-responsive table-striped" id='jobappliedTable'> -->
                        <?php 
                        echo '<span style="color:white; background-color:black;"><b>'.$num_rows.' result(s) returned.</b></span><br>';
                        $num = 0;
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
                        echo $table; 
                        ?>
                    <!-- </table> -->
                </div>
            </div>
        </div>
    </div>
    <script src="js/tilt.jquery.min.js"></script>
    <script src="js/signinModal.js"></script>
</body>

</html>
