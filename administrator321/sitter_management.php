<?php
	include("config/admin-includes.php");
	include("templates/sitter_management-tpl.php");	
	$page=new Settings("Sitter");
	$page->pageAdmin();
?>