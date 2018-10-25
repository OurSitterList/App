<?php

	include("config/admin-includes.php");
	include("classes/PageStructure.php");
	
	$logout=new PageStructure("Login");
	$logout->pageTop();
	
	$auth=new Authentication($conObj);
	$sess=array("AID","ALOG","ANAME","ATYPE");
	$auth->logout($sess);
	header("Location: ./");
?>