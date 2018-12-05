<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

extract($_POST);

$sql = "UPDATE messages SET deleted_at='" . date('Y-m-d H:i:s',time()) . "' WHERE id='" . $message_id . "';";

mysql_query($sql);

$response	= array('code' => 200, 'message' => 'Success.');
echo json_encode($response); exit;
