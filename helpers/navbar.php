<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Dhaka'); // Set PHP timezone
$basePath = 'http://localhost/AUST%20CODE%20REALM/';
$isLoggedIn = isset($_SESSION['user']);
$handle = $isLoggedIn ? $_SESSION['user']['Handle'] : 'Guest User';

// Server time and offset
$serverTime = time(); // Server's current time (seconds since Unix Epoch)
$gmtOffset = date('P'); // Server's GMT offset (e.g., "+06:00")

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: {$basePath}index.php");
    exit();
}
?>

<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="<?php echo $basePath; ?>index.php"><img src="" alt="ACR"></a>
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
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $basePath; ?>pages/community/community.php">Community</a>
            </li>
        </ul>
    </div>
    <?php if ($isLoggedIn): ?>
        <div class="dropdown profile-dropdown">
            <div class="profile-link dropdown-toggle" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?php echo $basePath; ?>images/icons/user.png" alt="Profile" class="profile-icon">
                <p class="handle"><?php echo $handle;?></p>
            </div>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?php echo $basePath; ?>pages/profilePage.php?id=<?php echo $_SESSION['user']['UserID']; ?>"><img src="<?php echo $basePath; ?>images/icons/profile.png" alt="Profile Icon" class="dropdown-icon"> Profile</a></li>
                <li><a class="dropdown-item" href="<?php echo $basePath; ?>pages/submissions.php"><img src="<?php echo $basePath; ?>images/icons/list1.png" alt="Profile Icon" class="dropdown-icon">My Submissions</a></li>
                <?php if(($isLoggedIn) && $_SESSION['user']['User_Role']=='admin'): ?>
                    <li class="nav-item">
                        <li><a class="dropdown-item" href="<?php echo $basePath; ?>admin/userCreatedProblems.php">
                        <img src="<?php echo $basePath; ?>images/icons/document.png" alt="Settings Icon" class="dropdown-icon">My Problems</a></li>
                    <li class="nav-item">
                        <li><a class="dropdown-item" href="<?php echo $basePath; ?>admin/manageContest.php">
                        <img src="<?php echo $basePath; ?>images/icons/calendar.png" alt="Settings Icon" class="dropdown-icon">My Contests</a>
                    </li>
                <?php endif; ?>
                <li><a class="dropdown-item" href="<?php echo $basePath; ?>pages/editProfile.php"><img src="<?php echo $basePath; ?>images/icons/settings.png" alt="Settings Icon" class="dropdown-icon"> Edit Profile</a></li>
                <li><a class="dropdown-item" href="javascript:void(0)" onclick="openSearchUserModal()"><img src="<?php echo $basePath; ?>images/icons/follower.png" alt="Search Profile Icon" class="dropdown-icon"> Search User</a></li>
                <li><a class="dropdown-item" href="<?php echo $basePath; ?>index.php?logout=true"><img src="<?php echo $basePath; ?>images/icons/logout.png" alt="Logout Icon" class="dropdown-icon"> Logout</a></li>
            </ul>
        </div>
    <?php else: ?>
        <a class="btn btn-primary" id="loginbtn" href="<?php echo $basePath; ?>pages/login.php">Login</a>
    <?php endif; ?>
</nav>

<!-- Search User Modal -->
<div id="searchUserModal" class="search-user-modal">
    <div class="search-user-modal-content">
        <span class="search-user-close" onclick="closeSearchUserModal()">&times;</span>
        <h2>Search User</h2>
        <input type="text" id="searchUserInput" placeholder="Enter username">
        <button class="search-user-button" onclick="searchUser()">Search</button>
    </div>
</div>

<script>
    function openSearchUserModal() {
        document.getElementById('searchUserModal').style.display = 'block';
    }

    function closeSearchUserModal() {
        document.getElementById('searchUserModal').style.display = 'none';
    }

    function searchUser() {
        var username = document.getElementById('searchUserInput').value;
        if (username.trim() === '') {
            alert('Please enter a username to search.');
            return;
        }

        // AJAX request to search user
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo $basePath; ?>helpers/searchUserHandler.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            window.location.href = '<?php echo $basePath; ?>pages/profilePage.php?id=' + response.userId;
                        } else {
                            alert('No such user exists.');
                        }
                    } catch (e) {
                        alert('An error occurred while processing your request. Please try again.');
                    }
                } else {
                    alert('An error occurred: ' + xhr.status);
                }
            }
        };
        xhr.send('username=' + encodeURIComponent(username));
    }
</script>


<a id="toggleClockBtn" href="javascript:void(0)" onclick="toggleClock()" class="text-center">
    <div id="toggle-btn" class="text-center">〉</div>
</a>
<a href="https://www.timeanddate.com/worldclock/" target="_blank">
    <div id="clock" class="text-center">
        <span id="clock-text" style="font-weight: 600;font-size: larger;">Loading...</span>
        <span id="gmt-offset" style="font-size:smaller;"></span><br>
        <span id="date"></span><br>
    </div>
</a>
<script>
    var serverTime = <?php echo $serverTime; ?> * 1000; // Server time in milliseconds
    var gmtOffset = "<?php echo $gmtOffset; ?>"; // Server's GMT offset
    var clientOffset = new Date().getTime() - serverTime; // Calculate client-side offset from server time

    function updateClock() {
        var now = new Date(new Date().getTime() - clientOffset); // Adjust client time to server time
        var date = new Date(now);

        var formattedDate = `${date.getDate()} ${date.toLocaleString('default', { month: 'short' })}, ${date.getFullYear()}`;
        var timeString = `${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}:${String(date.getSeconds()).padStart(2, '0')}`;

        document.getElementById('clock-text').textContent = timeString;
        document.getElementById('gmt-offset').textContent = '(' + gmtOffset + ')';
        document.getElementById('date').textContent = formattedDate;
    }

    function toggleClock() {
        var clock = document.getElementById('clock');
        var toggleBtn = document.getElementById('toggle-btn');

        if (clock.style.transform === "translateX(160px)") {
            clock.style.transform = "translateX(0)";
            toggleBtn.style.transform = "translateX(0)";
            toggleBtn.textContent = "〉";
        } else {
            clock.style.transform = "translateX(160px)";
            toggleBtn.style.transform = "translateX(160px)";
            toggleBtn.textContent = "〈";
        }
    }

    updateClock();
    setInterval(updateClock, 1000);
</script>
