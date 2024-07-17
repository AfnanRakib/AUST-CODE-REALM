<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user']['UserID'])) {
    die(json_encode(['success' => false, 'error' => "Unauthorized access"]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($course_id === 0) {
        die(json_encode(['success' => false, 'error' => "Invalid course ID"]));
    }

    // Fetch course details to check if the user has permission to edit
    $check_sql = "SELECT * FROM courses WHERE id = ? AND user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $course_id, $_SESSION['user']['UserID']);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows === 0) {
        die(json_encode(['success' => false, 'error' => "Course not found or you don't have permission to edit it"]));
    }

    $updates = [];
    $types = '';
    $params = [];

    if (isset($_POST['title']) && !empty($_POST['title'])) {
        $updates[] = "title = ?";
        $types .= "s";
        $params[] = $_POST['title'];
    }

    if (isset($_POST['description'])) {
        $updates[] = "description = ?";
        $types .= "s";
        $params[] = $_POST['description'];
    }

    if (isset($_POST['image_url']) && !empty($_POST['image_url'])) {
        $updates[] = "image_url = ?";
        $types .= "s";
        $params[] = $_POST['image_url'];
    }

    if (!empty($updates)) {
        $update_sql = "UPDATE courses SET " . implode(", ", $updates) . " WHERE id = ?";
        $types .= "i";
        $params[] = $course_id;

        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param($types, ...$params);

        if ($update_stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } else {
        echo json_encode(['success' => true, 'message' => 'No changes detected']);
    }
} else {
    $course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($course_id === 0) {
        die(json_encode(['success' => false, 'error' => "Invalid course ID"]));
    }

    // Fetch course details
    $course_sql = "SELECT * FROM courses WHERE id = ? AND user_id = ?";
    $course_stmt = $conn->prepare($course_sql);
    $course_stmt->bind_param("ii", $course_id, $_SESSION['user']['UserID']);
    $course_stmt->execute();
    $course_result = $course_stmt->get_result();

    if ($course_result->num_rows === 0) {
        die(json_encode(['success' => false, 'error' => "Course not found or you don't have permission to edit it"]));
    }

    $course = $course_result->fetch_assoc();
    echo json_encode($course);
}

$conn->close();
?>