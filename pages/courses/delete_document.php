<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user']) || $_POST['video_id'] == null) {
    echo "Unauthorized or missing data";
    exit;
}

$video_id = $_POST['video_id'];

// Check if the user is the author of the video
$check_sql = "SELECT user_id FROM videos WHERE id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $video_id);
$check_stmt->execute();
$result = $check_stmt->get_result();
$video = $result->fetch_assoc();

if ($video['user_id'] != $_SESSION['user']['UserID']) {
    echo "Unauthorized";
    exit;
}

// Delete the document
$delete_sql = "DELETE FROM video_documents WHERE video_id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("i", $video_id);
$delete_stmt->execute();

echo "Document deleted successfully";