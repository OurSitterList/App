<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . "/administrator321/config/constants.php";
include $_SERVER["DOCUMENT_ROOT"] . "/api/classes/class.NotificationUtil.php";

$mysqli = new mysqli(host, user, pass, db);

if ($mysqli->connect_errno) {
    http_response_code(500);
    echo json_encode(array('message' => "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error));
    exit;
}

$mysqli->query("set character_set_results='utf8'");

// GET JSON from HTTP request
$data = json_decode(file_get_contents("php://input"));
$data = (array) $data;

$notificationUtil = new NotificationUtil($mysqli);

if ($data['type'] === 'jobApplicationAccepted'){
    $notificationUtil->sendApplicationAccepted($data['recipient_id'], $data['user_id'], $data['job_id']);
} else if ($data['type'] === 'jobApplication') {
    $notificationUtil->sendJobApplication($data['recipient_id'], $data['user_id'], $data['job_id']);
} else {
    $notificationUtil->sendMessage($data['recipient_id'], $data['user_id'], $data['thread_id']);
}

header('Content-Type:application/json');
http_response_code(200);
echo json_encode(array('code' => 200, 'message' => 'Success'));
exit;
