<?php error_reporting(E_ALL);
ini_set("display_errors", 1);
include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php

require_once BASEPATH . 'class.MailUtil.php';

extract($_POST);

require_once("AuthnetARB.class.php");

require_once('tools/PHPMailer-master/PHPMailerAutoload.php');
$login = mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='8'"))->settingValue;
$transkey = mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='9'"))->settingValue;
$test = FALSE;

// check for cancellation
$sql = "SELECT * FROM user_management
WHERE user_id = '" . mysql_real_escape_string($_SESSION['user_id_member_choose']) . "'";
$result = mysql_query($sql);
if (mysql_num_rows($result) < 1)
{
	setPostMsg('An unexpected error has occurred.  Please try again later.');
	header("Location: error.php");
	exit;
}
$currentUser = mysql_fetch_object($result);

// user exists, update the address
if ((int)$currentUser->user_subscriberid > 0)
{
	try {
		$arb = new AuthnetARB($login, $transkey, $test);
		$arb->setParameter('subscrId', (int)$currentUser->user_subscriberid);
		$arb->setParameter('refID', time());
		$arb->setParameter('cardNumber', $cardNumber); 
		$arb->setParameter('expirationDate',  $expirationDate_year.'-'.$expirationDate_month);
		$arb->setParameter('cardCode', $cardCode);
		$arb->setParameter('firstName', $user_first_name);
		$arb->setParameter('lastName', $user_last_name);
		$arb->updateAccount();

		if ($arb->isSuccessful()) { 
			header('Location:'.$base_path.'/family_dashboard.php');
		} else {
			header('Location:'.$base_path.'/family_app_register_error.php?getResultCode='.$arb->getResultCode().'&isError='.$arb->isError().'&getResponse='.$arb->getResponse());
		}
	} catch (AuthnetARBException $e) {
		header('Location:'.$base_path.'/family_app_register_error.php?getResultCode='.$arb->getResultCode().'&isError='.$arb->isError().'&getResponse='.$arb->getResponse());
	}
} else {
	header('Location:'.$base_path.'/family_app_register_error.php?getResultCode='.$arb->getResultCode().'&isError='.$arb->isError().'&getResponse='.$arb->getResponse());
}
?>