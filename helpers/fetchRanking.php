<?php
include 'config.php';

$handle = isset($_GET['handle']) ? $_GET['handle'] : '';
$contest_id = isset($_GET['contestId']) ? intval($_GET['contestId']) : 0;

$sql = "SELECT p.ProblemID, cs.Status, 
               TIME_TO_SEC(TIMEDIFF(cs.SubmissionTime, c.StartTime)) + (cs.attempts - 1) * 20 * 60 as penalty 
        FROM contest_submissions cs 
        JOIN users u ON cs.UserID = u.UserID 
        JOIN problems p ON cs.ProblemID = p.ProblemID 
        JOIN contests c ON cs.ContestID = c.ContestID 
        WHERE u.Handle = ? AND cs.ContestID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $handle, $contest_id);
$stmt->execute();
$result = $stmt->get_result();

$details = '';
while ($row = $result->fetch_assoc()) {
    $details .= "<tr>
                    <td>{$row['ProblemID']}</td>
                    <td>{$row['Status']}</td>
                    <td>{$row['penalty']}</td>
                 </tr>";
}

$stmt->close();
echo $details;
?>
