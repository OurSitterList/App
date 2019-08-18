<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';

$template = $_SERVER["DOCUMENT_ROOT"] . '/templates/notification/sitter-application.html';

$firstName = 'Adam';
$lastName = 'Horky';

$msg = file_get_contents($template);
$msg = str_replace('%FULL_NAME%', $firstName . " " . $lastName, $msg);
$msg = str_replace('%DRIVER_LICENSE%', '$user_driver_license', $msg);
$msg = str_replace('%FIRST_AID%', '$user_firstaid_training', $msg);
$msg = str_replace('%DATE_OF_CERTIFICATION_FIRST_AID%', '$user_date_of_certification', $msg);
$msg = str_replace('%TO_BE_CERTIFIED_FIRST_AID%', '$is_user_willing_to_certified', $msg);
$msg = str_replace('%CPR_TRAINING%', '$user_cpr_training', $msg);
$msg = str_replace('%DATE_OF_CERTIFICATION_CPR_TRAINING%', '$user_date_of_certification_cpr', $msg);
$msg = str_replace('%TO_BE_CERTIFIED_CPR_TRAINING%', '$is_user_willing_to_certified_cpr', $msg);
$msg = str_replace('%SELF_DESCRIPTION%', '$user_description', $msg);
$msg = str_replace('%CELL_PHONE_NUMBER%', '$user_cell_phone', $msg);
$msg = str_replace('%EMAIL_ADDRESS%', '$sitter_email', $msg);
$msg = str_replace('%EMERGENCY_PHONE_NUMBER%', '$user_emergency_contact', $msg);
$msg = str_replace('%HIGH_SCHOOL%', '$user_high_school', $msg);
$msg = str_replace('%HIGH_SCHOOL_NAME%', '$user_high_school_name', $msg);
$msg = str_replace('%COLLEGE%', '$user_college', $msg);
$msg = str_replace('%COLLEGE_NAME%', '$user_college_name', $msg);
$msg = str_replace('%FIRST_REFERENCE_NAME_PHONE%', '$user_ref1_name', $msg);
$msg = str_replace('%FIRST_REFERENCE_ROLE%', '$user_ref1_role', $msg);
$msg = str_replace('%FIRST_AGE_OF_CHILDREN%', '$user_ref1_age', $msg);
$msg = str_replace('%FIRST_LENGTH_OF_EMPLOYMENT%', '$user_ref1_length', $msg);
$msg = str_replace('%SECOND_REFERENCE_NAME_PHONE%', '$user_ref2_name', $msg);
$msg = str_replace('%SECOND_REFERENCE_ROLE%', '$user_ref2_role', $msg);
$msg = str_replace('%SECOND_AGE_OF_CHILDREN%', '$user_ref2_age', $msg);
$msg = str_replace('%SECOND_LENGTH_OF_EMPLOYMENT%', '$user_ref2_length', $msg);
$msg = str_replace('%EXTRA_REFERENCE_DETAILS%', '$user_first_name', $msg);
$msg = str_replace('%SPECIAL_NEEDS_REFERENCE_DETAILS%', '$user_babysitting_exp', $msg);
$msg = str_replace('%SIGNATURE_APPLICANT%', '', $msg);
$msg = str_replace('%DATE_APPLICANT%', date('F j, Y'), $msg);
$msg = str_replace('%SIGNATURE_PARENT%', '', $msg);
$msg = str_replace('%DATE_PARENT%', date('F j, Y'), $msg);
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
