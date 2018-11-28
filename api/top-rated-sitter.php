<?php

  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

  $sql = "SELECT
    ui.user_id,
    (sum(rm.score)/COUNT(rm.score)) AS rating,
    CONCAT(ui.user_first_name,' ',ui.user_last_name) name,
    ui.user_image
  FROM
    review_management rm
  LEFT JOIN user_information ui ON rm.sitter_user_id = ui.user_id
  WHERE rm.review_status = '1'
  ORDER BY rating DESC
  LIMIT 0, 20";		
														
  $search_query = mysql_query($sql);
  $num = mysql_num_rows($search_query);
  $data = array();
  
  while ($job = mysql_fetch_object($search_query)) {
      $data[] = $job;
  }
  
  $response = array('code' => 200, 'message' => array('results' => $data, 'total' => $num));
  echo json_encode($response); exit;
  