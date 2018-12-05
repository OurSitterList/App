<?php

  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

  if (!isset($_REQUEST) || !$_REQUEST['user_id']) {
    return json_encode(array('code' => 401, 'message' => 'User ID is required.'));
  }

  $sql = "SELECT * FROM messages WHERE user_id='" . $_REQUEST['user_id'] . "' AND deleted_at IS NULL";
														
  $query = mysql_query($sql);
  $num = mysql_num_rows($query);
  $data = array();
  
  while ($R = mysql_fetch_object($query)) {
      $data[] = $R;
  }
  
  $response = array('code' => 200, 'message' => array('results' => $data, 'total' => $num));
  echo json_encode($response); exit;
   