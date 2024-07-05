<?php
session_start();
//$basePath = 'http://localhost:3000/';
$basePath = 'http://localhost/AUST%20CODE%20REALM/';
//echo json_encode($_SESSION['user']);
$isLoggedIn = isset($_SESSION['user']);
$handle=$_SESSION['user']['username'];
?>
<style>
    
</style>
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="<?php echo $basePath; ?>index.php"><img src="<?php echo $basePath; ?>images/logo.png" alt="ACR"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $basePath; ?>index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $basePath; ?>pages/contestSet.php">Contests</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $basePath; ?>pages/problemSet.php">Problems</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $basePath; ?>pages/courses.php">Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $basePath; ?>pages/help.php">Help</a>
            </li>
        </ul>
    </div>
    <a class="profile-link" href="<?php echo $isLoggedIn ? $basePath . 'pages/profilePage.php' : $basePath . 'pages/login.php'; ?>">
        <img src="<?php echo $basePath; ?>images/user.png" alt="Profile" class="profile-icon">
        <p class="handle"><?php echo $isLoggedIn ? $handle:'Guest User';?></p>
    </a>
</nav>
