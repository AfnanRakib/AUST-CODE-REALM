<?php
require_once '../helpers/judge0.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $language_id = $data['languageId'];
    $source_code = $data['code'];
    $stdin = isset($data['stdin']) ? $data['stdin'] : null;
    $expected_output = isset($data['expected_output']) ? $data['expected_output'] : null;;
    // Create a submission
    $submission_response = createSubmission([
        'language_id' => $language_id,
        'code' => $source_code
    ], $stdin, $expected_output);

    $token = $submission_response['token'];

    // Fetch submission result after a delay
    sleep(5);  // Wait for some time to let the submission be processed
    $result = getSubmission($token);

    // Decode base64 encoded fields
    $stdout = base64_decode($result['stdout'] ?? '');
    $stderr = base64_decode($result['stderr'] ?? '');
    $compile_output = base64_decode($result['compile_output'] ?? '');

    echo json_encode([
        'stdout' => $stdout,
        'stderr' => $stderr,
        'compile_output' => $compile_output
    ]);
}
?>
