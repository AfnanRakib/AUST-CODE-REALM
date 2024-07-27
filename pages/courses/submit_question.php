<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$video_id = $_POST['video_id'];
$user_id = $_SESSION['user']['UserID'];
$title = $_POST['title'];
$code = $_POST['code'];
$error_log = $_POST['error_log'];
$problem_description = $_POST['problem_description'];
$attempted_solutions = $_POST['attempted_solutions'];

$sql = "INSERT INTO questions (video_id, user_id, title, code, error_log, problem_description, attempted_solutions) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisssss", $video_id, $user_id, $title, $code, $error_log, $problem_description, $attempted_solutions);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$stmt->close();
$conn->close();