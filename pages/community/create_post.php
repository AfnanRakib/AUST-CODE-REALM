<?php
require_once '../courses/config.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

function uploadFile($file, $targetDir) {
    $fileName = basename($file["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Generate a unique file name to prevent overwriting
    $fileName = uniqid() . '.' . $fileType;
    $targetFilePath = $targetDir . $fileName;

    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'mp4', 'avi', 'mov');
    if (in_array($fileType, $allowTypes)) {
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            return $targetFilePath;
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user']['UserID'];
    $image_url = null;
    $video_url = null;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/images/";
        $image_url = uploadFile($_FILES['image'], $target_dir);
    }

    // Handle video upload
    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $target_dir = "uploads/videos/";
        $video_url = uploadFile($_FILES['video'], $target_dir);
    }

    $sql = "INSERT INTO posts (user_id, title, content, image_url, video_url) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $user_id, $title, $content, $image_url, $video_url);

    if ($stmt->execute()) {
        header("Location: community.php");
        exit();
    } else {
        $error = "Error creating post: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post - AUST CODE REALM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="css/community.css">
    <script src="../../js/tinymce/tinymce.min.js"></script>
    <script src="../../js/tinyMCEinit.js"></script>
    <style>
        .btn {
            margin-top: auto;
            overflow: hidden;
            color: white;
        }
        
        .btn:active {
            overflow: hidden;
            transform: none !important;
        }
    </style>
</head>
<body>
    <?php include '../../helpers/navbar.php'; ?>

    <div class="container mt-4">
        <h1>Create New Post</h1>

        <a href="community.php" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 10px;">Go Back to Community</a>

        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="create_post.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Post:</label>
                <textarea class="form-control" id="content" name="content"  required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image (optional):</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="video" class="form-label">Video (optional):</label>
                <input type="file" class="form-control" id="video" name="video" accept="video/*">
            </div>
            <button type="submit" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 10px;">Create Post</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>