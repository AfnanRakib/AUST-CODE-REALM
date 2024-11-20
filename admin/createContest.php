<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user']['UserID'])) {
    header("Location: login.php");
    exit();
}

include '../helpers/config.php';

$message = '';
$messageClass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $startTime = $_POST['start_time'] ?? '';
    $endTime = $_POST['end_time'] ?? '';
    $duration = $_POST['duration'] ?? '';
    $problems = $_POST['problems'] ?? '';

    $userID = $_SESSION['user']['UserID'];

    if (empty($title) || empty($description) || empty($startTime) || empty($endTime) || empty($duration)) {
        $message = "All fields are required.";
        $messageClass = 'alert-danger';
    } else {
        // Insert the contest
        $insertQuery = "INSERT INTO contests (Title, Description, StartTime, EndTime, Duration, CreatorID) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssssi", $title, $description, $startTime, $endTime, $duration, $userID);

        if ($stmt->execute()) {
            $contestID = $conn->insert_id;

            // Insert contest problems if provided
            if (!empty($problems)) {
                $problemIDs = explode(",", $problems);
                $insertProblemsQuery = "INSERT INTO contestproblems (ContestID, ProblemID) VALUES (?, ?)";
                $stmt = $conn->prepare($insertProblemsQuery);

                foreach ($problemIDs as $problemID) {
                    $problemID = intval($problemID);
                    $stmt->bind_param("ii", $contestID, $problemID);
                    $stmt->execute();
                }
            }

            $message = "Contest created successfully!";
            $messageClass = 'alert-success';
        } else {
            $message = "Error creating contest.";
            $messageClass = 'alert-danger';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="style.css">
    <title>Create Contest</title>
</head>
<body>
<?php include '../helpers/navbar.php'; ?>
<div class="container mt-5">
    <h1>Create Contest</h1>

    <?php if ($message): ?>
        <div class="alert <?php echo $messageClass; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="datetime-local" class="form-control" id="start_time" name="start_time" required>
        </div>
        <div class="mb-3">
            <label for="end_time" class="form-label">End Time</label>
            <input type="datetime-local" class="form-control" id="end_time" name="end_time" required>
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label">Duration (H:i:s)</label>
            <input type="text" class="form-control" id="duration" name="duration" placeholder="E.g., 02:30:00" required>
        </div>
        <div class="mb-3">
            <label for="problems" class="form-label">Problem IDs (comma-separated)</label>
            <input type="text" class="form-control" id="problems" name="problems" placeholder="E.g., 1,2,3">
        </div>
        <button type="submit" class="btn btn-primary">Create Contest</button>
    </form>
</div>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
