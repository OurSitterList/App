<?php

/**
 * POST: (all required, even if empty)
 *
 * $user_id
 * $user_first_name
 * $user_last_name
 * $cardNumber
 * $expirationDate_month
 * $expDateMonth
 * $expirationDate_year
 * $expDateYear
 * $cardCode
 *
 * $sitter_username
 * $sitter_password
 * $sitter_email
 * $user_zip
 * $user_first_name
 * $user_last_name
 * $user_driver_license
 * $user_firstaid_training
 * $user_date_of_certification
 * $is_user_willing_to_certified
 * $user_cpr_training
 * $user_date_of_certification_cpr
 * $is_user_willing_to_certified_cpr
 * $user_emergency_contact
 * $user_description
 * $user_cell_phone
 * $user_high_school
 * $user_high_school_name
 * $user_college
 * $user_college_name
 * $user_ref1_name
 * $user_ref1_role
 * $user_ref1_age
 * $user_ref1_length
 * $user_ref2_name
 * $user_ref2_role
 * $user_ref2_age
 * $user_ref2_length
 * $user_babysitting_exp
 */

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';

$template = $_SERVER["DOCUMENT_ROOT"] . '/templates/notification/sitter-application.html';

// var_dump($_POST);
// exit;

extract($_POST);

try {
    $firstName = trim($user_first_name);
    $lastName = trim($user_last_name);
    $creditCardNumber = trim($cardNumber);
    $expDateMonth = trim($expirationDate_month);
    $padDateMonth = str_pad(trim($expDateMonth), 2, '0', STR_PAD_LEFT);
    $expDateYear = trim($expirationDate_year);
    $cvv2Number = trim($cardCode);
    $amount = "25.00";
    $currencyCode = "USD";
    $paymentType = "AUTH_CAPTURE";
    $date = $expDateMonth . $expDateYear;

    $user_details = array(
        "user_name" => $sitter_username,
        "user_password" => $sitter_password,
        "user_email" => $sitter_email,
        "join_date" => time(),
        "user_type" => 'sitter',
        "location_code" => $user_zip,
        "user_first_name" => $user_first_name,
        "user_last_name" => $user_last_name,
        "user_driver_license" => $user_driver_license,
        "user_firstaid_training" => $user_firstaid_training,
        "user_date_of_certification" => $user_date_of_certification,
        "is_user_willing_to_certified" => $is_user_willing_to_certified,
        "user_cpr_training" => $user_cpr_training,
        "user_date_of_certification_cpr" => $user_date_of_certification_cpr,
        "is_user_willing_to_certified_cpr" => $is_user_willing_to_certified_cpr,
        "user_emergency_contact" => $user_emergency_contact,
        "user_description" => $user_description,
        "user_cell_phone" => $user_cell_phone,
        "user_high_school" => $user_high_school,
        "user_high_school_name" => $user_high_school_name,
        "user_college" => $user_college,
        "user_college_name" => $user_college_name,
        "user_ref1_name" => $user_ref1_name,
        "user_ref1_role" => $user_ref1_role,
        "user_ref1_age" => $user_ref1_age,
        "user_ref1_length" => $user_ref1_length,
        "user_ref2_name" => $user_ref2_name,
        "user_ref2_role" => $user_ref2_role,
        "user_ref2_age" => $user_ref2_age,
        "user_ref2_length" => $user_ref2_length,
        "user_biography" => $user_first_name,
        "user_newborn_exp" => $user_babysitting_exp,
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

    $auth = new Auth();
    $response = $auth->register($user_details, $payment_details, true);

    if ($response->success && isset($response->reason)) {
        $msg = file_get_contents($template);
        $msg = str_replace('%FULL_NAME%', $firstName . " " . $lastName, $msg);
        $msg = str_replace('%DRIVER_LICENSE%', $user_driver_license, $msg);
        $msg = str_replace('%FIRST_AID%', $user_firstaid_training, $msg);
        $msg = str_replace('%DATE_OF_CERTIFICATION_FIRST_AID%', $user_date_of_certification, $msg);
        $msg = str_replace('%TO_BE_CERTIFIED_FIRST_AID%', $is_user_willing_to_certified, $msg);
        $msg = str_replace('%CPR_TRAINING%', $user_cpr_training, $msg);
        $msg = str_replace('%DATE_OF_CERTIFICATION_CPR_TRAINING%', $user_date_of_certification_cpr, $msg);
        $msg = str_replace('%TO_BE_CERTIFIED_CPR_TRAINING%', $is_user_willing_to_certified_cpr, $msg);
        $msg = str_replace('%SELF_DESCRIPTION%', $user_description, $msg);
        $msg = str_replace('%CELL_PHONE_NUMBER%', $user_cell_phone, $msg);
        $msg = str_replace('%EMAIL_ADDRESS%', $sitter_email, $msg);
        $msg = str_replace('%EMERGENCY_PHONE_NUMBER%', $user_emergency_contact, $msg);
        $msg = str_replace('%HIGH_SCHOOL%', $user_high_school, $msg);
        $msg = str_replace('%HIGH_SCHOOL_NAME%', $user_high_school_name, $msg);
        $msg = str_replace('%COLLEGE%', $user_college, $msg);
        $msg = str_replace('%COLLEGE_NAME%', $user_college_name, $msg);
        $msg = str_replace('%FIRST_REFERENCE_NAME_PHONE%', $user_ref1_name, $msg);
        $msg = str_replace('%FIRST_REFERENCE_ROLE%', $user_ref1_role, $msg);
        $msg = str_replace('%FIRST_AGE_OF_CHILDREN%', $user_ref1_age, $msg);
        $msg = str_replace('%FIRST_LENGTH_OF_EMPLOYMENT%', $user_ref1_length, $msg);
        $msg = str_replace('%SECOND_REFERENCE_NAME_PHONE%', $user_ref2_name, $msg);
        $msg = str_replace('%SECOND_REFERENCE_ROLE%', $user_ref2_role, $msg);
        $msg = str_replace('%SECOND_AGE_OF_CHILDREN%', $user_ref2_age, $msg);
        $msg = str_replace('%SECOND_LENGTH_OF_EMPLOYMENT%', $user_ref2_length, $msg);
        $msg = str_replace('%EXTRA_REFERENCE_DETAILS%', $user_first_name, $msg);
        $msg = str_replace('%SPECIAL_NEEDS_REFERENCE_DETAILS%', $user_babysitting_exp, $msg);
        $msg = str_replace('%SIGNATURE_APPLICANT%', '', $msg);
        $msg = str_replace('%DATE_APPLICANT%', date('F j, Y'), $msg);
        $msg = str_replace('%SIGNATURE_PARENT%', '', $msg);
        $msg = str_replace('%DATE_PARENT%', date('F j, Y'), $msg);
        $msg = str_replace('%ADDITONAL_MESSAGE%', 'We are working hard in processing your application and will respond within 36 hours.', $msg);

        $mail = MailUtil::getMailerWhitney();
        // $mail->addAddress('oursitterlist@gmail.com', 'Webmaster');
        $mail->addAddress('adam.horky06@gmail.com', 'Webmaster');
        // $mail->addAddress($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
        $mail->Subject = 'New Sitter Registration';
        $mail->isHTML(true);
        $mail->msgHTML($msg);
        $mail->Debugoutput = 'html';
        $mail->AltBody = 'This is a plain-text message body';
        $mail->send();

        $response = array('code' => 200, 'message' => $response->reason . $notify);
    } else {
        $response = array('code' => 400, 'message' => $response->reason);
    }

    echo json_encode($response);exit;

} catch (Exception $e) {
    $response = array('code' => 400, 'message' => $e->getMessage());
    echo json_encode($response);exit;
}
