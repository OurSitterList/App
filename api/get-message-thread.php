<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

$query = mysql_query("SELECT DISTINCT thread_id
                      FROM messages
                      WHERE user_id = 139 AND recipient_id = 363");

$json = array();
if (mysql_num_rows($query) > 0) {
    $R = mysql_fetch_object($query);
    $json['thread_id'] = $R->thread_id;
    $response = array('code' => 200, 'result' => $json);
    echo json_encode($response);exit;
} else {
    $json['thread_id'] = null;
    $response = array('code' => 200, 'result' => $json);
    echo json_encode($response);exit;
}
