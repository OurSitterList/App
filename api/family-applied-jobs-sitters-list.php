<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

$sql = "SELECT *
        FROM jobapply_management j
        INNER JOIN user_information u ON u.user_id = j.sitter_user_id
        WHERE job_id = '" . $_REQUEST['set_code'] . "'";

$query = mysql_query($sql);
$num = mysql_num_rows($query);
$data = array();

while ($R = mysql_fetch_object($query)) {
    $data[] = $R;
}

$response = array('code' => 200, 'message' => array('results' => $data, 'total' => $num));
echo json_encode($response);exit;
