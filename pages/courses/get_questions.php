<?php
require_once 'config.php';

$video_id = $_GET['video_id'];

$sql = "SELECT q.*, u.Handle as user_handle, u.Profile_Picture as user_profile_picture 
        FROM questions q
        JOIN users u ON q.user_id = u.UserID
        WHERE q.video_id = ? ORDER BY q.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $video_id);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}

echo json_encode($questions);

$stmt->close();
$conn->close();
?>