<?php
header('Content-Type: application/json');

include 'config.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$rating = isset($_GET['rating']) ? $_GET['rating'] : '';
$tags = isset($_GET['tags']) ? $_GET['tags'] : '';

$limit = 10;
$offset = ($page - 1) * $limit;

$query = "SELECT problems.*, GROUP_CONCAT(tags.TagName SEPARATOR ', ') AS Tags 
          FROM problems 
          LEFT JOIN problem_tags ON problems.ProblemID = problem_tags.ProblemID 
          LEFT JOIN tags ON problem_tags.TagID = tags.TagID 
          WHERE 1=1";

if ($search != '') {
    $query .= " AND problems.Name LIKE '%" . $conn->real_escape_string($search) . "%'";
}
if ($rating != '') {
    $query .= " AND problems.RatedFor = " . intval($rating);
}
if ($tags != '') {
    $query .= " AND problems.ProblemID IN (SELECT ProblemID FROM problem_tags WHERE TagID = '" . $conn->real_escape_string($tags) . "')";
}

$query .= " GROUP BY problems.ProblemID";

$totalProblemsResult = $conn->query($query);
if (!$totalProblemsResult) {
    die(json_encode(["error" => "Query failed: " . $conn->error]));
}

$totalProblems = $totalProblemsResult->num_rows;
$totalPages = ceil($totalProblems / $limit);

$query .= " LIMIT $limit OFFSET $offset";
$result = $conn->query($query);
if (!$result) {
    die(json_encode(["error" => "Query failed: " . $conn->error]));
}

$problems = '';
while ($row = $result->fetch_assoc()) {
    $problems .= '<tr>';
    $problems .= '<th scope="row">' . $row['ProblemID'] . '</th>';
    $problems .= '<td><a href="problemPage.php?id=' . $row['ProblemID'] . '">' . $row['Name'] . '</a></td>';
    $problems .= '<td>' . $row['RatedFor'] . '</td>';
    $problems .= '<td>' . $row['Tags'] . '</td>';
    $problems .= '</tr>';
}

$response = [
    'problems' => $problems,
    'totalPages' => $totalPages
];

echo json_encode($response);

$conn->close();
?>
