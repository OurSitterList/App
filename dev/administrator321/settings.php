<?php
	include("config/admin-includes.php");
	include("templates/settings-tpl.php");
	
	$page=new Settings("Setting");
	$page->pageAdmin();
?>