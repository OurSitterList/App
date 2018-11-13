<?php

/**
 * $user_id
 * $user_first_name
 * $user_last_name
 * $user_driver_license
 * $user_firstaid_training
 * $user_date_of_certification
 * $is_user_willing_to_certified
 * $user_cpr_training
 * $user_newborn_cpr_training
 * $user_food_allergies
 * $user_overnight
 * $user_travel
 * $user_permanent
 * $user_newborn_exp
 * $user_sick_kids
 * $user_date_of_certification_cpr
 * $is_user_willing_to_certified_cpr
 * $user_cell_phone
 * $user_contact_email
 * $user_emergency_contact
 * $location_code
 * $is_user_agree_to_houseplans
 * $user_age
 * $user_school_affliation
 * $user_biography
 * $user_description
 * $user_high_school
 * $user_high_school_name
 * $user_college
 * $user_college_name
 * $user_ref1_name
 * $user_ref1_role
 * $user_ref1_age
 * $user_ref1_length
 * $user_ref2_name
 * $user_ref2_role
 * $user_ref2_age
 * $user_ref2_length
 * $user_babysitting_exp
 * $user_available_mon_start1
 * $user_available_mon_start2
 * $user_available_mon_start3
 * $user_available_mon_end1
 * $user_available_mon_end2
 * $user_available_mon_end3
 * $user_available_tue_start1
 * $user_available_tue_start2
 * $user_available_tue_start3
 * $user_available_tue_end1
 * $user_available_tue_end2
 * $user_available_tue_end3
 * $user_available_wed_start1
 * $user_available_wed_start2
 * $user_available_wed_start3
 * $user_available_wed_end1
 * $user_available_wed_end2
 * $user_available_wed_end3
 * $user_available_thu_start1
 * $user_available_thu_start2
 * $user_available_thu_start3
 * $user_available_thu_end1
 * $user_available_thu_end2
 * $user_available_thu_end3
 * $user_available_fri_start1
 * $user_available_fri_start2
 * $user_available_fri_start3
 * $user_available_fri_end1
 * $user_available_fri_end2
 * $user_available_fri_end3
 * $user_available_sat_start1
 * $user_available_sat_start2
 * $user_available_sat_start3
 * $user_available_sat_end1
 * $user_available_sat_end2
 * $user_available_sat_end3
 * $user_available_sun_start1
 * $user_available_sun_start2
 * $user_available_sun_start3
 * $user_available_sun_end1
 * $user_available_sun_end2
 * $user_available_sun_end3
 */

include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

// var_dump($_POST);
// var_dump($_FILES);
// exit;

extract($_POST);

if (!$user_id) {
  echo json_encode(array('code' => 401, 'message' => 'User ID is required.')); exit;
}

