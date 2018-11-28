<?php

  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

  $search_query_sql = "select *,UM.user_id 
    from user_management as UM
    JOIN user_information as UI ON UM.user_id=UI.user_id
    WHERE UM.user_type='sitter'
    AND user_status=1
    order by UI.user_first_name";
														
  $search_query = mysql_query($search_query_sql);
  $num = mysql_num_rows($results);
  $data = array();
  
  while ($job = mysql_fetch_object($results)) {
      $data[] = $job;
  }
  
  $response = array('code' => 200, 'message' => array('results' => $data, 'total' => $num));
  echo json_encode($response); exit;
  