<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php  //echo $_SESSION['user_id'];exit;?>
<?php

require_once 'class.MailUtil.php';
$debug = false;

// authenticate
if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='family')
{
	header('Location:/');
	exit;
}

// get job application instance
$jobsql = "SELECT m.*, j.family_user_id, ums.user_email AS sitter_email, ums.user_name AS sitter_user_name, umf.user_email AS family_email, umf.user_name AS family_user_name
FROM jobapply_management m
JOIN job_management j ON j.set_code = m.job_id
LEFT JOIN user_management ums ON ums.user_id = m.sitter_user_id
LEFT JOIN user_management umf ON umf.user_id = j.family_user_id
WHERE m.jobapply_id = '" . mysql_real_escape_string(base64_decode($_REQUEST['apply_id'])) . "'
LIMIT 1";
$jobresult = mysql_query($jobsql);
if (mysql_num_rows($jobresult) < 1)
{

	setPostMSG('An error occurred fetching the job details.', 'error');
	header('Location:'.$base_path.'/applied_job_list.php');
	exit();
}

$jobdetails = mysql_fetch_object($jobresult);
//print_r($jobdetails);die;

$isConfirmed = false;
if ($_REQUEST['mode']=='confirm')
{
	$isConfirmed = true;

	// set to approved
	mysql_query("update jobapply_management set family_approval='1' where jobapply_id='".base64_decode($_REQUEST['apply_id'])."'");
	mysql_query("update jobapply_management set family_approval='2' where jobapply_id!='".base64_decode($_REQUEST['apply_id'])."' and job_id='".$jobdetails->job_id."'");
	$job_query = mysql_query("select * from `job_management` where set_code='".$jobdetails->job_id."'");

		while($JD = mysql_fetch_object($job_query))
		{

			mysql_query("insert into book_management set sitter_user_id='".$jobdetails->sitter_user_id."',family_user_id='".$JD->family_user_id."',booking_date='".trim($JD->booking_date)."',booking_placed_date='".time()."',booking_status='1',start_time='".$JD->start_time."',end_time='".$JD->end_time."',no_of_kids='".$JD->no_of_kids."',location_code='".$JD->no_of_kids."',remarks='".$JD->remarks."',sitter_approval='1'");

			$booking_id  = mysql_insert_id();
			mysql_query("insert into message_management set book_id='".$booking_id."',send_by='S',message='".$jobdetails->remarks."',send_time='".time()."'");
		}
		$msg = 'Confirm';
}
elseif($_REQUEST['mode']=='cancel')
{
	mysql_query("delete from  jobapply_management where jobapply_id='".base64_decode($_REQUEST['apply_id'])."'");
	$msg = 'Cancel';
}

$job_details = mysql_fetch_object(mysql_query("select * from job_management where set_code='".$jobdetails->job_id."'"));
$job_query = mysql_query("select * from `job_management` where set_code='".$jobdetails->job_id."'");
	$show_msg='<table class="family-table"><tr><th><span>Appointment Date</span></th><th><span>Time</span></th></tr>';

	while($JD = mysql_fetch_object($job_query))
		{
			$show_msg.='<tr><td><span>'.trim($JD->booking_date).'</span></td><td><span>'.date("h:i a",mktime($JD->start_time,0,0,0,0,0)).' - '.date("h:i a",mktime($JD->end_time,0,0,0,0,0)).'</span></td></tr>';
		}
$show_msg.='</table>';


