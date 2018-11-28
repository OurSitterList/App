<?php

  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

 
  $searchArray = array();
  if (isset($_REQUEST['user_firstaid_training'])) {
    $searchArray[] = 'user_firstaid_training=' . $_REQUEST['user_firstaid_training'];
  }
  if (isset($_REQUEST['user_cpr_training'])) {
    $searchArray[] = 'user_cpr_training' . $_REQUEST['user_cpr_training'];
  }
  if (isset($_REQUEST['user_newborn_cpr_training'])) {
    $searchArray[] = 'user_newborn_cpr_training' . $_REQUEST['user_newborn_cpr_training'];
  }
  if (isset($_REQUEST['user_food_allergies'])) {
    $searchArray[] = 'user_food_allergies' . $_REQUEST['user_food_allergies'];
  }
  if (isset($_REQUEST['user_overnight'])) {
    $searchArray[] = 'user_overnight' . $_REQUEST['user_overnight'];
  }
  if (isset($_REQUEST['user_travel'])) {
    $searchArray[] = 'user_travel' . $_REQUEST['user_travel'];
  }
  if (isset($_REQUEST['user_permanent'])) {
    $searchArray[] = 'user_permanent' . $_REQUEST['user_permanent'];
  }
  if (isset($_REQUEST['user_newborn_exp'])) {
    $searchArray[] = 'user_newborn_exp' . $_REQUEST['user_newborn_exp'];
  }
  if (isset($_REQUEST['user_sick_kids'])) {
    $searchArray[] = 'user_sick_kids' . $_REQUEST['user_sick_kids'];
  }
  var_dump(implode('&', $searchArray));
  exit;



  // const searchArr = {};
  //   if (req.query && req.query.user_firstaid_training) {
  //     searchArr.user_firstaid_training = req.query.user_firstaid_training;
  //   }
  //   if (req.query && req.query.user_cpr_training) {
  //     searchArr.user_cpr_training = req.query.user_cpr_training;
  //   }
  //   if (req.query && req.query.user_newborn_cpr_training) {
  //     searchArr.user_newborn_cpr_training = req.query.user_newborn_cpr_training;
  //   }
  //   if (req.query && req.query.user_food_allergies) {
  //     searchArr.user_food_allergies = req.query.user_food_allergies;
  //   }
  //   if (req.query && req.query.user_overnight) {
  //     searchArr.user_overnight = req.query.user_overnight;
  //   }
  //   if (req.query && req.query.user_travel) {
  //     searchArr.user_travel = req.query.user_travel;
  //   }
  //   if (req.query && req.query.user_permanent) {
  //     searchArr.user_permanent = req.query.user_permanent;
  //   }
  //   if (req.query && req.query.user_newborn_exp) {
  //     searchArr.user_newborn_exp = req.query.user_newborn_exp;
  //   }
  //   if (req.query && req.query.user_sick_kids) {
  //     searchArr.user_sick_kids = req.query.user_sick_kids;
  //   }
  //   if (searchArr && Object.keys(searchArr).length > 0) {
  //     searchSql = searchSql + ' AND ' + Object.keys(searchArr).map((key) => {
  //       const val = searchArr[key];
  //       return `${key}='${val}'`;
  //     }).join(' AND ');
  //   }

  $search_query_sql = "select user_first_name, user_last_name, user_description,
    cpr_approve, background_approve, newborn_approve, 
    user_college, user_college_name, user_high_school, user_high_school_name, 
    user_image, UM.user_id 
    from user_management as UM
    JOIN user_information as UI ON UM.user_id=UI.user_id
    WHERE UM.user_type='sitter'
    AND user_status=1
    order by UI.user_first_name";
														
  $search_query = mysql_query($search_query_sql);
  $num = mysql_num_rows($search_query);
  $data = array();
  
  while ($job = mysql_fetch_object($search_query)) {
      $data[] = $job;
  }
  
  $response = array('code' => 200, 'message' => array('results' => $data, 'total' => $num));
  echo json_encode($response); exit;
  