<?php

  include('includes/connection.php');

  /**
   * POST
   * 
   * #user_id
   * $job_calender_val
   * $job_no_of_kids
   * $job_location_code
   * $job_remarks
   */

	$code =  time().rand(0,100);
	$calender_val_arr = explode(',',$job_calender_val);
	$insertedId = null;
	foreach($calender_val_arr as $CV) {
		$make_id = str_replace('/','',trim($CV));
		mysql_query("insert into job_management set set_code='".$code."',family_user_id='".$user_id."',booking_date='".trim($CV)."',booking_placed_date='".time()."',booking_status='1',start_time='".$_REQUEST['job_start_time'.$make_id]."',end_time='".$_REQUEST['job_end_time'.$make_id]."',no_of_kids='" . mysql_real_escape_string($_REQUEST['job_no_of_kids']) . "',location_code='".$_REQUEST['job_location_code']."',remarks='" . mysql_real_escape_string($_REQUEST['job_remarks']) . "', location_id = '" . $location_id . "'");

		if (!$insertedId)
		{
			$insertedId = mysql_insert_id();
		}

	}

	// send notification
	$notification 		= new Notification();
	$notification->send_family_notification($_REQUEST, $insertedId);
	$response = array('code' => 200, 'message' => 'Your job posting has been created.');
  echo json_encode($response); exit;

