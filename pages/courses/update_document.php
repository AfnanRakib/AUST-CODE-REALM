<?php
require_once 'config.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user']) || $_POST['video_id'] == null || $_POST['content'] == null) {
    echo "Unauthorized or missing data";
    exit;
}

$video_id = $_POST['video_id'];
$content = $_POST['content'];

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

// Check if a document already exists
$check_doc_sql = "SELECT id FROM video_documents WHERE video_id = ?";
$check_doc_stmt = $conn->prepare($check_doc_sql);
$check_doc_stmt->bind_param("i", $video_id);
$check_doc_stmt->execute();
$doc_result = $check_doc_stmt->get_result();

if ($doc_result->num_rows > 0) {
    // Update existing document
    $update_sql = "UPDATE video_documents SET content = ? WHERE video_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("si", $content, $video_id);
    if ($update_stmt->execute()) {
        echo "Document updated successfully";
    } else {
        echo "Error updating document: " . $update_stmt->error;
    }
} else {
    // Insert new document
    $insert_sql = "INSERT INTO video_documents (video_id, content) VALUES (?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("is", $video_id, $content);
    if ($insert_stmt->execute()) {
        echo "Document uploaded successfully";
    } else {
        echo "Error uploading document: " . $insert_stmt->error;
    }
}