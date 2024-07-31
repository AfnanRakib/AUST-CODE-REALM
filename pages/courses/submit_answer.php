<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$question_id = $_POST['question_id'];
$user_id = $_SESSION['user']['UserID'];
$content = $_POST['content'];

$sql = "INSERT INTO answers (question_id, user_id, content) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $question_id, $user_id, $content);

if ($stmt->execute()) {
    $newAnswer = [
        'id' => $stmt->insert_id,
        'content' => $content,
        'created_at' => date('Y-m-d H:i:s'),
        'user_handle' => $_SESSION['user']['Handle'],
        'user_profile_picture' => $_SESSION['user']['Profile_Picture'] ?? null
    ];
    echo json_encode(['success' => true, 'answer' => $newAnswer]);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$stmt->close();
$conn->close();