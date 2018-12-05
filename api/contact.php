<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

/*
  * POST: (all required, even if empty)
  * 
  * $contact_name
  * $contact_email
  * $contact_as
  * $contact_comment
*/

extract($_POST);

$notification 		= new Notification();

$name	= trim($contact_name);
$email	= trim($contact_email);
$as		= trim($contact_as);
$msg	= trim($contact_comment);

if(!empty($name) || !empty($email) || !empty($as) || !empty($msg))
{
	$details	= array	('name'	=>$name , 'email'	=>$email , 'as'	=>$as , 'msg'	=>$msg );
	$response 	= $notification->send_contact_form_email($details);
	$response	= array('code' => 200, 'message' => $response);
  echo json_encode($response); exit;
}

$response	= array('code' => 400, 'message' => 'Contact form failed to send.');
echo json_encode($response); exit;
