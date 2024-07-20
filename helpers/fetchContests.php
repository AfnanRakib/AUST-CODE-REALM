<?php
header('Content-Type: application/json');

include 'config.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

$limit = 10;
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM contests WHERE 1=1";
if ($search != '') {
    $query .= " AND Title LIKE '%" . $conn->real_escape_string($search) . "%'";
}

$currentTime = date('Y-m-d H:i:s');
if ($status == 'upcoming') {
    $query .= " AND StartTime > '$currentTime'";
} elseif ($status == 'running') {
    $query .= " AND StartTime <= '$currentTime' AND EndTime >= '$currentTime'";
} elseif ($status == 'past') {
    $query .= " AND EndTime < '$currentTime'";
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
    $status = '';
    if ($row['StartTime'] > $currentTime) {
        $status = 'Upcoming';
    } elseif ($row['StartTime'] <= $currentTime && $row['EndTime'] >= $currentTime) {
        $status = 'Running';
    } else {
        $status = 'Past';
    }

    $contests .= '<tr>';
    $contests .= '<th scope="row">' . $row['ContestID'] . '</th>';
    $contests .= '<td><a href="contestPage.php?id=' . $row['ContestID'] . '">' . $row['Title'] . '</a></td>';
    $contests .= '<td>' . $row['StartTime'] . '</td>';
    $contests .= '<td>' . $row['EndTime'] . '</td>';
    $contests .= '<td>' . $row['Duration'] . '</td>';
    $contests .= '<td>' . $status . '</td>';
    $contests .= '</tr>';
}

$response = [
    'currentTime' => $currentTime,
    'contests' => $contests,
    'totalPages' => $totalPages
];

echo json_encode($response);

$conn->close();
?>
