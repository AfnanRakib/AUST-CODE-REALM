<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

session_start();

if (!isset($_SESSION['user']['UserID'])) {
    header("Location: login.php");
    exit();
}
date_default_timezone_set('Asia/Dhaka');
include 'config.php';

$userId = $_SESSION['user']['UserID'];
require_once '../helpers/judge0.php';

function saveSubmission($conn, $submissionData, $problemId, $userId, $code, $score) {
    $sql = "INSERT INTO submissions (ProblemID, UserID, LanguageID, SubmissionTime, JudgeTime, TimeTaken, MemoryUsed, Code, Status, Score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssdissi", $problemId, $userId, $submissionData['language_id'], $submissionData['submission_time'], $submissionData['judge_time'], $submissionData['time'], $submissionData['memory'], $code, $submissionData['status'], $score);
    $stmt->execute();
    $submissionId = $stmt->insert_id;
    $stmt->close();
    return $submissionId;
}

function saveContestSubmission($conn, $contestId, $userId, $problemId, $submissionId, $status, $attempts, $penalty) {
    // Get the contest start time
    $sql = "SELECT StartTime FROM contests WHERE ContestID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $contestId);
    $stmt->execute();
    $result = $stmt->get_result();
    $contest = $result->fetch_assoc();
    $startTime = new DateTime($contest['StartTime']);
    $submissionTime = new DateTime();
    
    // Calculate time since contest start in minutes
    $timeDiff = $startTime->diff($submissionTime);
    $minutesSinceStart = $timeDiff->days * 24 * 60 + $timeDiff->h * 60 + $timeDiff->i;
    
    // Calculate penalty
    $penalty = $minutesSinceStart + ($attempts - 1) * 20;

    $sql = "INSERT INTO contest_submissions (ContestID, UserID, ProblemID, SubmissionID, SubmissionTime, Status, attempts, penalty) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiissii", $contestId, $userId, $problemId, $submissionId, $status, $attempts, $penalty);
    $stmt->execute();
    $stmt->close();
}

