<?php

  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

  if (!isset($_REQUEST) || !array_key_exists('user_id', $_REQUEST)) {
    echo json_encode(array('code' => 401, 'message' => 'User ID is required.'));
    exit;
  }

  $user_id = $_REQUEST['user_id'];
  $search_query_sql = "select * from jobapply_management WHERE sitter_user_id='".$user_id."' order by applytime;";
  $search_query = mysql_query($search_query_sql);
  $results = array();
  if (mysql_num_rows($search_query) > 0) {
    $available = 1;
    while($R = mysql_fetch_object($search_query)) {
      $job_query = mysql_query("select * from `job_management` where set_code='".$R->job_id."'");
      $datearr =array();
      $datearr1 =array();

      while($JD = mysql_fetch_object($job_query)) {
        $datearr[] = "'".trim($JD->booking_date)."'";
        $datearr1[] = trim($JD->booking_date);
      }

      $totaldate = implode(',',$datearr);
      $totaldate1 = implode(', ',$datearr1);
      $job_history = mysql_query("select * from `job_management` where set_code='".$R->job_id."'");
      $data = array();

      while ($job = mysql_fetch_object($job_history)) {
        $data[] = $job;
      }

      $results[] = array(
        'totalDate' => $totaldate,
        'totalDate1' =>  $totaldate1,
        'results' => $data,
        'job' => $R,
      );
    }
  }

  $response = array('code' => 200, 'message' => $results);
  echo json_encode($response); exit;
