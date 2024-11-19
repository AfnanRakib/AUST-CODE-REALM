<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    include '../helpers/config.php';

    $username = isset($_POST['username']) ? trim($_POST['username']) : '';

    if (empty($username)) {
        echo json_encode(['success' => false, 'message' => 'Username is required']);
        exit;
    }

    // Prepare and execute the SQL statement to search for the user
    $sql = "SELECT UserID FROM users WHERE Handle = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode(['success' => true, 'userId' => $user['UserID']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No such user exists']);
    }

    $stmt->close();
    $conn->close();
}
?>
