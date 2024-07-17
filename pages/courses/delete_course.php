<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user']['UserID'])) {
    die("Unauthorized access");
}

$course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : 0;

if ($course_id === 0) {
    die("Invalid course ID");
}

$delete_sql = "DELETE FROM courses WHERE id = ? AND user_id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("ii", $course_id, $_SESSION['user']['UserID']);

if ($delete_stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>