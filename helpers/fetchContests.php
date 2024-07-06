<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'aust_code_realm');

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

$limit = 10;
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM contests WHERE 1=1";
if ($search != '') {
    $query .= " AND contest_name LIKE '%" . $conn->real_escape_string($search) . "%'";
}
if ($status != '') {
    $query .= " AND status = '" . $conn->real_escape_string($status) . "'";
}

$totalContestsResult = $conn->query($query);
if (!$totalContestsResult) {
    die(json_encode(["error" => "Query failed: " . $conn->error]));
}

$totalContests = $totalContestsResult->num_rows;
$totalPages = ceil($totalContests / $limit);

$query .= " LIMIT $limit OFFSET $offset";
$result = $conn->query($query);
if (!$result) {
    die(json_encode(["error" => "Query failed: " . $conn->error]));
}

$contests = '';
while ($row = $result->fetch_assoc()) {
    $contests .= '<tr>';
    $contests .= '<th scope="row">' . $row['id'] . '</th>';
    $contests .= '<td><a href="contestPage.php?id=' . $row['id'] . '">' . $row['contest_name'] . '</a></td>';
    $contests .= '<td>' . $row['start_time'] . '</td>';
    $contests .= '<td>' . $row['duration'] . '</td>';
    $contests .= '<td>' . $row['status'] . '</td>';
    $contests .= '</tr>';
}

$response = [
    'contests' => $contests,
    'totalPages' => $totalPages
];

echo json_encode($response);

$conn->close();
?>
