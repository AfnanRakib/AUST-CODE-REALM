<?php
$base= 'http://localhost:2358/';
/* Step for active server
1) docker theke run kore rakhbo
2) terminal theke cloudflared tunnel --url http://localhost:2358 diye firste tunnel kore link pabo
   oi link ta base hisebe use korbo(laste ekta / thakbe) terminal close kora jabe na.
*/
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
        'max_file_size' => 4095,
        'base64_encoded' => 'true',
        'wait' => 'false',
        'fields' => '*'
    ];

    $headers = [
        'Content-Type: application/json'
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

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

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

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    if(curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);
    return json_decode($response, true);
}
?>