//print_r($job_details);die;
global $admin_contact_email, $admin_contact_name;

	require_once('tools/PHPMailer-master/PHPMailerAutoload.php');
	$admin_contact_email = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='1'"));
	$admin_contact_name = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='4'"));

	// send confirmation to sitter
	sendJobEmail(
		$jobdetails->sitter_email,
		$jobdetails->sitter_user_name,
		'Job Application Confirmation Mode',
		$show_msg,
		$msg,
		$jobdetails,
		'templates/notification/confirm-job-sitter.html',
		$debug
	);


	// send copy to family
	sendJobEmail(
		$jobdetails->family_email,
		$jobdetails->family_user_name,
		'Job Application Confirmation Mode',
		$show_msg,
		$msg,
		$jobdetails,
		'templates/notification/confirm-job-family.html',
		$debug
	);

	// send notificattions for sitters that were not approved
	if ($isConfirmed)
	{
		// get job application instance
		$jobsql = "SELECT m.*, j.family_user_id, ums.user_email AS sitter_email, ums.user_name AS sitter_user_name, umf.user_email AS family_email, umf.user_name AS family_user_name
		FROM jobapply_management m
		JOIN job_management j ON j.set_code = m.job_id
		JOIN user_management ums ON ums.user_id = m.sitter_user_id
		LEFT JOIN user_management umf ON umf.user_id = j.family_user_id
		WHERE m.job_id = '".$jobdetails->job_id."'
		AND m.sitter_user_id != '" . mysql_real_escape_string($jobdetails->sitter_user_id) . "'";

		$jobresult = mysql_query($jobsql);
		if (mysql_num_rows($jobresult) > 0)
		{
			while ($jobdetails = mysql_fetch_object($jobresult))
			{
					// send declined copy to sitters who didn't get the job
					sendJobEmail(
						$jobdetails->sitter_email,
						$jobdetails->sitter_user_name,
						'Job Application',
						$show_msg,
						$msg,
						$jobdetails,
						'templates/notification/confirm-job-sitter-notapproved.html',
						$debug
					);
			}
		}
	}


		//die('AFter sitter check...' . $isConfirmed);

/**
 * function to send an email based on job details
 */
	function sendJobEmail($msgTo, $msgToName, $subject, $show_msg, $confirmMsg, $jobdetails, $template, $debug = false)
	{
		global $admin_contact_email, $admin_contact_name;

		$msg = file_get_contents($template);

		$msg = str_replace('%USERNAME%', $jobdetails->sitter_user_name, $msg);
		$msg = str_replace('%JOBID%', $jobdetails->job_id, $msg);

		$msg = str_replace('%NOOFKIDS%', $jobdetails->no_of_kids, $msg);
		$msg = str_replace('%REMARKS%', urldecode($jobdetails->remarks), $msg);
		$msg = str_replace('%ZIPCODE%', $jobdetails->location_code, $msg);
		//print_r($jobdetails);die('BOOKING DATE...');
		$msg = str_replace('%APPDATE%', date('m/d/Y',$jobdetails->applytime), $msg);
		$msg = str_replace('%ACCOUNT_STATUS%', $show_msg, $msg);
		$msg = str_replace('%CSTATUS%', $confirmMsg, $msg);
		$msg = str_replace('%CONTACTLINKFAMILY%', '<a href="' . HTTPS . '/sitter_details.php?sitter_id=' . base64_encode($jobdetails->sitter_user_id) . '">Click here to view or contact Sitter</a>', $msg);
		$msg = str_replace('%CONTACTLINKSITTER%', '<a href="' . HTTPS . '/family.php?fid=' . $jobdetails->family_user_id . '">Click here to view or contact Family</a>', $msg);
		///sitter_details.php?sitter_id=

		// get mailer
		$mailer = MailUtil::getMailerWhitney();
		$mailer->Debugoutput = 'html';
		$mailer->addAddress($msgTo, $msgToName);
		$mailer->addAddress($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
		$mailer->AddBCC("subhodeep@lnsel.net");
		//$mailFamily->addAddress('sethcriedel@gmail.com', $jobdetails->sitter_user_name);
		$mailer->Subject = $subject;
		//echo $message;

		$mailer->msgHTML($msg);
		$mailer->AltBody = 'This is a plain-text message body';

		if ($debug === true)
		{
			print_r($jobdetails);
			echo 'sendJobEmail: ' . print_r(func_get_args(), true) . $msg . '
			<br /><br /><br />
			';
		}
		else
		{
			$mailer->send();
		}
	}

	if ($debug)
	{
		die('About to redirect....');
	}

	// redirect
	setPostMSG('Your application has been submitted successfully.', 'success');
	header('Location: '.$base_path.'/applied_job_list.php');
	exit;
