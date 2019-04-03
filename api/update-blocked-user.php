<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

if (!isset($_REQUEST) || !array_key_exists('user_id', $_REQUEST)) {
    echo json_encode(array('code' => 401, 'message' => 'User ID is required.'));
    exit;
}

$user_id = $_REQUEST['user_id'];
$blocked_user_id = $_REQUEST['blocked_user_id'];
$block_state = $_REQUEST['block_state'];

if ($block_state === 'unblock') {
    $sql_DeleteExisting = "DELETE FROM blocked_users
                           WHERE b.user_id='" . $user_id . "' AND b.blocked_user_id='" . $blocked_user_id . "'";
    mysql_query($sql_DeleteExisting);
} else {
    $sql_SearchForExisting = "SELECT b.blocked_id as id, b.user_id as user_id, b.blocked_user_id as blocked_user_id
                              FROM blocked_users b
                              WHERE b.user_id='" . $user_id . "' AND b.blocked_user_id='" . $blocked_user_id . "'";
    $query_results = mysql_query($sql_SearchForExisting);
    if (mysql_num_rows($query_results) === 0) {
        $sql_InsertNew = "INSERT INTO blocked_users ('user_id', 'blocked_user_id')
                          VALUES ('" . $user_id . "'', '" . $blocked_user_id . "')";
        mysql_query($sql_InsertNew);
    }
}

$response = array('code' => 200, 'message' => 'Success');
echo json_encode($response);
exit;
