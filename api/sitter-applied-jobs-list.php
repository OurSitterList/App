<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
  
  include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');
  $user_id = (isset($_GET['user_id'])) ? trim($_GET['user_id']) : NULL;
  if (!$user_id) {
    $response = array('code' => 401, 'message' => 'User ID is required.');
    echo json_encode($response); exit;
  }
  $sql = "SELECT
    jm.job_id,
    jm.set_code,
    jm.family_user_id,
    jm.booking_date,
    @booking_date := STR_TO_DATE(jm.booking_date, '%m/%d/%Y'),
    jm.booking_placed_date,
    @date_diff := DATEDIFF(@booking_date, NOW()),
    @date_diff AS days_left,
    (
      FROM_UNIXTIME(
        jm.booking_placed_date,
        '%m/%d/%Y'
      )
    )AS job_posted_date,
    jm.booking_date,
  (
      SELECT
        GROUP_CONCAT(
          jm2.booking_date SEPARATOR ' , '
        )		FROM
        job_management AS jm2
      WHERE
        jm.set_code = jm2.set_code
    )AS dates_in_job,
  (
      SELECT
        GROUP_CONCAT(
          TIME_FORMAT(CONCAT(jm2.start_time,':00:00'), '%h:%i %p'),
          '-',
          TIME_FORMAT(CONCAT(jm2.end_time,':00:00'), '%h:%i %p')
          SEPARATOR ' / '
        )
      FROM
        job_management AS jm2
      WHERE
        jm.set_code = jm2.set_code
    )AS time_in_job,
    (
      SELECT
        GROUP_CONCAT(
          '<tr><td><span>',
          jm2.booking_date,
          '</span></td><td><span>',
          TIME_FORMAT(CONCAT(jm2.start_time,':00:00'), '%h:%i %p'),
          '-',
          TIME_FORMAT(CONCAT(jm2.end_time,':00:00'), '%h:%i %p'),
          '</span></td></tr>' SEPARATOR ''
        )AS sched
      FROM
        job_management AS jm2
      WHERE
        jm.set_code = jm2.set_code
    )AS sched,
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
  JOIN jobapply_management AS jam ON jm.set_code = jam.job_id AND jam.sitter_user_id = " . $user_id . "
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
$results = mysql_query($sql);
$num = mysql_num_rows($results);
$data = array();

while ($job = mysql_fetch_object($results)) {
    $data[] = $job;
}

$response = array('code' => 200, 'message' => array('results' => $data, 'total' => $num));
echo json_encode($response); exit;
