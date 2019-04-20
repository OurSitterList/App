<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/tools/PHPMailer-master/PHPMailerAutoload.php';

// send confirmation to sitter
sendJobEmail(
    'adam.horky06@gmail.com',
    'sitter',
    'Job Application Confirmation Mode',
    '',
    '',
    '',
    $_SERVER["DOCUMENT_ROOT"] . '/templates/notification/confirm-job-sitter.html'
);

// send copy to family
sendJobEmail(
    'adam.horky06@gmail.com',
    'family',
    'Job Application Confirmation Mode',
    '',
    '',
    '',
    $_SERVER["DOCUMENT_ROOT"] . '/templates/notification/confirm-job-family.html'
);

function sendJobEmail($msgTo, $msgToName, $subject, $show_msg, $confirmMsg, $jobdetails, $template)
{
    global $admin_contact_email, $admin_contact_name;

    $msg = file_get_contents($template);
    $msg = str_replace('%USERNAME%', '$jobdetails->sitter_user_name', $msg);
    $msg = str_replace('%JOBID%', '$jobdetails->job_id', $msg);
    $msg = str_replace('%NOOFKIDS%', '$jobdetails->no_of_kids', $msg);
    $msg = str_replace('%REMARKS%', '$jobdetails->remarks', $msg);
    $msg = str_replace('%ZIPCODE%', '$jobdetails->location_code', $msg);
    $msg = str_replace('%APPDATE%', 'date("m/d/Y", $jobdetails->applytime)', $msg);
    $msg = str_replace('%ACCOUNT_STATUS%', $show_msg, $msg);
    $msg = str_replace('%CSTATUS%', $confirmMsg, $msg);
    $msg = str_replace('%CONTACTLINKFAMILY%', '<a href="' . HTTPS . '/sitter_details.php?sitter_id=12345">Click here to view or contact Sitter</a>', $msg);
    $msg = str_replace('%CONTACTLINKSITTER%', '<a href="' . HTTPS . '/family.php?fid=54321">Click here to view or contact Family</a>', $msg);

    $mailer = MailUtil::getMailerWhitney();
    $mailer->Debugoutput = 'html';
    $mailer->addAddress($msgTo, $msgToName);
    $mailer->Subject = $subject;

    $mailer->msgHTML($msg);
    $mailer->AltBody = 'This is a plain-text message body';

    $mailer->send();
}

$response = array('code' => 200, 'message' => 'sent');
echo json_encode($response);
exit;
