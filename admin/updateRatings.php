<?php
// updateRatings.php
require_once 'calculateRating.php';
require_once '../helpers/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contestId'])) {
    $contestId = intval($_POST['contestId']);
    try {
        $participantsCount = updateContestRatings($contestId);
        echo "Ratings updated successfully for $participantsCount participants.";
    } catch (Exception $e) {
        http_response_code(400);
        echo "Error: " . $e->getMessage();
    }
} else {
    http_response_code(400);
    echo "Invalid request";
}