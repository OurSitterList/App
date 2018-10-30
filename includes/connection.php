<?php ob_start();
//error_reporting(0);
session_start();
include("administrator321/config/constants.php");
include("administrator321/classes/Classes.php");
$con=new DBConnection(host,user,pass,db);
$conObj=$con->connectDB();
mysql_query ("set character_set_results='utf8'");
//$base_path=mysql_fetch_object(mysql_query("select * from setting where id = '3'"))->settingValue;

$base_path = 	'';

$https_base_path = '';

include("classes/Loader.php");
?>
