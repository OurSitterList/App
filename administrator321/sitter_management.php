<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

	include("config/admin-includes.php");
	include("templates/sitter_management-tpl.php");	
	$page=new Settings("Sitter");
	$page->pageAdmin();
?>