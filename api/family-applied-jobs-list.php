<?php include('../includes/connection.php');

  $user_id = (isset($_GET['user_id'])) ? trim($_GET['user_id']) : NULL;

  if (!$user_id) {
    $response = array('code' => 401, 'message' => 'User ID is required.');
    return json_encode($response);
  }

  $search_query_sql = "select  * from jobapply_management WHERE 
    sitter_user_id='".$user_id."' order by applytime ";
								
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
      $job_history =  mysql_fetch_object(mysql_query("select * from `job_management` where set_code='".$R->job_id."'"));

      $results[] = array(
        'totalDate' => $totaldate,
        'totalDate1' =>  $totaldate1,
        'results' => $job_history,
        'job' => $R,
      );
    }
  }

  return json_encode(array('code' => 200, 'message' => $results));
