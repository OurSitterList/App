<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

$user_id = $_REQUEST['user_id'];
$recipient_id = $_REQUEST['recipient_id'];

$query = mysql_query("SELECT DISTINCT thread_id
                      FROM messages
                      WHERE user_id = '" . $user_id . "' AND recipient_id = '" . $recipient_id . "'
                      OR user_id = '" . $recipient_id . "' AND recipient_id = '" . $user_id . "' LIMIT 1");

$json = array();
if (mysql_num_rows($query) > 0) {
    $R = mysql_fetch_object($query);
    $json['thread_id'] = $R->thread_id;

    header('Content-Type:application/json');
    http_response_code(200);
    $response = array('result' => $json);
    echo json_encode($response);exit;
} else {
    $json['thread_id'] = null;
    $response = array('result' => $json);

    header('Content-Type:application/json');
    http_response_code(200);
    echo json_encode($response);exit;
}
