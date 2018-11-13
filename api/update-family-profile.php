<?php

/**
 * $user_id
 * $user_first_name
 * $user_middle_name
 * $user_last_name
 * $user_cell_phone
 * $user_contact_email
 * $user_contact_address
 * $user_current_address
 * $is_user_agree_to_houseplans
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
    
  $search_query = mysql_query("select * from  user_information where user_id='".$user_id."'");

  if (mysql_num_rows($search_query) > 0) {
    
    if (is_uploaded_file($_FILES['user_image']['tmp_name'])) {
      $old_img = mysql_fetch_object($search_query)->user_image;
      if (is_file('images/user_images/'.$old_img)) {
        unlink('images/user_images/'.$old_img);
      }		
      $user_image = time().str_replace(' ','_',$_FILES['user_image']['name']);
      move_uploaded_file($_FILES['user_image']['tmp_name'],'images/user_images/'.$user_image);
      
    } else {
      $user_image = mysql_fetch_object($search_query)->user_image;
    }

    $update_query = "UPDATE user_information set
      `user_first_name`= '".mysql_real_escape_string($user_first_name)."',
      `user_middle_name`= '".mysql_real_escape_string($user_middle_name)."',
      `user_last_name` = '".mysql_real_escape_string($user_last_name)."',
      `user_cell_phone`= '".mysql_real_escape_string($user_cell_phone)."',
      `user_image`= '".mysql_real_escape_string($user_image)."',
      `user_contact_email` = '".mysql_real_escape_string($user_contact_email)."',
      `user_contact_address`= '".mysql_real_escape_string($user_contact_address)."',
      `user_current_address`= '".mysql_real_escape_string($user_current_address)."',
      `is_user_agree_to_houseplans`= '".mysql_real_escape_string($is_user_agree_to_houseplans)."'
      where user_id='".$user_id."'";
  } else {
    if (is_uploaded_file($_FILES['user_image']['tmp_name'])) {
      $user_image = time().str_replace(' ','_',$_FILES['user_image']['name']);
      move_uploaded_file($_FILES['user_image']['tmp_name'],'images/user_images/'.$user_image);
    } else {
      $user_image='';
    }
    $update_query = "INSERT into user_information set
      `user_id`= '".$user_id."',
      `user_first_name`= '".mysql_real_escape_string($user_first_name)."',
      `user_middle_name`= '".mysql_real_escape_string($user_middle_name)."',
      `user_last_name` = '".mysql_real_escape_string($user_last_name)."',
      `user_cell_phone`= '".mysql_real_escape_string($user_cell_phone)."',
      `user_contact_email` = '".mysql_real_escape_string($user_contact_email)."',
      `user_image`= '".mysql_real_escape_string($user_image)."',
      `user_contact_address`= '".mysql_real_escape_string($user_contact_address)."',
      `is_user_agree_to_houseplans`= '".mysql_real_escape_string($is_user_agree_to_houseplans)."',
      `user_current_address`= '".mysql_real_escape_string($user_current_address)."'";
  }

  mysql_query($update_query);

  $response	= array('code' => 200, 'message' => 'Success.');
  echo json_encode($response); exit;

} catch (Exception $e) {
  $response	= array('code' => 400, 'message' => 'Error.');
  echo json_encode($response); exit;
}