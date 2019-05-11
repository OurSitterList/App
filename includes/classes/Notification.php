<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/tools/PHPMailer-master/PHPMailerAutoload.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';

class Notification {
	public 				$debug			= FALSE;

	private 			$template_path,
						$user_id,
						$sitter_user_id,
						$family_user_id,
						$book_id,
						$job_id,
						$jobapply_id,
						$message_id,
						$sender_email;

	protected			$_debug_var			= array();

	protected static 	$_valid_sender	= array('F', 'S');


	public function __construct() {
		$this->user_id 			= Auth::_get_user_id();
		$this->template_path	= BASEPATH.'templates/notification/';

		$setting 				= new Setting(array('id' => 1));
		$setting_item			= $setting::get_setting_item();
		$this->sender_email		= $setting_item[3];
	}

	public function send_family_notification($data, $job_id)
	{
//		echo 'SEND FAMILY NOTIFICATION: ' . $booking_id;
		//print_r($data);die();
		$sql	= "SELECT
							um.user_name,
							um.user_email,
							bm.job_id,
							bm.family_user_id,
							bm.booking_date,
							FROM_UNIXTIME(
									bm.booking_placed_date,
									'%m/%d/%Y'
							) AS booking_placed_date,
							bm.start_time,
							bm.end_time,
							bm.no_of_kids,
							bm.location_code,
							bm.remarks,
							bm.booking_status,
							ui.user_first_name,
							ui.user_middle_name,
							ui.user_last_name,
							ui.user_current_address
						FROM
							job_management AS bm
						LEFT JOIN user_management AS um ON um.user_id = bm.family_user_id
						LEFT JOIN user_information AS ui ON ui.user_id = um.user_id
						WHERE
							bm.job_id = ".$job_id;

		$results	= mysql_query($sql);
		$num_rows 	= mysql_num_rows($results);

//		echo "NUMROWS: " . $num_rows;die();
//		die;
		if( $num_rows > 0) {
			$account 						= new MyAccount();
			$row 							= mysql_fetch_object($results);

			$this->book_id 					= $row->book_id;
			$nonce							= base64_encode($row->nonce);

			$this->family_user_id 			= $row->family_user_id;
			$family_user_name				= $row->user_name;
			$family_user_complete_name		= "{$row->user_first_name} {$row->user_middle_name} {$row->user_last_name}";
			$family_user_current_address	= $row->user_current_address;
			$family_no_of_kids				= $row->no_of_kids;
			$family_remarks					= $row->remarks;
			$family_location_code			= $row->location_code;
			$family_booking_placed_date		= $row->booking_date . ' from ' . (($row->start_time == '0') ? 12 : $row->start_time) . ':00' . (((int)($row->start_time) > 11) ? 'PM' : 'AM') . ' to ' .
					(($row->end_time == '0') ? 12 : $row->end_time) . ':00' . (((int)($row->end_time) > 11) ? 'PM' : 'AM');

			$sitter 						= $account->get_user_details_by_id($row->sitter_user_id);

			$sitter_user_complete_name		= "{$sitter->user_first_name} {$sitter->user_middle_name} {$sitter->user_last_name}";
			$sitter_user_email				= $sitter->user_email;

			$booking_details				= join('', $details->booking_details);
			$details						= "	<table class=\"family-table\">
														<tr><th><span>Appointment Date</span></th><th><span>Time</span></th></tr>
														{$booking_details}
													</table>";
			$accept_booking_url				= HTTPS."/action.php?do=update_booking_approval&action=1&nonce={$nonce}";


			$message = file_get_contents($this->template_path.'action-posting.html');
			$message = str_replace('%USERNAME%', $family_user_name, $message);
			$message = str_replace('%FAMILYNAME%', $family_user_complete_name, $message);

			$message = str_replace('%ADDRESS%', $family_user_current_address, $message);
			$message = str_replace('%NOOFKIDS%', $family_no_of_kids, $message);
			$message = str_replace('%REMARKS%', urldecode($family_remarks), $message);
			$message = str_replace('%ZIPCODE%', $family_location_code, $message);
			$message = str_replace('%APPDATE%', $family_booking_placed_date . ' ', $message);
			$message = str_replace('%DETAILS%', $details, $message);
			$message = str_replace('%ACCEPT_BOOKING_URL%', $accept_booking_url, $message);

			$sender_email	= $this->sender_email;

			$setting 		= new Setting(array('id' => 4));
			$setting_item	= $setting::get_setting_item();
			$sender_name	= $setting_item[3];

			$subject 		= "{$family_user_complete_name} created a job posting on " . $family_booking_placed_date;

			$mail = MailUtil::getMailer();

			$mail->setFrom('oursitterlist@gmail.com', $sender_name);
//			$mail->setFrom('oursitterlist@gmail.com');
			$mail->addAddress($sitter_user_email, $sitter_user_complete_name);
			$mail->Subject = $subject;
			$mail->msgHTML($message);
			$mail->AltBody = 'This is a plain-text message body';



			//die('ABOUT TO SEND POST EMAIL!');
			if (!$mail->send()) {
				// die('Could not send email. ' . print_r(error_get_last(), true));
				mail('sethcriedel@gmail.com', 'Failed to send email', $mail->Debugoutput, 'From: oursitterlist@gmail.com');
				return 'Email failure to sent.' . $mail->ErrorInfo;
			}
		}
		else {
			return 'Boooking information cannot be found';
		}
	}

