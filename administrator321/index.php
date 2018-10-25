<?php
	include("config/admin-includes.php");
	include("templates/index-tpl.php");
	
	$page=new Index("-:: Admin ::-");
	$page->pageAdmin();
?>