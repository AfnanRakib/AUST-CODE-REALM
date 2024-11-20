<?php
header('Content-Type: application/json');
include 'config.php';

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

// Get current server time
$currentTime = date('Y-m-d H:i:s');

// Initialize the problems array as empty
$problems = [];

// Only fetch problems if the contest has started
if ($currentTime >= $contest['StartTime']) {
    $query = "SELECT p.* FROM problems p
              INNER JOIN contestproblems cp ON p.ProblemID = cp.ProblemID
              WHERE cp.ContestID = ?";
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
    'startTime' => $contest['StartTime'],
    'endTime' => $contest['EndTime'],
    'duration' => $contest['Duration'],
    'description' => $contest['Description'],
    'problems' => $problems // This will be empty if the contest has not started
];

echo json_encode($response);
$conn->close();
?>
