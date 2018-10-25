<?
	include("config/admin-includes.php");
	include("templates/home-tpl.php");
	
	$page=new Home("Dashboard");
	$page->pageAdmin();
?>