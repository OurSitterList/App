<?php

  // error_reporting(E_ALL);
  // ini_set("display_errors", 1);

  include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');
  $executable = [];


$searchArray = array();
  if (isset($_REQUEST['user_firstaid_training'])) {
    $searchArray[] ='user_firstaid_training=:user_firstaid_training';
    $executable['user_firstaid_training'] = $_REQUEST['user_firstaid_training'];
  }
  if (isset($_REQUEST['user_cpr_training'])) {
    $searchArray[] ='user_cpr_training=:user_cpr_training';
    $executable['user_cpr_training'] = $_REQUEST['user_cpr_training'];
  }
  if (isset($_REQUEST['user_newborn_cpr_training'])) {
    $searchArray[] = 'user_newborn_cpr_training=:user_newborn_cpr_training';
    $executable['user_newborn_cpr_training'] = $_REQUEST['user_newborn_cpr_training'];
  }
  if (isset($_REQUEST['user_food_allergies'])) {
    $searchArray[] = 'user_food_allergies=:user_food_allergies';
    $executable['user_food_allergies'] = $_REQUEST['user_food_allergies'];
  }
  if (isset($_REQUEST['user_overnight'])) {
    $searchArray[] = 'user_overnight=:user_overnight';
    $executable['user_overnight'] = $_REQUEST['user_overnight'];
  }
  if (isset($_REQUEST['user_travel'])) {
    $searchArray[] = 'user_travel=:user_travel';
    $executable['user_travel'] = $_REQUEST['user_travel'];
  }
  if (isset($_REQUEST['user_permanent'])) {
    $searchArray[] = 'user_permanent=:user_permanent';
    $executable['user_permanent'] = $_REQUEST['user_permanent'];
  }
  if (isset($_REQUEST['user_newborn_exp'])) {
    $searchArray[] = 'user_newborn_exp=:user_newborn_exp';
    $executable['user_newborn_exp'] = $_REQUEST['user_newborn_exp'];
  }
  if (isset($_REQUEST['user_sick_kids'])) {
    $searchArray[] = 'user_sick_kids=:user_sick_kids';
    $executable['user_sick_kids'] = $_REQUEST['user_sick_kids'];
  }
  $and_string = " AND ";
  $search_string = !empty($searchArray) ? $and_string . implode($and_string, $searchArray) . " " : '';

  $search_query_sql = "select user_first_name, user_last_name, user_description,
    cpr_approve, background_approve, newborn_approve, 
    user_college, user_college_name, user_high_school, user_high_school_name, 
    user_image, UM.user_id 
    from user_management as UM
    JOIN user_information as UI ON UM.user_id=UI.user_id
    WHERE UM.user_type='sitter'
    AND user_status=1" . $search_string . "
    order by UI.user_first_name";
														
  $data = $db->get($search_query_sql,$executable);
  
  $response = array('code' => 200, 'message' => array('results' => $data, 'total' => count($data)));
  echo json_encode($response); exit;
  