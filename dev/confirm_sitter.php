<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php  //echo $_SESSION['user_id'];exit;?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='family')
			{

			header('Location:/');

			}

if($_REQUEST['mode']=='confirm')
{
	mysql_query("update jobapply_management set family_approval='1' where jobapply_id='".base64_decode($_REQUEST['apply_id'])."'");
	$get_job_id = mysql_fetch_object(mysql_query("select * from jobapply_management where jobapply_id='".base64_decode($_REQUEST['apply_id'])."'"));
	mysql_query("update jobapply_management set family_approval='2' where jobapply_id!='".base64_decode($_REQUEST['apply_id'])."' and job_id='".$get_job_id->job_id."'");
	$job_query = mysql_query("select * from `job_management` where set_code='".$get_job_id->job_id."'");

		while($JD = mysql_fetch_object($job_query))
		{

			mysql_query("insert into book_management set sitter_user_id='".$get_job_id->sitter_user_id."',family_user_id='".$JD->family_user_id."',booking_date='".trim($JD->booking_date)."',booking_placed_date='".time()."',booking_status='1',start_time='".$JD->start_time."',end_time='".$JD->end_time."',no_of_kids='".$JD->no_of_kids."',location_code='".$JD->no_of_kids."',remarks='".$JD->remarks."',sitter_approval='1'");

			$booking_id  = mysql_insert_id();
			mysql_query("insert into message_management set book_id='".$booking_id."',send_by='S',message='".$get_job_id->remarks."',send_time='".time()."'");
		}
		$msg = 'Confirm';
}
elseif($_REQUEST['mode']=='cancel')
{
	$get_job_id = mysql_fetch_object(mysql_query("select * from jobapply_management where jobapply_id='".base64_decode($_REQUEST['apply_id'])."'"));
	mysql_query("delete from  jobapply_management where jobapply_id='".base64_decode($_REQUEST['apply_id'])."'");
	$msg = 'Cancel';
}

$job_details = mysql_fetch_object(mysql_query("select * from job_management where set_code='".$get_job_id->job_id."'"));
$job_query = mysql_query("select * from `job_management` where set_code='".$get_job_id->job_id."'");
	$show_msg='<table class="family-table"><tr><th><span>Appointment Date</span></th><th><span>Time</span></th></tr>';

	while($JD = mysql_fetch_object($job_query))
		{


			$show_msg.='<tr><td><span>'.trim($JD->booking_date).'</span></td><td><span>'.date("h:i a",mktime($JD->start_time,0,0,0,0,0)).' - '.date("h:i a",mktime($JD->end_time,0,0,0,0,0)).'</span></td></tr>';

		}
$show_msg.='</table>';

	require('tools/PHPMailer-master/PHPMailerAutoload.php');
	$admin_contact_email = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='1'"));
	$admin_contact_name = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='4'"));

	$search_current_stat = mysql_fetch_array(mysql_query("select * from user_management where user_id='".$get_job_id->sitter_user_id."'"));
	$message = file_get_contents('confirm-job.html');
	$message = str_replace('%USERNAME%', $search_current_stat['user_name'], $message);
	$message = str_replace('%JOBID%', $get_job_id->job_id, $message);

	$message = str_replace('%NOOFKIDS%', $job_details->no_of_kids, $message);
	$message = str_replace('%REMARKS%', urldecode($job_details->remarks), $message);
	$message = str_replace('%ZIPCODE%', $job_details->location_code, $message);
	$message = str_replace('%APPDATE%', date('m/d/Y',$job_details->booking_placed_date), $message);
	$message = str_replace('%ACCOUNT_STATUS%', $show_msg, $message);
	 $message = str_replace('%CSTATUS%', $msg, $message);
//echo $search_current_stat['user_email'];
	$mail = new PHPMailer;
	$mail->Debugoutput = 'html';
	$mail->setFrom($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
	//echo $search_current_stat['user_email'].$search_current_stat['user_name'];
	$mail->addAddress($search_current_stat['user_email'], $search_current_stat['user_name']);
	$mail->addAddress($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
	$mail->AddBCC("subhodeep@lnsel.net");
	$mail->Subject = 'Job Application Confirmation Mode';
	//echo $message;
	$mail->msgHTML($message);
	$mail->AltBody = 'This is a plain-text message body';

	//Attach an image file
	//$mail->addAttachment('images/phpmailer_mini.png');
	if (!$mail->send()) {

	}


//exit;

header('Location:'.$base_path.'/applied_job_list.php');
?>


<?php include('includes/footer.php');?>