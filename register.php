<!-- Veri good -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    <title>Register</title>
</head>
<body>
<style type="text/css">
body {
background-image: url('img/k-on.jpg');
background-position: center;
background-repeat: no-repeat;
background-size: cover;
}
</style>
<main>
<br><br><br><br><br><br>
    <form action="" method="post">
        <h1>Register</h1>
        <div>
            <label for="Email">Your Email:</label>
            <input type="email" name="email" id="email" placeholder="DucDepTrai@sis.hust.edu.vn" required>
        </div>
        <div>
            <label for="Password">Password:</label>
            <input type="password" name="password" id="password" placeholder="L0r3m1psumd0l0rs1t4m3t" required>
        </div>
        <div>
            <label for="role">You are:</label>
            <select name="role" id="color">
	            <option value="jobsk">Job Seeker</option>
	            <option value="emplr">Employer</option>
            </select>
        </div>
        <section>
            <button type="submit">Register</button>
            <a href="signin.php">Already have an account?</a>
        </section>
    </form>
</main>
</body>
</html>
<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user'])){
        include 'connect.php';
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        /*if (!filter_var($email, FILTER_VALIDATE_EMAIL)) echo '<script type="text/javascript">
                        window.onload=function(){ 
                            alert("Invalid Email Format!");
                        }
                        </script>'; */
        if ($role == "emplr"){
            $query = "SELECT * FROM emp_login WHERE email = '$email'";
            $result = pg_query($conn, $query) or die();
            if (pg_num_rows($result) != 0) echo '<script type="text/javascript">
                        window.onload=function(){ 
                            alert("An account using this email already exists!");
                        }
                        </script>'; 

            $query = "SELECT add_emp ('".$email."', '".$password."') AS generate";
            $result = pg_query($conn, $query) or die();
            $query = "INSERT INTO employer(email) VALUES ('$email')";
            $add = pg_query($conn, $query);
            if ($result && $add){
                header("refresh:5; url=signin.php");
                echo '<script type="text/javascript">
                        window.onload=function(){ 
                            alert("Account created successfully! Redirecting to Login...");
                        }
                        </script>'; 
                exit;    
            }   
        }
        else if ($role == "jobsk"){
            $query = "SELECT * FROM user_login WHERE email = '$email'";
            $result = pg_query($conn, $query) or die();
            if (pg_num_rows($result) != 0) echo '<script type="text/javascript">
                        window.onload=function(){ 
                            alert("An account using this email already exists!");
                        }
                        </script>'; 

            $query = "SELECT add_user ('".$email."', '".$password."') AS generate";
            $result = pg_query($conn, $query) or die();
            $query = "INSERT INTO jobseeker(email) VALUES ('$email')";
            $add = pg_query($conn, $query);
            if ($result && $add){
                header("refresh:5; url=signin.php");
                echo '<script type="text/javascript">
                        window.onload=function(){ 
                            alert("Account created successfully! Redirecting to Login...");
                        }
                        </script>'; 
                exit;    
            }
        }
    } else {header('Location: index.php'); exit;} //if already signed in, we dont need to register!
?>
