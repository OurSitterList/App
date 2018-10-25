<?php include('includes/connection.php');?>
<?php
if(!isset($_REQUEST['mode'])) return false;

$myaccount 	= new myAccount();
$mode		= trim($_REQUEST['mode']);

switch($mode) {
	case 'username':
		$result	= $myaccount->get_user_details_by_user_name($_REQUEST['sitter_username']);
		if($result)
			echo "false";
		else
			echo "true";
	break;

	case 'username_family':
		$result	= $myaccount->get_user_details_by_user_name($_REQUEST['family_username']);
		if($result)
			echo "false";
		else
			echo "true";
	break;

	
	case 'email':
		$result	= $myaccount->get_user_details_by_user_name($_REQUEST['sitter_email']);
		if($result)
			echo "false";
		else
			echo "true";
	break;

	case 'email_family':
		$result	= $myaccount->get_user_details_by_user_name($_REQUEST['family_email']);
		if($result)
			echo "false";
		else
			echo "true";
	break;

	case 'date_time_check':
		if($_POST['calender_val']=='')
		{
			echo 'No date Choosen';
			exit;
		}
		else
		{
			$response			= true;
			$calender_val_arr 	= explode(',',$_POST['calender_val']);
			$sitter_id			= $_POST['sitter_main_id'];
			$flag_arr 			= array();
			foreach($calender_val_arr as $CV)
			{
				$CV = trim($CV);
				$make_id = str_replace('/','',$CV);
				if($_POST['start_time'.$make_id]>=$_POST['end_time'.$make_id])
				{
					
					echo 'For '.$CV,' - Start time cannot be less than End time';
					exit;
				}
				else {
					$date	= $CV;
					$time	= $_POST['sitter_main_id'];
					$time_s	= $_POST['start_time'.$make_id];
					$time_e	= $_POST['end_time'.$make_id];
					
					$response = $myaccount->check_my_time_availability($sitter_id, $date, $time_s, $time_e);
				}
			}
			if(is_array($response)) {
				foreach($response as $k=>$v) {
					echo "<p>$v</p>";
				}
				exit;
			}
			else {
				echo 1;
			}
			
			if(!in_array('0',$flag_arr))
			{
				
			}
		}
	break;
	
	case 'job_date_time_check':
		if($_POST['calender_val']=='')
		{
			echo 'No date Choosen';
			exit;
		}
		else
		{
			$response			= true;
			$calender_val_arr 	= explode(',',$_POST['job_calender_val']);
			$sitter_id			= $_POST['sitter_main_id'];
			$flag_arr 			= array();
			foreach($calender_val_arr as $CV)
			{
				$CV = trim($CV);
				$make_id = str_replace('/','',$CV);
				if($_POST['start_time'.$make_id]>=$_POST['end_time'.$make_id])
				{
					
					echo 'For '.$CV,' - Start time cannot be less than End time';
					exit;
				}
				else {
					$date	= $CV;
					$time	= $_POST['sitter_main_id'];
					$time_s	= $_POST['start_time'.$make_id];
					$time_e	= $_POST['end_time'.$make_id];
					
					$response = $myaccount->check_my_time_availability($sitter_id, $date, $time_s, $time_e);
				}
			}
			if(is_array($response)) {
				foreach($response as $k=>$v) {
					echo "<p>$v</p>";
				}
				exit;
			}
			else {
				echo 1;
			}
			
			if(!in_array('0',$flag_arr))
			{
				
			}
		}
	break;
	
	default:
}
?>