try {   
  $mon_s = array_filter(array($user_available_mon_start1,$user_available_mon_start2,$user_available_mon_start3));
  $mon_e = array_filter(array($user_available_mon_end1,$user_available_mon_end2,$user_available_mon_end3));
  $mon_s = join(',', $mon_s);
  $mon_e = join(',', $mon_e);
    
  $tue_s = array_filter(array($user_available_tue_start1,$user_available_tue_start2,$user_available_tue_start3));
  $tue_e = array_filter(array($user_available_tue_end1,$user_available_tue_end2,$user_available_tue_end3));
  $tue_s = join(',', $tue_s);
  $tue_e = join(',', $tue_e);

  $wed_s = array_filter(array($user_available_wed_start1,$user_available_wed_start2,$user_available_wed_start3));
  $wed_e = array_filter(array($user_available_wed_end1,$user_available_wed_end2,$user_available_wed_end3));
  $wed_s = join(',', $wed_s);
  $wed_e = join(',', $wed_e);

  $thu_s = array_filter(array($user_available_thu_start1,$user_available_thu_start2,$user_available_thu_start3));
  $thu_e = array_filter(array($user_available_thu_end1,$user_available_thu_end2,$user_available_thu_end3));
  $thu_s = join(',', $thu_s);
  $thu_e = join(',', $thu_e);

  $fri_s = array_filter(array($user_available_fri_start1,$user_available_fri_start2,$user_available_fri_start3));
  $fri_e = array_filter(array($user_available_fri_end1,$user_available_fri_end2,$user_available_fri_end3));
  $fri_s = join(',', $fri_s);
  $fri_e = join(',', $fri_e);

  $sat_s = array_filter(array($user_available_sat_start1,$user_available_sat_start2,$user_available_sat_start3));
  $sat_e = array_filter(array($user_available_sat_end1,$user_available_sat_end2,$user_available_sat_end3));
  $sat_s = join(',', $sat_s);
  $sat_e = join(',', $sat_e);

  $sun_s = array_filter(array($user_available_sun_start1,$user_available_sun_start2,$user_available_sun_start3));
  $sun_e = array_filter(array($user_available_sun_end1,$user_available_sun_end2,$user_available_sun_end3));
  $sun_s = join(',', $sun_s);
  $sun_e = join(',', $sun_e);	
    
  $search_query = mysql_query("select * from  user_information where user_id='".$user_id."'");
  if (mysql_num_rows($search_query) > 0) {
    if (is_uploaded_file($_FILES['user_image']['tmp_name'])) {
      $old_img = mysql_fetch_object($search_query)->user_image;
      if (is_file('images/user_images/'.$old_img)){
        unlink('images/user_images/'.$old_img);
      }		
      $user_image=time().str_replace(' ','_',$_FILES['user_image']['name']);
      move_uploaded_file($_FILES['user_image']['tmp_name'],'images/user_images/'.$user_image);
    } else {
      $user_image=mysql_fetch_object($search_query)->user_image;
    }
      
    $update_query = "UPDATE user_information set
      `user_first_name`= '".mysql_real_escape_string($user_first_name)."',
      `user_last_name` = '".mysql_real_escape_string($user_last_name)."',
      `user_driver_license`= '".mysql_real_escape_string($user_driver_license)."',
      `user_firstaid_training`= '".mysql_real_escape_string($user_firstaid_training)."',
      `user_date_of_certification`= '".mysql_real_escape_string($user_date_of_certification)."',
      `is_user_willing_to_certified`= '".mysql_real_escape_string($is_user_willing_to_certified)."',
      `user_cpr_training`= '".mysql_real_escape_string($user_cpr_training)."',
      `user_newborn_cpr_training`= '".mysql_real_escape_string($user_newborn_cpr_training)."',
      `user_food_allergies`= '".mysql_real_escape_string($user_food_allergies)."',
      `user_overnight`= '".mysql_real_escape_string($user_overnight)."',
      `user_travel`= '".mysql_real_escape_string($user_travel)."',
      `user_permanent`= '".mysql_real_escape_string($user_permanent)."',
      `user_newborn_exp`= '".mysql_real_escape_string($user_newborn_exp)."',
      `user_sick_kids`= '".mysql_real_escape_string($user_sick_kids)."',
      `user_date_of_certification_cpr` = '".mysql_real_escape_string($user_date_of_certification_cpr)."',
      `is_user_willing_to_certified_cpr`= '".mysql_real_escape_string($is_user_willing_to_certified_cpr)."',
      `user_cell_phone`= '".mysql_real_escape_string($user_cell_phone)."',
      `user_contact_email` = '".mysql_real_escape_string($user_contact_email)."',
      `user_emergency_contact`= '".mysql_real_escape_string($user_emergency_contact)."',
      `location_code`= '".mysql_real_escape_string($location_code)."',
      `is_user_agree_to_houseplans`= '".mysql_real_escape_string($is_user_agree_to_houseplans)."',
      `user_age`= '".mysql_real_escape_string($user_age)."',
      `user_school_affliation`= '".mysql_real_escape_string($user_school_affliation)."',
      `user_image`= '".mysql_real_escape_string($user_image)."',
      `user_biography`= '".mysql_real_escape_string($user_biography)."',
      `user_description`= '".mysql_real_escape_string($user_description)."',
      `user_high_school`= '".mysql_real_escape_string($user_high_school)."',
      `user_high_school_name`= '".mysql_real_escape_string($user_high_school_name)."',
      `user_college`= '".mysql_real_escape_string($user_college)."',
      `user_college_name`= '".mysql_real_escape_string($user_college_name)."',
      `user_ref1_name`= '".mysql_real_escape_string($user_ref1_name)."',
      `user_ref1_role`= '".mysql_real_escape_string($user_ref1_role)."',
      `user_ref1_age`= '".mysql_real_escape_string($user_ref1_age)."',
      `user_ref1_length`= '".mysql_real_escape_string($user_ref1_length)."',
      `user_ref2_name`= '".mysql_real_escape_string($user_ref2_name)."',
      `user_ref2_role`= '".mysql_real_escape_string($user_ref2_role)."',
      `user_ref2_age`= '".mysql_real_escape_string($user_ref2_age)."',
      `user_ref2_length`= '".mysql_real_escape_string($user_ref2_length)."',
      `user_available_mon_start`= '".mysql_real_escape_string($mon_s)."',
      `user_available_tue_start`= '".mysql_real_escape_string($tue_s)."',
      `user_available_wed_start`= '".mysql_real_escape_string($wed_s)."',
      `user_available_thu_start`= '".mysql_real_escape_string($thu_s)."',
      `user_available_fri_start`= '".mysql_real_escape_string($fri_s)."',
      `user_available_sat_start`= '".mysql_real_escape_string($sat_s)."',
      `user_available_sun_start`= '".mysql_real_escape_string($sun_s)."',
      `user_available_mon_end`= '".mysql_real_escape_string($mon_e)."',
      `user_available_tue_end`= '".mysql_real_escape_string($tue_e)."',
      `user_available_wed_end`= '".mysql_real_escape_string($wed_e)."',
      `user_available_thu_end`= '".mysql_real_escape_string($thu_e)."',
      `user_available_fri_end`= '".mysql_real_escape_string($fri_e)."',
      `user_available_sat_end`= '".mysql_real_escape_string($sat_e)."',
      `user_available_sun_end`= '".mysql_real_escape_string($sun_e)."',
      `user_babysitting_exp`= '".mysql_real_escape_string($user_babysitting_exp)."'
        where user_id='".$user_id."'";
  } else {
    if (is_uploaded_file($_FILES['user_image']['tmp_name'])){
      $user_image=time().str_replace(' ','_',$_FILES['user_image']['name']);
      move_uploaded_file($_FILES['user_image']['tmp_name'],'images/user_images/'.$user_image);
    } else {
      $user_image='';
    }
    $update_query = "INSERT into user_information set
      `user_id`= '".$user_id."',
      `user_first_name`= '".mysql_real_escape_string($user_first_name)."',
      `user_last_name` = '".mysql_real_escape_string($user_last_name)."',
      `user_driver_license`= '".mysql_real_escape_string($user_driver_license)."',
      `user_firstaid_training`= '".mysql_real_escape_string($user_firstaid_training)."',
      `user_date_of_certification`= '".mysql_real_escape_string($user_date_of_certification)."',
      `is_user_willing_to_certified`= '".mysql_real_escape_string($is_user_willing_to_certified)."',
      `user_cpr_training`= '".mysql_real_escape_string($user_cpr_training)."',
      `user_newborn_cpr_training`= '".mysql_real_escape_string($user_newborn_cpr_training)."',
      `user_food_allergies`= '".mysql_real_escape_string($user_food_allergies)."',
      `user_overnight`= '".mysql_real_escape_string($user_overnight)."',
      `user_travel`= '".mysql_real_escape_string($user_travel)."',
      `user_permanent`= '".mysql_real_escape_string($user_permanent)."',
      `user_newborn_exp`= '".mysql_real_escape_string($user_newborn_exp)."',
      `user_sick_kids`= '".mysql_real_escape_string($user_sick_kids)."',
      `user_date_of_certification_cpr` = '".mysql_real_escape_string($user_date_of_certification_cpr)."',
      `is_user_willing_to_certified_cpr`= '".mysql_real_escape_string($is_user_willing_to_certified_cpr)."',
      `user_cell_phone`= '".mysql_real_escape_string($user_cell_phone)."',
      `user_contact_email` = '".mysql_real_escape_string($user_contact_email)."',
      `user_emergency_contact`= '".mysql_real_escape_string($user_emergency_contact)."',
      `location_code`= '".mysql_real_escape_string($location_code)."',
      `is_user_agree_to_houseplans`= '".mysql_real_escape_string($is_user_agree_to_houseplans)."',
      `user_age`= '".mysql_real_escape_string($user_age)."',
      `user_school_affliation`= '".mysql_real_escape_string($user_school_affliation)."',
      `user_image`= '".mysql_real_escape_string($user_image)."',
      `user_biography`= '".mysql_real_escape_string($user_biography)."',
      `user_description`= '".mysql_real_escape_string($user_description)."',
      `user_high_school`= '".mysql_real_escape_string($user_high_school)."',
      `user_high_school_name`= '".mysql_real_escape_string($user_high_school_name)."',
      `user_college`= '".mysql_real_escape_string($user_college)."',
      `user_college_name`= '".mysql_real_escape_string($user_college_name)."',
      `user_ref1_name`= '".mysql_real_escape_string($user_ref1_name)."',
      `user_ref1_role`= '".mysql_real_escape_string($user_ref1_role)."',
      `user_ref1_age`= '".mysql_real_escape_string($user_ref1_age)."',
      `user_ref1_length`= '".mysql_real_escape_string($user_ref1_length)."',
      `user_ref2_name`= '".mysql_real_escape_string($user_ref2_name)."',
      `user_ref2_role`= '".mysql_real_escape_string($user_ref2_role)."',
      `user_ref2_age`= '".mysql_real_escape_string($user_ref2_age)."',
      `user_ref2_length`= '".mysql_real_escape_string($user_ref2_length)."',
      `user_available_mon_start`= '".mysql_real_escape_string($mon_s)."',
      `user_available_tue_start`= '".mysql_real_escape_string($tue_s)."',
      `user_available_wed_start`= '".mysql_real_escape_string($wed_s)."',
      `user_available_thu_start`= '".mysql_real_escape_string($thu_s)."',
      `user_available_fri_start`= '".mysql_real_escape_string($fri_s)."',
      `user_available_sat_start`= '".mysql_real_escape_string($sat_s)."',
      `user_available_sun_start`= '".mysql_real_escape_string($sun_s)."',
      `user_available_mon_end`= '".mysql_real_escape_string($mon_e)."',
      `user_available_tue_end`= '".mysql_real_escape_string($tue_e)."',
      `user_available_wed_end`= '".mysql_real_escape_string($wed_e)."',
      `user_available_thu_end`= '".mysql_real_escape_string($thu_e)."',
      `user_available_fri_end`= '".mysql_real_escape_string($fri_e)."',
      `user_available_sat_end`= '".mysql_real_escape_string($sat_e)."',
      `user_available_sun_end`= '".mysql_real_escape_string($sun_e)."',
      `user_babysitting_exp`= '".mysql_real_escape_string($user_babysitting_exp)."'";
  }
  mysql_query($update_query);
  $response	= array('code' => 200, 'message' => 'Success.');
  echo json_encode($response); exit;

} catch (Exception $e) {
  $response	= array('code' => 400, 'message' => 'Error.');
  echo json_encode($response); exit;
}