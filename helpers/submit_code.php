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

$userId = $_SESSION['user']['UserID'];

require_once '../helpers/judge0.php';

function saveSubmission($conn, $submissionData, $problemId, $contestId, $userId, $code) {
    $sql = "INSERT INTO submissions (ProblemID, ContestID, UserID, LanguageID, SubmissionTime, TimeTaken, MemoryUsed, Code, Status, Score) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiisiissi", $problemId, $contestId, $userId, $submissionData['language_id'], $submissionData['submission_time'], $submissionData['time'], $submissionData['memory'], $code, $submissionData['status'], $submissionData['score']);
    $stmt->execute();
    $stmt->close();
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $testcases = $data['testcases'];
        $problemId = $data['problemId'];
        $language_id = $data['languageId'];
        $source_code = $data['code'];
        $cpu_time_limit = isset($problem['TimeLimit']) ? $problem['TimeLimit'] : 5;
        $memory_limit = isset($problem['MemoryLimit']) ? $problem['MemoryLimit'] : 128000;
        $max_file_size = isset($problem['MaxFileSize']) ? $problem['MaxFileSize'] : 10240;
        
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'aust_code_realm');
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        $isAccepted = true;
        $status = 'Accepted';

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

            // Fetch submission result after a delay
            sleep(5);  // Wait for some time to let the submission be processed
            $result = getSubmission($token);

            // Decode base64 encoded fields
            $stdout = base64_decode($result['stdout'] ?? '');
            $stderr = base64_decode($result['stderr'] ?? '');
            $compile_output = base64_decode($result['compile_output'] ?? '');
            $status_description = $result['status']['description'] ?? '';

            // Check if the output matches the expected output
            if ($status_description !== 'Accepted') {
                $isAccepted = false;
                $status = $status_description . " on testcase " . ($index + 1);
                break;
            }
        }

        // Save submission details to the database
        $submissionData = [
            'problemId' => $problemId,
            'language_id' => $language_id,
            'submission_time' => date('Y-m-d H:i:s'),
            'time' => $result['time'] ?? 0,
            'memory' => $result['memory'] ?? 0,
            'status' => $status,
            'score' => $isAccepted ? 100 : 0
        ];
        saveSubmission($conn, $submissionData, $problemId, $problem['ContestID'] ?? null, $userId, $data['code']);

        echo json_encode([
            'stdout' => $stdout,
            'stderr' => $stderr,
            'compile_output' => $compile_output,
            'status' => $status,
            'created_at' => $result['created_at'] ?? '',
            'finished_at' => $result['finished_at'] ?? '',
            'token' => $token,
            'time' => $result['time'] ?? '',
            'memory' => $result['memory'] ?? ''
        ]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
