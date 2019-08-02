<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

if (!isset($_REQUEST) || !array_key_exists('user_id', $_REQUEST)) {
    echo json_encode(array('code' => 401, 'message' => 'User ID is required.'));
    exit;
}

$sql1 = "SELECT m.id, m.user_id as user_id, m.recipient_id as recipient_id, m.thread_id, m.message, ui.user_first_name as user_first_name, ui.user_last_name as user_last_name, uir.user_first_name as recipient_first_name, uir.user_last_name as recipient_last_name
         FROM messages m
         LEFT JOIN user_information ui ON m.user_id = ui.user_id
         LEFT JOIN user_information uir ON m.recipient_id = uir.user_id
         WHERE m.user_id='" . $_REQUEST['user_id'] . "' AND m.recipient_id = '" . $_REQUEST['recipient_id'] . "' AND m.deleted_at IS NULL;";

$sql2 = "SELECT m.id, m.user_id as user_id, m.recipient_id as recipient_id, m.thread_id, m.message, ui.user_first_name as user_first_name, ui.user_last_name as user_last_name, uir.user_first_name as recipient_first_name, uir.user_last_name as recipient_last_name
         FROM messages m
         LEFT JOIN user_information ui ON m.user_id = ui.user_id
         LEFT JOIN user_information uir ON m.recipient_id = uir.user_id
         WHERE m.user_id='" . $_REQUEST['recipient_id'] . "' AND m.recipient_id = '" . $_REQUEST['user_id'] . "' AND m.deleted_at IS NULL;";

$query1 = mysql_query($sql1);
$query2 = mysql_query($sql2);
$data = array();

while ($R = mysql_fetch_object($query1)) {
    $R['id'] = (int) $R['id'];
    $data[] = $R;
}
while ($R = mysql_fetch_object($query2)) {
    $R['id'] = (int) $R['id'];
    $data[] = $R;
}

header('Content-Type:application/json');
http_response_code(200);
$response = array('code' => 200, 'message' => array('results' => $data));
echo json_encode($response);exit;
