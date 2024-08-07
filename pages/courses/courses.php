<?php
session_start();
require_once 'config.php';


$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_type = isset($_GET['search_type']) ? $_GET['search_type'] : 'title';

$sql = "SELECT courses.*, users.Handle as creator_name 
        FROM courses 
        JOIN users ON courses.user_id = users.UserID";

if (!empty($search)) {
    if ($search_type == 'title') {
        $sql .= " WHERE courses.title LIKE ?";
    } else {
        $sql .= " WHERE users.Handle LIKE ?";
    }
    $stmt = $conn->prepare($sql);
    $search_param = "%$search%";
    $stmt->bind_param("s", $search_param);
} else {
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/courses.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <title>AUST CODE REALM</title>
</head>
<body>
    <!-- Navbar -->
    <?php include '../../helpers/navbar.php'; ?>
	<div class="container mt-4">
		<div class="row justify-content-center mb-4">
			<div class="col-md-8">
				<form action="" method="GET" class="d-flex justify-content-center">
					<input type="text" name="search" class="form-control me-2" style="max-width: 300px;" placeholder="Search..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
					<select name="search_type" class="form-select me-2" style="width: auto;">
						<option value="title" <?php echo (isset($_GET['search_type']) && $_GET['search_type'] == 'title') ? 'selected' : ''; ?>>Title</option>
						<option value="creator" <?php echo (isset($_GET['search_type']) && $_GET['search_type'] == 'creator') ? 'selected' : ''; ?>>Created by</option>
					</select>
					<button type="submit" class="btn btn-primary" style="background-color: rgb(3, 191, 98);">Search</button>
				</form>
			</div>
		</div>
	</div>

    <!--card-items-->
    <div class="container mt-4">
        <div class="green-header mb-4">
            <h2 style="color: rgb(3, 191, 98)">Available Courses</h2>
        </div>
		
        
        <?php if (isset($_SESSION['user']['UserID'])): ?>
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6">
                    <a href="create_course.php" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98);">Create Course</a>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-3 col-sm-6 course-card">
                        <div class="card">
                            <?php if (isset($_SESSION['user']['UserID']) && $_SESSION['user']['UserID'] == $row['user_id']): ?>
                                <div class="dropdown" style="position: absolute; top: 10px; right: 10px; z-index: 1000;">
                                    <button class="btn btn-light btn-sm dropdown-toggle" type="button" style="background-color: rgb(3, 191, 98);" id="dropdownMenuButton <?php echo $row['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i> 
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton<?php echo $row['id']; ?>">
                                        <li><a class="dropdown-item edit-course" href="#" data-course-id="<?php echo $row['id']; ?>">Edit</a></li>
                                        <li><a class="dropdown-item delete-course" href="#" data-course-id="<?php echo $row['id']; ?>">Delete</a></li>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                                <img src="<?php echo $row['image_url']; ?>" class="img-fluid" alt="<?php echo $row['title']; ?>"/>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['title']; ?></h5>
                                <p class="card-text"><?php echo $row['description']; ?></p>
                                <p class="card-text"><small>Created by: <?php echo $row['creator_name']; ?></small></p>
                                <a href="course_videos.php?course_id=<?php echo $row['id']; ?>" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98)">Go to course</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No courses available.</p>";
            }
            ?>
        </div>
        
    </div>
    <footer class="text-center py-4" style="background-color: rgb(3, 191, 98);">
    
        <p style="color: white;">&copy; 2024 AUST CODE REALM. All rights reserved.</p>
    </footer>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/courses.js"></script>
<!--edit secondary-->
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