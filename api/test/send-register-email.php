<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';

$template = $_SERVER["DOCUMENT_ROOT"] . '/templates/notification/family-application.html';

$firstName = 'Adam';
$lastName = 'Horky';

$msg = file_get_contents($template);
$msg = str_replace('%FULL_NAME%', $firstName . " " . $lastName, $msg);
    $msg = str_replace('%CURRENT_ZIP%', '$user_zip', $msg);
    $msg = str_replace('%CURRENT_ADDRESS%', '$user_current_address', $msg);
    $msg = str_replace('%EMAIL_ADDRESS%', '$user_contact_email', $msg);
    $msg = str_replace('%PHONE_NUMBER%', '$user_cell_phone', $msg);
    $msg = str_replace('%NEEDS%', '$user_contact_address', $msg);
    $msg = str_replace('%HEAR_ABOUT_US%', '$user_hear_about', $msg);
    $msg = str_replace('%DATE%', date('F j, Y'), $msg);
    $msg = str_replace('%ADDITONAL_MESSAGE%', 'We are working hard in processing your application and will respond within 36 hours.', $msg);

$mail = MailUtil::getMailerWhitney();
$mail->addAddress('adam.horky06@gmail.com', 'Adam');
$mail->Subject = 'New Sitter Registration';
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
