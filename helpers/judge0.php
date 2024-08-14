<?php
//change comment if key expired
$API_KEY = '58db07e382mshb0ba8bdce54360ap16822djsnd7382ff19b11';
//$API_KEY = '386d354f6dmsh86c78ca9a27d4f6p1ef2e8jsn41bbc0d8d92d';
$base= 'https://judge0-ce.p.rapidapi.com/';

function createSubmission($DATA, $cpu_time_limit = 5, $memory_limit = 128000, $max_file_size = 10240, $stdin = null, $expected_output = null) {
    global $API_KEY;
    global $base;
    $url = $base.'submissions';

    $data = [
        'language_id' => $DATA['language_id'],
        'source_code' => base64_encode($DATA['code']),
        'stdin' => $stdin ? base64_encode($stdin) : null,
        'expected_output' => $expected_output ? base64_encode($expected_output) : null,
        'cpu_time_limit' => $cpu_time_limit,
        'memory_limit' => $memory_limit,
        'max_file_size' => $max_file_size,
        'base64_encoded' => 'true',
        'wait' => 'false',
        'fields' => '*'
    ];

    $headers = [
        'Content-Type: application/json',
        'X-RapidAPI-Key: ' . $API_KEY,
        'X-RapidAPI-Host: judge0-ce.p.rapidapi.com'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        error_log("cURL Error: " . $err);
        return ['error' => $err];
    } else {
        $decoded_response = json_decode($response, true);
        error_log("API Response: " . print_r($decoded_response, true));
        return $decoded_response;
    }
}

function getSubmission($token) {
    global $API_KEY;
    global $base;
    $url =  $base.'submissions/' . $token . '?base64_encoded=true&fields=*';

    $headers = [
        'x-rapidapi-key: ' . $API_KEY,
        'x-rapidapi-host: judge0-ce.p.rapidapi.com'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);
    return json_decode($response, true);
}

function getLanguages() {
    global $API_KEY;
    global $base;
    $url = $base.'languages';

    $headers = [
        'x-rapidapi-key: ' . $API_KEY,
        'x-rapidapi-host: judge0-ce.p.rapidapi.com'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);
    return json_decode($response, true);
}

function createBatchSubmission($submissions) {
    global $API_KEY;
    $url = 'https://judge0-ce.p.rapidapi.com/submissions/batch';

    $data = [
        'submissions' => $submissions
    ];

    $headers = [
        'Content-Type: application/json',
        'X-RapidAPI-Key: ' . $API_KEY,
        'X-RapidAPI-Host: judge0-ce.p.rapidapi.com'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        error_log("cURL Error: " . $err);
        return ['error' => $err];
    } else {
        $decoded_response = json_decode($response, true);
        error_log("API Response: " . print_r($decoded_response, true));
        return $decoded_response;
    }
}

function getBatchSubmissions($tokens) {
    global $API_KEY;
    $url = 'https://judge0-ce.p.rapidapi.com/submissions/batch?tokens=' . implode(',', $tokens) . '&base64_encoded=true&fields=*';

    $headers = [
        'x-rapidapi-key: ' . $API_KEY,
        'x-rapidapi-host: judge0-ce.p.rapidapi.com'
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);
    return json_decode($response, true);
}

?>
