<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php  //echo $_SESSION['user_id'];exit;?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='family')
			{
				
			header('Location:/');
				
			}
		
 if($_POST['edit_PostjobForm']=='yes' && $_POST['edit_job_calender_val']!='')
{
	mysql_query("delete from job_management where set_code='".$_REQUEST['edit_job_id']."'");
	$code =  $_REQUEST['edit_job_id'];
$calender_val_arr = explode(',',$_POST['edit_job_calender_val']);
	foreach($calender_val_arr as $CV)
	{
		$make_id = str_replace('/','',trim($CV));
	mysql_query("insert into job_management set set_code='".$code."',family_user_id='".$_SESSION['user_id']."',booking_date='".trim($CV)."',booking_placed_date='".time()."',booking_status='1',start_time='".$_REQUEST['edit_job_start_time'.$make_id]."',end_time='".$_REQUEST['edit_job_end_time'.$make_id]."',no_of_kids='".$_REQUEST['edit_job_no_of_kids']."',location_code='".$_REQUEST['edit_job_location_code']."',remarks='".$_REQUEST['edit_job_remarks']."'");
	}
}
header('Location:'.$base_path.'/family_posting.php');
?>


<?php include('includes/footer.php');?>