<?php
// Function to get the current page URL
    function currentPageURL() {
        $currentURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
        $currentURL .= $_SERVER["SERVER_NAME"];
        if ($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443") {
            $currentURL .= ":".$_SERVER["SERVER_PORT"];
        }
        $currentURL .= $_SERVER["REQUEST_URI"];
        return $currentURL;
    }
//session_start();
$basePath = 'http://localhost:3000/';//'http://localhost/AUST%20CODE%20REALM/';
$isLoggedIn = false;//isset($_SESSION['user_id']);
function isActive($page) {
        return (strpos(currentPageURL(), $page) !== false) ? 'active' : '';
    }
?>
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="<?php echo $basePath; ?>index.php"><img src="<?php echo $basePath; ?>images/logo.png" alt="ACR"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item <?php echo isActive('index.php'); ?>">
                <a class="nav-link" href="<?php echo $basePath; ?>index.php">Home</a>
            </li>
            <li class="nav-item <?php echo isActive('contests.php'); ?>">
                <a class="nav-link" href="<?php echo $basePath; ?>pages/contestSet.php">Contests</a>
            </li>
            <li class="nav-item <?php echo isActive('problemSet.php'); ?>">
                <a class="nav-link" href="<?php echo $basePath; ?>pages/problemSet.php">Problems</a>
            </li>
            <li class="nav-item <?php echo isActive('courses.php'); ?>">
                <a class="nav-link" href="<?php echo $basePath; ?>pages/courses.php">Courses</a>
            </li>
            <li class="nav-item <?php echo isActive('help.php'); ?>">
                <a class="nav-link" href="<?php echo $basePath; ?>pages/help.php">Help</a>
            </li>
        </ul>
    </div>
    <a class="profile-link" href="<?php echo $isLoggedIn ? $basePath . 'pages/profilePage.php' : $basePath . 'pages/login.php'; ?>">
        <img src="<?php echo $basePath; ?>images/user.png" alt="Profile" class="profile-icon">
    </a>
</nav>
<style>
    /* Style for active link */
    .navbar-nav .nav-item.active a {
        color: rgb(3, 191, 98) !important; 
    }
</style>

