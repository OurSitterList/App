<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

if (!isset($_REQUEST) || !array_key_exists('user_id', $_REQUEST)) {
    echo json_encode(array('code' => 401, 'message' => 'User ID is required.'));
    exit;
}

mysql_query("DELETE FROM jobapply_management
             WHERE job_id='" . $_REQUEST['job_id'] . "' AND sitter_user_id='" . $_REQUEST['user_id'] . "'");

header('Content-Type:application/json');
http_response_code(200);
$response = array('code' => 200, 'message' => 'Success');
echo json_encode($response);
exit;
