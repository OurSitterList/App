<?php

ob_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

include $_SERVER["DOCUMENT_ROOT"] . "/administrator321/config/constants.php";

$mysqli = new mysqli(host, user, pass, db);

if ($mysqli->connect_errno) {
    http_response_code(500);
    echo json_encode(array('message' => "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error));
    exit;
}

$mysqli->query("set character_set_results='utf8'");

$user_name = $_REQUEST['user_name'];
$user_password = $_REQUEST['user_password'];

$queryString = "SELECT m.*, i.location_code AS zip, i.location_id
                FROM user_management m
                LEFT JOIN user_information i ON i.user_id = m.user_id
                WHERE m.user_name='" . $mysqli->real_escape_string($user_name) . "'
                AND m.user_password='" . $mysqli->real_escape_string(md5($user_password)) . "'
                AND m.user_type = 'family'";

$result = $mysqli->query($queryString);
$row_count = $result->num_rows;
if ($row_count > 0) {
    $currentRow = $result->fetch_object();
    $user = array();
    $user['user_id'] = $currentRow->user_id;
    $user['user_name'] = $currentRow->user_name;
    $user['user_type'] = 'family';
    $user['user_zip'] = $currentRow->zip;
    $user['user_location_id'] = '';

    header('Content-Type:application/json');
    http_response_code(200);
    echo json_encode(array('code' => 200, 'message' => $user));
    exit;
}

http_response_code(500);
echo json_encode(array('message' => 'User not found'));
exit;
