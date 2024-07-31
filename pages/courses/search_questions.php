<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user']) || !isset($_GET['video_id'])) {
    echo json_encode([]);
    exit;
}

$video_id = $_GET['video_id'];
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_type = isset($_GET['search_type']) ? $_GET['search_type'] : 'title';

$sql = "SELECT q.*, u.Handle as user_handle, u.Profile_Picture as user_profile_picture 
        FROM questions q
        JOIN users u ON q.user_id = u.UserID
        WHERE q.video_id = ?";

$params = [$video_id];
$types = "i";

if (!empty($search)) {
    $sql .= " AND q.$search_type LIKE ?";
    $params[] = "%$search%";
    $types .= "s";
}

$sql .= " ORDER BY q.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}

echo json_encode($questions);