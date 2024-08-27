<?php
session_start();
if (!isset($_SESSION['user']['UserID'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
$profile_picture_src = empty($user['Profile_Picture']) ? '../images/uploads/profile_pictures/default.png' : $user['Profile_Picture'];

include '../helpers/config.php';

$userId = $_SESSION['user']['UserID'];
$sql = "SELECT DATE_FORMAT(SubmissionTime, '%Y-%c-%e') as date, COUNT(*) as value FROM submissions WHERE UserID = ? GROUP BY DATE(SubmissionTime)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

$submissions = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $submissions[] = array('date' => $row['date'], 'value' => $row['value']);
    }
} else {
    $submissions = [];
}

$stmt->close();
$conn->close();
?>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/footer.css">
    <script src="../js/jquery-2.0.3.min.js"></script>
    <script src="../js/jquery.glanceyear.min.js"></script>
    <script src="../js/chart.js"></script>
    <script src="../js/chartjs-adapter-date-fns.js"></script>
    <title><?php echo $user['Name']; ?> - AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>
    <!-- Section -->
    <section class="profile-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="<?php echo $profile_picture_src; ?>" alt="Profile Picture" id="profile-img" class="img-fluid rounded-circle mb-3">
                    <h2 id="username"><?php echo $user['Handle']; ?></h2>
                    <p><strong>Rating:</strong> <?php echo "{$user['CurrentRating']} , {$user['RatingCategory']} ( Max Rating: {$user['MaxRating']})"; ?></p>
                    <div class="user-details">
                        <p><strong>Full Name:</strong> <?php echo $user['Name']; ?></p>
                        <p><strong>Email:</strong> <?php echo $user['Email']; ?></p>
                        <p><strong>Date Joined:</strong> <?php echo date("F j, Y", strtotime($user['DateJoined'])); ?></p>
                        <?php if (!empty($user['Institution'])): ?>
                            <p><strong>Institution:</strong> <?php echo $user['Institution']; ?></p>
                        <?php endif; ?>
                        <?php if (!empty($user['DateOfBirth'])): ?>
                            <p><strong>Gender:</strong> <?php echo $user['Gender']; ?></p>
                        <?php endif; ?>
                        <?php if (!empty($user['DateOfBirth'])): ?>
                            <p><strong>Date of Birth:</strong> <?php echo date("F j, Y", strtotime($user['DateOfBirth'])); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-7" style="padding:10px; margin: auto;">
                    <h3>Activity Graph</h3>
                    <div class="container-graph">
                        <?php include '../helpers/ratingGraph.php'; ?>
                    </div>
                    <div style="height: 10px;"></div>
                    <h3>Problem Solving Activity</h3>
                    <div class="container-graph">
                        <?php include '../helpers/heatmap.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include'../helpers/footer.php'?>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
