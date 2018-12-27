<?php


  // error_reporting(E_ALL);
  // ini_set("display_errors", 1);

  include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

  /**
   * POST
   * 
   * hidden_code
   * sitter_new_password
   */

  extract($_POST);

  mysql_query("update user_management set
    user_password  = '".mysql_real_escape_string(md5($sitter_new_password))."'
    where user_code='".$hidden_code."'");

  $response	= array('code' => 200, 'message' => 'Success.');
  echo json_encode($response); exit;
