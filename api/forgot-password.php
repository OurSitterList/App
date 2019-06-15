<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/tools/PHPMailer-master/PHPMailerAutoload.php';

$username = $_REQUEST['user_name'];
$isSitter = $_REQUEST['is_sitter'];

if ($isSitter === true || $isSitter === 'true') {
    $userType = 'sitter';
} else {
    $userType = 'family';
}

$admin_contact_email = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='1'"));
$admin_contact_name = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='4'"));
$user_search = mysql_query("SELECT * FROM user_management WHERE user_name='" . mysql_real_escape_string($username) . "' AND user_type = '" . $userType . "' AND user_status = '1'");
if (mysql_num_rows($user_search) > 0) {
    $R = mysql_fetch_object($user_search);
    $generate_code = time() . rand(0, 100000000);
    mysql_query("update user_management set user_code='" . $generate_code . "' where user_name='" . mysql_real_escape_string($username) . "' AND user_type = '" . $userType . "' AND user_status = '1'");
    $message = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/templates/notification/contact-form.html');
    $message = str_replace('%FULL_NAME%', $R->user_name, $message);
    $message = str_replace('%EMAIL%', $R->user_email, $message);
    if ($isSitter === true || $isSitter === 'true') {
        $message = str_replace('%AS%', 'Sitter', $message);
    } else {
        $message = str_replace('%AS%', 'Family', $message);
    }
    $message = str_replace('%COMMENT%', 'To Reset Your Password <a href="https://www.oursitterlist.com/?reset_pass=1&reset_code=' . $generate_code . '">Click Here</a> or copy this link in your browser https://www.oursitterlist.com/?reset_pass=1&reset_code=' . $generate_code, $message);

    $mail = MailUtil::getMailerWhitney();
    $mail->Debugoutput = 'html';
    // $mail->setFrom($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
    $mail->addAddress($R->user_email, $R->user_name);
    if ($isSitter === true || $isSitter === 'true') {
        $mail->Subject = 'Reset - Sitter Account Password';
    } else {
        $mail->Subject = 'Reset - Family Account Password';
    }
    $mail->msgHTML($message);
    $mail->AltBody = 'This is a plain-text message body';
    if (!$mail->send()) {
        $response = array('code' => 500, 'message' => $mail->ErrorInfo);
    } else {
        $response = array('code' => 500, 'message' => 'An email has been sent to your registered account');
    }
} else {
    $response = array('code' => 500, 'message' => 'Username not found');
}

echo json_encode($response);
exit;
