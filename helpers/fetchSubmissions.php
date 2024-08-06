<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');

include 'config.php';

$searchUsername = isset($_GET['searchUsername']) ? $_GET['searchUsername'] : '';
$searchProblem = isset($_GET['searchProblem']) ? $_GET['searchProblem'] : '';
$statusFilter = isset($_GET['statusFilter']) ? $_GET['statusFilter'] : '';
$showAll = isset($_GET['showAll']) ? intval($_GET['showAll']) : 1;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$submissionsPerPage = isset($_GET['submissionsPerPage']) ? intval($_GET['submissionsPerPage']) : 20;
$offset = ($page - 1) * $submissionsPerPage;

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

// Get total count for pagination
$countQuery = str_replace("SELECT submissions.*, problems.Name AS ProblemName, users.Handle AS UserHandle", "SELECT COUNT(*) AS total", $query);
$countResult = $conn->query($countQuery);
$totalSubmissions = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalSubmissions / $submissionsPerPage);

$query .= " ORDER BY submissions.SubmissionTime DESC LIMIT $submissionsPerPage OFFSET $offset";

$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}

$submissionsHtml = '';
while ($row = $result->fetch_assoc()) {
    $statusClass = ($row['Status'] === 'Accepted') ? 'status-accepted' : 'status-rejected';
    $submissionsHtml .= '<tr>';
    $submissionsHtml .= '<th scope="row"><a href="#" class="submission-id" data-code="'.htmlspecialchars($row['Code']).'" data-lang="'.htmlspecialchars($row['LanguageID']).'">' . $row['SubmissionID'] .'</a></th>';
    $submissionsHtml .= '<td><a href="problemPage.php?id=' . $row['ProblemID'] . '">' . $row['ProblemName'] . '</a></td>';
    $submissionsHtml .= '<td>' . $row['UserHandle'] . '</td>';
    $submissionsHtml .= '<td>' . $row['SubmissionTime'] . '</td>';
    $submissionsHtml .= '<td>' . $row['TimeTaken'] . '</td>';
    $submissionsHtml .= '<td>' . $row['MemoryUsed'] . '</td>';
    $submissionsHtml .= '<td>' . $row['LanguageID'] . '</td>';
    $submissionsHtml .= '<td class="' . $statusClass . '">' . $row['Status'] . '</td>';
    $submissionsHtml .= '</tr>';
}

$response = [
    'submissionsHtml' => $submissionsHtml,
    'totalPages' => $totalPages
];

echo json_encode($response);

$conn->close();
?>
