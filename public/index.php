<?php
header('Content-Type: application/json');
$baseUrl = '/status';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    $response = [
        'error' => [
            'code' => 405,
            'message' => 'Method Not Allowed',
        ],
    ];
} elseif (strtok($_SERVER['REQUEST_URI'], '?') === "{$baseUrl}/") {
    $response = [
        'name' => 'Status Dashboard API',
        'description' => 'Wrapper for getting data from Uptime Robot\'s API',
        'about' => 'https://github.com/afonsodemori/aio-status-api',
        'version' => '0.0.1',
    ];
} elseif (strtok($_SERVER['REQUEST_URI'], '?') !== "{$baseUrl}/monitors") {
    $response = [
        'error' => [
            'code' => 404,
            'message' => 'Not Found',
        ],
    ];
} elseif (empty($_GET['id'])) {
    $response = [
        'error' => [
            'code' => 400,
            'message' => 'Bad Request',
        ],
    ];
} else {
    $params = array_merge($_GET, [
        'api_key' => $_SERVER['UPTIME_ROBOT_API_KEY'],
        'monitors' => $_GET['id'],
        'format' => 'json',
    ]);
    unset($params['id']);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.uptimerobot.com/v2/getMonitors',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_HTTPHEADER => array(
            'cache-control: no-cache',
            'content-type: application/x-www-form-urlencoded'
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        $response = [
            'error' => [
                'code' => 500,
                'message' => 'Internal Server Error',
                'details' => $err,
            ],
        ];
    }
}

if (isset($response['error'])) {
    header(sprintf('HTTP/1.1 %d %s', $response['error']['code'], $response['error']['message']));
}

if (is_array($response)) {
    $response = json_encode($response);
}

echo $response;
