<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user']['UserID'])) {
        header("Location: login.php");
        exit();
    }

    include '../helpers/config.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $problemID = intval($_POST['problemID']);
        $userID = $_SESSION['user']['UserID'];

        $verifyQuery = "SELECT * FROM problems WHERE ProblemID='$problemID' AND AuthorID='$userID'";
        $verifyResult = $conn->query($verifyQuery);
        if ($verifyResult->num_rows > 0) {
            // Delete the problem
            $conn->query("DELETE FROM `problems` WHERE ProblemID='$problemID'");
            $conn->query("DELETE FROM `problem_tags` WHERE ProblemID='$problemID'");
            $conn->query("DELETE FROM `testcases` WHERE ProblemID='$problemID'");
            $conn->query("DELETE FROM `contestproblems` WHERE ProblemID='$problemID'");

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Problem not found or you do not have permission to delete this problem.']);
        }
    }

    $conn->close();
?>
