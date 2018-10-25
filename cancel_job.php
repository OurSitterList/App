<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php  //echo $_SESSION['user_id'];exit;?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='sitter')
			{
				
			header('Location:'.$base_path);
				
			}
		

	
	mysql_query("delete from jobapply_management where job_id='".$_REQUEST['id']."' and sitter_user_id='".$_SESSION['user_id']."'");

setPostMSG('Your application has been cancelled.', 'success');
header('Location:'.$base_path.'/applied_job_list.php');
?>


<?php include('includes/footer.php');?>