	public function send_booking_notification($details = NULL) {
		$details	= (object) $details;
		$book_id	= (int) $details->first_inserted_id;

		if($book_id > 0) {
			$sql	= "SELECT
							um.user_name,
							um.user_email,
							bm.book_id,
							bm.sitter_user_id,
							bm.family_user_id,
							bm.booking_date,
							FROM_UNIXTIME(
									bm.booking_placed_date,
									'%m/%d/%Y'
							) AS booking_placed_date,
							bm.start_time,
							bm.end_time,
							bm.no_of_kids,
							bm.location_code,
							bm.remarks,
							bm.booking_status,
							bm.nonce,
							ui.user_first_name,
							ui.user_middle_name,
							ui.user_last_name,
							ui.user_current_address
						FROM
							book_management AS bm
						LEFT JOIN user_management AS um ON um.user_id = bm.family_user_id
						LEFT JOIN user_information AS ui ON ui.user_id = um.user_id
						WHERE
							bm.book_id = ".$details->first_inserted_id;

			$results	= mysql_query($sql);
			$num_rows 	= mysql_num_rows($results);

			if( $num_rows > 0) {
				$account 						= new MyAccount();
				$row 							= mysql_fetch_object($results);

				$this->book_id 					= $row->book_id;
				$nonce							= base64_encode($row->nonce);

				$this->family_user_id 			= $row->family_user_id;
				$family_user_name				= $row->user_name;
				$family_user_complete_name		= "{$row->user_first_name} {$row->user_middle_name} {$row->user_last_name}";
				$family_user_current_address	= $row->user_current_address;
				$family_no_of_kids				= $row->no_of_kids;
				$family_remarks					= $row->remarks;
				$family_location_code			= $row->location_code;
				$family_booking_placed_date		= $row->booking_placed_date;

				$sitter 						= $account->get_user_details_by_id($row->sitter_user_id);

				$sitter_user_complete_name		= "{$sitter->user_first_name} {$sitter->user_middle_name} {$sitter->user_last_name}";
				$sitter_user_email				= $sitter->user_email;

				$booking_details				= join('', $details->booking_details);
				$details						= "	<table class=\"family-table\">
														<tr><th><span>Appointment Date</span></th><th><span>Time</span></th></tr>
														{$booking_details}
													</table>";
				$accept_booking_url				= HTTPS."/action.php?do=update_booking_approval&action=1&nonce={$nonce}";
				$decline_booking_url			= HTTPS."/action.php?do=update_booking_approval&action=3&nonce={$nonce}";

				$message = file_get_contents($this->template_path.'action-booking.html');
				$message = str_replace('%USERNAME%', $family_user_name, $message);
				$message = str_replace('%FAMILYNAME%', $family_user_complete_name, $message);

				$message = str_replace('%ADDRESS%', $family_user_current_address, $message);
				$message = str_replace('%NOOFKIDS%', $family_no_of_kids, $message);
				$message = str_replace('%REMARKS%', urldecode($family_remarks), $message);
				$message = str_replace('%ZIPCODE%', $family_location_code, $message);
				$message = str_replace('%APPDATE%', $family_booking_placed_date, $message);
				$message = str_replace('%DETAILS%', $details, $message);
				$message = str_replace('%ACCEPT_BOOKING_URL%', $accept_booking_url, $message);
				$message = str_replace('%DECLINE_BOOKING_URL%', $decline_booking_url, $message);

				$sender_email	= $this->sender_email;

				$setting 		= new Setting(array('id' => 4));
				$setting_item	= $setting::get_setting_item();
				$sender_name	= $setting_item[3];

				$subject 		= "{$family_user_complete_name} made a booking request!";

				try
				{
					$mail = MailUtil::getMailer();

					$mail->Debugoutput = 'html';
					$mail->setFrom('oursitterlist@gmail.com', $sender_name);
					$mail->addAddress($sitter_user_email, $sitter_user_complete_name);
					$mail->Subject = $subject;
					$mail->msgHTML($message);
					$mail->AltBody = 'This is a plain-text message body';

					if (!$mail->send()) {
						return 'Email failure to sent.' . $mail->ErrorInfo;
					}
				}
				catch (Exception $terr)
				{
					return $terr;
				}
			}
			else {
				return 'Boooking information cannot be found';
			}
		}
		else {
			return 'Boooking information cannot be found';
		}
	}

