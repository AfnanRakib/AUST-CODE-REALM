<?php
require_once 'config.php';

if (!isset($_SESSION)) {
    session_start();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $video_id = $_POST['video_id'];
    $content = $_POST['content'];
     $user_id = $_SESSION['user']['UserID'];
	

    $sql = "INSERT INTO comments (video_id, user_id, content) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $video_id, $user_id, $content);

    if ($stmt->execute()) {
        header("Location: play_video.php?video_id=" . $video_id);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
