<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

if (!isset($_REQUEST) || !array_key_exists('user_id', $_REQUEST)) {
    echo json_encode(array('code' => 401, 'message' => 'User ID is required.'));
    exit;
}

/**
 * POST
 *
 * $user_id
 * $book_id
 * $sitter_approval
 */

try {
    $search_query = mysql_query("select * from book_management where book_id=" . $book_id . "");
    if (mysql_num_rows($search_query) > 0) {
        $response = array('code' => 500, 'message' => 'success');
        echo json_encode($response);exit;
    } else {
        $response = array('code' => 500, 'message' => 'No booking found that matches the id: ' . $book_id);
        echo json_encode($response);exit;
    }
} catch (Exception $e) {
    $response = array('code' => 400, 'message' => 'Error.');
    echo json_encode($response);
    exit;
}