	public function send_booking_approval_notification($nonce = NULL) {
		if($nonce != '') {
			$sql	= "SELECT
							um.user_name,
							um.user_email,
							bm.book_id,
							bm.sitter_user_id,
							bm.family_user_id,
							bm.booking_date,
							FROM_UNIXTIME(
									bm.booking_placed_date,
									'%m/%d/%Y'
							) AS booking_placed_date,
							bm.start_time,
							bm.end_time,
							bm.no_of_kids,
							bm.location_code,
							bm.remarks,
							bm.booking_status,
							bm.nonce,
							ui.user_first_name,
							ui.user_middle_name,
							ui.user_last_name,
							ui.user_current_address
						FROM
							book_management AS bm
						LEFT JOIN user_management AS um ON um.user_id = bm.family_user_id
						LEFT JOIN user_information AS ui ON ui.user_id = um.user_id
						WHERE
							bm.nonce = '$nonce'";

			$results	= mysql_query($sql);
			$num_rows 	= mysql_num_rows($results);

			if( $num_rows > 0) {
				$account 						= new MyAccount();
				$row 							= mysql_fetch_object($results);

				$this->book_id 					= $row->book_id;
				$nonce							= $row->nonce;

				$this->family_user_id 			= $row->family_user_id;
				$family_user_email				= $row->user_email;
				$family_user_name				= $row->user_name;
				$family_user_complete_name		= "{$row->user_first_name} {$row->user_middle_name} {$row->user_last_name}";
				$family_user_current_address	= $row->user_current_address;
				$family_no_of_kids				= $row->no_of_kids;
				$family_remarks					= $row->remarks;
				$family_location_code			= $row->location_code;
				$family_booking_placed_date		= $row->booking_placed_date;

				$sitter 						= $account->get_user_details_by_id($row->sitter_user_id);

				$sitter_user_name				= $sitter->user_name;
				$sitter_user_complete_name		= "{$sitter->user_first_name} {$sitter->user_middle_name} {$sitter->user_last_name}";
				$sitter_user_email				= $sitter->user_email;
				$sitter_user_current_address	= $sitter->user_current_address;
				$sitter_user_cell_phone			= $sitter->user_cell_phone;

				$$booking_details				= '';

				$results = mysql_query($sql);
				while($row = mysql_fetch_object($results)) {
					$booking_details .='<tr><td><span>'.trim($row->booking_date).'</span></td><td><span>'.date("h:i a",mktime($row->start_time,0,0,0,0,0)).' - '.date("h:i a",mktime($row->end_time,0,0,0,0,0)).'</span></td></tr>';
				}
				$details						= "	<table class=\"family-table\">
														<tr><th><span>Appointment Date</span></th><th><span>Time</span></th></tr>
														{$booking_details}
													</table>";


				$message = file_get_contents($this->template_path.'confirm-booking.html');
				//sitter
				$message = str_replace('%SITTERUSERNAME%', $sitter_user_name, $message);
				$message = str_replace('%SITTERNAME%', $sitter_user_complete_name, $message);
				$message = str_replace('%SITTERADDRESS%', $sitter_user_current_address, $message);
				$message = str_replace('%SITTERPHONE%', $sitter_user_cell_phone, $message);

				//family
				$message = str_replace('%FAMILYUSERNAME%', $family_user_name, $message);
				$message = str_replace('%FAMILYNAME%', $family_user_complete_name, $message);
				$message = str_replace('%FAMILYADDRESS%', $family_user_current_address, $message);

				$message = str_replace('%NOOFKIDS%', $family_no_of_kids, $message);
				$message = str_replace('%REMARKS%', urldecode($family_remarks), $message);
				$message = str_replace('%ZIPCODE%', $family_location_code, $message);
				$message = str_replace('%APPDATE%', $family_booking_placed_date, $message);
				$message = str_replace('%DETAILS%', $details, $message);

				$sender_email	= $this->sender_email;

				$setting 		= new Setting(array('id' => 4));
				$setting_item	= $setting::get_setting_item();
				$sender_name	= $setting_item[3];

				$subject 		= "{$sitter_user_complete_name} confirmed your booking.";

				$mail = MailUtil::getMailer();

				$mail->Debugoutput = 'html';
				$mail->setFrom('oursitterlist@gmail.com', $sender_name);
				$mail->addAddress($family_user_email, $family_user_complete_name);
				$mail->Subject = $subject;
				$mail->msgHTML($message);
				$mail->AltBody = 'This is a plain-text message body';

				if (!$mail->send()) {
					return 'Email failure to sent.' . $mail->ErrorInfo;
				}
				else {
					return 'Booking successfully confirmed';
				}
			}
			else {
				return 'Boooking information cannot be found';
			}
		}
		else {
			return 'Boooking information cannot be found';
		}
	}

