<?php

  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

  if (!isset($_REQUEST) || !array_key_exists('user_id', $_REQUEST)) {
    echo json_encode(array('code' => 401, 'message' => 'User ID is required.'));
    exit;
	}

  $sql = "select * from user_information where user_id='" . $_REQUEST['user_id'] . "'";
														
  $query = mysql_query($sql);
  $num = mysql_num_rows($query);
  $data = array();
  
  while ($R = mysql_fetch_object($query)) {
      $data[] = $R;
  }
  
  $response = array('code' => 200, 'message' => array('results' => $data, 'total' => $num));
  echo json_encode($response); exit;
  