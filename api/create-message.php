<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

/*
  * POST: (all required, even if empty)
  * 
  * $user_id
  * $recipient_id
  * $thread_id
  * $message
*/


$data = json_decode(file_get_contents('php://input'), true);

$sql = "INSERT INTO messages (user_id, recipient_id, thread_id, message, created_at)
  VALUES ('" . $data['user_id'] . "', '" . $data['recipient_id'] . "', '" . $data['thread_id'] . "', '" . $data['message'] . "', '" . date('Y-m-d H:i:s',time()) . "')";

mysql_query($sql);

$response	= array('code' => 200, 'message' => 'Success.');
echo json_encode($response); exit;
