<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php  //echo $_SESSION['user_id'];exit;?>
<?php

require_once 'class.MailUtil.php';


if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='sitter')
{
	mail('sethcriedel@gmail.com', 'APPLY JOB INVALID USER', 'Someone applied to a job, but no user id specified. ' . print_r($_REQUEST, true), 'From: oursitterlist@gmail.com');
	header('Location:/');
	exit;
}
		


	$sql = "insert into jobapply_management set job_id='".$_REQUEST['job_code_input']."', sitter_user_id='".$_SESSION['user_id']."', remarks='".addslashes($_REQUEST['job_remarks'])."', applytime='".time()."'";
	mysql_query($sql);
	$err = mysql_error();

	if ($err)
	{
		mail('sethcriedel@gmail.com', 'APPLY JOB MySQL Error', 'Someone applied to a job, but a MySQL error occurred:' . $err . "\n\nSQL: \n" . $sql, 'From: oursitterlist@gmail.com');
	}
	$job_details = mysql_fetch_object(mysql_query("select * from job_management where set_code='".$_REQUEST['job_code_input']."'"));
	$job_query = mysql_query("select * from `job_management` where set_code='".$_REQUEST['job_code_input']."'");
	$show_msg='<table class="family-table"><tr><th><span>Appointment Date</span></th><th><span>Time</span></th></tr>';
	
	while($JD = mysql_fetch_object($job_query))
		{
		
			
			$show_msg.='<tr><td><span>'.trim($JD->booking_date).'</span></td><td><span>'.date("h:i a",mktime($JD->start_time,0,0,0,0,0)).' - '.date("h:i a",mktime($JD->end_time,0,0,0,0,0)).'</span></td></tr>';
			
		}
		$show_msg.='</table>';
	$family_details = mysql_fetch_object(mysql_query("select * from user_information where user_id='".$job_details->family_user_id."'"));
	require_once('tools/PHPMailer-master/PHPMailerAutoload.php');
	$admin_contact_email = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='1'"));
	$admin_contact_name = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='4'"));
	
	$search_current_stat = mysql_fetch_array(mysql_query("select * from user_management where user_id='".$_SESSION['user_id']."'"));
	$search_current_stat_family = mysql_fetch_array(mysql_query("select * from user_management where user_id='".$job_details->family_user_id."'"));
	
	$message = file_get_contents('apply-job.html');
	$message = str_replace('%USERNAME%', $search_current_stat['user_name'], $message);
	$message = str_replace('%JOBID%', $_REQUEST['job_code_input'], $message);

	$message = str_replace('%NOOFKIDS%', $job_details->no_of_kids, $message);
	$message = str_replace('%REMARKS%', $job_details->remarks, $message);
	$message = str_replace('%SITTERREMARKS%', $_REQUEST['job_remarks'], $message);
	$message = str_replace('%ZIPCODE%', $job_details->location_code, $message);
	$message = str_replace('%APPDATE%', date('m/d/Y',$job_details->booking_placed_date), $message);
	$message = str_replace('%ACCOUNT_STATUS%', $show_msg, $message);
//echo $search_current_stat['user_email'];
	$mail = MailUtil::getMailerWhitney();
	$mail->Debugoutput = 'html';
//	$mail->setFrom($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);

	$mail->addAddress($search_current_stat_family['user_email'], $search_current_stat_family['user_name']);
	$mail->addAddress('oursitterlist@gmail.com', 'Webmaster');
	$mail->addAddress($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
//	$mail->addAddress('sethcriedel@gmail.com', 'Seth Riedel');


	$mail->AddBCC("subhodeep@lnsel.net");
	$mail->Subject = 'Application to your Job';
	//echo $message;
	$mail->msgHTML($message);
	$mail->AltBody = 'This is a plain-text message body';
	
	//Attach an image file
	//$mail->addAttachment('images/phpmailer_mini.png');
	if (!$mail->send()) {
//		die('Could not send email: ' . $mail->ErrorInfo);
	}



	
setPostMSG('Your application has been submitted successfully.', 'success');
header('Location:'.$base_path.'/applied_job_list.php');
?>


<?php include('includes/footer.php');?>