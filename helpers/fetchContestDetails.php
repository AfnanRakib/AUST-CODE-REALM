<?php
header('Content-Type: application/json');
include 'config.php';

$contestId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = "SELECT * FROM contests WHERE ContestID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $contestId);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die(json_encode(["error" => "Query failed: " . $conn->error]));
}

$contest = $result->fetch_assoc();

$query = "SELECT p.* FROM problems p
          INNER JOIN contestproblems cp ON p.ProblemID = cp.ProblemID
          WHERE cp.ContestID = $contestId";
$result = $conn->query($query);

if (!$result) {
    die(json_encode(["error" => "Query failed: " . $conn->error]));
}

$problems = [];
while ($row = $result->fetch_assoc()) {
    $problems[] = $row;
}

$response = [
    'title' => $contest['Title'],
    'startTime' => $contest['StartTime'],
    'endTime' => $contest['EndTime'],
    'duration' => $contest['Duration'],
    'description' => $contest['Description'],
    'problems' => $problems
];

echo json_encode($response);
$conn->close();
?>
