<?php
	include("config/admin-includes.php");
	include("classes/AdminStructure.php");
	include_once("./fckeditor/fckeditor.php");

session_start();
//date_default_timezone_set ( 'America/Chicago' );


if ($_SESSION['ANAME'] !== 'admin')
{
//	echo "Not authorized:";
//	print_r($_SESSION);die;
	header('Location: /home.php');
	exit();
}



$con = new DBConnection(host, user, pass, db);
$conObj = $con->connectDB();


$code = $_REQUEST['id'];
$sql = "DELETE FROM job_management WHERE job_id = " . $code;

//die('About to delete... ' . $sql);

$r = mysql_query($sql);
$err = mysql_error();
if ($err)
{
	die('An error occurred trying to delete the job: ' . $err);
}

header("Location: job_management.php?page=" . ((isset($_REQUEST['page'])) ? $_REQUEST['page'] : '0'));
exit();

?>