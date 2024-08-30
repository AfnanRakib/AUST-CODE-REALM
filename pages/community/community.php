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
        .carousel-item img, .carousel-item video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .carousel-control-prev, .carousel-control-next {
            background-color: rgba(0,0,0,0.2);
            width: 1px;
            padding: 10px;
        }
        .carousel-control-prev-icon, .carousel-control-next-icon {
            background-color: rgba(0,0,0,0.5);
            border-radius: 20%;
            padding: 10px;
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
                        <?php if ($post['image_url'] || $post['video_url']): ?>
                            <div id="mediaCarousel<?php echo $post['id']; ?>" class="carousel slide" data-bs-interval="false">
                                <div class="carousel-inner">
                                    <?php if ($post['image_url']): ?>
                                        <div class="carousel-item active">
                                            <img src="<?php echo htmlspecialchars($post['image_url']); ?>" class="d-block w-100" alt="Post image">
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($post['video_url']): ?>
                                        <div class="carousel-item <?php echo !$post['image_url'] ? 'active' : ''; ?>">
                                            <video src="<?php echo htmlspecialchars($post['video_url']); ?>" class="d-block w-100" controls>
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if ($post['image_url'] && $post['video_url']): ?>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel<?php echo $post['id']; ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#mediaCarousel<?php echo $post['id']; ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                <?php endif; ?>
                            </div>
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