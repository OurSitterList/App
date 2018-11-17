<?php
/**
 * GET
 * 
 * user_id
 * location_id
 * user_location_id
 * 
 * */

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

$search_query = mysql_query("select * from  user_information where user_id='".$_GET['user_id']."'");
if(mysql_num_rows($search_query) > 0) {
	$R = mysql_fetch_object($search_query);
} else {
  $response = array('code' => 401, 'message' => 'User does not exist.');
  echo json_encode($response); exit;
}
$myaccount = new myAccount();
$useLocationId = (isset($_GET['location_id']) && preg_match('/^[1-9]+[0-9]*$/', $_GET['location_id']) > -1) ? $_GET['location_id'] : $_GET['user_location_id'];

$sql = "SELECT
	jm.job_id,
	jm.set_code,
	jm.family_user_id,
	jm.booking_date,
	jm.start_time,
	@booking_date := STR_TO_DATE(jm.booking_date, '%m/%d/%Y'),
	@date_diff := DATEDIFF(@booking_date, NOW()),
	@date_diff AS days_left,
	(
		FROM_UNIXTIME(
			jm.booking_placed_date,
			'%m/%d/%Y'
		)
	)AS job_posted_date,
(
		SELECT
			GROUP_CONCAT(
				'\'',
				jm2.booking_date,
				'\'' SEPARATOR ','
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
	jm.sitter_approval,
	jam.family_approval,
	jam.sitter_user_id,
	ui.user_first_name,
    ui.user_middle_name,
    ui.user_last_name
FROM job_management AS jm
LEFT JOIN jobapply_management AS jam ON jm.set_code = jam.job_id AND jam.family_approval = '1'
LEFT JOIN user_management AS um ON um.user_id = jm.family_user_id
LEFT JOIN user_information AS ui ON ui.user_id = um.user_id
WHERE jm.location_id = " . $useLocationId . "
AND jm.booking_status = 1
AND jm.sitter_approval = '0'
AND DATEDIFF(STR_TO_DATE(jm.booking_date, '%m/%d/%Y'), NOW()) >= 0
GROUP BY jm.set_code
ORDER BY jam.family_approval, jm.job_id DESC";
$query	= mysql_query($sql);

$results = array();
if (mysql_num_rows($query) > 0) {
  while($R = mysql_fetch_object($query)) {
    $results[] = $R;
  }
}

$response = array('code' => 200, 'message' => $results);
echo json_encode($response); exit;