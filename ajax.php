<?php include('includes/connection.php');?>
<?php

require_once 'class.MailUtil.php';

class ratings {
	
	private $booking_id;
	private $review_message;
	private $sitter_user_id;
	private $family_user_id;
	private $review_date;
	private $review_status;
	private $score;
	
	
	function __construct() {
		$this->booking_id 			= $_REQUEST['booking_id'];
		$this->sitter_user_id 		= $_REQUEST['sitter_user_id'];
		$this->family_user_id 		= $_REQUEST['family_user_id'];
		$this->review_date 			= date('Y-m-d h:i:s');
		$this->review_status 		= $_REQUEST['review_status'];
		$this->review_message 		= $_REQUEST['review_message'];

		$clicked_on					= $_REQUEST['clicked_on'];
		preg_match('/star_([1-5]{1})/', $clicked_on , $match);		
		$vote 						= $match[1];
		$this->score				= (int) $vote;
	}
	
	public function get_ratings() {
		$data		= array();
		$book_id 	= (int) $this->booking_id;
		$sql		= "SELECT * FROM review_management rm 
						LEFT JOIN job_management jm ON rm.book_id = jm.job_id
						LEFT JOIN user_management um ON jm.family_user_id =  um.user_id
						WHERE book_id='".$this->booking_id."'";		
								
		$booking	= mysql_query($sql);
		
		if(mysql_num_rows($booking) > 0) {
			while($booking = mysql_fetch_object($booking)) {
				$data[]['review_message'] 		= $booking->review_message;
				$data[]['sitter_user_id'] 		= $booking->sitter_user_id;
				$data[]['family_user_id'] 		= $booking->family_user_id;
				$data[]['review_date'] 			= $booking->review_date;
				$data[]['review_status'] 		= $booking->review_status;
			}
			
			return json_encode($data);
		}
		else {
			return false;
		}
	}
	
	public function vote() {
	
		$book_id 			= (int) $this->booking_id;
		$review_message 	= mysql_escape_string($this->review_message);
		$sitter_user_id		= (int) $this->sitter_user_id;
		$family_user_id		= (int) $this->family_user_id;
		$review_date		= $this->review_date;
		$review_status		= 1;
		$score				= $this->score;
		
		if($this->get_ratings()) {
			$return = "You already rubmitted rating and comment to this posting.";
		}
		elseif($this->get_ratings() == false && $book_id && $sitter_user_id && $family_user_id && $score && $review_message != "") {
			$sql	= "INSERT 
						INTO review_management (	book_id, 	review_message, 	sitter_user_id, 	family_user_id, 	review_date, 	review_status, 		score)
						VALUES (					'$book_id', '$review_message', 	'$sitter_user_id', 	'$family_user_id', 	'$review_date', '$review_status', 	'$score')
						";
			mysql_query($sql);
			
			$return = "Your rating and comment successfully submitted.";
		}
		else {
			$return = "Rating and comment cannot be empty";
		}
		
		return $return;
	}
}
?>
<?php
if(isset($_POST)) {
	extract($_POST);
}
if(isset($_GET)) {
	extract($_GET);	
}

