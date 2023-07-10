<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    <title> Login </title>
    <script>
    function showAlert() {
      alert("Due to our current Security Policies, please relax and try to remember your password!");
    }
    </script>
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
    <form action="" method="post" autocomplete="on">
        <h1>Login</h1>
        <div>
            <label for="Email">Your Email:</label>
            <input type="email" name="email" id="email" placeholder="DucDepTrai@sis.hust.edu.vn" required>
        </div>
        <div>
            <label for="Password">Password:</label>
            <input type="password" name="password" id="password" placeholder="L0r3m1psumd0l0rs1t4m3t" required>
        </div>
        <div>
            <label for="role">Login as:</label>
            <select name="role" id="color">
	            <option value="jobsk">Job Seeker</option>
	            <option value="emplr">Employer</option>
            </select>
        </div>
        <section>
            <button type="submit">Login</button>
            <a href="register.php"> Don't have an account? </a>
        </section>
        
        <button onclick="showAlert()"> Forgot Password? </button>
    </form>
</main>
</body>
</html>
<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    include 'connect.php';
    if (!isset($_SESSION['user'])){
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $email = pg_escape_string($email); $password = pg_escape_string($password);

        if ($role == "jobsk"){    
            $query = "SELECT * FROM user_login WHERE email = '$email'";
            $result = pg_query($conn, $query) or die();
            $num = pg_num_rows($result);

            if ($num == 1){
                $row = pg_fetch_assoc($result);
                $hashedPassword = $row['pwdhashed']; $salt = $row['salt'];
                $query = "SELECT verify_user('".$email."', '".$password."') AS verify_result";
                $result = pg_query($conn, $query) or die();
                $verify_user = pg_fetch_assoc($result)['verify_result'];
                if ($verify_user == 't') {
                    $_SESSION["user"] = "jobsk";
                    $_SESSION["email"] = $email;
                    $url = 'dashboard.php';
                    $delay = 2; // in seconds
                    header("refresh:{$delay};url={$url}");
                    echo '<script type="text/javascript">
                        window.onload=function(){ 
                            alert("Authentication Successful!\nRedirecting to Account Dashboard ...");
                        }
                        </script>'; 
                    exit;  
                }
                else echo '<script type="text/javascript">window.onload=function(){ alert("Incorrect Email / Password!"); }</script>'; 
             } else echo '<script type="text/javascript">window.onload=function(){ alert("Incorrect Email / Password!"); }</script>'; 
        }
        else if ($role == "emplr"){
            $query = "SELECT * FROM emp_login WHERE email = '$email'";
            $result = pg_query($conn, $query) or die();
            $num = pg_num_rows($result);
            if ($num == 1){
                $row = pg_fetch_assoc($result);
                $hashedPassword = $row['pwdhashed']; $salt = $row['salt'];
                $query = "SELECT verify_emp('".$email."', '".$password."') AS verify_result";
                $result = pg_query($conn, $query) or die();
                $verify_user = pg_fetch_assoc($result)['verify_result'];
                if ($verify_user == 't') {
                    $_SESSION["user"] = "emplr";
                    $_SESSION["email"] = $email;
                    $url = 'dashboard.php';
                    $delay = 2; // in seconds
                    header("refresh:{$delay};url={$url}");
                    echo '<script type="text/javascript">
                        window.onload=function(){ 
                            alert("Authentication Successful!\nRedirecting to Account Dashboard ...");
                        }
                        </script>'; 
                    exit;  
                } else echo '<script type="text/javascript">window.onload=function(){ alert("Incorrect Email / Password!"); }</script>'; 
             } else echo '<script type="text/javascript">window.onload=function(){ alert("Incorrect Email / Password!"); }</script>'; 
        }
    }
    } else {header('Location: index.php'); exit;} //if already signed in, we dont need to access here!
?>

