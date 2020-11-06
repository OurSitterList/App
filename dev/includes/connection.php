<?php ob_start();
//error_reporting(0);
session_start();
include("administrator321/config/constants.php");
include("administrator321/classes/Classes.php");
$con=new DBConnection(host,user,pass,db);
$conObj=$con->connectDB(true);
mysql_query ("set character_set_results='utf8'");
//$base_path=mysql_fetch_object(mysql_query("select * from setting where id = '3'"))->settingValue;

$base_path = 	'https://oursitterlistnashville.com';

$https_base_path = 'https://oursitterlistnashville.com';


$base_path = 	'http://www.sitter.tracksometime.com';

$https_base_path = 'http://www.sitter.tracksometime.com';

include("classes/Loader.php");
?>