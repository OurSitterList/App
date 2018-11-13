<?php
	chdir("..");
	include("config/admin-includes.php");
	chdir("ajax");
	
	$con=new DBConnection(host,user,pass,db);
	$conObj=$con->connectDB();
	
	if(isset($_POST['mode']))
	{
		extract($_POST);
		switch($mode)
		{
			case 'setVal':
			//print_r($_POST);exit;
					$Q="UPDATE `setting` SET settingValue='".addslashes($newVal)."' WHERE `id`=".$id;
					//echo $Q;
					mysql_query($Q) or die(mysql_error());
					//$dt->executeNonQuery($Q);
					echo '- Setting Updated.';
				break;
			default:
					echo "- ERROR.";
				break;
		}
	}
	else
		echo "- ERROR.";
	ob_flush();
?>