function getSubmissionWithPolling($token, $maxAttempts = 5, $interval = 3) {
    sleep(2);
    $attempts = 0;
    while ($attempts < $maxAttempts) {
        $result = getSubmission($token);
        if (isset($result['status']['description']) && $result['status']['description'] == 'Accepted') {
            return $result;
        }
        $attempts++;
        sleep($interval);
    }
    return $result;
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $isRun = $data['isRun'];
        $problem = $data['problem'];
        $testcases = $data['testcases'];
        $problemId = $data['problemId'];
        $language_id = $data['languageId'];
        $languageName = $data['languageName'];
        $source_code = $data['code'];
        $cpu_time_limit = isset($problem['TimeLimit']) ? $problem['TimeLimit'] : 5;
        $memory_limit = isset($problem['MemoryLimit']) ? $problem['MemoryLimit'] : 128000;
        $max_file_size = isset($problem['MaxFileSize']) ? $problem['MaxFileSize'] : 10240;

        $isAccepted = true;
        $status = 'Accepted';

        $submitTime = date('Y-m-d H:i:s');
        $timeTaken = 0;
        $memoryTaken = 0;

        // Determine the number of previous attempts
        $sql = "SELECT COUNT(*) as attempts FROM contest_submissions WHERE ContestID = ? AND UserID = ? AND ProblemID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $contest_id, $userId, $problemId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $attempts = $row['attempts'] + 1;
        $stmt->close();

        foreach ($testcases as $index => $testcase) {
            $stdin = $testcase['Input'];
            $expected_output = $testcase['Output'];

            $submission_response = createSubmission([
                'language_id' => $language_id,
                'code' => $source_code
            ], $cpu_time_limit, $memory_limit, $max_file_size, $stdin, $expected_output);

            if (isset($submission_response['error'])) {
                throw new Exception('Error creating submission: ' . $submission_response['error']);
            }

            $token = isset($submission_response['token']) ? $submission_response['token'] : null;
            if (!$token) {
                throw new Exception('No token received from submission. Full response: ' . json_encode($submission_response));
            }

            $result = getSubmissionWithPolling($token);

            $stdout = base64_decode($result['stdout'] ?? '');
            $stderr = base64_decode($result['stderr'] ?? '');
            $compile_output = base64_decode($result['compile_output'] ?? '');
            $status_description = $result['status']['description'] ?? '';

            $timeTaken = max($timeTaken, $result['time']);
            $memoryTaken = max($memoryTaken, $result['memory']);

            if ($status_description !== 'Accepted') {
                $cnt = $index + 1;
                $isAccepted = false;
                $status = "$status_description on testcase $cnt";
                break;
            }
        }
        $judgeTime = date('Y-m-d H:i:s');

        // Calculate the penalty
        $penalty = ($attempts - 1) * 20 * 60; // Each failed attempt adds 20 minutes of penalty
        $submissionData = [
            'problemId' => $problemId,
            'language_id' => $languageName,
            'submission_time' => $submitTime,
            'judge_time' => $judgeTime,
            'time' => $timeTaken,
            'memory' => $memoryTaken,
            'status' => $status,
            'score' => $isAccepted ? 100 : 0
        ];


        if (!$isRun) {
            $currentTime = date('Y-m-d H:i:s');
            $runStatus = '';

            $query = "SELECT ContestID FROM contestproblems WHERE ProblemID = $problemId";
            $contest_id_result = $conn->query($query);
            if (!$contest_id_result) {
                die(json_encode(["error" => "Query failed: " . $conn->error]));
            }
            $row = $contest_id_result->fetch_assoc();
            $contest_id = $row['ContestID'];

            $query = "SELECT * FROM contests WHERE ContestID = $contest_id";
            $contestResult = $conn->query($query);
            if (!$contestResult) {
                die(json_encode(["error" => "Query failed: " . $conn->error]));
            }
            $contest = $contestResult->fetch_assoc();

            if ($contest['StartTime'] <= $currentTime && $contest['EndTime'] >= $currentTime) {
                $runStatus = 'Running';
            }
            if ($runStatus == 'Running') {
                $submissionData['score'] = 100;
            }

            $sql = "INSERT INTO contest_rankings (ContestID, UserID, problems_solved, total_penalty) 
                    VALUES (?, ?, IF(? = 'Accepted', 1, 0), ?) 
                    ON DUPLICATE KEY UPDATE 
                    problems_solved = problems_solved + IF(? = 'Accepted' AND problems_solved < (SELECT COUNT(*) FROM contestproblems WHERE ContestID = ?), 1, 0),
                    total_penalty = total_penalty + ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiisisi", $contest_id, $userId, $status, $penalty, $status, $contest_id, $penalty);
            $stmt->execute();
            $stmt->close();

            $sql = "SET @rank = 0";
            $conn->query($sql);

            $sql = "UPDATE contest_rankings cr1,
                        (SELECT ContestID, UserID,
                                @rank := @rank + 1 AS new_rank
                            FROM contest_rankings
                            WHERE ContestID = ?
                            ORDER BY problems_solved DESC, total_penalty ASC) cr2
                    SET cr1.rank = cr2.new_rank
                    WHERE cr1.ContestID = cr2.ContestID AND cr1.UserID = cr2.UserID";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $contest_id);
            $stmt->execute();
            $stmt->close();

            $submissionId = saveSubmission($conn, $submissionData, $problemId, $userId, $data['code'], $submissionData['score']);
            saveContestSubmission($conn, $contest_id, $userId, $problemId, $submissionId, $status, $attempts, $penalty);
        }

        echo json_encode([
            'stdout' => $stdout,
            'stderr' => $stderr,
            'compile_output' => $compile_output,
            'status' => $status,
            'created_at' => $submitTime,
            'finished_at' => $judgeTime,
            'token' => $token,
            'time' => $timeTaken,
            'memory' => $memoryTaken
        ]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
