<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

include 'config.php';

$searchUsername = isset($_GET['searchUsername']) ? $_GET['searchUsername'] : '';
$searchProblem = isset($_GET['searchProblem']) ? $_GET['searchProblem'] : '';
$statusFilter = isset($_GET['statusFilter']) ? $_GET['statusFilter'] : '';
$showAll = isset($_GET['showAll']) ? intval($_GET['showAll']) : 1;

$query = "SELECT submissions.*, problems.Name AS ProblemName, users.Handle AS UserHandle
          FROM submissions
          LEFT JOIN problems ON submissions.ProblemID = problems.ProblemID
          LEFT JOIN users ON submissions.UserID = users.UserID
          WHERE 1=1";

if ($searchUsername !== '') {
    $query .= " AND users.Handle LIKE '%" . $conn->real_escape_string($searchUsername) . "%'";
}
if ($searchProblem !== '') {
    $query .= " AND problems.Name LIKE '%" . $conn->real_escape_string($searchProblem) . "%'";
}
if ($statusFilter !== '') {
    $query .= " AND submissions.Status LIKE '%" . $conn->real_escape_string($statusFilter) . "%'";
}
if (!$showAll) {
    $userId = $_SESSION['user']['UserID'];
    $query .= " AND submissions.UserID = " . intval($userId);
}


$query .= " ORDER BY submissions.SubmissionTime DESC";

$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}

while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<th scope="row"><a href="#" class="submission-id" data-code="'.htmlspecialchars($row['Code']).'" data-lang="'.htmlspecialchars($row['LanguageID']).'">' . $row['SubmissionID'] .'</a></th>';
    echo '<td><a href="problemPage.php?id=' . $row['ProblemID'] . '">' . $row['ProblemName'] . '</a></td>';
    echo '<td>' . $row['UserHandle'] . '</td>';
    echo '<td>' . $row['Status'] . '</td>';
    echo '<td>' . $row['SubmissionTime'] . '</td>';
    echo '<td>' . $row['TimeTaken'] . '</td>';
    echo '<td>' . $row['MemoryUsed'] . '</td>';
    echo '<td>' . $row['LanguageID'] . '</td>';
    echo '</tr>';
}

$conn->close();
?>
