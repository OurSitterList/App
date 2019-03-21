<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/AuthnetARB.class.php";

$session = array();
$user_name = (isset($_POST['username'])) ? $_POST['username'] : null;
$user_password = (isset($_POST['password'])) ? $_POST['password'] : null;
$user_search = mysql_query("select m.*, i.location_code as zip, i.location_id
    from user_management m
    left join user_information i ON i.user_id = m.user_id
    where m.user_name='" . mysql_real_escape_string($user_name) . "'
    AND m.user_password='" . mysql_real_escape_string(md5($user_password)) . "'
    AND m.user_type = 'family'");

$user_search = mysql_query($sql);

if (mysql_num_rows($user_search) > 0) {
    $R = mysql_fetch_object($user_search);
    $session['user_id'] = $R->user_id;
    $session['user_name'] = $R->user_name;
    $session['user_type'] = 'family';
    $session['user_zip'] = $R->zip;
    $session['user_location_id'] = getUserLocation($R->user_id, $R->zip, $R->location_id);
    $session['_sub_expired'] = false;

    if (!$R->user_subscriberid && !$R->promo_code) {
        $session['_sub_expired'] = true;
    }

    $response = array('code' => 200, 'message' => $session);
    echo json_encode($response);exit;
} else {
    $response = array('code' => 400, 'message' => 'Invalid or incorrect username/password. Please check your login credentials and try again.');
    echo json_encode($response);exit;
}
