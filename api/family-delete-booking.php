<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

if (!isset($_REQUEST) || !array_key_exists('user_id', $_REQUEST)) {
    echo json_encode(array('code' => 401, 'message' => 'User ID is required.'));
    exit;
}

mysql_query("DELETE FROM book_management WHERE book_id='" . $_REQUEST['book_id'] . "' AND family_user_id='" . $_REQUEST['user_id'] . "'");

$response = array('code' => 200, 'message' => 'Success');
echo json_encode($response);exit;
