<?php
session_start();
require_once 'config.php';

$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

if ($course_id === 0) {
    die("Invalid course ID");
}

// Fetch course details
$course_sql = "SELECT courses.*, users.Handle as creator_name FROM courses JOIN users ON courses.user_id = users.UserID WHERE courses.id = ?";
$course_stmt = $conn->prepare($course_sql);
$course_stmt->bind_param("i", $course_id);
$course_stmt->execute();
$course_result = $course_stmt->get_result();

if ($course_result->num_rows === 0) {
    die("Course not found");
}

$course = $course_result->fetch_assoc();

$is_course_creator = isset($_SESSION['user']['UserID']) && $_SESSION['user']['UserID'] == $course['user_id'];

// Fetch videos for the course
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$video_sql = "SELECT * FROM videos WHERE course_id = ?";
$params = [$course_id];
$types = "i";

if (!empty($search)) {
    $video_sql .= " AND (title LIKE ? OR description LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "ss";
}

$video_stmt = $conn->prepare($video_sql);
$video_stmt->bind_param($types, ...$params);
$video_stmt->execute();
$video_result = $video_stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="css/course_videos.css">
    <script src="../../js/tinymce/tinymce.min.js"></script>
    <script src="../../js/tinyMCEinit.js"></script>
    <title><?php echo $course['title']; ?> - AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include '../../helpers/navbar.php'; ?>
	<div class="container mt-4">
		<div class="row justify-content-center mb-4">
			<div class="col-md-6">
				<form action="" method="GET" class="d-flex justify-content-center">
					<input type="text" name="search" class="form-control me-2" style="max-width: 300px;" placeholder="Search videos..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
					<button type="submit" class="btn btn-primary" style="background-color: rgb(3, 191, 98);">Search</button>
					<input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
				</form>
			</div>
		</div>
	</div>

    <!--card-items-->
    <div class="container mt-4">
		<div class="green-header mb-4">
				<h2 style="color: rgb(3, 191, 98)"><?php echo $course['title']; ?></h2>
				<p>Created by: <?php echo htmlspecialchars($course['creator_name']); ?></p>
		</div>
		
		
			
		<div class="row">
			<div class="col-md-3 col-sm-6 goback">
				<a href="courses.php" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 40px;">Go back to courses</a>
			</div>
				<?php if ($is_course_creator): ?>
				 <div class="col-md-3 col-sm-6 add-video-btn">
						<a href="add_video.php?course_id=<?php echo $course_id; ?>" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 40px;">Add Video</a>
				</div>
				<?php endif; ?>
			</div>
				
        <div class="row">
            <?php
            while($video = $video_result->fetch_assoc()) {
                ?>
                <div class="col-md-3 col-sm-6 course-card">
                    <div class="card">
						<?php if ($is_course_creator): ?>
						<div class="dropdown">
							<button class="btn btn-light btn-sm dropdown-toggle" type="button" style="background-color: rgb(3, 191, 98); margin-bottom: 40px;" id="dropdownMenuButton  <?php echo $video['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="fas fa-ellipsis-v"></i> 
							</button>
							<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton<?php echo $video['id']; ?>">
								<li><a class="dropdown-item edit-video" href="#" data-video-id="<?php echo $video['id']; ?>">Edit</a></li>
								<li><a class="dropdown-item delete-video" href="#" data-video-id="<?php echo $video['id']; ?>">Delete</a></li>
							</ul>
						</div>
						<?php endif; ?>
                        <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                            <iframe width="100%" height="100%" src="<?php echo $video['youtube_embed_url']; ?>" title="<?php echo $video['title']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $video['title']; ?></h5>
                            <p class="card-text"><?php echo $video['description']; ?></p>
							<a href="play_video.php?video_id=<?php echo $video['id']; ?>" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98)">Watch Video</a>
                        </div>
                    </div>
                </div>
				<?php 
			}
			?>
            
            <?php if ($video_result->num_rows === 0): ?>
            <div class="col-12">
                <p>No videos found for this course.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
	
    <footer class="text-center py-4" style="background-color: rgb(3, 191, 98);">
    
        <p style="color: white;">&copy; 2024 AUST CODE REALM. All rights reserved.</p>
    </footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/course_videos.js"></script>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editModalLabel">Edit Item</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<!-- Form will be inserted here dynamically -->
				</div>
			</div>
		</div>
	</div>


</body>
</html>
<?php
$conn->close();
?>