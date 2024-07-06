<?php
session_start();
$basePath = 'http://localhost/AUST%20CODE%20REALM/';
$isLoggedIn = isset($_SESSION['user']);
$handle = $isLoggedIn ? $_SESSION['user']['username'] : 'Guest User';
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
                <a class="nav-link" href="<?php echo $basePath; ?>">Help</a>
            </li>
        </ul>
    </div>
    <?php if ($isLoggedIn): ?>
        <div class="dropdown profile-dropdown">
            <div class="profile-link dropdown-toggle" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo $basePath; ?>images/user.png" alt="Profile" class="profile-icon">
                <p class="handle"><?php echo $handle;?></p>
            </div>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?php echo $basePath; ?>pages/profilePage.php">Profile</a></li>
                <li><a class="dropdown-item" href="<?php echo $basePath; ?>">Settings</a></li>
                <li><a class="dropdown-item" href="<?php echo $basePath; ?>index.php?logout=true">Logout</a></li>
            </ul>
        </div>
    <?php else: ?>
        <a class="btn btn-primary ms-auto" id="loginbtn" href="<?php echo $basePath; ?>pages/login.php">Login</a>
    <?php endif; ?>
</nav>

<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: {$basePath}index.php");
    exit();
}
?>