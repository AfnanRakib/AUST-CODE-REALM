<?php
header('Content-Type: application/json');
include 'config.php';

// Set PHP timezone to Asia/Dhaka
date_default_timezone_set('Asia/Dhaka');

$contestId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the contest details
$query = "SELECT * FROM contests WHERE ContestID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $contestId);
$stmt->execute();
$result = $stmt->get_result();


if (!$result) {
    die(json_encode(["error" => "Query failed: " . $conn->error]));
}

$contest = $result->fetch_assoc();

if (!$contest) {
    die(json_encode(["error" => "Contest not found."]));
}

// Get current server time in the configured timezone
$currentTime = date('Y-m-d H:i:s');

// Convert contest times to PHP timezone
$startTime = date('Y-m-d H:i:s', strtotime($contest['StartTime']));
$endTime = date('Y-m-d H:i:s', strtotime($contest['EndTime']));

// Initialize the problems array as empty
$problems = [];

// Only fetch problems if the contest has started
if ($currentTime >= $startTime) {
    $query = "SELECT p.* FROM problems p
              INNER JOIN contestproblems cp ON p.ProblemID = cp.ProblemID
              WHERE cp.ContestID = ?
              ORDER BY p.ProblemNumber";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $contestId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $problems[] = $row;
        }
    }
}

// Prepare the response
$response = [
    'title' => $contest['Title'],
    'startTime' => $startTime,
    'endTime' => $endTime,
    'duration' => $contest['Duration'],
    'description' => $contest['Description'],
    'problems' => $problems // This will be empty if the contest has not started
];

echo json_encode($response);
$conn->close();
?>