	public function send_booking_pm ($id = 0, $message = NULL, $send_by = NULL) {


		$this->_debug_var['id']			= $id 			= (int) $id;
		$this->_debug_var['send_by']	= $send_by 		= trim($send_by);
		$this->_debug_var['message']	= $msg 			= mysql_real_escape_string(trim($message));

		if(!$id || !$send_by || !$message || !in_array($send_by, self::$_valid_sender)) return false;

		$this->_debug_var['sender']		= $sender		= ($send_by == 'F') ? 'family' : 'sitter';
		$this->_debug_var['recipient']	= $recipient	= ($send_by == 'F') ? 'sitter' : 'family';

		//sender
		$sql	= "
				SELECT
					CONCAT (
						ui.user_middle_name, ' ',
						ui.user_last_name,  ' ',
						ui.user_first_name
					) name,
					um.user_email,
					bm.book_id
				FROM
					book_management AS bm
				LEFT JOIN user_management AS um ON um.user_id = bm.{$sender}_user_id
				LEFT JOIN user_information AS ui ON um.user_id = ui.user_id
				WHERE
					bm.book_id = $id
				";
		$this->_debug_var['sender_sql']	= $sql;
		$results	= mysql_query($sql);
		$num_rows 	= mysql_num_rows($results);

		if( $num_rows > 0) {
			$row								= mysql_fetch_object($results);
			$this->_debug_var['sender_name']	= $sender_name	= $row->name;
		}

		//recipient
		$sql	= "
				SELECT
					CONCAT (
						ui.user_middle_name, ' ',
						ui.user_last_name,  ' ',
						ui.user_first_name
					) name,
					um.user_email,
					bm.book_id
				FROM
					book_management AS bm
				LEFT JOIN user_management AS um ON um.user_id = bm.{$recipient}_user_id
				LEFT JOIN user_information AS ui ON um.user_id = ui.user_id
				WHERE
					bm.book_id = $id
				";

		$this->_debug_var['recipient_sql']	= $sql;
		$results	= mysql_query($sql);
		$num_rows 	= mysql_num_rows($results);

		if( $num_rows > 0) {
			$row									= mysql_fetch_object($results);
			$this->_debug_var['recipient_name']		= $recipient_name		= $row->name;
			$this->_debug_var['recipient_email']	= $recipient_email		= $row->user_email;
		}

		$this->_debug_var['subject'] =
		$subject	= $sender_name.' sent you a message.';

		if($this->debug) {
			$this->test();
		}

		mysql_query("INSERT INTO message_management SET book_id='".$id."', send_by='".$send_by."', message='".$message."', send_time='".time()."'");

		$sender_email	= $this->sender_email;

		$text_message	= $msg;

		if(filter_var($sender_email, FILTER_VALIDATE_EMAIL) && filter_var($recipient_email, FILTER_VALIDATE_EMAIL)) {
			$message = file_get_contents($this->template_path.'messages.html');
			$message = str_replace('%FROM%', $sender_name, $message);
			$message = str_replace('%JOB_CODE%', 'Direct Booking - #'.$id, $message);
			$message = str_replace('%MESSAGE%', $msg, $message);

			$mail = MailUtil::getMailer();
			$mail->Debugoutput = 'html';
			$mail->setFrom('oursitterlist@gmail.com', $sender_name);
			$mail->addAddress($recipient_email, $recipient_name);
			$mail->Subject = $sender_name.' sent you a message.';
			$mail->msgHTML($message);
			$mail->AltBody = 'This is a plain-text message body';

			if (!$mail->send()) {
				return "1|{$sender_name}: Sorry email failure to sent. {$mail->ErrorInfo}";
			}
			else {
				return "1|{$sender_name}";
			}
		}
		else {
			return "1|{$sender_name}: Sorry email failure to sent. Invalid recipient/sender email address.";
		}
	}

