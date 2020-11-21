<?php
error_reporting(0);
include('includes/connection.php');
require_once("AuthnetARB.class.php");

//sleep(2);
//die('{"error": true, "msg": "Test error"}');


function dieJSONError($error)
{
    die('{"error": true, "msg": "' . $error . '"}');
}

function dieJSONSuccess($redirect)
{
    die('{"error": false, "red": "' . $redirect . '"}');
}

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
        dieJSONError("An unexpected error has occurred. Please try again.");
}

/**
 * Processes the sitter login form
 */
function processSitterLogin()
{
    global $db;
    $user_name = (isset($_POST['username'])) ? $_POST['username'] : NULL;
    $user_password = (isset($_POST['password'])) ? $_POST['password'] : NULL;

    $R = $db->first("select m.*, i.location_code as zip, i.location_id
    from user_management m
    left join user_information i ON i.user_id = m.user_id
    where m.user_name=:user_name
    AND m.user_password=:user_password
    AND m.user_type = 'sitter'", [
        'user_name' => $user_name,
        'user_password' => md5($user_password)
    ]);

    if ($R) {
        if ($R->user_status != 1) {
            $message = file_get_contents('account-activation.html');
            $message = str_replace('%USERNAME%', $R->user_name, $message);
            $message = str_replace('%COMMENT%', 'Our Sitter List Founders are working hard at processing your application and we will respond your application within 36 hours.');


            require_once BASEPATH . 'class.MailUtil.php';
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

            dieJSONError('Your Account is Not Activated Yet.<br>An email has been sent and you are waiting for approval.');
        } else {
            $_SESSION['user_id'] = $R->user_id;
            $_SESSION['user_name'] = $R->user_name;
            $_SESSION['user_type'] = 'sitter';
            $_SESSION['user_zip'] = $R->zip;
            $_SESSION['user_location_id'] = getUserLocation($R->user_id, $R->zip, $R->location_id);

            if (isset($_REQUEST['redirect']) && $_REQUEST['redirect']) {
                $redirect = urldecode($_REQUEST['redirect']);
            } else {
                $redirect = '/sitter_dashboard.php';
            }

            dieJSONSuccess($redirect);
        }
    } else {
        dieJSONError('Invalid or incorrect username/password. Please check your login credentials and try again.');
    }
}

/**
 * Processes the family login form
 */
