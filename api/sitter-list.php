<?php

  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

  print_r($_REQUEST);
  echo "request";

  print_r($_GET);
  echo "get";

  $search_query_sql = "select user_first_name, user_last_name, user_description,
    cpr_approve, background_approve, newborn_approve, 
    user_college, user_college_name, user_high_school, user_high_school_name, 
    user_image, UM.user_id 
    from user_management as UM
    JOIN user_information as UI ON UM.user_id=UI.user_id
    WHERE UM.user_type='sitter'
    AND user_status=1
    order by UI.user_first_name";
														
  $search_query = mysql_query($search_query_sql);
  $num = mysql_num_rows($search_query);
  $data = array();
  
  while ($job = mysql_fetch_object($search_query)) {
      $data[] = $job;
  }
  
  $response = array('code' => 200, 'message' => array('results' => $data, 'total' => $num));
  echo json_encode($response); exit;
  