	public function send_contact_form_email($details = NULL) {
		extract($details);

		$sender_email	= $this->sender_email;

		$setting 		= new Setting(array('id' => 5));
		$setting_item	= $setting::get_setting_item();
		$this->_debug_var['recipient_email'] =
		$recipient_email= $setting_item[3];
		$recipient_name= 'OurSitterListnNashville.com Administrator';


		if(filter_var($sender_email, FILTER_VALIDATE_EMAIL) && filter_var($recipient_email, FILTER_VALIDATE_EMAIL)) {
			$message = file_get_contents($this->template_path.'contact-form.html');
			$message = str_replace('%FULL_NAME%', $name, $message);
			$message = str_replace('%EMAIL%', $email, $message);
			$message = str_replace('%AS%', $as, $message);
			$message = str_replace('%COMMENT%',$msg, $message);

			$mail = MailUtil::getMailer();
			$mail->Debugoutput = 'html';
			$mail->setFrom('oursitterlist@gmail.com', $name);
			$mail->addAddress($recipient_email, $recipient_name);
			$mail->Subject = $name.' inquiry - Contact Us Form.';
			$mail->msgHTML($message);
			$mail->AltBody = 'This is a plain-text message body';

			if (!$mail->send()) {
				return "Email failure to sent. {$mail->ErrorInfo}";
			}
			else {
				return "Email successfully sent";
			}
		}
		else {
			return "Email failure to sent. Invalid recipient/sender email address";
		}
	}

