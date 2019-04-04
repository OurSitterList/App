<?php
header('Content-Type: application/json');

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

// Did the recipient block messages from this User?
$sql_SearchForExisting = mysql_query(
    "SELECT b.blocked_id as id, b.user_id as user_id, b.blocked_user_id as blocked_user_id
     FROM blocked_users b
     WHERE b.user_id='" . $recipient_id . "' AND b.blocked_user_id='" . $user_id . "'"
);
if (mysql_num_rows($sql_SearchForExisting) > 0) {
    $response = array('code' => 200, 'message' => 'Blocked');
    echo json_encode($response);
    exit;
}

$sql = "INSERT INTO messages (user_id, recipient_id, thread_id, message, created_at)
  VALUES ('" . $user_id . "', '" . $recipient_id . "', '" . $thread_id . "', '" . $message . "', '" . date('Y-m-d H:i:s', time()) . "')";
mysql_query($sql);

$err = mysql_error();
if ($err) {
    die('An error occurred trying to create the message: ' . $err);
}

$search_query = mysql_query("SELECT p.push_token, u.user_first_name, u.user_last_name
                             FROM push_tokens p
                             INNER JOIN user_information u ON p.user_id = u.user_id
                             WHERE p.user_id='" . $recipient_id . "'");
if (mysql_num_rows($search_query) > 0) {
    while ($R = mysql_fetch_object($search_query)) {
        $token = $R->push_token;
        $data = array(
            'to' => $token,
            'title' => 'Our Sitter List',
            'body' => 'New message',
            'badge' => 1,
            'sound' => 'default',
            'data' => array(
                'type' => 'message',
                'thread_id' => $thread_id,
                'first_name' => $R->user_first_name,
                'last_name' => $R->user_last_name,
            ),
        );
        $json = json_encode($data);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_VERBOSE, false);
        curl_setopt($curl, CURLOPT_URL, "http://ec2-34-228-190-15.compute-1.amazonaws.com:3000/message");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'accept: application/json',
            'accept-encoding: gzip, deflate',
            'content-type: application/json',
        ));
        $curl_response = curl_exec($curl);
        curl_close($curl);
    }
}

$response = array('code' => 200, 'message' => 'Success.');
echo json_encode($response);exit;
