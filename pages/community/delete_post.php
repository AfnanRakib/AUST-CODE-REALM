<?php
require_once '../courses/config.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$post_id = $_GET['id'];

$sql = "DELETE FROM posts WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $post_id, $_SESSION['user']['UserID']);

if ($stmt->execute()) {
    header("Location: community.php");
    exit();
} else {
    echo "Error deleting post: " . $conn->error;
}