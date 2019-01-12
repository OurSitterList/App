<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

extract($_POST);

if (!$user_id) {
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
        $update_query = "UPDATE book_management SET sitter_approval = ".$sitter_approval." WHERE book_id = ".$book_id;

        mysql_query($update_query);

        $response = array('code' => 500, 'message' => $update_query);
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
