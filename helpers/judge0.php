<?php
$API_KEY = '386d354f6dmsh86c78ca9a27d4f6p1ef2e8jsn41bbc0d8d92d';

function createSubmission($DATA, $stdin = null, $expected_output = null) {
    global $API_KEY;
    $url = 'https://judge0-ce.p.rapidapi.com/submissions';

    $data = [
        'language_id' => $DATA['language_id'],
        'source_code' => base64_encode($DATA['code']),
        'stdin' => $stdin ? base64_encode($stdin) : null,
        'expected_output' => $expected_output ? base64_encode($expected_output) : null,
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
    if(curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);
    return json_decode($response, true);
}

function getSubmission($token) {
    global $API_KEY;
    $url = 'https://judge0-ce.p.rapidapi.com/submissions/' . $token . '?base64_encoded=true&fields=*';

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
    $url = 'https://judge0-ce.p.rapidapi.com/languages';

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
