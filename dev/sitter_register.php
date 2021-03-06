<?php error_reporting(E_ALL);
ini_set("display_errors", 1);
include('includes/connection.php');?>
<?php
extract($_POST);
if(base64_decode($_POST['user_info_submit'])=='submit_sitter_page')
{
	$firstName 				= trim($user_first_name);
	$lastName 				= trim($user_last_name);
	$creditCardNumber 		= trim($cardNumber);
	$expDateMonth 			= trim($expirationDate_month);		
	$padDateMonth 			= str_pad(trim($expDateMonth), 2, '0', STR_PAD_LEFT);		
	$expDateYear 			= trim($expirationDate_year);
	$cvv2Number 			= trim($cardCode);
	$amount 				= "45.00";
	$currencyCode			= "USD";
	$paymentType			= "AUTH_CAPTURE";
	$date 					= $expDateMonth.$expDateYear;
	
	$user_details			= array (
		"user_name"				=> $sitter_username,
		"user_password"			=> $sitter_password,
		"user_email"			=> $sitter_email,
		"join_date"				=> time(),
		"user_type"				=> 'sitter',
		
		"user_first_name"		=> $user_first_name,
		"user_last_name"		=> $user_last_name,
		"user_driver_license"	=> $user_driver_license,
		"user_firstaid_training"			=> $user_firstaid_training,
		"user_date_of_certification"		=> $user_date_of_certification,
		"is_user_willing_to_certified"		=> $is_user_willing_to_certified,
		"user_cpr_training"					=> $user_cpr_training,
		"user_date_of_certification_cpr"	=> $user_date_of_certification_cpr,
		"is_user_willing_to_certified_cpr"	=> $is_user_willing_to_certified_cpr,
		"user_emergency_contact"			=> $user_emergency_contact,
		"user_description"		=> $user_description,
		"user_cell_phone"		=> $user_cell_phone,
		"user_high_school"		=> $user_high_school,
		"user_high_school_name"	=> $user_high_school_name,
		"user_college"			=> $user_college,
		"user_college_name"		=> $user_college_name,
		"user_ref1_name"		=> $user_ref1_name,
		"user_ref1_role"		=> $user_ref1_role,
		"user_ref1_age"			=> $user_ref1_age,
		"user_ref1_length"		=> $user_ref1_length,
		"user_ref2_name"		=> $user_ref2_name,
		"user_ref2_role"		=> $user_ref2_role,
		"user_ref2_age"			=> $user_ref2_age,
		"user_ref2_length"		=> $user_ref2_length,
		"user_biography"		=> $user_first_name,
		"user_newborn_exp"		=> $user_babysitting_exp
	);
	
	$setting 		= new Setting(array('id' => 8));
	$setting_item	= $setting::get_setting_item();		
	$login		= $setting_item[3];
	
	$setting 		= new Setting(array('id' => 9));
	$setting_item	= $setting::get_setting_item();		
	$transkey		= $setting_item[3];

	$payment_details = array(
		"x_login"			=> "$login",
		"x_tran_key"		=> "$transkey",
		"x_version"			=> "3.1",
		"x_delim_data"		=> "TRUE",
		"x_delim_char"		=> "|",
		"x_relay_response"	=> "FALSE",
		"x_device_type"		=> "1",
		"x_type"			=> "AUTH_CAPTURE",
		"x_method"			=> "CC",
		"x_card_num"		=> $creditCardNumber,
		"x_exp_date"		=> $date,
		"x_amount"			=> $amount,
		"x_description"		=> "{$firstName} {$lastName} one time registration fee.",
		"x_first_name"		=> $firstName,
		"x_last_name"		=> $lastName,
		"x_response_format"	=> "1",
		"is_payment_test"	=> 0
	);

	$auth	= new Auth();
	$response = $auth->register($user_details, $payment_details);
		
	if($response->success && isset($response->reason)) {
		$notification	= new Notification();
		$notify			= $notification->send_application_details($user_details);	
		$response		= array('message' => $response->reason.$notify);
	}
	else {
		$response		= array('message' => $response->reason);
	}
}
?>
<?php include('includes/header.php');?>
<?php
$response 	= new Response($response);
$response::modal();
?>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<?php include('includes/footer.php');?>
