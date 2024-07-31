<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user']['UserID'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $user_id = $_SESSION['user']['UserID'];

    $sql = "INSERT INTO courses (title, description, image_url, user_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $description, $image_url, $user_id);

    if ($stmt->execute()) {
        header("Location: courses.php");
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
    <title>Create Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/problemPage.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <script src="../../js/tinymce/tinymce.min.js"></script>
    <script src="../../js/tinyMCEinit.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Create a New Course</h2>
		<div class="col-md-3 col-sm-6 goback">
				<a href="courses.php" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 40px;">Go back to courses</a>
		</div>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea class="form-control" id="course-description" name="description" required></textarea>
            </div>

            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL:</label>
                <input type="text" class="form-control" id="image_url" name="image_url" required>
            </div>

            <button type="submit" class="btn btn mt-auto" style="background-color: rgb(3, 191, 98); margin-bottom: 40px;">create course</button>
        </form>
    </div>
	
</body>
</html>