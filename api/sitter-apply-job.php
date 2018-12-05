<?php
  // error_reporting(E_ALL);
  // ini_set("display_errors", 1);

  include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');
	require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';
	
	/**
 * POST
 * 
 * user_id
 * job_code_input
 * job_remarks
 * 
 * */

  extract($_POST);

	$sql = "insert into jobapply_management set job_id='".mysql_real_escape_string($job_code_input)."', sitter_user_id='".mysql_real_escape_string($user_id)."', remarks='".mysql_real_escape_string($job_remarks)."', applytime='".time()."'";
	mysql_query($sql);

	$job_details = mysql_fetch_object(mysql_query("select * from job_management where set_code='".$job_code_input."'"));
	$job_query = mysql_query("select * from `job_management` where set_code='".$job_code_input."'");
	$show_msg='<table class="family-table"><tr><th><span>Appointment Date</span></th><th><span>Time</span></th></tr>';
	
	while($JD = mysql_fetch_object($job_query)) {
		$show_msg.='<tr><td><span>'.trim($JD->booking_date).'</span></td><td><span>'.date("h:i a",mktime($JD->start_time,0,0,0,0,0)).' - '.date("h:i a",mktime($JD->end_time,0,0,0,0,0)).'</span></td></tr>';
	}
  $show_msg.='</table>';
	$family_details = mysql_fetch_object(mysql_query("select * from user_information where user_id='".$job_details->family_user_id."'"));
	require_once($_SERVER["DOCUMENT_ROOT"] . '/tools/PHPMailer-master/PHPMailerAutoload.php');
	$admin_contact_email = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='1'"));
	$admin_contact_name = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='4'"));
	
	$search_current_stat = mysql_fetch_array(mysql_query("select * from user_management where user_id='".$user_id."'"));
	$search_current_stat_family = mysql_fetch_array(mysql_query("select * from user_management where user_id='".$job_details->family_user_id."'"));
	
	$message = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/apply-job.html');
	$message = str_replace('%USERNAME%', $search_current_stat['user_name'], $message);
	$message = str_replace('%JOBID%', $job_code_input, $message);
	$message = str_replace('%NOOFKIDS%', $job_details->no_of_kids, $message);
	$message = str_replace('%REMARKS%', $job_details->remarks, $message);
	$message = str_replace('%SITTERREMARKS%', $job_remarks, $message);
	$message = str_replace('%ZIPCODE%', $job_details->location_code, $message);
	$message = str_replace('%APPDATE%', date('m/d/Y',$job_details->booking_placed_date), $message);
	$message = str_replace('%ACCOUNT_STATUS%', $show_msg, $message);
	$mail = MailUtil::getMailerWhitney();
	$mail->Debugoutput = 'html';

	$mail->addAddress($search_current_stat_family['user_email'], $search_current_stat_family['user_name']);
	$mail->addAddress('oursitterlist@gmail.com', 'Webmaster');
	$mail->addAddress($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);

	$mail->AddBCC("subhodeep@lnsel.net");
	$mail->Subject = 'Application to your Job';
	$mail->msgHTML($message);
	$mail->AltBody = 'This is a plain-text message body';
	
	// if (!$mail->send()) {
  //   $response	= array('code' => 200, 'message' => 'Could not send email: ' . $mail->ErrorInfo);
  //   echo json_encode($response); exit;
	// }

  $response	= array('code' => 200, 'message' => 'Your application has been submitted successfully.');
  echo json_encode($response); exit;