function processFamilyLogin()
{
    global $db;
    $user_name = (isset($_POST['username'])) ? $_POST['username'] : NULL;
    $user_password = (isset($_POST['password'])) ? $_POST['password'] : NULL;

    $R = $db->first("select m.*, i.location_code as zip, i.location_id
                        from user_management m
                        left join user_information i ON i.user_id = m.user_id
                      where m.user_name=:user_name
                      AND m.user_password=:user_password
                      AND m.user_type = 'family'", [
                        'user_name' => $user_name,
                        'user_password' => md5($user_password)
                    ]);


    if ($R) {
        //var_dump($R);die;
        if ($R->user_status != 1) {
            try {
                $message = file_get_contents('account-activation.html');
                $message = str_replace('%USERNAME%', $R->user_name, $message);
                $message = str_replace('%COMMENT%', 'Our Sitter List Founders are working hard at processing your application and we will respond your application within 36 hours.');
                require_once BASEPATH . 'class.MailUtil.php';
                $mail = MailUtil::getMailerWhitney();
                $mail->Debugoutput = 'html';
//				  $mail->setFrom($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
                $mail->addAddress($R->user_email, $R->user_name);

                //$mail->addAddress('chrisperando@gmail.com');
                //$mail->addAddress('crisperando@yahoo.com');
                $mail->Subject = 'Family Account Activation';
                $mail->msgHTML($message);
                $mail->AltBody = 'This is a plain-text message body';
                $mail->send();
            } catch (Exception $e) {
                // do nothing
            }

            // return error
            dieJSONError('Your Account is Not Activated Yet. An email has been sent and you are waiting for approval.');
        } else if ($R->is_payment_status != 1 && !$R->promo_code) {
            $_SESSION['user_id_member_choose'] = $R->user_id;
            $_SESSION['user_name_member_choose'] = $R->user_name;
            $_SESSION['user_type_member_choose'] = 'family';
//echo date('d M, Y',$R->user_expierydate);exit;
//            header('Location:'.$base_path.'/family_app_member.php');

            // redirect to membership page
            dieJSONSuccess(BASEPATH . '/family_app_member.php');
        } else if ($R->user_expierydate && $R->user_expierydate < strtotime('now')) {
            dieJSONError('Your Account is expired. Please contact us to renew your subscription.');
        } else {
            $_SESSION['user_id'] = $R->user_id;
            $_SESSION['user_name'] = $R->user_name;
            $_SESSION['user_type'] = 'family';
            $_SESSION['user_zip'] = $R->zip;
            $_SESSION['user_location_id'] = getUserLocation($R->user_id, $R->zip, $R->location_id);

//echo date('d M, Y',$R->user_expierydate);exit;

            if (!$R->user_subscriberid && !$R->promo_code) {
                $_SESSION['user_id_member_choose'] = $R->user_id;
                $_SESSION['user_name_member_choose'] = $R->user_name;
                $_SESSION['user_type_member_choose'] = 'family';
                $_SESSION['user_old_subscriberid'] = $R->user_subscriberid;
                $_SESSION['_sub_expired'] = true;
                dieJSONSuccess(BASEPATH . '/family_app_member.php?expired=1');
            }

            // check subscription
            if ($R->promo_code) {
                $_SESSION['_sub_expired'] = false;
            } else {

                if ((int)$R->payment_error == 1) {
                    redirectToFamilyError($R, 2);
                    return;
                }
                try {
                    $login = $db->first("SELECT `settingValue` FROM `setting` WHERE `id`='8'")->settingValue;
                    $transkey = $db->first("SELECT `settingValue` FROM `setting` WHERE `id`='9'")->settingValue;

                    if ($login && $transkey) {

                        $arb = new AuthnetARB($login, $transkey, false);
                        $arb->getAccountStatus($R->user_subscriberid);

                        $resp = $arb->response;
                        if ($resp) {
                            $split = explode('<Status>', $resp);
                            if (count($split) > 1) {
                                $split2 = explode('</Status>', $split[1]);
                                //    print_r($split2);die();

                                $status = trim($split2[0]);


                                if ($status === 'canceled') {
                                    redirectToFamilyError($R, 4);
                                } else if ($status === 'expired') {
                                    redirectToFamilyError($R, 3);
                                } else {
                                    $_SESSION['_sub_expired'] = false;
                                }
                            } else {
                                $_SESSION['_sub_expired'] = false;
                            }
                        } else {
                            $_SESSION['_sub_expired'] = false;
                        }
                    }
                } catch (Exception $terr) {
                    // do nothing
                    $_SESSION['_sub_expired'] = false;
                }
            }


            // redirect
            if (isset($_REQUEST['redirect']) && $_REQUEST['redirect']) {
                $redirect = urldecode($_REQUEST['redirect']);
            } else {
                $redirect = '/family_dashboard.php';
            }

            dieJSONSuccess($redirect);
        }
    } else {
        dieJSONError('Invalid or incorrect username/password. Please check your login credentials and try again.');
    }
}

function redirectToFamilyError($R, $code = 1)
{
    mail('sethcriedel@gmail.com', 'EXPIRED OSL SUBSCRIPTION', print_r($R, true), 'From: oursitterlist@gmail.com');
    $_SESSION['_sub_expired'] = true;

    $_SESSION['user_id_member_choose'] = $R->user_id;
    $_SESSION['user_name_member_choose'] = $R->user_name;
    $_SESSION['user_type_member_choose'] = 'family';
    $_SESSION['user_old_subscriberid'] = $R->user_subscriberid;

    if ($code === 3) {
        dieJSONSuccess(BASEPATH . '/cc_update.php?expired=' . $code);
    } else {
        dieJSONSuccess(BASEPATH . '/family_app_member.php?expired=' . $code);
    }
}

function getUserLocation($userId, $zip, $locationId)
{
    global $db;
    if ((int)$locationId > 0) {
        // die('Already has location: ' . $locationId);
        return $locationId;
    }

    // check ZIP code
    if (!$zip || strlen($zip) !== 5) {
        //die('No ZIP! ' . $zip);
        return 1;
    }

    $r = $db->first("SELECT location_id FROM zip_code WHERE zip =:zip",[
        'zip' => $zip
    ]);

    if ($r) {
        return 1;
    }

    $db->update("user_information SET location_id =:location_id. WHERE user_id =:user_id",[
        'location_id' => $r->location_id,
        'user_id' => $user_id
    ]);

    return $r->location_id;
}
