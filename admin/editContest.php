<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user']['UserID'])) {
    header("Location: login.php");
    exit();
}

include '../helpers/config.php';

// Set PHP timezone
date_default_timezone_set('Asia/Dhaka');

$contestID = $_GET['id'] ?? null;
$message = '';
$messageClass = '';

if (!$contestID) {
    header("Location: manageContests.php");
    exit();
}

// Fetch the contest details
$query = "SELECT * FROM contests WHERE ContestID = ? AND CreatorID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $contestID, $_SESSION['user']['UserID']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: manageContests.php");
    exit();
}

$contest = $result->fetch_assoc();

// Handle updating contest details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['description'], $_POST['start_time'], $_POST['end_time'], $_POST['duration'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];
    $duration = $_POST['duration'];

    // Update contest details in the database
    $updateQuery = "UPDATE contests SET Title = ?, Description = ?, StartTime = ?, EndTime = ?, Duration = ? WHERE ContestID = ? AND CreatorID = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sssssii", $title, $description, $startTime, $endTime, $duration, $contestID, $_SESSION['user']['UserID']);

    if ($updateStmt->execute()) {
        $message = "Contest details updated successfully.";
        $messageClass = 'alert-success';

        // Refresh the contest details after updating
        $stmt->execute();
        $contest = $stmt->get_result()->fetch_assoc();
    } else {
        $message = "Failed to update contest details.";
        $messageClass = 'alert-danger';
    }
}

// Fetch existing problems for the contest
$problemQuery = "SELECT * FROM contestproblems WHERE ContestID = ?";
$problemStmt = $conn->prepare($problemQuery);
$problemStmt->bind_param("i", $contestID);
$problemStmt->execute();
$problemsResult = $problemStmt->get_result();

$problems = [];
while ($row = $problemsResult->fetch_assoc()) {
    $problems[] = $row['ProblemID'];
}

// Handle deletion of a problem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_problem'])) {
    $problemID = intval($_POST['problem_id']);
    $deleteQuery = "DELETE FROM contestproblems WHERE ContestID = ? AND ProblemID = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("ii", $contestID, $problemID);
    if ($deleteStmt->execute()) {
        $message = "Problem removed successfully.";
        $messageClass = 'alert-success';
    } else {
        $message = "Failed to remove problem.";
        $messageClass = 'alert-danger';
    }
    header("Location: editContest.php?id=$contestID");
    exit();
}

// Handle addition of a new problem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_problem'])) {
    $problemID = intval($_POST['new_problem_id']);
    $insertQuery = "INSERT INTO contestproblems (ContestID, ProblemID) VALUES (?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("ii", $contestID, $problemID);
    if ($insertStmt->execute()) {
        $message = "Problem added successfully.";
        $messageClass = 'alert-success';
    } else {
        $message = "Failed to add problem.";
        $messageClass = 'alert-danger';
    }
    header("Location: editContest.php?id=$contestID");
    exit();
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
    <title>Edit Contest</title>
</head>
<body>
<?php include '../helpers/navbar.php'; ?>
<div class="container mt-5">
    <h1>Edit Contest</h1>

    <?php if ($message): ?>
        <div class="alert <?php echo $messageClass; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($contest['Title']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($contest['Description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="start_time" class="form-label">Start Time</label>
            <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="<?php echo date('Y-m-d\TH:i', strtotime($contest['StartTime'])); ?>" required>
        </div>
        <div class="mb-3">
            <label for="end_time" class="form-label">End Time</label>
            <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="<?php echo date('Y-m-d\TH:i', strtotime($contest['EndTime'])); ?>" required>
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label">Duration (H:i:s)</label>
            <input type="text" class="form-control" id="duration" name="duration" value="<?php echo htmlspecialchars($contest['Duration']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Contest</button>
    </form>

    <h2 class="mt-5">Manage Problems</h2>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Problem ID</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($problems as $problemID): ?>
                <tr>
                    <td><?php echo $problemID; ?></td>
                    <td>
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="problem_id" value="<?php echo $problemID; ?>">
                            <button type="submit" name="delete_problem" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Add New Problem</h3>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="new_problem_id" class="form-label">Problem ID</label>
            <input type="text" class="form-control" id="new_problem_id" name="new_problem_id" required>
        </div>
        <button type="submit" name="add_problem" class="btn btn-success">Add Problem</button>
    </form>
    <br>
</div>
<br>
<script src="../js/bootstrap.bundle.min.js"></script>
</body>
</html>
