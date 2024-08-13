<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user']['UserID'])) {
    die(json_encode(['success' => false, 'error' => "Unauthorized access"]));
}

function extractYoutubeEmbedUrl($iframeCode) {
    $pattern = '/src="([^"]+)"/';
    if (preg_match($pattern, $iframeCode, $matches)) {
        return $matches[1];
    }
    return '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $video_id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($video_id === 0) {
        die(json_encode(['success' => false, 'error' => "Invalid video ID"]));
    }

    // Fetch video details to check if the user has permission to edit
    $check_sql = "SELECT v.* FROM videos v JOIN courses c ON v.course_id = c.id WHERE v.id = ? AND c.user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $video_id, $_SESSION['user']['UserID']);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows === 0) {
        die(json_encode(['success' => false, 'error' => "Video not found or you don't have permission to edit it"]));
    }

    $updates = [];
    $types = '';
    $params = [];

    if (isset($_POST['title']) && !empty($_POST['title'])) {
        $updates[] = "title = ?";
        $types .= "s";
        $params[] = $_POST['title'];
    }

    if (isset($_POST['description'])) {
        $updates[] = "description = ?";
        $types .= "s";
        $params[] = $_POST['description'];
    }

    if (isset($_POST['youtube_embed_url']) && !empty($_POST['youtube_embed_url'])) {
        $input = $_POST['youtube_embed_url'];
        $pattern = '/src="([^"]+)"/';
        
        if (preg_match($pattern, $input)) {
            // It's a full embed code, so we need to extract the URL
            $youtube_embed_url = extractYoutubeEmbedUrl($input);
        } else {
            // It's already just the URL, so we use it as is
            $youtube_embed_url = $input;
        }
    
        if (!empty($youtube_embed_url)) {
            $updates[] = "youtube_embed_url = ?";
            $types .= "s";
            $params[] = $youtube_embed_url;
        } else {
            die(json_encode(['success' => false, 'error' => "Invalid YouTube embed URL"]));
        }
    }

    if (!empty($updates)) {
        $update_sql = "UPDATE videos SET " . implode(", ", $updates) . " WHERE id = ?";
        $types .= "i";
        $params[] = $video_id;

        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param($types, ...$params);

        if ($update_stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } else {
        echo json_encode(['success' => true, 'message' => 'No changes detected']);
    }
} else {
    $video_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($video_id === 0) {
        die(json_encode(['success' => false, 'error' => "Invalid video ID"]));
    }

    // Fetch video details
    $video_sql = "SELECT v.* FROM videos v JOIN courses c ON v.course_id = c.id WHERE v.id = ? AND c.user_id = ?";
    $video_stmt = $conn->prepare($video_sql);
    $video_stmt->bind_param("ii", $video_id, $_SESSION['user']['UserID']);
    $video_stmt->execute();
    $video_result = $video_stmt->get_result();

    if ($video_result->num_rows === 0) {
        die(json_encode(['success' => false, 'error' => "Video not found or you don't have permission to edit it"]));
    }

    $video = $video_result->fetch_assoc();
    echo json_encode($video);
}

$conn->close();
?>