	public function send_application_details1($details = NULL) {

		$user_type 				= $details['user_type'];
		$user_first_name 		= $details['user_first_name'];
		$user_last_name 		= $details['user_last_name'];
		$name					= $user_first_name." ".$user_last_name;
		$location_code 			= $details['location_code'];
		$user_current_address 	= $details['user_current_address'];
		$user_email 			= $details['user_email'];
		$user_cell_phone 		= $details['user_cell_phone'];
		$user_first_name 		= $details['user_first_name'];
		$user_hear_about 		= $details['user_hear_about'];
		$txt 					=  '';
		$date					= date("M d, Y", $details['join_date']);

		switch($user_type) {
			case 'family':
				$message = file_get_contents($this->template_path.'family-application.html');
				$message = str_replace('%FULL_NAME%', $name, $message);
				$message = str_replace('%CURRENT_ZIP%', $location_code, $message);
				$message = str_replace('%CURRENT_ADDRESS%', $user_current_address, $message);
				$message = str_replace('%EMAIL_ADDRESS%', $user_email, $message);
				$message = str_replace('%PHONE_NUMBER%', $user_cell_phone, $message);
				$message = str_replace('%NEEDS%', $user_current_address, $message);
				$message = str_replace('%HEAR_ABOUT_US%', $user_hear_about, $message);
				$message = str_replace('%DATE%', $date, $message);
			break;

			case 'sitter':
				$message = file_get_contents($this->template_path.'sitter-application.html');
				$message = str_replace('%FULL_NAME%', $user_first_name." ".$user_last_name, $message);
				$message = str_replace('%DRIVER_LICENSE%', $user_driver_license, $message);
				$message = str_replace('%FIRST_AID%', $user_firstaid_training, $message);
				$message = str_replace('%DATE_OF_CERTIFICATION_FIRST_AID%', $user_date_of_certification, $message);
				$message = str_replace('%TO_BE_CERTIFIED_FIRST_AID%', $is_user_willing_to_certified, $message);
				$message = str_replace('%CPR_TRAINING%', $user_cpr_training, $message);
				$message = str_replace('%DATE_OF_CERTIFICATION_CPR_TRAINING%', $user_date_of_certification_cpr, $message);
				$message = str_replace('%TO_BE_CERTIFIED_CPR_TRAINING%', $is_user_willing_to_certified_cpr, $message);
				$message = str_replace('%SELF_DESCRIPTION%', $user_description, $message);
				$message = str_replace('%CELL_PHONE_NUMBER%', $user_cell_phone, $message);
				$message = str_replace('%EMAIL_ADDRESS%', $user_email, $message);
				$message = str_replace('%EMERGENCY_PHONE_NUMBER%', $user_emergency_contact, $message);
				$message = str_replace('%HIGH_SCHOOL%', $user_high_school, $message);
				$message = str_replace('%HIGH_SCHOOL_NAME%', $user_high_school_name, $message);
				$message = str_replace('%COLLEGE%', $user_college, $message);
				$message = str_replace('%COLLEGE_NAME%', $user_college_name, $message);
				$message = str_replace('%FIRST_REFERENCE_NAME_PHONE%', $user_ref1_name, $message);
				$message = str_replace('%FIRST_REFERENCE_ROLE%', $user_ref1_role, $message);
				$message = str_replace('%FIRST_AGE_OF_CHILDREN%', $user_ref1_age, $message);
				$message = str_replace('%FIRST_LENGTH_OF_EMPLOYMENT%', $user_ref1_length, $message);
				$message = str_replace('%SECOND_REFERENCE_NAME_PHONE%', $user_ref2_name, $message);
				$message = str_replace('%SECOND_REFERENCE_ROLE%', $user_ref2_role, $message);
				$message = str_replace('%SECOND_AGE_OF_CHILDREN%', $user_ref2_age, $message);
				$message = str_replace('%SECOND_LENGTH_OF_EMPLOYMENT%', $user_ref2_length, $message);
				$message = str_replace('%EXTRA_REFERENCE_DETAILS%', $user_biography, $message);
				$message = str_replace('%SPECIAL_NEEDS_REFERENCE_DETAILS%', $user_newborn_exp, $message);
				$message = str_replace('%SIGNATURE_APPLICANT%', '', $message);
				$message = str_replace('%DATE_APPLICANT%', date("M d, Y",$today), $message);
				$message = str_replace('%SIGNATURE_PARENT%', '', $message);
				$message = str_replace('%DATE_PARENT%', date("M d, Y",$today), $message);
				$message = str_replace('%verify_area%', 'Proceed to Background Checking <a href="https://true-hire.com/oursitterlist/">Click Here</a>', $message);
			break;

			default:
				$result->success	= false;
				$result->reason		= 'Invalid user type';
				return false;
		}

		//send copy to applicant
		$recipient_email	= $details['user_email'];
		$recipient_name		= $name;

		$setting 		= new Setting(array('id' => 4));
		$setting_item	= $setting::get_setting_item();
		$sender_name	= $setting_item[3];

		if(filter_var($this->sender_email, FILTER_VALIDATE_EMAIL) && filter_var($recipient_email, FILTER_VALIDATE_EMAIL)) {

			$message = str_replace('%ADDITONAL_MESSAGE%', 'We are working hard in processing your application and will respond within 36 hours.', $message);

			$mail = MailUtil::getMailer();
			$mail->Debugoutput = 'html';
			$mail->setFrom('oursitterlist@gmail.com', $sender_name);
			$mail->addAddress($recipient_email, $recipient_name);
			$mail->Subject = "{$recipient_name} {$user_type} registration form.";
			$mail->msgHTML($message);
			$mail->AltBody = 'This is a plain-text message body';

			if (!$mail->send()) {
				$txt =  "<p>Email failure to sent. {$mail->ErrorInfo}</p>";
			}
			else {
				$txt =  "<p>Email successfully sent to your registered email address.</p>";
			}
		}
		else {
			$txt =  "<p>Email failure to sent. Invalid recipient/sender email address</p>";
		}

		//send copy to website administrator

		$setting 		= new Setting(array('id' => 5));
		$setting_item	= $setting::get_setting_item();
		$this->_debug_var['recipient_email'] =
		$recipient_email= $setting_item[3];
		$recipient_name	= 'OurSitterListNashville.com Administrator';

		$sender_name	= $name;


		if(filter_var($this->sender_email, FILTER_VALIDATE_EMAIL) && filter_var($recipient_email, FILTER_VALIDATE_EMAIL)) {

			$message = str_replace('We are working hard in processing your application and will respond within 36 hours.', '', $message);

			$mail = MailUtil::getMailer();
			$mail->Debugoutput = 'html';
			$mail->setFrom('oursitterlist@gmail.com', $sender_name);
			$mail->addAddress($recipient_email, $recipient_name);
			$mail->Subject = "{$sender_name} {$user_type} registration form.";
			$mail->msgHTML($message);
			$mail->AltBody = 'This is a plain-text message body';

			if (!$mail->send()) {
				$txt =  "<p>Email failure to sent. {$mail->ErrorInfo}</p>";
			}
			else {
				$txt .=  "<p>Email successfully sent to OurSitterListNashville Administrator</p>";
			}
		}
		else {
			$txt =  "<p>Email failure to sent. Invalid recipient/sender email address</p>";
		}

		return $txt;
	}

