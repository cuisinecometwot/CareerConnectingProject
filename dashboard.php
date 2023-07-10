<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="img/logo.svg" type="image/x-icon">
    <title> Dashboard </title>
    <link href="css/simpleGridTemplate.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/Animate.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="css/animate.min.css" rel="stylesheet" type="text/css">
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
            font-family: Sora;
        }
        .textDarkShadow {text-shadow: 0px 0px 3px #000, 3px 3px 5px #003333;}
        .pc {
            animation-name: pc;
            animation-duration: 3s;
            animation-iteration-count: infinite;
            animation-timing-function: ease-in-out;
            margin-left: 30px;
            margin-top: 5px;
        }
        .box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        @keyframes pc {
            0% {transform: translate(0, 0px);}
            50% {transform: translate(0, 15px);}
            100% {transform: translate(0, -0px);}
        }
    </style>
</head>
<body onload="logoBeat()" style="font-family: 'Sora', sans-serif;">
    <?php
    include 'connect.php';
    include 'navBar.php';
    include 'signinEmployerModals.php';
    if (!isset($_SESSION['user'])){header('Location: index.php'); exit;}
    if ($_SESSION["user"]=="jobsk"){
        $query = "SELECT * FROM jobseeker WHERE email = '".$_SESSION["email"]."'";
        $result = pg_query($conn, $query) or die();
        $row = pg_fetch_assoc($result);?>
        <div class="container-fluid" style="background-color:#FFDAB9;">
            <div class="hero">
                <div style="width: 100%; " class="row">
                    <div class="col-md-6">
                        <img src="img/1.jpg" class="img-circle pc" width="200" style="margin: 20%; box-shadow: 0px 0px 20px #1e1e1e;">
                        <!-- Skills, etc-->
                    </div>
                    <div style="height: 100vh; color: black;" class="col-md-6">
                        <form action="updateProfile.php" method="POST" style="margin-top:50px; background-color: rgba(0, 0, 0, 0.8);">
                            <label style="font-size: 24px; color:white;">Email: </label>
                            <span style="font-size: 24px; color:white;""><?php echo $row['email'];?></span><br><br>
                            <label style="font-size: 24px; color:white;">Your Fullname: </label>
                            <input name="fullname" id="fullname" type="text" style="font-size: 24px;" value="<?php echo $row['fullname'];?>"><br><br>
                            <label style="font-size: 24px; color:white;">Gender: </label>
                            <select name="gender" id="gender" style="font-size: 24px;">
                                <option value="Male" <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                            </select><br><br>
                            <label style="font-size: 24px; color:white;">Date Of Birth: </label>
                            <input name="dob" id="dob" type="text" style="font-size: 24px;" value="<?php echo date('Y-m-d', strtotime($row['dob'])); ?>"><br><br>
                            <label style="font-size: 24px; color:white;">Phone Number: </label>
                            <input name="phonenum" id="phonenum" type="text" style="font-size: 24px;" value="<?php echo $row['phonenum'];?>"><br><br>
                            <label style="font-size: 24px; color:white;">Address: </label>
                            <input name="address" id="address" type="text" style="font-size: 24px;" value="<?php echo $row['address'];?>"><br><br>
                            <label style="font-size: 24px; color:white;"> Main Industry: <?php echo $row['industry'];?> </label>
                            <select type="text" name="industry" style="border-radius:0px; height: 50px;"> <?php include 'industryOptions.php'; ?></select> <br><br>
                            <label style="font-size: 24px; color:white;">Self Intro: </label>
                            <textarea name="selfintro" id="selfintro" type="text" style="font-size: 24px;" rows="3"><?php echo $row['selfintro'];?></textarea><br><br>
                            <label style="font-size: 24px; color:white;">Privacy Status: </label>
                            <select name="isprivate" id="isprivate" style="font-size: 24px;">
                                <option value="Public" <?php if ($row['isprivate'] == 'Public') echo 'selected'; ?>>Public</option>
                                <option value="ApplicationOnly" <?php if ($row['isprivate'] == 'ApplicationOnly') echo 'selected'; ?>>Application Only</option>
                            </select><br><br>
                            <section><button type="submit" style="font-size: 28px; background-color: rgba(255, 255, 255, 0.5);">Apply Change</button></section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } else {
        $query = "SELECT * FROM employer WHERE email = '".$_SESSION["email"]."'";
        $result = pg_query($conn, $query) or die();
        $row = pg_fetch_assoc($result);?>
        <div class="container-fluid" style="background-color:#FFDAB9;">
            <div class="hero">
                <div style="width: 100%; " class="row">
                    <div class="col-md-6">
                        <img src="img/2.webp" class="img-circle pc" width="200" style="margin: 20%; box-shadow: 0px 0px 20px #1e1e1e;">
                        <!-- etc -->
                    </div>
                    <div style="height: 100vh; color: black;" class="col-md-6">
                        <form action="updateProfile.php" method="POST" style="margin-top:50px; background-color: rgba(0, 0, 0, 0.8);">
                            <label style="font-size: 24px; color:white;">Corporation Name: </label>
                            <input name="empname" id="empname" type="text" style="font-size: 24px;" value="<?php echo $row['empname'];?>"><br><br>
                            <label style="font-size: 24px; color:white;">Contact Email: </label>
                            <span style="font-size: 24px;  color:white"><?php echo $row['email'];?></span><br><br>
                            <label style="font-size: 24px; color:white;">Contact Address: </label>
                            <input name="address" id="address" type="text" style="font-size: 24px;" value="<?php echo $row['address'];?>"><br><br>
                            <label style="font-size: 24px; color:white;">Contact Number: </label>
                            <input name="phonenum" id="phonenum" type="text" style="font-size: 24px;" value="<?php echo $row['phonenum'];?>"><br><br>
                            <label style="font-size: 24px; color:white;">Website: </label>
                            <input name="website" id="website" type="text" style="font-size: 24px;" value="<?php echo $row['website'];?>"><br><br>
                            <label style="font-size: 24px; color:white;"> Main Industry: <?php echo $row['industry'];?> </label>
                            <select type="text" name="industry" style="border-radius:0px; height: 50px;"> <?php include 'industryOptions.php'; ?></select> <br><br>
                            <label style="font-size: 24px; color:white;">About Your Corporation: </label>
                            <textarea name="selfintro" id="selfintro" type="text" style="font-size: 24px;" rows="3"><?php echo $row['selfintro'];?></textarea><br><br>
                            <section><button type="submit" style="font-size: 28px; background-color: rgba(255, 255, 255, 0.5);">Apply Change</button></section>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php }?>
    <script src="js/tilt.jquery.min.js"></script>
    <script src="js/signinModal.js"></script>
</body>
</html>
