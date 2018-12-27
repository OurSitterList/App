<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

if (!isset($_GET) || !array_key_exists('sitter_id', $_GET)) {
	echo json_encode(array('code' => 401, 'message' => 'Sitter ID is required.'));
	exit;
}

$data = array();
$search_query_sql = mysql_query("select distinct family_user_id from book_management where sitter_user_id='".base64_decode($_GET['sitter_id'])."' and booking_status='1'");		
if (mysql_num_rows($search_query_sql) > 0) {
	while ($R = mysql_fetch_object($search_query_sql)) {
    $sitter_dateils = mysql_fetch_object(mysql_query("select * from `user_information` where user_id='".$R->family_user_id."'"));
    $data[] = $sitter_dateils;
  }
}
$num = mysql_num_rows($search_query_sql);

$response = array('code' => 200, 'message' => array('results' => $data, 'total' => $num));
echo json_encode($response); exit;
