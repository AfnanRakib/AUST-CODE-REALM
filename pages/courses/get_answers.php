<?php
require_once 'config.php';

$question_id = $_GET['question_id'];

$sql = "SELECT a.*, u.Handle as user_handle, u.Profile_Picture as user_profile_picture 
        FROM answers a
        JOIN users u ON a.user_id = u.UserID
        WHERE a.question_id = ? ORDER BY a.created_at ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $question_id);
$stmt->execute();
$result = $stmt->get_result();

$answers = [];
while ($row = $result->fetch_assoc()) {
    $answers[] = $row;
}

echo json_encode($answers);

$stmt->close();
$conn->close();
?>