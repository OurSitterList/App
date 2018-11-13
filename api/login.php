<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/AuthnetARB.class.php");


// process login
  var_dump($_POST);
$type = (isset($_POST['type'])) ? $_POST['type'] : null;
switch ($type) {
  // sitter login
  case 'sitter':
      processSitterLogin();
      break;

  // family login
  case 'family':
      processFamilyLogin();
      break;

  // we should never get here...
  default:
    $response	= array('code' => 400, 'message' => 'User type must be either "sitter" or "family".');
    echo json_encode($response); exit;
}



/**
 * Processes the sitter login form
 */
function processSitterLogin() {
  $user_name			= (isset($_POST['username'])) ? $_POST['username'] : NULL;
  $user_password		= (isset($_POST['password'])) ? $_POST['password'] : NULL;
  $sql	= "select m.*, i.location_code as zip, i.location_id
  from user_management m
  left join user_information i ON i.user_id = m.user_id
  where m.user_name='".mysql_real_escape_string($user_name)."'
  AND m.user_password='".mysql_real_escape_string(md5($user_password))."'
  AND m.user_type = 'sitter'";

  $user_search = mysql_query($sql);
  if(mysql_num_rows($user_search)>0) {
    $R=  mysql_fetch_object($user_search);
    if( $R->user_status!=1 ) {
      $message = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/account-activation.html');
      $message = str_replace('%USERNAME%', $R->user_name, $message);
      $message = str_replace('%COMMENT%','Our Sitter List Founders are working hard at processing your application and we will respond your application within 36 hours.');

      require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';
      $mail = MailUtil::getMailerWhitney();
      $mail->Debugoutput = 'html';

      $mail->setFrom($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
      $mail->addAddress($R->user_email, $R->user_name);

      //$mail->addAddress('chrisperando@gmail.com');
      //$mail->addAddress('crisperando@yahoo.com');
      $mail->Subject = 'Sitter Account Activation';
      $mail->msgHTML($message);
      $mail->AltBody = 'This is a plain-text message body';
      $mail->send();

      $response	= array('code' => 400, 'message' => 'Your Account is Not Activated Yet.<br>An email has been sent and you are waiting for approval.');
      echo json_encode($response); exit;
    } else {
      $_SESSION['user_id'] = $R->user_id;
      $_SESSION['user_name'] = $R->user_name;
      $_SESSION['user_type'] = 'sitter';
      $_SESSION['user_zip'] = $R->zip;
      $_SESSION['user_location_id'] = getUserLocation($R->user_id, $R->zip, $R->location_id);

      $response	= array('code' => 200, 'message' => 'Login successful!');
      echo json_encode($response); exit;
    }
  } else {
    dieJSONError('Invalid or incorrect username/password. Please check your login credentials and try again.');
  }
}


function processFamilyLogin() {
  echo "family login"; exit;
}