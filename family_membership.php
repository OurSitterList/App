<?php error_reporting(E_ALL);
ini_set("display_errors", 1);
include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php

require_once BASEPATH . 'class.MailUtil.php';


if(base64_decode($_POST['user_info_submit'])=='submit_family_membership')
{
extract($_POST);

if($user_plan ==3)
{
	$amount = 38;
	$recurr_time = 2;
	$expiery_date = strtotime("+3 months");
	$msg = '<p style="font-size:13px; margin:5px 0;">$38 per month for 3 month membership <span style="font-style:italic;"></span></p>';
}
elseif($user_plan ==6)
{
	$amount = 32;
$recurr_time = 5;
$expiery_date = strtotime("+6 months");
$msg = '<p style="font-size:13px; margin:5px 0;">$32 per monthfor a 6 month membership <span style="font-style:italic;"></span></p>';
}
else
{
	$amount = 24;
$recurr_time = 11;
$expiery_date = strtotime("+12 months");
$msg = '<p style="font-size:13px; margin:5px 0;">$24 per month a 12 month membership <span style="font-style:italic;"></span></p>';
}

	// overrides the number of recurrences and sets to unlimited.
	// automatic billing will continue until the customer cancels.
	$recurr_time = 9999;
	$expiery_date = strtotime("+20 years");


	$testMode = false; //(($cardNumber == '4111111111111') ? true : false);
//	die('Expires: ' . date('m/d/Y', $expiery_date) . ' - test mode: ' . $testMode);

 require_once("AuthnetARB.class.php");

 require_once('tools/PHPMailer-master/PHPMailerAutoload.php');
$login = mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='8'"))->settingValue;
 $transkey = mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='9'"))->settingValue;
 $test = FALSE;

//	mail('sethcriedel@gmail.com', 'AUTH STUFF', 'Login: ' . $login . ', key: ' . $transkey);

// check for cancellation
$sql = "SELECT * FROM user_management
WHERE user_id = '" . mysql_real_escape_string($_SESSION['user_id_member_choose']) . "'";
$result = mysql_query($sql);
if (mysql_num_rows($result) < 1)
{
	setPostMsg('An unexpected error has occurred.  Please try again later.');
	//header('Location:'.$base_path.'/family_app_register_error.php?getResultCode=&isError=An-unexpected-error-has-occurred&getResponse=');
	header("Location: error.php");
	exit;
}
$currentUser = mysql_fetch_object($result);

print_r($currentUser);

if ((int)$currentUser->user_subscriberid > 0 && (int)$currentUser->payment_error === 1)
{
	//die('NEED TO CANCEL: ' . $currentUser->user_subscriberid);
	// cancel existing/old subscription
	$arb = new AuthnetARB($login, $transkey, $testMode);
	$arb->deleteAccountBySubscriberId($currentUser->user_subscriberid);

	if ($arb->isSuccessful())
	{
		/*die('Cancellation successful!

		' . print_r($arb->getResponse(), true));
	}
	else
	{
		die('Cancellation failed!

		' . print_r($arb->getResponse(), true));*/
	}
}
else
{
	//die('Nothing to cancel..');
}
//die ('after check cancellation');


$arb = new AuthnetARB($login, $transkey, $testMode);

$arb->setParameter('interval_length', 1);
 $arb->setParameter('interval_unit', 'months');
  $arb->setParameter('startDate', date("Y-m-d"));
   $arb->setParameter('totalOccurrences', $recurr_time);
    $arb->setParameter('trialOccurrences', 0);
	 $arb->setParameter('trialAmount', $amount);

$arb->setParameter('amount', $amount);
 $arb->setParameter('refID', time());
 $arb->setParameter('cardNumber', $cardNumber);
 $arb->setParameter('expirationDate',  $expirationDate_year.'-'.$expirationDate_month);
 $arb->setParameter('cardCode', $cardCode);

$arb->setParameter('firstName', $user_first_name);
$arb->setParameter('lastName', $user_last_name);

$arb->setParameter('subscrName', 'Family Subscription - '.$_SESSION['user_name_member_choose']);
 $arb->createAccount();
 if ($arb->isSuccessful())
 {

	 // remove expired flag
	 if (isset($_SESSION))
	 {
		 $_SESSION['_sub_expired'] = false;
	 }
 $today = time();

 $newsubid = $arb->getSubscriberID();

 // log subscriber id change if existing subscriber id exists
 $logsql = "INSERT INTO user_subscriberid_log (user_id, log_time, old_subscriberid, new_subscriberid) " .
	 "SELECT '" . $_SESSION['user_id_member_choose'] . "', NOW(), user_subscriberid, '" . $newsubid . "' " .
	 "FROM user_management " .
	 "WHERE user_id = '" . $_SESSION['user_id_member_choose'] . "' " .
 	"AND user_subscriberid != ''";
	 mail('sethcriedel@gmail.com', 'New SQL for subscriberid', "SQL: \n\n<br />" . $logsql, 'From: noreply@oursitterlistnashville.com');
 mysql_query($logsql);


 mysql_query("update user_management set
 			is_payment_status = '1',
			payment_error = 0,
			user_plan = '".$user_plan."',
			user_expierydate = '".$expiery_date."',
			user_subscriberid = '".$newsubid."',
			join_date = '".$today."'
			where user_id='".$_SESSION['user_id_member_choose']."'
			");


	$admin_contact_email = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='1'"));
	$admin_contact_name = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='4'"));

	$message = file_get_contents('family-application1.html');
	$message = str_replace('%FULL_NAME%', $user_first_name." ".$user_last_name, $message);

	$message = str_replace('%USER_ID%', $_SESSION['user_name_member_choose'], $message);
	$message = str_replace('%SUBSCRIPTION_ID%', $arb->getSubscriberID(), $message);
	$message = str_replace('%MEMBERSHIP_PLAN%', $msg, $message);
	$message = str_replace('%DATE%', date("M d, Y",$today), $message);

	$mail = MailUtil::getMailerWhitney();
	//$mail->isSMTP();
	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	//$mail->SMTPDebug = 0;
	$mail->Debugoutput = 'html';
	//$mail->Host = "mail.lnsel.in";
	//Set the SMTP port number - likely to be 25, 465 or 587
	//$mail->Port = 25;
	//$mail->SMTPAuth = true;
	//$mail->Username = "mail@lnsel.in";
	//$mail->Password = "India_123";
//	$mail->setFrom($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
	//$mail->addReplyTo('replyto@example.com', 'First Last');
	$user_info = mysql_fetch_object(mysql_query("select * from user_management where user_id='".$_SESSION['user_id_member_choose']."'"));
	$mail->addAddress($user_info->user_email, $user_first_name);

	 $mail->AddCC($admin_contact_email['settingValue']);
	$mail->AddBCC("subhodeep@lnsel.net");
	 $mail->AddBCC("cjohnson@furiae-interactive.com");
	 //$mail->AddBCC("sethcriedel@gmail.com");
	$mail->Subject = 'Family Membership Subscription';
	//Replace the plain text body with one created manually
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	$mail->msgHTML($message);
	//Replace the plain text body with one created manually
	$mail->AltBody = 'This is a plain-text message body';

	//Attach an image file
	//$mail->addAttachment('images/phpmailer_mini.png');
	if (!$mail->send())
	{
//		echo "Mailer Error: " . $mail->ErrorInfo;
	}


	  $_SESSION['user_id'] = $_SESSION['user_id_member_choose'];
$_SESSION['user_name'] = $_SESSION['user_name_member_choose'];
$_SESSION['user_type'] = $_SESSION['user_type_member_choose'];
unset($_SESSION['user_id_member_choose']);
unset($_SESSION['user_name_member_choose']);
unset($_SESSION['user_type_member_choose']);


//echo date('d M, Y',$R->user_expierydate);exit;
header('Location:'.$base_path.'/family_dashboard.php');

  }

  else {
		header('Location:'.$base_path.'/family_app_register_error.php?getResultCode='.$arb->getResultCode().'&isError='.$arb->isError().'&getResponse='.$arb->getResponse());
	}
}
?>
