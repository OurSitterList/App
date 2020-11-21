<?php error_reporting(E_ALL);
ini_set("display_errors", 1);
include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php 

extract($_POST);

/// Code written by prakash on 21/11/2020
$db->update("user_management set user_password='" . md5($sitter_new_password) . "' where user_code=:user_code", [
                                'user_code' => $_POST['hidden_code']
                            ]);
// mysql_query("update user_management set
// 			user_password  = '".md5($sitter_new_password)."'
// 			where user_code='".$_REQUEST['hidden_code']."'");

// echo "update user_management set
// user_password  = '".mysql_real_escape_string(md5($sitter_new_password))."'
// where user_code='".$_REQUEST['hidden_code']."'";
			
header('Location:'.$base_path.'/?passchange=1');
?>