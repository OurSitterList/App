<?php

  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

  $sql = mysql_query("select * from user_information ui 
    left join user_management um ON ui.user_id = um.user_id
    where ui.user_id='".base64_decode($_REQUEST['user_id'])."' AND um.user_type='family' AND user_status=1");
														
  $query = mysql_query($sql);
  $num = mysql_num_rows($query);
  $data = array();
  
  while ($job = mysql_fetch_object($query)) {
      $data[] = $job;
  }
  
  $response = array('code' => 200, 'message' => array('results' => $data, 'total' => $num));
  echo json_encode($response); exit;
  