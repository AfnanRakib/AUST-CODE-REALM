<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$basePath = 'http://localhost/AUST%20CODE%20REALM/';
$isLoggedIn = isset($_SESSION['user']);
$handle = $isLoggedIn ? $_SESSION['user']['Handle'] : 'Guest User';
$serverTime = time(); // Get server's current time in seconds since the Unix Epoch
?>

<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="<?php echo $basePath; ?>index.php"><img src="<?php echo $basePath; ?>images/logo.png" alt="ACR"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
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
                <a class="nav-link" href="<?php echo $basePath; ?>pages/courses/courses.php">Courses</a>
            </li>
        <?php if(($isLoggedIn) && $_SESSION['user']['User_Role']=='admin'): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $basePath; ?>admin/userCreatedProblems.php">Admin Panel</a>
            </li>
        <?php endif; ?>
        </ul>
    </div>
    <?php if ($isLoggedIn): ?>
        <div class="dropdown profile-dropdown">
            <div class="profile-link dropdown-toggle" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo $basePath; ?>images/icons/user.png" alt="Profile" class="profile-icon">
                <p class="handle"><?php echo $handle;?></p>
            </div>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?php echo $basePath; ?>pages/profilePage.php"><img src="<?php echo $basePath; ?>images/icons/profile.png" alt="Profile Icon" class="dropdown-icon"> Profile</a></li>
                <li><a class="dropdown-item" href="<?php echo $basePath; ?>pages/submissions.php"><img src="<?php echo $basePath; ?>images/icons/list1.png" alt="Profile Icon" class="dropdown-icon"> Submissions</a></li>
                <li><a class="dropdown-item" href="<?php echo $basePath; ?>pages/editProfile.php"><img src="<?php echo $basePath; ?>images/icons/settings.png" alt="Settings Icon" class="dropdown-icon"> Edit Profile</a></li>
                <li><a class="dropdown-item" href="<?php echo $basePath; ?>index.php?logout=true"><img src="<?php echo $basePath; ?>images/icons/logout.png" alt="Logout Icon" class="dropdown-icon"> Logout</a></li>
            </ul>
        </div>
    <?php else: ?>
        <a class="btn btn-primary" id="loginbtn" href="<?php echo $basePath; ?>pages/login.php">Login</a>
    <?php endif; ?>
</nav>

<div id="clock" class="text-center mb-4">
    <span id="clock-text" class="clockTimer">Loading...</span><br>
    <span>(+6:00) GMT</span><br>
</div>

<script>
    var serverTime = <?php echo $serverTime; ?> * 1000; // Server time in milliseconds
    var clientOffset = new Date().getTime() - serverTime; // Calculate client's offset from the server

    function updateClock() {
        var now = new Date().getTime() - clientOffset; // Adjust client time to server time
        var date = new Date(now);
        var hours = String(date.getHours()).padStart(2, '0');
        var minutes = String(date.getMinutes()).padStart(2, '0');
        var seconds = String(date.getSeconds()).padStart(2, '0');
        document.getElementById('clock-text').textContent = hours + ":" + minutes + ":" + seconds;
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>

<?php
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: {$basePath}index.php");
    exit();
}
?>
