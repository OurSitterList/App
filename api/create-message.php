<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

/*
 * POST: (all required, even if empty)
 *
 * $user_id
 * $recipient_id
 * $thread_id
 * $message
 */

$data = json_decode(file_get_contents('php://input'), true);

$user_id = $data['user_id'];
$recipient_id = $data['recipient_id'];
$thread_id = $data['thread_id'];
$message = mysql_real_escape_string($data['message']);

$sql = "INSERT INTO messages (user_id, recipient_id, thread_id, message, created_at)
  VALUES ('" . $user_id . "', '" . $recipient_id . "', '" . $thread_id . "', '" . $message . "', '" . date('Y-m-d H:i:s', time()) . "')";

mysql_query($sql);

$err = mysql_error();
if ($err) {
    die('An error occurred trying to create the message: ' . $err);
}

$search_query = mysql_query("select * from push_tokens where user_id='" . $user_id . "'");
if (mysql_num_rows($search_query) > 0) {
    $data = json_encode(array('to' => 'ExponentPushToken[IWwlmUPaI5KfMO3vCMs2ly]', 'title' => 'fromPHP', 'body' => 'PHP body', 'badge' => 1, 'data' => '{"name":"billy"}'));
    $curl = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://exp.host/--/api/v2/push/send");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: application/json',
        'accept-encoding: gzip, deflate',
        'content-type: application/json',
    ));
    $result = curl_exec($curl);
    curl_close($curl);
}

$response = array('code' => 200, 'message' => 'Success.');
echo json_encode($response);exit;
