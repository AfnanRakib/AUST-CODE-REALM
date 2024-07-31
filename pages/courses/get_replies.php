<?php
require_once 'config.php';

$comment_id = $_GET['comment_id'];

$replies_sql = "SELECT r.*, u.Handle, u.Profile_Picture FROM replies r 
                JOIN users u ON r.user_id = u.UserID 
                WHERE r.comment_id = ? ORDER BY r.created_at ASC";
$replies_stmt = $conn->prepare($replies_sql);
$replies_stmt->bind_param("i", $comment_id);
$replies_stmt->execute();
$replies_result = $replies_stmt->get_result();

$replies = [];
while ($reply = $replies_result->fetch_assoc()) {
    $replies[] = $reply;
}

header('Content-Type: application/json');
echo json_encode($replies);

$replies_stmt->close();
$conn->close();
?>