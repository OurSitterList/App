<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

var_dump($_POST);
// exit;

extract($_POST);

$sql = "INSERT INTO messages (user_id, recipient_id, thread_id, message, created_at)
  VALUES ('" . $user_id . "', '" . $recipient_id . "', '" . $thread_id . "', '" . $message . "', '" . date('m/d/Y h:i:s a', time()) . "')";

var_dump($sql);
exit;
