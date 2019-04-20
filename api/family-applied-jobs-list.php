<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include $_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php';

if (!isset($_REQUEST) || !array_key_exists('user_id', $_REQUEST)) {
    echo json_encode(array('code' => 401, 'message' => 'User ID is required.'));
    exit;
}

$user_id = $_REQUEST['user_id'];
$search_query_sql = "SELECT family_user_id, booking_date, start_time, end_time, remarks, job_id, NULL as book_id, sitter_approval, no_of_kids, location_code, booking_placed_date, NULL as sitter_user_id, set_code
                     FROM job_management
                     WHERE family_user_id = '" . $user_id . "'
                     UNION
                     SELECT family_user_id, booking_date, start_time, end_time, remarks, NULL as job_id, book_id, sitter_approval, no_of_kids, location_code, booking_placed_date, sitter_user_id, 0 as set_code
                     FROM book_management
                     WHERE family_user_id = '" . $user_id . "'
                     ORDER BY STR_TO_DATE(booking_date, '%m/%d/%Y') desc, start_time asc
                     LIMIT 30";
$search_query = mysql_query($search_query_sql);
$results = array();
if (mysql_num_rows($search_query) > 0) {
    while ($R = mysql_fetch_object($search_query)) {
        $job_query = mysql_query("select * from `job_management` where set_code='" . $R->set_code . "' ORDER BY STR_TO_DATE(booking_date, '%m/%d/%Y') desc, start_time asc");
        $datearr = array();
        $datearr1 = array();

        while ($JD = mysql_fetch_object($job_query)) {
            $datearr[] = "'" . trim($JD->booking_date) . "'";
            $datearr1[] = trim($JD->booking_date);
        }

        $totaldate = implode(',', $datearr);
        $totaldate1 = implode(', ', $datearr1);
        $job_history = mysql_query("SELECT jm.*, ui.user_last_name as sitter_last_name, jam.family_approval
                                    FROM `job_management` jm
                                    LEFT JOIN `jobapply_management` jam on jam.job_id = jm.set_code
                                    JOIN user_information ui on ui.user_id = jam.sitter_user_id
                                    WHERE jm.set_code='" . $R->set_code . "';");
        $data = array();

        while ($job = mysql_fetch_object($job_history)) {
            $data[] = $job;
        }

        if ($R->sitter_user_id !== null) {
            $sitter_query = mysql_query("SELECT user_first_name as sitter_first_name, user_last_name as sitter_last_name
                                         FROM user_information
                                         WHERE user_id = '" . $R->sitter_user_id . "'");
            if (mysql_num_rows($sitter_query) > 0) {
                while ($row = mysql_fetch_object($sitter_query)) {
                    $R->sitter_first_name = $row->sitter_first_name;
                    $R->sitter_last_name = $row->sitter_last_name;
                }
            }
        }

        $results[] = array(
            'totalDate' => $totaldate,
            'totalDate1' => $totaldate1,
            'results' => $data,
            'job' => $R,
        );
    }
}

$response = array('code' => 200, 'message' => $results);
echo json_encode($response);exit;
