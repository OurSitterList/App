<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php  //echo $_SESSION['user_id'];exit;?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='family')
			{

			header('Location:/');
				
			}
		
 if($_POST['PostjobForm']=='yes' && $_POST['job_calender_val']!='')
{
	$location_id = (isset($_SESSION['user_location_id'])) ? $_SESSION['user_location_id'] : 1;
	
	$code =  time().rand(0,100);
	$calender_val_arr = explode(',',$_POST['job_calender_val']);
	$insertedId = null;

	$postingTimeout = strtotime('-1 Minute');
	$throttlePostings = $db->get('
	    SELECT job_id,booking_placed_date FROM job_management 
	    WHERE family_user_id=:user_id
	    AND booking_placed_date >= '.$postingTimeout,[
			'user_id' => $_SESSION['user_id']
		]
	);
	if(count($throttlePostings) > 0) {
		$maxTime = 0;
		foreach($throttlePostings as $posting) {
			if($posting->booking_placed_date > $maxTime) {
				$maxTime = $posting->booking_placed_date;
			}
		}
		$msg = 'Oops! You\'re trying that too often.';
		if($maxTime > 0) {
			$timeout = time() - $maxTime;
			if($timeout > 0) {
				$timeout = 5 - ceil($timeout / 60);
				if($timeout > 0) {
					//$msg .= ' Please try again in ' . $timeout . ' minute'.($timeout == 1 ? '' : 's');
					$msg .= ' Please try again in a bit';
				}
			}
		}
		setPostMSG($msg, 'error');
	} else {

		foreach ($calender_val_arr as $CV) {
			$make_id = str_replace('/', '', trim($CV));
			$insertedId = $db->insert("INTO job_management SET 
				set_code='" . $code . "',
				family_user_id=:user_id,
				booking_date=:cv,
				booking_placed_date='" . time() . "',
				booking_status='1',
				start_time=:start,
				end_time=:endtime,
				no_of_kids=:kids,
				location_code=:location,
				remarks=:remarks, 
				location_id =:location_id", [
				'user_id' => $_SESSION['user_id'],
				'cv' => trim($CV),
				'start' => $_REQUEST['job_start_time' . $make_id],
				'endtime' => $_REQUEST['job_end_time' . $make_id],
				'kids' => $_REQUEST['job_no_of_kids'],
				'location' => $_REQUEST['job_location_code'],
				'remarks' => $_REQUEST['job_remarks'],
				'location_id' => $location_id
			]);

		}

		// send notification
		$notification = new Notification();
		$notification->send_family_notification($_REQUEST, $insertedId);

		setPostMSG('Your job posting has been created.', 'success');
	}
}
header('Location:'.$base_path.'/family_posting.php');
?>


<?php include('includes/footer.php');?>