<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0); // Change this to 0

ob_start(); // Start output buffering

require_once '../helpers/judge0.php';
//batch submission
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['batch_submissions']) && is_array($data['batch_submissions'])) {
            // Batch submission
            $batch_submissions = array_map(function($submission) {
                return [
                    'language_id' => $submission['languageId'],
                    'source_code' => base64_encode($submission['code']),
                    'stdin' => isset($submission['stdin']) ? base64_encode($submission['stdin']) : null,
                    'expected_output' => isset($submission['expected_output']) ? base64_encode($submission['expected_output']) : null,
                    'cpu_time_limit' => $submission['cpu_time_limit'] ?? 5,
                    'memory_limit' => $submission['memory_limit'] ?? 128000,
                    'max_file_size' => $submission['max_file_size'] ?? 10240,
                ];
            }, $data['batch_submissions']);

            $batch_submission_response = createBatchSubmission($batch_submissions);
            if (isset($batch_submission_response['error'])) {
                throw new Exception('Error creating batch submission: ' . $batch_submission_response['error']);
            }

            $batch_tokens = array_column($batch_submission_response, 'token');

            if (empty($batch_tokens)) {
                throw new Exception('No tokens received from batch submission.');
            }

            // Fetch batch submission results after a delay
            sleep(5);
            $batch_results = getBatchSubmissions($batch_tokens);

            // Process and decode the results
            $processed_batch_results = array_map(function($submission) {
                return [
                    'stdout' => base64_decode($submission['stdout'] ?? ''),
                    'stderr' => base64_decode($submission['stderr'] ?? ''),
                    'compile_output' => base64_decode($submission['compile_output'] ?? ''),
                    'status' => $submission['status']['description'] ?? '',
                    'created_at' => $submission['created_at'] ?? '',
                    'finished_at' => $submission['finished_at'] ?? '',
                    'token' => $submission['token'] ?? '',
                    'time' => $submission['time'] ?? '',
                    'memory' => $submission['memory'] ?? ''
                ];
            }, $batch_results['submissions']);

            echo json_encode($processed_batch_results);
        }
    } 
    }catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
   }
        
ob_end_flush(); // End output buffering and flush output
?>