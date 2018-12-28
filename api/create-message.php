<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

require_once $_SERVER["DOCUMENT_ROOT"] . '/tools/Expo/Expo.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/tools/Expo/ExpoRegistrar.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/tools/Expo/ExpoRepository.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/tools/Expo/Repositories/ExpoFileDriver.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/tools/Expo/Exceptions/ExpoException.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/tools/Expo/Exceptions/ExpoRegistrarException.php';

try {
    $instance = \ExponentPhpSDK\Expo::normalSetup();
    echo 'Succeeded! We have created an Expo instance successfully';
} catch (Exception $e) {
    echo 'Test Failed';
}

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

$response = array('code' => 200, 'message' => 'Success.');
echo json_encode($response);exit;