switch($mode)
{
	case 'appointment_approval':
		if($stat==1)
		{
			
		 mysql_query("update book_management set sitter_approval='1' where book_id='".$id."'");
			$msg = 'Confirmed';
			$for_sub = 'Booking Request Confirmed';
		}
		if($stat==0)
		{
			
			mysql_query("update book_management set sitter_approval='2' where book_id='".$id."'");
			$msg = 'Cancelled';
			$for_sub = 'Booking Request Cancelled';
		}
		
	$B_details = mysql_fetch_object(mysql_query("select * from book_management where book_id='".$id."'"));
	
	$family_details = mysql_fetch_object(mysql_query("select * from user_information where user_id='".$B_details->family_user_id."'"));
	$family_details_email = mysql_fetch_object(mysql_query("select * from user_management where user_id='".$B_details->family_user_id."'"));


	$admin_contact_email = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='1'"));
	$admin_contact_name = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='4'"));
	$search_current_stat = mysql_fetch_array(mysql_query("select * from user_management where user_id='".$B_details->sitter_user_id."'"));
	
	$message = file_get_contents('cancel-booking.html');
	$message = str_replace('%USERNAME%', $search_current_stat['user_name'], $message);
	$message = str_replace('%FAMILYNAME%', $family_details->user_first_name.' '.$family_details->user_middle_name.' '.$family_details->user_last_name, $message);
	
	$message = str_replace('%ADDRESS%', $family_details->user_current_address, $message);
	$message = str_replace('%NOOFKIDS%', $B_details->no_of_kids, $message);
	$message = str_replace('%REMARKS%', $B_details->remarks, $message);
	$message = str_replace('%ZIPCODE%', $B_details->location_code, $message);
	$message = str_replace('%APPDATE%', $B_details->booking_date.' - '.date("h:i a",mktime($B_details->start_time,0,0,0,0,0)).' - '.date("h:i a",mktime($B_details->end_time,0,0,0,0,0)), $message);
	
	$message = str_replace('%ACCOUNT_STATUS%', $msg, $message);
//echo $search_current_stat['user_email'];
	$mail = MailUtil::getMailerWhitney();
	$mail->Debugoutput = 'html';
//	$mail->setFrom($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
	$mail->addAddress($family_details_email->user_email,$family_details_email->user_name);
	$mail->addAddress($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
	//$mail->AddBCC("subhodeep@lnsel.net");
	$mail->AddBCC("sethcriedel@gmail.com");
	$mail->Subject = $for_sub;
	//echo $message;
	$mail->msgHTML($message);
	$mail->AltBody = 'This is a plain-text message body';
	
	//Attach an image file
	//$mail->addAttachment('images/phpmailer_mini.png');
	if (!$mail->send()) {
		
	}	
	echo $msg ;	
		
	break;
	case 'get_message':
	$get_booking_info = mysql_fetch_object(mysql_query("select * from book_management where book_id='".$id."'"));
	$sitter_user_name = mysql_fetch_object(mysql_query("select * from user_information where user_id='".$get_booking_info->sitter_user_id."'"));
	$sittername= $sitter_user_name->user_first_name.' '.$sitter_user_name->user_middle_name.' '.$sitter_user_name->user_last_name;
	$family_user_name = mysql_fetch_object(mysql_query("select * from user_information where user_id='".$get_booking_info->family_user_id."'"));
	$familyname= $family_user_name->user_first_name.' '.$family_user_name->user_middle_name.' '.$family_user_name->user_last_name;
	$select_msg = mysql_query("select * from message_management where book_id='".$id."' order by send_time");
	if($enquired_by=='S')
			{
				mysql_query("update message_management set is_view='1' where  book_id='".$id."' and send_by='F'");
			}
			else
			{
				mysql_query("update message_management set is_view='1' where  book_id='".$id."' and send_by='S'");
			}
	if(mysql_num_rows($select_msg)>0)
	{
		while($M = mysql_fetch_object($select_msg))
		{
			
			
			if($M->send_by=='S')
			{
				
			$msg.='<li class="sitter_msg"><span>'.$sittername.' : </span>'.$M->message.'</li>';
			}
			else
			{
			$msg.='<li class="family_msg"><span>'.$familyname.' : </span>'.$M->message.'</li>';
			}
		}
	}
	else
	{
		$msg.='<li>No message Yet</li>';
	}
	echo $msg;
	break;
	
	case 'send_message':
		$notification	= new Notification();
		$response		= $notification->send_booking_pm($id, $msg, $send_by);
		
		echo $response;
	break;
	case 'get_bookibg_info':
	
	$search_date = mysql_query("select * from book_management where booking_date='".$cal_date."' and sitter_user_id='".$_SESSION['user_id']."'  and booking_status='1'");
	
	if(mysql_num_rows($search_date)>0)
				 {
					 $msg = '<ul>';
					 while($S = mysql_fetch_object($search_date))
					 {
				if($S->book_id==$cal_id)
				{
					$active_class = 'active';
				}
				else
				{
					$active_class = '';
				}
				if( strtotime($S->booking_date) < strtotime('now') ) {
							$status = 'Expired';
							$title = 'Expired Booking';
						}
						else
						{
							if($S->sitter_approval==0)
							{
							$status = 'Not Confirmed';	
					
							}
							elseif($S->sitter_approval==2)
							{
							$status = 'Cancelled';	
						
							}
							else
							{
								$status = 'Confirmed';	
			
							}
							
							
							}
					$already_notify_booking = mysql_query("select * from book_management as BM  JOIN message_management as MM where BM.book_id = MM.book_id and BM.sitter_user_id='".$_SESSION['user_id']."' and BM.booking_status='1' and BM.book_id='".$S->book_id."' and MM.send_by='F' and is_view='0'");
							if(mysql_num_rows($already_notify_booking)>0)
							{
								$class_notify = '<span class="notify_me" id="notify_me'.$S->book_id.'"></span>';
							}
							else
							{
								$class_notify = '';
							}		
             $msg.='<li class=" all_date_time '.$active_class.'" id="spe_date_time_'.$S->book_id.'" onClick="call_info('.$S->book_id.',\''.$status.'\')">'.$class_notify.date("h:i a",mktime($S->start_time,0,0,0,0,0)).' - '.date("h:i a",mktime($S->end_time,0,0,0,0,0)).'</li>';
						 
						 
						 
					 }
					 				 $msg.='</ul>';
				 }
				 echo $msg;
	break;
	case 'call_info':
	
	$S = mysql_fetch_object(mysql_query("select * from book_management where book_id='".$id."'"));
	
	$family_details = mysql_fetch_object(mysql_query("select * from user_information where user_id='".$S->family_user_id."'"));
	
	$msg= '<p><span>Name:</span><a href="family_details.php?family_user_id='.base64_encode($family_details->user_id).'">'.$family_details->user_first_name.' '.$family_details->user_middle_name.' '.$family_details->user_last_name.'<a/></p><p><span>Address:</span>'.$family_details->user_current_address.'</p><p><span>Time:</span>'.date("h:i a",mktime($S->start_time,0,0,0,0,0)).' - '.date("h:i a",mktime($S->end_time,0,0,0,0,0)).'</p><p><span>No Of Kids:</span>'.$S->no_of_kids.'</p><p><span>Zipcode:</span>'.$S->location_code.'</p><p><span>Remarks:</span>'.$S->remarks.'</p><p><span>Appointment Date:</span>'.$S->booking_date.'</p><p><span>Booking Date:</span>'.date('m/d/Y',$S->booking_placed_date);
	
	
	echo $msg;
	break;
	case 'get_bookibg_info_family':
	
	$search_date = mysql_query("select * from book_management where booking_date='".$cal_date."' and family_user_id='".$_SESSION['user_id']."'  and booking_status='1'");
	
	if(mysql_num_rows($search_date)>0)
				 {
					 $msg = '<ul>';
					 while($S = mysql_fetch_object($search_date))
					 {
						 //print_r($S);
				if($S->book_id==$cal_id)
				{
					$active_class = 'active';
				}
				else
				{
					$active_class = '';
				}
				if( strtotime($S->booking_date) < strtotime('now') ) {
							$status = 'Expired';
							$title = 'Expired Booking';
						}
						else
						{
							if($S->sitter_approval==0)
							{
							$status = 'Not Confirmed';	
					
							}
							elseif($S->sitter_approval==2)
							{
							$status = 'Cancelled';	
						
							}
							else
							{
								$status = 'Confirmed';	
			
							}
							
							//echo "<p>$status</p>";
							
							
							}
							$already_notify_booking = mysql_query("select * from book_management as BM  JOIN message_management as MM where BM.book_id = MM.book_id and BM.family_user_id='".$_SESSION['user_id']."' and BM.booking_status='1' and BM.book_id='".$S->book_id."' and MM.send_by='S' and is_view='0'");
							//echo "select * from book_management as BM  JOIN message_management as MM where BM.book_id = MM.book_id and BM.family_user_id='".$_SESSION['user_id']."' and BM.booking_status='1' and BM.book_id='".$S->book_id."' and MM.send_by='S' and is_view='0'";
							if(mysql_num_rows($already_notify_booking)>0)
							{
								$class_notify = '<span class="notify_me" id="notify_me'.$S->book_id.'"></span>';
							}
							else
							{
								$class_notify = '';
							}		
             $msg.='<li class=" all_date_time '.$active_class.'" id="spe_date_time_'.$S->book_id.'" onClick="call_info_family('.$S->book_id.',\''.$status.'\')">'.$class_notify.date("h:i a",mktime($S->start_time,0,0,0,0,0)).' - '.date("h:i a",mktime($B_details->end_time,0,0,0,0,0)).'</li>';
						 
						 
						 
					 }
					 				 $msg.='</ul>';
				 }
				 echo $msg;
	break;
	case 'call_info_family':
	
		$S = mysql_fetch_object(mysql_query("select * from book_management where book_id='".$id."'"));
		
	
		$sitter_details = mysql_fetch_object(mysql_query("select * from user_information where user_id='".$S->sitter_user_id."'"));
		
		$msg= '<p><span>Name:</span>'.$sitter_details->user_first_name.' '.$sitter_details->user_middle_name.' '.$sitter_details->user_last_name.'</p><p><span>Phone No:</span>'.$sitter_details->user_cell_phone.'</p><p><span>Email Address:</span>'.$sitter_details->user_contact_email.'</p><p><span>Address:</span>'.$sitter_details->user_current_address.'</p><p><span>Time:</span>'.date("h:i a",mktime($S->start_time,0,0,0,0,0)).' - '.date("h:i a",mktime($S->end_time,0,0,0,0,0)).'</p><p><span>No Of Kids:</span>'.$S->no_of_kids.'</p><p><span>Zipcode:</span>'.$S->location_code.'</p><p><span>Remarks:</span>'.$S->remarks.'</p><p><span>Appointment Date:</span>'.$S->booking_date.'</p><p><span>Booking Date:</span>'.date('m/d/Y',$S->booking_placed_date);
		
		
		echo $msg;
	break;
	
	case 'add_rating':
		$rating = new ratings();
		echo $rating->vote();
	break;

	case 'get_ratings':
		$rating = new ratings();
		echo $rating->get_ratings();
		
	break;
}
?>