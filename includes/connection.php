<?php ob_start();
//error_reporting(0);
session_start();
include($_SERVER["DOCUMENT_ROOT"] . "/administrator321/config/constants.php");
include($_SERVER["DOCUMENT_ROOT"] . "/administrator321/classes/Classes.php");

$base_path = 	'';

$https_base_path = '';

include($_SERVER["DOCUMENT_ROOT"] . "/includes/classes/Loader.php");

global $db;
$db = new DBConnection(host,user,pass,db);
?>
