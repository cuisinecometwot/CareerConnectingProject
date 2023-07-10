<!--FONTS-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@200&display=swap" rel="stylesheet">
<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" style="box-shadow: 0px 3px 4px rgba(225, 225, 225, .6); font-family: 'Sora', sans-serif;">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php" style="padding-left: 50px; font-size:25px; color:white; font-family: 'Sora', sans-serif">Career Connecting</a>
    </div>
    <div class="collapse navbar-collapse" id="defaultNavbar1" style="padding-right:50px;">
      <ul class="nav navbar-nav navbar-right ">
        <?php
        if (session_status() == PHP_SESSION_NONE) {
          session_start();
        }
        if ($_SESSION['user'] == "jobsk"){
          $myusername = $_SESSION['user'];
          echo ' <li><a href="jobs.php">JOBS</a></li>
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $myusername . '<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
             <li><a href="dashboard.php">My Profile</a></li>
             <li><a href="AppliedJobs.php">Jobs Applied</a></li>
             <li><a href="logout.php">Logout</a></li>
          </ul>
          </li>';
        }
        if ($_SESSION['user'] == "emplr"){
          $myusername = $_SESSION['user'];
          echo ' <li><a href="postjob.php">Post a job</a></li>
          <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">' . $myusername . '<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
              <li><a href="dashboard.php">My Account</a></li>
              <li><a href="ViewApplicants.php">View Applications</a></li>
              <li><a href="logout.php">Logout</a></li>
          </ul>
          </li>';
        } ?>
      </ul>
    </div>
  </div>
</nav>
