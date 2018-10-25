<?php error_reporting(E_ALL);
ini_set("display_errors", 1);
include('includes/connection.php');?>
<?php
extract($_POST);
if(base64_decode($_POST['user_info_submit'])=='submit_family_page')
{
	$firstName 				= trim($user_first_name);
	$lastName 				= trim($user_last_name);
	$creditCardNumber 		= trim($cardNumber);
	$expDateMonth 			= trim($expirationDate_month);
	$padDateMonth 			= str_pad(trim($expDateMonth), 2, '0', STR_PAD_LEFT);
	$expDateYear 			= trim($expirationDate_year);
	$cvv2Number 			= trim($cardCode);
	$card_information		= (isset($card_information)) ? trim($card_information) : 0;
	$amount 				= "45.00";
	$currencyCode			= "USD";
	$paymentType			= "AUTH_CAPTURE";
	$date 					= $expDateMonth.$expDateYear;

	$user_details			= array (
		"user_name"				=> $family_username,
		"user_password"			=> $family_password,
		"user_email"			=> $family_email,
		"join_date"				=> time(),
		"user_type"				=> 'family',

		"user_first_name"		=> $user_first_name,
		"user_last_name"		=> $user_last_name,
		"location_code"			=> $user_zip,
		"user_current_address"	=> $user_current_address,
		"user_cell_phone"		=> $user_cell_phone,
		"user_biography"		=> $user_first_name,
		"user_contact_email"	=> $user_contact_email,
		"user_hear_about"		=> $user_hear_about,
		"user_family_needs"		=> $user_contact_address
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

	if ($_POST['user_contact_email'] === 'cjohnson2242@mailinator.com')
	{
		$payment_details['x_test_request'] = true;
//		$payment_details['x_validation_mode'] = 'testMode';
	}

	// validate email
	$response = false;
	if (strlen($user_contact_email) < 4)
	{
		$response		= array('message' => 'A valid email address must be entered. Please hit the back button on your browser window and try again.');
	}
	else
	{
		$tsplit = explode('@', $user_contact_email);
		if (count($tsplit) !== 2) {
			$response = array('message' => 'A valid email address must be entered. Please hit the back button on your browser window and try again.');
		} else {
			$tsplit2 = explode('.', $tsplit[1]);
			if (count($tsplit2) !== 2) {
				$response = array('message' => 'A valid email address must be entered. Please hit the back button on your browser window and try again.');
			}
		}
	}




//	print_r($payment_details);die;

	if (!$response)
	{
		// check promo code
//		die('Promo: ' . $_SESSION['familypromo']);
		$skipBilling = false;
		if (isset($_SESSION['familypromo']) && (int)$_SESSION['familypromo'] === 1)
		{
			// skip billing
			$skipBilling = true;
		}

		$auth = new Auth();
		$response = $auth->register($user_details, $payment_details, $skipBilling);

		if ($response->success && isset($response->reason)) {
			if ($skipBilling)
			{
				$notification = new Notification();
				$notify = $notification->send_application_details($user_details);
				$response = array('message' => 'You have successfully signed up. You may now sign in using the Login link in the top right hand corner.');

				// update user status
//				mysql_query("UPDATE user_management SET user_status = 1, is_payment_status = 1, promo_code = '1' WHERE user_email = '" . mysql_real_escape_string($family_email) . "'");
			}
			else
			{
				$notification = new Notification();
				$notify = $notification->send_application_details($user_details);
				$response = array('message' => $response->reason . $notify);
			}
		} else {
			$response = array('message' => $response->reason);
		}
//		echo print_r($response, true);die('here');
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
