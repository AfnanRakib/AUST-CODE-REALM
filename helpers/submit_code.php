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
date_default_timezone_set('Asia/Dhaka'); // Set timezone
$tz=date_default_timezone_get();
$ini_tz=ini_get('date.timezone');
include 'config.php';

$userId = $_SESSION['user']['UserID'];

//change the comment if want top change api
require_once '../helpers/judge0.php';
//require_once '../helpers/hostedJudge0.php';

function saveSubmission($conn, $submissionData, $problemId, $userId, $code,$score) {
    $sql = "INSERT INTO submissions (ProblemID, UserID, LanguageID, SubmissionTime,JudgeTime, TimeTaken, MemoryUsed, Code, Status, Score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisssdissi", $problemId, $userId, $submissionData['language_id'], $submissionData['submission_time'],$submissionData['judge_time'], $submissionData['time'], $submissionData['memory'], $code, $submissionData['status'], $score);
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
        error_log(print_r($data, true));
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
        $timeTaken=0;
        $memoryTaken=0;

        foreach ($testcases as $index => $testcase) {
            $stdin = $testcase['Input'];
            $expected_output = $testcase['Output'];

            // Create a submission
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

            // Fetch submission result using polling
            $result = getSubmissionWithPolling($token);

            // Decode base64 encoded fields
            $stdout = base64_decode($result['stdout'] ?? '');
            $stderr = base64_decode($result['stderr'] ?? '');
            $compile_output = base64_decode($result['compile_output'] ?? '');
            $status_description = $result['status']['description'] ?? '';

            $timeTaken=max($timeTaken,$result['time']);
            $memoryTaken=max($memoryTaken,$result['memory']);

            // Check if the output matches the expected output
            if ($status_description !== 'Accepted') {
                $cnt= $index + 1;
                $isAccepted = false;
                $status = "$status_description on testcase $cnt";
                break;
            }
        }
        $judgeTime = date('Y-m-d H:i:s');
        // Save submission details to the database
        $submissionData = [
            'problemId' => $problemId,
            'language_id' => $languageName,
            'submission_time' => $submitTime,
            'judge_time' => $judgeTime,
            'time' => $timeTaken,
            'memory' => $memoryTaken,
            'status' => $status,
            'score' => $isAccepted ? 100 : 0// score will be counted based on some conditions later
        ];

        if(!$isRun){
            $currentTime = date('Y-m-d H:i:s');
            $runStatus = '';
            $score='';

            $query = "SELECT `ContestID` FROM `contestproblems` WHERE `ProblemID`= $problemId";
            $contest_id_result = $conn->query($query);
            if (!$contest_id_result) {
                die(json_encode(["error" => "Query failed: " . $conn->error]));
            }
            $row = $contest_id_result->fetch_assoc();
            
            $contest_id=$row['ContestID'];

            $query = "SELECT * FROM contests WHERE ContestID = $contest_id";
            $contestResult = $conn->query($query);
            if (!$contestResult) {
                die(json_encode(["error" => "Query failed: " . $conn->error]));
            }
            $contest = $contestResult->fetch_assoc();

            if ($contest['StartTime'] <= $currentTime && $contest['EndTime'] >= $currentTime) {
                $runStatus = 'Running';
            }
            if($runStatus == 'Running'){
                $score='100';
            }
            $submissionData['score']=$score;
            saveSubmission($conn, $submissionData, $problemId, $userId, $data['code'],$score);
        }

        echo json_encode([
            'stdout' => $stdout,
            'stderr' => $stderr,
            'compile_output' => $compile_output,
            'status' => $status,
            'created_at' => $submitTime,
            'finished_at' => $judgeTime ,
            'token' => $token,
            'time' => $timeTaken,
            'memory' => $memoryTaken
        ]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
