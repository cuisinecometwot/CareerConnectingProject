<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="img/jobsConnect.svg" type="image/x-icon">
  <title> Jobs Listing </title>
  <link href="css/simpleGridTemplate.css" rel="stylesheet" type="text/css">
  <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="css/Animate.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="css/Animate.css" rel="stylesheet" type="text/css">
  <link href="css/animate.min.css" rel="stylesheet" type="text/css">
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
    /* -------------------------------------------------------------------------------------- */
  </style>
  <script src="js/tilt.jquery.min.js"></script>
  <script src="js/signinModal.js"></script>
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
  <script>
    function showJobDetails(jobId) {
        $.ajax({
            url: 'get_job_details.php',
            method: 'GET',
            data: { jobId: jobId },
            success: function(response) {
                var jobDetails = JSON.parse(response);
                showModal(jobDetails, jobId);
            },
            error: function() {
                alert('Error retrieving job details.');
            }
        });
    }
    function showModal(jobDetails, jobId) {
      var modalContent = '<div id="myModal" class="modal">';
      modalContent += '<div class="modal-content" style="max-width: 400px; top: 50%; left: 50%; transform: translate(-50%, -50%);">';
      modalContent += '<span class="close" style="font-size: 48px;">&times;</span>';
      modalContent += '<h2>Job Details</h2>';
      for (var key in jobDetails) {
        modalContent += '<p><strong>' + key + ': </strong>' + jobDetails[key] + '</p>';
      }
      modalContent += '<p><a href="applyJob.php?jobId=' + jobId + '" class="apply-button">Apply Job</a></p></div></div>';
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<body onload="logoBeat()" style="font-family: 'Sora', sans-serif;">
  <?php
  include 'navBar.php';
  include 'signinEmployerModals.php';
  ?>
  <!-- Main Container -->
  <div class="container-fluid" style=" background-color: #18303B; background-position: center; background-size: cover; background-repeat: no-repeat; background-attachment: fixed;">
    <div class="hero" style=" color:whitesmoke; height: 1700px;">
      <br>
      <br>
      <div style="width: 100%" class="row">
        <div class="col-md-9">
          <div style=" margin-top: 30px; padding-left: 50px;">
            <h1 id="jbs" style="color:black"><b>Find jobs</b></h1>
            <form class="example" action="jobs.php">
                <input style="color:#000; height:45px; width:1220px; border-radius:30px 0px 0px 30px;" type="text" placeholder="     Search For Jobs..." name="q">
                <button type="submit" style="height:45px; width:160px; border-radius:0px 30px 30px 0px; background-color: #257059; "><i class="fa fa-search bb"></i>
                </button>
            </form>
          </div>
          <div class="container" style="padding-left:50px; padding-top:50px; padding-bottom:50px;">
                <?php 
                include 'connect.php';
                $query = 'SELECT jid as "ID", email AS "Email", industry AS "Industry", job_title AS "Job Title", salary_demand AS "Salary Demand", location AS "Location", close_at "Application Close", status AS "Status" FROM joblist'; // change to shortened list VIEW
                $result = pg_query($conn, $query) or die();
                $num_rows = pg_num_rows($result);
                $total = pg_fetch_all($result);
                echo '<span style="color:white; background-color:black;"><b>'.$num_rows.' result(s) returned.</b></span><br>';
                $thead = '<thead><tr>';
                $num=0;
                foreach ($total[0] as $key => $value) {
                    $thead.='<th onclick="sortTable('.$num++.')">'.$key.'</th>';
                }
                $thead.='</tr></thead>';

                $tbody = '<tbody>';
                foreach ($total as $key => $value) {
                    $tbody .= '<tr>';
                    foreach ($value as $k => $v) {
                        if ($k=="Status" && $v=="Hiring")
{$tbody .= '<td style="border: 1px solid black; padding: 8px; font-weight: bold; color:white; height: 36px;"><button class="job-status-hiring" data-job-id="'.$v.'" onclick="showJobDetails(\''.$value['ID'].'\')"><b>Hiring</b></button></td>';}
                        else $tbody .= '<td style="border: 1px solid black; padding: 8px; font-weight: bold; color:white; height: 36px;">'.$v.'</td>';
                    }
                    $tbody .= '</tr>';
                }
                $tbody .= '</tbody>';
                $tableStyle = 'style="border-collapse: collapse; border: 2px solid black; background-color: black; width: 110%;"';
                $thStyle = 'style="border: 1px solid black; padding: 8px; font-weight: bold; color: black;"';
                $tdStyle = 'style="border: 1px solid black; padding: 8px; color: black;"';
                $table = '<table id="myTable" '.$tableStyle.'>'.$thead.$tbody.'</table>';
                echo $table;?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
