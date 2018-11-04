<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php  //echo $_SESSION['user_id'];exit;?>
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']=='') || $_SESSION['user_type']!='family')
			{
				
			header('Location:/');
				
			}
		

	
	mysql_query("delete from job_management where set_code='".$_REQUEST['job_id']."' and family_user_id='".$_SESSION['user_id']."'");
	
header('Location:'.$base_path.'/family_posting.php');
?>


<?php include('includes/footer.php');?>