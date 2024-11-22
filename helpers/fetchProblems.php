<?php
header('Content-Type: application/json');
include 'config.php';

// Set timezone to Asia/Dhaka
date_default_timezone_set('Asia/Dhaka');

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$rating = isset($_GET['rating']) ? $_GET['rating'] : '';
$tags = isset($_GET['tags']) ? $_GET['tags'] : '';

$limit = 10;
$offset = ($page - 1) * $limit;

// Get the current time based on PHP timezone
$currentTime = date('Y-m-d H:i:s');

// Main query to fetch problems and filter them based on contest status
$query = "SELECT problems.*, GROUP_CONCAT(tags.TagName SEPARATOR ', ') AS Tags 
          FROM problems 
          LEFT JOIN problem_tags ON problems.ProblemID = problem_tags.ProblemID 
          LEFT JOIN tags ON problem_tags.TagID = tags.TagID 
          WHERE 1=1
          AND (
              problems.ProblemID NOT IN (
                  SELECT ProblemID FROM contestproblems cp
                  INNER JOIN contests c ON cp.ContestID = c.ContestID
                  WHERE c.EndTime > ?
              )
          )"; // Exclude problems from contests that have not yet finished

// Apply filters
if ($search != '') {
    $query .= " AND problems.Name LIKE ?";
}
if ($rating != '') {
    $query .= " AND problems.RatedFor = ?";
}
if ($tags != '') {
    $query .= " AND problems.ProblemID IN (SELECT ProblemID FROM problem_tags WHERE TagID = ?)";
}

$query .= " GROUP BY problems.ProblemID";

// Prepare and bind parameters for secure filtering
$stmt = $conn->prepare($query);
$params = [$currentTime];

if ($search != '') {
    $params[] = '%' . $search . '%';
}
if ($rating != '') {
    $params[] = intval($rating);
}
if ($tags != '') {
    $params[] = intval($tags);
}

// Dynamically bind parameters
$types = str_repeat('s', count($params));
$stmt->bind_param($types, ...$params);
$stmt->execute();

$totalProblemsResult = $stmt->get_result();
if (!$totalProblemsResult) {
    die(json_encode(["error" => "Query failed: " . $conn->error]));
}

$totalProblems = $totalProblemsResult->num_rows;
$totalPages = ceil($totalProblems / $limit);

// Add pagination to the query
$query .= " LIMIT $limit OFFSET $offset";
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();

$result = $stmt->get_result();
if (!$result) {
    die(json_encode(["error" => "Query failed: " . $conn->error]));
}

// Build the HTML for the problems table rows
$problems = '';
while ($row = $result->fetch_assoc()) {
    $problems .= '<tr>';
    $problems .= '<th scope="row">' . $row['ProblemID'] . '</th>';
    $problems .= '<td><a href="problemPage.php?id=' . $row['ProblemID'] . '">' . $row['Name'] . '</a></td>';
    $problems .= '<td>' . $row['RatedFor'] . '</td>';
    $problems .= '<td>' . $row['Tags'] . '</td>';
    $problems .= '</tr>';
}

// Prepare the JSON response
$response = [
    'problems' => $problems,
    'totalPages' => $totalPages
];

echo json_encode($response);

$conn->close();
?>
