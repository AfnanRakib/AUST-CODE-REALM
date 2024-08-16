<?php
// calculateRating.php

require_once '../helpers/config.php';

function calculateRatings($contestId) {
    global $conn;
    
    $participants = getContestParticipants($conn, $contestId);
    
    if (empty($participants)) {
        throw new Exception("No participants found for contest ID: $contestId");
    }
    
    processRatingChanges($participants);
    updateRatings($conn, $participants, $contestId);
    
    return count($participants);
}

function getContestParticipants($conn, $contestId) {
    $query = "SELECT cr.UserID, cr.rank, cr.problems_solved, u.CurrentRating, 
              (SELECT COUNT(*) FROM contest_rankings WHERE UserID = cr.UserID) as contestCount
              FROM contest_rankings cr
              JOIN users u ON cr.UserID = u.UserID
              WHERE cr.ContestID = ?
              ORDER BY cr.rank ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $contestId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $participants = [];
    while ($row = $result->fetch_assoc()) {
        $participants[] = [
            'userId' => $row['UserID'],
            'rank' => $row['rank'],
            'problemsSolved' => $row['problems_solved'],
            'rating' => $row['CurrentRating'],
            'contestCount' => $row['contestCount'],
            'delta' => 0
        ];
    }
    
    return $participants;
}

function processRatingChanges(&$participants) {
    $totalParticipants = count($participants);
    
    if ($totalParticipants == 0) {
        throw new Exception("No participants to process");
    }
    
    $maxProblems = max(array_column($participants, 'problemsSolved'));
    
    foreach ($participants as &$participant) {
        $performanceScore = ($totalParticipants - $participant['rank'] + 1) * 50;
        $problemScore = ($participant['problemsSolved'] / $maxProblems) * 100;
        $baseChange = $performanceScore + $problemScore;
        
        $weight = getWeight($participant['contestCount']);
        $participant['delta'] = round($weight * $baseChange);
    }

    adjustDeltas($participants);
}

function getWeight($contestCount) {
    return max(0.5, 1 / (1 + 0.1 * ($contestCount - 1)));
}

function adjustDeltas(&$participants) {
    $minDelta = min(array_column($participants, 'delta'));
    $maxDelta = max(array_column($participants, 'delta'));
    $range = $maxDelta - $minDelta;
    
    if ($range > 200) {
        $scaleFactor = 200 / $range;
        foreach ($participants as &$participant) {
            $participant['delta'] = round(($participant['delta'] - $minDelta) * $scaleFactor + 50);
        }
    } elseif ($range < 100) {
        $scaleFactor = 100 / $range;
        foreach ($participants as &$participant) {
            $participant['delta'] = round(($participant['delta'] - $minDelta) * $scaleFactor + 50);
        }
    }
}

function updateRatings($conn, $participants, $contestId) {
    $stmt = $conn->prepare("INSERT INTO ratinggraph (UserID, PrevRating, NewRating, ChangedRating, ContestID, Date) VALUES (?, ?, ?, ?, ?, CURDATE())");
    $updateStmt = $conn->prepare("UPDATE users SET CurrentRating = ?, MaxRating = GREATEST(MaxRating, ?), RatingCategory = ? WHERE UserID = ?");
    
    foreach ($participants as $participant) {
        $newRating = max(1, $participant['rating'] + $participant['delta']);
        $change = $newRating - $participant['rating'];
        
        $stmt->bind_param("iiiii", $participant['userId'], $participant['rating'], $newRating, $change, $contestId);
        $stmt->execute();
        
        $ratingCategory = getRatingCategory($newRating);
        $updateStmt->bind_param("iisi", $newRating, $newRating, $ratingCategory, $participant['userId']);
        $updateStmt->execute();
    }
}

function getRatingCategory($rating) {
    if ($rating < 400) return 'Novice';
    if ($rating < 800) return 'Specialist';
    if ($rating < 1200) return 'Expert';
    if ($rating < 1600) return 'Master';
    return 'Grandmaster';
}

function updateContestRatings($contestId) {
    return calculateRatings($contestId);
}