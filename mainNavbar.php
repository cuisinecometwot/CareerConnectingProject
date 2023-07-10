<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
        <img src="img/logo.svg" style="width:33px;" alt="">
        <h1 class="m-0 text-primary">Career Connection</h1>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="index.php" class="nav-item nav-link active">Home</a>
            <a href="index.php#category" class="nav-item nav-link">Category</a>
            <a href="index.php#about" class="nav-item nav-link">About Us</a>
            <a href="contact.php" class="nav-item nav-link">Contact</a>
            <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if (!isset($_SESSION['user'])) echo '<a href="signin.php" class="nav-item nav-link">Sign In</a>';
            else {
                echo '<a href="dashboard.php" class="nav-item nav-link">Dashboard</a>';
                echo '<a href="logout.php" class="nav-item nav-link">Log Out</a>';
            }
            ?>
            <a href="jobs.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">VIEW JOBS<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </div>
</nav>
<!-- Navbar End -->
