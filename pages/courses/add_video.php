<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user']['UserID'])) {
    header("Location: login.php");
    exit();
}

$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

if ($course_id === 0) {
    die("Invalid course ID");
}

// Check if the current user is the course creator
$check_sql = "SELECT user_id FROM courses WHERE id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $course_id);
$check_stmt->execute();
$result = $check_stmt->get_result();
$course = $result->fetch_assoc();

if ($course['user_id'] != $_SESSION['user']['UserID']) {
    die("You don't have permission to add videos to this course");
}

function extractYoutubeEmbedUrl($iframeCode) {
    $pattern = '/src="([^"]+)"/';
    if (preg_match($pattern, $iframeCode, $matches)) {
        return $matches[1];
    }
    return '';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    
    $youtube_embed_url = extractYoutubeEmbedUrl($_POST['youtube_embed_url']);
    $user_id = $_SESSION['user']['UserID'];

    $sql = "INSERT INTO videos (course_id, title, description, youtube_embed_url, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssi", $course_id, $title, $description, $youtube_embed_url, $user_id);

    if ($stmt->execute()) {
        header("Location: course_videos.php?course_id=" . $course_id);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Video</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/problemPage.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <script src="../../js/tinymce/tinymce.min.js"></script>
    <script src="../../js/tinyMCEinit.js"></script>
</head>
<<body>
	
    <div class="container mt-4">
        <h2>Add a New Video</h2>
		<div class="row">  
			<div class="col-md-3 col-sm-6 goback">
				<a href="course_videos.php?course_id=<?php echo $course_id; ?>" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 40px;">Go back </a>
			</div>
		</div>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="video-description" name="description" required></textarea>
            </div>

            <div class="mb-3">
                <label for="youtube_embed_url" class="form-label">YouTube Embed Code:</label>
                <textarea class="form-control" id="youtube_embed_url" name="youtube_embed_url" required></textarea>
                <small class="form-text text-muted">Paste the full iframe code here.</small>
            </div>

            <button type="submit" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 40px;">Add Video</button>
        </form>
    </div>
</body>
</html>