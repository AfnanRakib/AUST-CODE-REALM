<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'aust_code_realm');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$contest_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT * FROM contests WHERE id = $contest_id";
$contestResult = $conn->query($query);
$contest = $contestResult->fetch_assoc();

$query = "SELECT p.* FROM problems p
          INNER JOIN contest_problems cp ON p.id = cp.problem_id
          WHERE cp.contest_id = $contest_id";
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
    <title><?php echo $contest['contest_name']; ?> - AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include '../helpers/navbar.php'; ?>
    
    <!-- Contest Details Section -->
    <div class="container mt-5">
        <h1 class="text-center mb-4"><?php echo $contest['contest_name']; ?></h1>
        <p><strong>Start Time:</strong> <?php echo $contest['start_time']; ?></p>
        <p><strong>Duration:</strong> <?php echo $contest['duration']; ?></p>
        <p><strong>Status:</strong> <?php echo $contest['status']; ?></p>

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
                    echo '<th scope="row">' . $row['id'] . '</th>';
                    echo '<td><a href="problemPage.php?id=' . $row['id'] . '">' . $row['problem_name'] . '</a></td>';
                    echo '<td>' . $row['rating'] . '</td>';
                    echo '<td>' . $row['tags'] . '</td>';
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