	public function send_application_details($details = NULL) {
		extract($details);
		$name					= $user_first_name." ".$user_last_name;
		$date					= date("M d, Y", $details['join_date']);
		$txt 					=  '';

		switch($user_type) {
			case 'family':
				$message = file_get_contents($this->template_path.'family-application.html');
				$message = str_replace('%FULL_NAME%', $name, $message);
				$message = str_replace('%CURRENT_ZIP%', $location_code, $message);
				$message = str_replace('%CURRENT_ADDRESS%', $user_current_address, $message);
				$message = str_replace('%EMAIL_ADDRESS%', $user_email, $message);
				$message = str_replace('%PHONE_NUMBER%', $user_cell_phone, $message);
				$message = str_replace('%NEEDS%', $user_family_needs, $message);
				$message = str_replace('%HEAR_ABOUT_US%', $user_hear_about, $message);
				$message = str_replace('%DATE%', $date, $message);
			break;

			case 'sitter':
				$message = file_get_contents($this->template_path.'sitter-application.html');
				$message = str_replace('%FULL_NAME%', $user_first_name." ".$user_last_name, $message);
				$message = str_replace('%DRIVER_LICENSE%', $user_driver_license, $message);
				$message = str_replace('%FIRST_AID%', $user_firstaid_training, $message);
				$message = str_replace('%DATE_OF_CERTIFICATION_FIRST_AID%', $user_date_of_certification, $message);
				$message = str_replace('%TO_BE_CERTIFIED_FIRST_AID%', $is_user_willing_to_certified, $message);
				$message = str_replace('%CPR_TRAINING%', $user_cpr_training, $message);
				$message = str_replace('%DATE_OF_CERTIFICATION_CPR_TRAINING%', $user_date_of_certification_cpr, $message);
				$message = str_replace('%TO_BE_CERTIFIED_CPR_TRAINING%', $is_user_willing_to_certified_cpr, $message);
				$message = str_replace('%SELF_DESCRIPTION%', $user_description, $message);
				$message = str_replace('%CELL_PHONE_NUMBER%', $user_cell_phone, $message);
				$message = str_replace('%EMAIL_ADDRESS%', $user_email, $message);
				$message = str_replace('%EMERGENCY_PHONE_NUMBER%', $user_emergency_contact, $message);
				$message = str_replace('%HIGH_SCHOOL%', $user_high_school, $message);
				$message = str_replace('%HIGH_SCHOOL_NAME%', $user_high_school_name, $message);
				$message = str_replace('%COLLEGE%', $user_college, $message);
				$message = str_replace('%COLLEGE_NAME%', $user_college_name, $message);
				$message = str_replace('%FIRST_REFERENCE_NAME_PHONE%', $user_ref1_name, $message);
				$message = str_replace('%FIRST_REFERENCE_ROLE%', $user_ref1_role, $message);
				$message = str_replace('%FIRST_AGE_OF_CHILDREN%', $user_ref1_age, $message);
				$message = str_replace('%FIRST_LENGTH_OF_EMPLOYMENT%', $user_ref1_length, $message);
				$message = str_replace('%SECOND_REFERENCE_NAME_PHONE%', $user_ref2_name, $message);
				$message = str_replace('%SECOND_REFERENCE_ROLE%', $user_ref2_role, $message);
				$message = str_replace('%SECOND_AGE_OF_CHILDREN%', $user_ref2_age, $message);
				$message = str_replace('%SECOND_LENGTH_OF_EMPLOYMENT%', $user_ref2_length, $message);
				$message = str_replace('%EXTRA_REFERENCE_DETAILS%', $user_biography, $message);
				$message = str_replace('%SPECIAL_NEEDS_REFERENCE_DETAILS%', $user_newborn_exp, $message);
				$message = str_replace('%SIGNATURE_APPLICANT%', '', $message);
				$message = str_replace('%DATE_APPLICANT%', $date, $message);
				$message = str_replace('%SIGNATURE_PARENT%', '', $message);
				$message = str_replace('%DATE_PARENT%', $date, $message);
				$message = str_replace('%verify_area%', 'Proceed to Background Checking <a href="https://true-hire.com/oursitterlist/">Click Here</a>', $message);
			break;

			default:
				$result->success	= false;
				$result->reason		= 'Invalid user type';
				return false;
		}

		//send copy to applicant
		$recipient_email	= $details['user_email'];
		$recipient_name		= $name;

		$setting 		= new Setting(array('id' => 4));
		$setting_item	= $setting::get_setting_item();
		$sender_name	= $setting_item[3];

		if(filter_var($this->sender_email, FILTER_VALIDATE_EMAIL) && filter_var($recipient_email, FILTER_VALIDATE_EMAIL)) {

			$message = str_replace('%ADDITONAL_MESSAGE%', 'We are working hard in processing your application and will respond within 36 hours.', $message);

			$mail = MailUtil::getMailer();
			$mail->Debugoutput = 'html';
			$mail->setFrom('oursitterlist@gmail.com', $sender_name);
			$mail->addAddress($recipient_email, $recipient_name);
			$mail->Subject = "{$recipient_name} {$user_type} registration form.";
			$mail->msgHTML($message);
			$mail->AltBody = 'This is a plain-text message body';

			if (!$mail->send()) {
				$txt =  "<p>Email failure to sent. {$mail->ErrorInfo}</p>";
			}
			else {
				$txt =  "<p>Email successfully sent to your registered email address.</p>";
			}
		}
		else {
			$txt =  "<p>Email failure to sent. Invalid recipient/sender email address</p>";
		}

		//send copy to website administrator

		$setting 		= new Setting(array('id' => 5));
		$setting_item	= $setting::get_setting_item();
		$this->_debug_var['recipient_email'] =
		$recipient_email= $setting_item[3];
		$recipient_name	= 'OurSitterListNashville.com Administrator';

		$sender_name	= $name;


		if(filter_var($this->sender_email, FILTER_VALIDATE_EMAIL) && filter_var($recipient_email, FILTER_VALIDATE_EMAIL)) {

			$message = str_replace('We are working hard in processing your application and will respond within 36 hours.', '', $message);

			$mail = MailUtil::getMailer();
			$mail->Debugoutput = 'html';
			$mail->setFrom('oursitterlist@gmail.com', $sender_name);
			$mail->addAddress($recipient_email, $recipient_name);
			$mail->Subject = "{$sender_name} {$user_type} registration form.";
			$mail->msgHTML($message);
			$mail->AltBody = 'This is a plain-text message body';

			if (!$mail->send()) {
				$txt =  "<p>Email failure to sent. {$mail->ErrorInfo}</p>";
			}
			else {
				$txt .=  "<p>Email successfully sent to OurSitterListNashville Administrator</p>";
			}
		}
		else {
			$txt =  "<p>Email failure to sent. Invalid recipient/sender email address</p>";
		}

		return $txt;
	}
}
?>
