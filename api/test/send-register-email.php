<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';

$mail = MailUtil::getMailerWhitney();
$mail->addAddress('oursitterlist@gmail.com', 'Webmaster');
$mail->addAddress($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
$mail->Subject = 'New Sitter Registration';
$mail->msgHTML('Hi');
$mail->AltBody = 'This is a plain-text message body';
$mail->send();

header('Content-Type:application/json');
http_response_code(200);
$response = array('message' => 'Success');
echo json_encode($response);
exit;
