<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/profilePage.css">
    <link rel="stylesheet" href="../css/ratingGraph.css">
    <link rel="stylesheet" href="../css/navbar.css">

    <link rel="stylesheet" href="../css/glanceyear.css">
    <link rel="stylesheet" href="../css/ratingGraph.css">
    <script src="../js/jquery-2.0.3.min.js"></script><!-- https://code.jquery.com/jquery-2.0.3.min.js -->
    <script src="../js/jquery.glanceyear.min.js"></script>
    <script src="../js/chart.js"></script><!--https://cdn.jsdelivr.net/npm/chart.js-->
    <script src="../js/chartjs-adapter-date-fns.js"></script><!--https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns-->
    <title>AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>
    
    <!-- Section -->
    <section class="profile-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="container">
                        <img src="../images/logo with cover.png" alt="Profile Picture" class="img-fluid rounded-circle mb-3">
                    </div>
                    <div class="container">
                        <h2 id="username">Afnan Rakib</h2>
                        <p id="user-rating">Contest rating: 1165 (max. newbie, 1165)</p>
                        <a href="#" class="btn btn-link">Change settings</a><br>
                        <a href="#" class="btn btn-link"><span>afnanhaasdfdsfsfasdsanrakib476@gmail.com (not visible)</span></a><br>
                        <p id="user-last-visit">Last visit: 32 minutes ago</p>
                        <p id="user-registered">Registered: 2 years ago</p>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-7" style="padding:10px; margin: auto;">
                    <h3>Activity Graph</h3>
                    <div class="container-graph">
                        <?php include'../helpers/ratingGraph.php'?>
                    </div>
                    <div style="height: 10px;"></div>
                    <h3>Problem Solving Activity</h3>
                    <div class="container-graph">
                        <?php include'../helpers/heatmap.php'?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
