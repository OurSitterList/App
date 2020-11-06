<?php
	chdir("..");
	include("config/admin-includes.php");
	chdir("ajax");
	
	$con=new DBConnection(host,user,pass,db);
	$conObj=$con->connectDB(true);
	
	$dt=new DBTools($conObj);
	
	if(isset($_POST['mode']))
	{
		extract($_POST);
		switch($mode)
		{
			case 'change':
					$Q="UPDATE `".DBPrefix."admin_login` SET password='".md5($NP)."' WHERE `id`=".$aid;
					$dt->executeNonQuery($Q);
					echo '- Password Updated.';
				break;
			case 'edit':
					$Q="UPDATE `".DBPrefix."admin_login` SET atype='".$type."' WHERE `id`=".$aid;
					$dt->executeNonQuery($Q);
					echo '- Admin Type Updated.';
				break;
			case 'delete':
					$Q="DELETE FROM `".DBPrefix."admin_login` WHERE `id`=".$aid;
					$dt->executeNonQuery($Q);
				break;
			case 'newAdmin':
					$Q="INSERT INTO `".DBPrefix."admin_login` (updtime,adminid,`password`,atype) VALUES(0,'".$name."','".md5($pass)."','".$type."')";
					$dt->executeNonQuery($Q);
					echo mysql_insert_id();
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