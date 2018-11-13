<?php

/**
 * POST:
 * 
 * $user_id
 * $cardNumber
 * $expirationDate_year
 * $expirationDate_month
 * $cardCode
 * $user_first_name
 * $user_last_name
 * 
 */

error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');
require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';

extract($_POST);

if (!$user_id) {
  return array('code' => 401, 'message' => 'User ID is required.');
}

require_once($_SERVER["DOCUMENT_ROOT"] . "/AuthnetARB.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . 'tools/PHPMailer-master/PHPMailerAutoload.php');

$login = mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='8'"))->settingValue;
$transkey = mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='9'"))->settingValue;
$test = FALSE;

// check for cancellation
$sql = "SELECT * FROM user_management
WHERE user_id = '" . mysql_real_escape_string($user_id) . "'";
$result = mysql_query($sql);
if (mysql_num_rows($result) < 1) {
  $response		= array('message' => 'An unexpected error has occurred.  Please try again later.');
  echo json_encode($response); exit;
}
$currentUser = mysql_fetch_object($result);

// user exists, update the address
if ((int)$currentUser->user_subscriberid > 0) {
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
      $response	= array('code' => 200, 'message' => 'Success.');
		} else {
      $response	= array('code' => 400, 'message' => $arb->getResponse());
		}
	} catch (AuthnetARBException $e) {
    $response	= array('code' => 400, 'message' => $arb->getResponse());
	}
} else {
  $response	= array('code' => 400, 'message' => $arb->getResponse());
}

echo json_encode($response); exit;
