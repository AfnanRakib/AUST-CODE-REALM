<?php

include '../helpers/config.php';

$contest_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT * FROM contests WHERE ContestID = $contest_id";
$contestResult = $conn->query($query);
$contest = $contestResult->fetch_assoc();

$query = "SELECT p.* FROM problems p
          INNER JOIN contestproblems cp ON p.ProblemID = cp.ProblemID
          WHERE cp.ContestID = $contest_id";
$problemsResult = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/contestPage.css">
    <title><?php echo $contest['Title']; ?> - AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>
    
    <!-- Contest Details Section -->
    <div class="container mt-5">
        <h1 class="text-center mb-4"><?php echo $contest['Title']; ?></h1>
        <p><strong>Start Time:</strong> <?php echo $contest['Description']; ?></p>
        <p><strong>Duration:</strong> <?php echo $contest['StartTime']; ?></p>
        <p><strong>Status:</strong> <?php echo $contest['EndDate']; ?></p>
        <p><strong>Status:</strong> <?php echo $contest['Duration']; ?></p>

        <!-- Problems Related to Contest -->
        <h2 class="mt-5">Problems</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Problem</th>
                    <th scope="col">Rating</th>
                    <th scope="col">Tags</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $problemsResult->fetch_assoc()) {
                    echo '<tr>';
                    echo '<th scope="row">' . $row['ProblemID'] . '</th>';
                    echo '<td><a href="problemPage.php?id=' . $row['ProblemID'] . '">' . $row['Name'] . '</a></td>';
                    echo '<td>' . $row['RatedFor'] . '</td>';
                    echo '<td>' . $row['TagID'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="../js/jquery-3.1.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
