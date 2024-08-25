<?php
require_once '../courses/config.php';
session_start();

define('DEFAULT_PROFILE_IMG', '../../images/blank_profile_img.jpg');

$post_id = $_GET['id'];

// Fetch post details
$post_sql = "SELECT p.*, u.Handle, u.Profile_Picture FROM posts p 
             JOIN users u ON p.user_id = u.UserID 
             WHERE p.id = ?";
$post_stmt = $conn->prepare($post_sql);
$post_stmt->bind_param("i", $post_id);
$post_stmt->execute();
$post_result = $post_stmt->get_result();
$post = $post_result->fetch_assoc();

// Fetch comments
$comments_sql = "SELECT c.*, u.Handle, u.Profile_Picture FROM post_comments c 
                 JOIN users u ON c.user_id = u.UserID 
                 WHERE c.post_id = ? ORDER BY c.created_at DESC";
$comments_stmt = $conn->prepare($comments_sql);
$comments_stmt->bind_param("i", $post_id);
$comments_stmt->execute();
$comments_result = $comments_stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - AUST CODE REALM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="css/community.css">
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
        <a href="community.php" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 10px;">Go Back to Community</a>

        <div class="card mb-4">
            <div class="card-body">
                <div class="user-info">
                    <img src="<?php echo $post['Profile_Picture'] ? $post['Profile_Picture'] : DEFAULT_PROFILE_IMG; ?>" 
                         alt="Profile Picture" class="profile-pic">
                    <h6 class="mb-0"><?php echo htmlspecialchars($post['Handle']); ?></h6>
                </div>
                <h1 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h1>
                <p class="text-muted">
                    Posted on <?php echo date('F j, Y, g:i a', strtotime($post['created_at'])); ?>
                </p>
                <p class="card-text"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <?php if ($post['image_url']): ?>
                    <img src="<?php echo htmlspecialchars($post['image_url']); ?>" class="img-fluid mb-2" alt="Post image">
                <?php endif; ?>
                <?php if ($post['video_url']): ?>
                    <video src="<?php echo htmlspecialchars($post['video_url']); ?>" controls class="img-fluid mb-2">
                        Your browser does not support the video tag.
                    </video>
                <?php endif; ?>

                <?php if (isset($_SESSION['user']) && $_SESSION['user']['UserID'] == $post['user_id']): ?>
                    <div class="mt-3">
                        <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-primary">Edit Post</a>
                        <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete Post</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <h3>Comments</h3>
        <?php if (isset($_SESSION['user'])): ?>
            <form action="add_comment.php" method="post" class="mb-4">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <div class="mb-3">
                    <textarea class="form-control" name="content" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 10px;">Add Comment</button>
            </form>
        <?php endif; ?>

        <div class="comments-container">
            <?php while ($comment = $comments_result->fetch_assoc()): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="user-info">
                            <img src="<?php echo $comment['Profile_Picture'] ? $comment['Profile_Picture'] : DEFAULT_PROFILE_IMG; ?>" 
                                 alt="Profile Picture" class="profile-pic">
                            <h6 class="mb-0"><?php echo htmlspecialchars($comment['Handle']); ?></h6>
                        </div>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
                        <p class="text-muted">
                            Commented on <?php echo date('F j, Y, g:i a', strtotime($comment['created_at'])); ?>
                        </p>
                        <?php if (isset($_SESSION['user'])): ?>
                            <button class="btn btn-sm btn-secondary" onclick="toggleReplyForm(<?php echo $comment['id']; ?>)">Reply</button>
                            <div id="replyForm-<?php echo $comment['id']; ?>" style="display: none;">
                                <form action="add_reply.php" method="post" class="mt-2">
                                    <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                                    <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                    <div class="mb-3">
                                        <textarea class="form-control" name="content" rows="2" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 10px;">Reply</button>
                                </form>
                            </div>
                        <?php endif; ?>
                        <div class="replies mt-3">
                            <?php
                            $replies_sql = "SELECT r.*, u.Handle, u.Profile_Picture FROM post_comment_replies r 
                                            JOIN users u ON r.user_id = u.UserID 
                                            WHERE r.comment_id = ? ORDER BY r.created_at ASC";
                            $replies_stmt = $conn->prepare($replies_sql);
                            $replies_stmt->bind_param("i", $comment['id']);
                            $replies_stmt->execute();
                            $replies_result = $replies_stmt->get_result();
                            while ($reply = $replies_result->fetch_assoc()):
                            ?>
                                <div class="card mt-2">
                                    <div class="card-body">
                                        <div class="user-info">
                                            <img src="<?php echo $reply['Profile_Picture'] ? $reply['Profile_Picture'] : DEFAULT_PROFILE_IMG; ?>" 
                                                 alt="Profile Picture" class="profile-pic">
                                            <h6 class="mb-0"><?php echo htmlspecialchars($reply['Handle']); ?></h6>
                                        </div>
                                        <p class="card-text"><?php echo nl2br(htmlspecialchars($reply['content'])); ?></p>
                                        <p class="text-muted">
                                            Replied on <?php echo date('F j, Y, g:i a', strtotime($reply['created_at'])); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <footer class="text-center py-4" style="background-color: rgb(3, 191, 98);">
    
        <p style="color: white;">&copy; 2024 AUST CODE REALM. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleReplyForm(commentId) {
            const replyForm = document.getElementById(`replyForm-${commentId}`);
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>