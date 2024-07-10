<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0); // Change this to 0

ob_start(); // Start output buffering

require_once '../helpers/judge0.php';
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        $language_id = $data['languageId'];
        $source_code = $data['code'];
        $stdin = isset($data['stdin']) ? $data['stdin'] : "dipto";
        $expected_output = isset($data['expected_output']) ? $data['expected_output'] : "dip";
        $cpu_time_limit = isset($data['cpu_time_limit']) ? $data['cpu_time_limit'] : 5;
        $memory_limit = isset($data['memory_limit']) ? $data['memory_limit'] : 128000;
        $max_file_size = isset($data['max_file_size']) ? $data['max_file_size'] : 10240;

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
            error_log("Submission response: " . print_r($submission_response, true));
            throw new Exception('No token received from submission. Full response: ' . json_encode($submission_response));      
        }

        // Fetch submission result after a delay
        sleep(5);  // Wait for some time to let the submission be processed
        $result = getSubmission($token);

        // Decode base64 encoded fields
        $stdout = base64_decode($result['stdout'] ?? '');
        $stderr = base64_decode($result['stderr'] ?? '');
        $compile_output = base64_decode($result['compile_output'] ?? '');
        $status = $result['status']['description'] ?? '';
        $created_at = $result['created_at'] ?? '';
        $finished_at = $result['finished_at'] ?? '';
        $time = $result['time'] ?? '';
        $memory = $result['memory'] ?? '';

        echo json_encode([
            'stdout' => $stdout,
            'stderr' => $stderr,
            'compile_output' => $compile_output,
            'status' => $status,
            'created_at'=> $created_at,
            'finished_at'=> $finished_at,
            'token' => $token,
            'time' =>  $time,
            'memory' => $memory
        ]);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

ob_end_flush(); // End output buffering and flush output
?>