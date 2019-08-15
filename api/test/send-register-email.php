<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';

$template = $_SERVER["DOCUMENT_ROOT"] . '/templates/notification/registered-sitter-or-family.html';

$mail = MailUtil::getMailerWhitney();
// $mail->addAddress('oursitterlist@gmail.com', 'Webmaster');
// $mail->addAddress($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
$mail->addAddress('adam.horky06@gmail.com', 'Adam');
$mail->Subject = 'New Sitter Registration';

$msg = file_get_contents($template);
$msg = str_replace('%TYPE%', 'Sitter', $msg);
$msg = str_replace('%FIRSTNAME%', 'Adam', $msg);
$msg = str_replace('%LASTNAME%', 'Horky', $msg);
$mail->isHTML(true);
$mail->msgHTML($msg);
$mail->Debugoutput = 'html';
$mail->AltBody = 'This is a plain-text message body';

$mail->send();

header('Content-Type:application/json');
http_response_code(200);
$response = array('message' => 'Email Sent!');
echo json_encode($response);
exit;
