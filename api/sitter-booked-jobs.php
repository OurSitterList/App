<?php
  // error_reporting(E_ALL);
  // ini_set("display_errors", 1);
  
  include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

  if (!isset($_REQUEST) || !array_key_exists('user_id', $_REQUEST)) {
    echo json_encode(array('code' => 401, 'message' => 'User ID is required.'));
    exit;
  }
  
  $sql = "SELECT
      jm.job_id,
      jm.set_code,
      jm.family_user_id,
      jm.booking_date,
      jm.booking_placed_date,
      jm.booking_date,
      jm.no_of_kids,
      jm.location_code,
      jm.remarks,
      jam.remarks AS your_remarks,
      jm.sitter_approval,
      jam.family_approval,
      jam.sitter_user_id,
      jam.applytime,
      ui.user_first_name,
      ui.user_middle_name,
      ui.user_last_name
  FROM
      job_management AS jm
  JOIN jobapply_management AS jam ON jm.set_code = jam.job_id AND jam.sitter_user_id = ". $_REQUEST['user_id'] ."
  LEFT JOIN user_management AS um ON um.user_id = jm.family_user_id
  LEFT JOIN user_information AS ui ON ui.user_id = um.user_id
  WHERE
      jm.booking_status = 1
  AND jm.sitter_approval = '0'
  AND DATEDIFF(STR_TO_DATE(jm.booking_date, '%m/%d/%Y'), NOW()) > 0
  GROUP BY
      jm.set_code
  ORDER BY
      jm.job_id DESC;";

  $query = mysql_query($sql);
  $num = mysql_num_rows($query);
  $data = array();
  
  while ($R = mysql_fetch_object($query)) {
      $data[] = $R;
  }
  
  $response = array('code' => 200, 'message' => array('results' => $data, 'total' => $num));
  echo json_encode($response); exit;
  