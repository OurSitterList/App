<?php

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

/**
 * POST
 *
 * user_id
 * push_token
 */

$data = json_decode(file_get_contents('php://input'), true);

$user_id = $data['user_id'];
$push_token = $data['push_token'];

if (!$user_id) {
    echo json_encode(array('code' => 500, 'message' => 'User ID is required.'));
    exit;
}

$search_query = mysql_query("select * from user_information where user_id='" . $user_id . "'");
if (mysql_num_rows($search_query) > 0) {
    $search_query = mysql_query("select * from push_tokens where user_id='" . $user_id . "' and push_token='" . $push_token . "'");
    if (mysql_num_rows($search_query) > 0) {
        echo json_encode(array('code' => 200, 'message' => 'Record already exists for this user and device.'));
        exit;
    }
    mysql_query("insert into push_tokens set user_id='" . $user_id . "', push_token='" . $push_token . "'");
    echo json_encode(array('code' => 200, 'message' => 'Success.'));
    exit;
} else {
    echo json_encode(array('code' => 500, 'message' => 'Valid User Id is required.'));
    exit;
}
