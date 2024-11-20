<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user']['UserID'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized.']);
    exit();
}

include '../helpers/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contestID = intval($_POST['contestID'] ?? 0);

    if ($contestID <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid contest ID.']);
        exit();
    }

    $userID = $_SESSION['user']['UserID'];

    // Verify that the contest belongs to the current user
    $checkQuery = "SELECT * FROM contests WHERE ContestID = ? AND CreatorID = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $contestID, $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Contest not found or not owned by you.']);
        exit();
    }

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete associated entries from contestproblems
        $deleteProblemsQuery = "DELETE FROM contestproblems WHERE ContestID = ?";
        $stmt = $conn->prepare($deleteProblemsQuery);
        $stmt->bind_param("i", $contestID);
        $stmt->execute();

        // Delete the contest itself
        $deleteContestQuery = "DELETE FROM contests WHERE ContestID = ?";
        $stmt = $conn->prepare($deleteContestQuery);
        $stmt->bind_param("i", $contestID);
        $stmt->execute();

        // Commit the transaction
        $conn->commit();

        echo json_encode(['success' => true, 'message' => 'Contest and associated problems deleted successfully.']);
    } catch (Exception $e) {
        // Roll back the transaction on error
        $conn->rollback();

        echo json_encode(['success' => false, 'message' => 'Failed to delete contest.']);
    }
}
?>
