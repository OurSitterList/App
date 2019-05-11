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

mysql_query("DELETE from push_tokens where user_id='" . $user_id . "' and push_token='" . $push_token . "'");
echo json_encode(array('code' => 200, 'message' => 'Success.'));
exit;
