<?php
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');
require_once($_SERVER["DOCUMENT_ROOT"] . "/AuthnetARB.class.php");

$session = array();
// process login
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
  if (mysql_num_rows($user_search)>0) {
    $R = mysql_fetch_object($user_search);
    if ($R->user_status != 1) {
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
      // $mail->send();

      $response	= array('code' => 400, 'message' => 'Your Account is Not Activated Yet.<br>An email has been sent and you are waiting for approval.');
      echo json_encode($response); exit;
    } else {
      $session['user_id'] = $R->user_id;
      $session['user_name'] = $R->user_name;
      $session['user_type'] = 'sitter';
      $session['user_zip'] = $R->zip;
      $session['user_location_id'] = getUserLocation($R->user_id, $R->zip, $R->location_id);

      $response	= array('code' => 200, 'message' => $session);
      echo json_encode($response); exit;
    }
  } else {
    $response	= array('code' => 400, 'message' => 'Invalid or incorrect username/password. Please check your login credentials and try again.');
    echo json_encode($response); exit;
  }
}


function processFamilyLogin() {
  $user_name	= (isset($_POST['username'])) ? $_POST['username'] : NULL;
  $user_password = (isset($_POST['password'])) ? $_POST['password'] : NULL;
  $user_search 	= mysql_query("select m.*, i.location_code as zip, i.location_id
    from user_management m
    left join user_information i ON i.user_id = m.user_id
    where m.user_name='".mysql_real_escape_string($user_name)."'
    AND m.user_password='".mysql_real_escape_string(md5($user_password))."'
    AND m.user_type = 'family'");

  if (mysql_num_rows($user_search)>0) {
    $R = mysql_fetch_object($user_search);
    if ( $R->user_status!=1 ) {
      try {
        $message = file_get_contents('account-activation.html');
        $message = str_replace('%USERNAME%', $R->user_name, $message);
        $message = str_replace('%COMMENT%','Our Sitter List Founders are working hard at processing your application and we will respond your application within 36 hours.');
        require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';
        $mail = MailUtil::getMailerWhitney();
        $mail->Debugoutput = 'html';
        $mail->addAddress($R->user_email, $R->user_name);

        //$mail->addAddress('chrisperando@gmail.com');
        //$mail->addAddress('crisperando@yahoo.com');
        $mail->Subject = 'Family Account Activation';
        $mail->msgHTML($message);
        $mail->AltBody = 'This is a plain-text message body';
        // $mail->send();
      } catch (Exception $e) { // do nothing
      }
      // return error
      $response	= array('code' => 400, 'message' => 'Your Account is Not Activated Yet. An email has been sent and you are waiting for approval.');
      echo json_encode($response); exit;

    } else if( $R->is_payment_status!=1 && !$R->promo_code) {
      $session['user_id_member_choose'] = $R->user_id;
      $session['user_name_member_choose'] = $R->user_name;
      $session['user_type_member_choose'] = 'family';
      $response	= array('code' => 200, 'message' => $session);
      echo json_encode($response); exit;

    } else if ( $R->user_expierydate && $R->user_expierydate < strtotime('now')) {
      $response	= array('code' => 400, 'message' => $session);
      echo json_encode($response); exit;

    } else {
      $session['user_id'] = $R->user_id;
      $session['user_name'] = $R->user_name;
      $session['user_type'] = 'family';
      $session['user_zip'] = $R->zip;
      $session['user_location_id'] = getUserLocation($R->user_id, $R->zip, $R->location_id);

      if (!$R->user_subscriberid && !$R->promo_code) {
        $session['user_id_member_choose'] = $R->user_id;
        $session['user_name_member_choose'] = $R->user_name;
        $session['user_type_member_choose'] = 'family';
        $session['user_old_subscriberid'] = $R->user_subscriberid;
        $session['_sub_expired'] = true;
        $response	= array('code' => 200, 'message' => $session);
        echo json_encode($response); exit;
      }

      // check subscription
      if ($R->promo_code) {
        $session['_sub_expired'] = false;
      } else {
        if ((int)$R->payment_error == 1) {
          redirectToFamilyError($R, 2);
        }
              
        try {
          $login = mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='8'"))->settingValue;
          $transkey = mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='9'"))->settingValue;

          if ($login && $transkey) {

            $arb = new AuthnetARB($login, $transkey, false);
            $arb->getAccountStatus($R->user_subscriberid);

            $resp = $arb->response;
            if ($resp) {
              $split = explode('<Status>', $resp);
              if (count($split) > 1) {
                $split2 = explode('</Status>', $split[1]);
                $status = trim($split2[0]);
                if ($status === 'canceled') {
                  redirectToFamilyError($R, 4);
                } else if ($status === 'expired') {
                  redirectToFamilyError($R, 3);
                } else {
                  $session['_sub_expired'] = false;
                }
              } else {
                $session['_sub_expired'] = false;
              }
            } else {
              $session['_sub_expired'] = false;
            }
          }
        } catch (Exception $terr) {
          $session['_sub_expired'] = false;
        }
      }

      $response	= array('code' => 200, 'message' => $session);
      echo json_encode($response); exit;
    }
  } else {
    $response	= array('code' => 400, 'message' => 'Invalid or incorrect username/password. Please check your login credentials and try again.');
    echo json_encode($response); exit;
  }
}


function getUserLocation($userId, $zip, $locationId) {
  if ((int)$locationId > 0){
    return $locationId;
  }

  if (!$zip || strlen($zip) !== 5) {
    return 1;
  }

  $searchSQL = "SELECT location_id FROM zip_code WHERE zip = '" . mysql_real_escape_string($zip) . "'";
  $user_search = mysql_query($searchSQL);
  if (mysql_num_rows($user_search) < 1) {
    return 1;
  }

  $r = mysql_fetch_object($user_search);

  $updateSQL = "UPDATE user_information SET location_id = '" . mysql_real_escape_string($r->location_id) . "' WHERE user_id = '" . mysql_real_escape_string($userId) . "'";
  mysql_query($updateSQL);
  return $r->location_id;
}

function redirectToFamilyError($R, $code=1) {
  $session['_sub_expired'] = true;
  $session['user_id_member_choose'] = $R->user_id;
  $session['user_name_member_choose'] = $R->user_name;
  $session['user_type_member_choose'] = 'family';
  $session['user_old_subscriberid'] = $R->user_subscriberid;

  if ($code === 3) {
    $response	= array('code' => 200, 'message' => $session);
    echo json_encode($response); exit;
  } else {
    $response	= array('code' => 200, 'message' => $session);
    echo json_encode($response); exit;
  }
}