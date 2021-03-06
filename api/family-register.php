<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';

$template = $_SERVER["DOCUMENT_ROOT"] . '/templates/notification/family-application.html';

/*
 * POST: (all required, even if empty)
 *
 * $user_first_name
 * $user_last_name
 * $cardNumber
 * $expirationDate_month
 * $expirationDate_year
 * $cardCode
 * $card_information
 * $family_username
 * $family_password
 * $family_email
 * $user_first_name
 * $user_last_name
 * $user_zip
 * $user_current_address
 * $user_cell_phone
 * $user_contact_email
 * $user_hear_about
 * $user_contact_address
 */

extract($_POST);

$firstName = trim($user_first_name);
$lastName = trim($user_last_name);
$creditCardNumber = trim($cardNumber);
$expDateMonth = trim($expirationDate_month);
$padDateMonth = str_pad(trim($expDateMonth), 2, '0', STR_PAD_LEFT);
$expDateYear = trim($expirationDate_year);
$cvv2Number = trim($cardCode);
$card_information = (isset($card_information)) ? trim($card_information) : 0;
$amount = "45.00";
$currencyCode = "USD";
$paymentType = "AUTH_CAPTURE";
$date = $expDateMonth . $expDateYear;

$user_details = array(
    "user_name" => $family_username,
    "user_password" => $family_password,
    "user_email" => $family_email,
    "join_date" => time(),
    "user_type" => 'family',

    "user_first_name" => $user_first_name,
    "user_last_name" => $user_last_name,
    "location_code" => $user_zip,
    "user_current_address" => $user_current_address,
    "user_cell_phone" => $user_cell_phone,
    "user_biography" => $user_first_name,
    "user_contact_email" => $user_contact_email,
    "user_hear_about" => $user_hear_about,
    "user_family_needs" => $user_contact_address,
);

$setting = new Setting(array('id' => 8));
$setting_item = $setting::get_setting_item();
$login = $setting_item[3];

$setting = new Setting(array('id' => 9));
$setting_item = $setting::get_setting_item();
$transkey = $setting_item[3];

$payment_details = array(
    "x_login" => "$login",
    "x_tran_key" => "$transkey",
    "x_version" => "3.1",
    "x_delim_data" => "TRUE",
    "x_delim_char" => "|",
    "x_relay_response" => "FALSE",
    "x_device_type" => "1",
    "x_type" => "AUTH_CAPTURE",
    "x_method" => "CC",
    "x_card_num" => $creditCardNumber,
    "x_exp_date" => $date,
    "x_amount" => $amount,
    "x_description" => "{$firstName} {$lastName} one time registration fee.",
    "x_first_name" => $firstName,
    "x_last_name" => $lastName,
    "x_response_format" => "1",
    "is_payment_test" => 1,
);

if ($user_contact_email === 'cjohnson2242@mailinator.com') {
    $payment_details['x_test_request'] = true;
}

$error = false;
if (strlen($user_contact_email) < 4) {
    $error = array('message' => 'Invalid Email.');
} else {
    $tsplit = explode('@', $user_contact_email);
    if (count($tsplit) !== 2) {
        $error = array('message' => 'A valid email address must be entered.');
    } else {
        $tsplit2 = explode('.', $tsplit[1]);
        if (count($tsplit2) !== 2) {
            $error = array('message' => 'A valid email address must be entered.');
        }
    }
}

$skipBilling = true;

$auth = new Auth();
$response = $auth->register($user_details, $payment_details, $skipBilling);

if ($response->success && isset($response->reason)) {
    $msg = file_get_contents($template);
    $msg = str_replace('%FULL_NAME%', $firstName . " " . $lastName, $msg);
    $msg = str_replace('%CURRENT_ZIP%', $user_zip, $msg);
    $msg = str_replace('%CURRENT_ADDRESS%', $user_current_address, $msg);
    $msg = str_replace('%EMAIL_ADDRESS%', $user_contact_email, $msg);
    $msg = str_replace('%PHONE_NUMBER%', $user_cell_phone, $msg);
    $msg = str_replace('%NEEDS%', $user_contact_address, $msg);
    $msg = str_replace('%HEAR_ABOUT_US%', $user_hear_about, $msg);
    $msg = str_replace('%DATE%', date('F j, Y'), $msg);
    $msg = str_replace('%ADDITONAL_MESSAGE%', 'We are working hard in processing your application and will respond within 36 hours.', $msg);

    $mail = MailUtil::getMailerWhitney();
    $mail->addAddress('oursitterlist@gmail.com', 'Webmaster');
    $mail->addAddress($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
    $mail->Subject = 'New Family Registration';
    $mail->isHTML(true);
    $mail->msgHTML($msg);
    $mail->Debugoutput = 'html';
    $mail->AltBody = 'This is a plain-text message body';
    $mail->send();

    if ($skipBilling) {
        $response = array('code' => 200, 'message' => 'You have successfully signed up.');
    } else {
        $response = array('code' => 200, 'message' => $response->reason . $notify);
    }
} else {
    $response = array('code' => 400, 'message' => $response->reason);
}

echo json_encode($response);exit;
