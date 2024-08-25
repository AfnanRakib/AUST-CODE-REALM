<?php
require_once '../courses/config.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment_id = $_POST['comment_id'];
    $post_id = $_POST['post_id'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user']['UserID'];

    $sql = "INSERT INTO post_comment_replies (comment_id, user_id, content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $comment_id, $user_id, $content);

    if ($stmt->execute()) {
        header("Location: view_post.php?id=" . $post_id);
        exit();
    } else {
        echo "Error adding reply: " . $conn->error;
    }
}