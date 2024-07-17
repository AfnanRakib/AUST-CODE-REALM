<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user']['UserID'])) {
    die("Unauthorized access");
}

$video_id = isset($_POST['video_id']) ? intval($_POST['video_id']) : 0;

if ($video_id === 0) {
    die("Invalid video ID");
}

$delete_sql = "DELETE v FROM videos v JOIN courses c ON v.course_id = c.id WHERE v.id = ? AND c.user_id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("ii", $video_id, $_SESSION['user']['UserID']);

if ($delete_stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>