<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';

$mail = MailUtil::getMailerWhitney();
// $mail->addAddress('oursitterlist@gmail.com', 'Webmaster');
// $mail->addAddress($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
$mail->addAddress('adam.horky06@gmail.com', 'Adam');
$mail->isHTML(false);
$mail->Subject = 'New Sitter Registration';
$mail->Body = 'Hi!';
$mail->AltBody = 'This is a plain-text message body';

header('Content-Type:application/json');
if (!$mail->send()) {
    http_response_code(200);
    $response = array('message' => 'EMail Sent!');
} else {
    http_response_code(500);
    $response = array('message' => 'Failure!');
}
echo json_encode($response);
exit;
