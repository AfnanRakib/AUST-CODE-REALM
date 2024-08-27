<?php
require_once '../courses/config.php';
session_start();

define('DEFAULT_PROFILE_IMG', '../../images/blank_profile_img.jpg');

// Fetch all posts with user information
$posts_sql = "SELECT p.*, u.Handle, u.Profile_Picture FROM posts p 
              JOIN users u ON p.user_id = u.UserID 
              ORDER BY p.created_at DESC";
$posts_result = $conn->query($posts_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - AUST CODE REALM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/navbar.css">

    <style>
        .profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
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
        <h1>Community Posts</h1>
        
        <?php if (isset($_SESSION['user'])): ?>
            <a href="create_post.php" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 20px;">Create New Post</a>
        <?php endif; ?>

        <div class="posts-container">
            <?php while ($post = $posts_result->fetch_assoc()): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="user-info">
                            <img src="<?php echo $post['Profile_Picture'] ? $post['Profile_Picture'] : DEFAULT_PROFILE_IMG; ?>" 
                                 alt="Profile Picture" class="profile-pic">
                            <h6 class="mb-0"><?php echo htmlspecialchars($post['Handle']); ?></h6>
                        </div>
                        <h5 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h5>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                        <?php if ($post['image_url']): ?>
                            <img src="<?php echo htmlspecialchars($post['image_url']); ?>" class="img-fluid mb-2" alt="Post image">
                        <?php endif; ?>
                        <?php if ($post['video_url']): ?>
                            <video src="<?php echo htmlspecialchars($post['video_url']); ?>" controls class="img-fluid mb-2">
                                Your browser does not support the video tag.
                            </video>
                        <?php endif; ?>
                        <p class="text-muted">Posted on <?php echo date('F j, Y, g:i a', strtotime($post['created_at'])); ?></p>
                        <a href="view_post.php?id=<?php echo $post['id']; ?>" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 5px;">View Post</a>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['UserID'] == $post['user_id']): ?>
                            <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Edit</a>
                            <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <footer class="text-center py-4" style="background-color: rgb(3, 191, 98);">
    
        <p style="color: white;">&copy; 2024 AUST CODE REALM. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>