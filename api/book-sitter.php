<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

/**
 * user_id - Falmiy ID
 * sitter_main_id - Sitter ID
 * no_of_kids
 * location_code
 * remarks
 * calender_val - comma separated values
 * start_time - $_POST['start_time'.$make_id];
 * end_time - $_POST['end_time'.$make_id];
 */

extract($_POST);

$nonce 		        = $this->nonce;
$booking 			    = new Booking($user_id);
$notification 		= new Notification();
$booking_details  = $booking->set_booking();

if ($booking_details != false)
{
  $response 	= $notification->send_booking_notification($booking_details);
	$response = array('code' => 200, 'message' => 'Booking request has been sent to sitter.');
  echo json_encode($response); exit;
}

$response = array('code' => 200, 'message' => 'Booking request has failed. Please try again.');
echo json_encode($response); exit;
