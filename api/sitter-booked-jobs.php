<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

if (!isset($_REQUEST) || !array_key_exists('user_id', $_REQUEST)) {
    echo json_encode(array('code' => 401, 'message' => 'User ID is required.'));
    exit;
}

$user_id = $_REQUEST['user_id'];

$sql = "SELECT
      bm.book_id,
      bm.family_user_id,
      bm.sitter_user_id,
      bm.booking_date,
      bm.booking_placed_date,
      bm.start_time,
      bm.end_time,
      bm.no_of_kids,
      bm.location_code,
      bm.remarks,
      bm.sitter_approval,
      ui.user_first_name,
      ui.user_middle_name,
      ui.user_last_name
  FROM
      book_management AS bm
  LEFT JOIN user_management AS um ON um.user_id = bm.family_user_id
  LEFT JOIN user_information AS ui ON ui.user_id = um.user_id
  WHERE bm.sitter_user_id = " . $user_id . "
  AND DATEDIFF(STR_TO_DATE(bm.booking_date, '%m/%d/%Y'), NOW()) >= 0
  ORDER BY
      bm.book_id DESC;";

$query = mysql_query($sql);
$num = mysql_num_rows($query);
$data = array();

while ($R = mysql_fetch_object($query)) {
    $data[] = $R;
}

$response = array('code' => 200, 'message' => array('results' => $data, 'total' => $num));
echo json_encode($response);exit;
