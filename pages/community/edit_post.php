<?php
require_once '../courses/config.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$post_id = $_GET['id'];

// Fetch post details
$post_sql = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
$post_stmt = $conn->prepare($post_sql);
$post_stmt->bind_param("ii", $post_id, $_SESSION['user']['UserID']);
$post_stmt->execute();
$post_result = $post_stmt->get_result();
$post = $post_result->fetch_assoc();

if (!$post) {
    header("Location: community.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_url = $post['image_url'];
    $video_url = $post['video_url'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/images/";
        $image_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_file)) {
            $image_url = $image_file;
        }
    }

    // Handle video upload
    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $target_dir = "uploads/videos/";
        $video_file = $target_dir . basename($_FILES["video"]["name"]);
        if (move_uploaded_file($_FILES["video"]["tmp_name"], $video_file)) {
            $video_url = $video_file;
        }
    }

    $sql = "UPDATE posts SET title = ?, content = ?, image_url = ?, video_url = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $title, $content, $image_url, $video_url, $post_id);

    if ($stmt->execute()) {
        header("Location: view_post.php?id=" . $post_id);
        exit();
    } else {
        $error = "Error updating post: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post - AUST CODE REALM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="css/community.css">
</head>
<body>
    <?php include '../../helpers/navbar.php'; ?>

    <div class="container mt-4">
        <h1>Edit Post</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="edit_post.php?id=<?php echo $post_id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image (optional)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <?php if ($post['image_url']): ?>
                    <img src="<?php echo htmlspecialchars($post['image_url']); ?>" class="img-thumbnail mt-2" alt="Current image">
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label for="video" class="form-label">Video (optional)</label>
                <input type="file" class="form-control" id="video" name="video" accept="video/*">
                <?php if ($post['video_url']): ?>
                    <video src="<?php echo htmlspecialchars($post['video_url']); ?>" controls class="img-thumbnail mt-2">
                        Your browser does not support the video tag.
                    </video>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>