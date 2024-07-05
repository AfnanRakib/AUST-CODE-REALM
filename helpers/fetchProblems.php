<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'aust_code_realm');

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$rating = isset($_GET['rating']) ? $_GET['rating'] : '';
$tags = isset($_GET['tags']) ? $_GET['tags'] : '';

$limit = 10;
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM problems WHERE 1=1";
if ($search != '') {
    $query .= " AND problem_name LIKE '%" . $conn->real_escape_string($search) . "%'";
}
if ($rating != '') {
    $query .= " AND rating = " . intval($rating);
}
if ($tags != '') {
    $query .= " AND tags LIKE '%" . $conn->real_escape_string($tags) . "%'";
}

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
    $problems .= '<th scope="row">' . $row['id'] . '</th>';
    $problems .= '<td><a href="problemPage.php?id=' . $row['id'] . '">' . $row['problem_name'] . '</a></td>';
    $problems .= '<td>' . $row['rating'] . '</td>';
    $problems .= '<td>' . $row['tags'] . '</td>';
    $problems .= '</tr>';
}

$response = [
    'problems' => $problems,
    'totalPages' => $totalPages
];

echo json_encode($response);

$conn->close();
?>
