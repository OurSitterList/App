<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

if (!isset($_REQUEST) || !array_key_exists('user_id', $_REQUEST)) {
    echo json_encode(array('code' => 401, 'message' => 'User ID is required.'));
    exit;
}

$sql = "SELECT b.blocked_id as id, b.user_id as user_id, b.blocked_user_id as blocked_user_id
  FROM blocked_users b WHERE m.user_id='" . $_REQUEST['user_id'] . "'";

$query = mysql_query($sql);
$data = array();

while ($R = mysql_fetch_object($query)) {
    $data[] = $R;
}

$response = array('code' => 200, 'message' => array('results' => $data));
echo json_encode($response);exit;
