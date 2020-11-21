<?php
Auth::_set_user_id();
require_once("AuthnetARB.class.php");

$isSignedIn = false;

function getPostMSG()
{
    if (isset($_SESSION['postmsg'])) {
        $val = $_SESSION['postmsg'];
        unset($_SESSION['postmsg']);
        return $val;
    } else {
        return '';
    }
}

function getPostMSGType()
{
    if (isset($_SESSION['postmsg_type'])) {
        $val = $_SESSION['postmsg_type'];
        unset($_SESSION['postmsg_type']);
        return $val;
    } else {
        return 'danger';
    }
}

function setPostMSG($msg, $type = '')
{
    $_SESSION['postmsg'] = $msg;
    if ($type) {
        $_SESSION['postmsg_type'] = $type;
    }
}

$title = $db->first("SELECT `settingValue` FROM `setting` WHERE `id`='2'");

?>
    <!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta name="description" content=""/>
        <meta name="author" content=""/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0,"/>
        <title><?= $title ? $title->settingValue : 'Our Sitter List'; ?></title>
        <link href="<?= $base_path ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $base_path ?>/css/fonts.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $base_path ?>/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $base_path ?>/css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $base_path ?>/css/modal.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $base_path ?>/css/custom.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $base_path ?>/css/responsive.css" rel="stylesheet" type="text/css"/>
        <link href="<?= $base_path ?>/css/fullcalendar.css" rel='stylesheet'/>
        <link href="<?= $base_path ?>/css/fullcalendar.print.css" rel='stylesheet' media='print'/>
        <link href="<?= $base_path; ?>/css/jquery.smartmarquee.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= $base_path ?>/css/mdp.css">
        <link rel="shortcut icon" type="image/x-icon" href="<?= $base_path ?>sitter/images/favicon.ico">
        <strong></strong>

        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script language="JavaScript" type="text/javascript" src="<?= $base_path ?>/js/core.js"></script>
        <script>
            $(function () {
                var today = new Date();
                $("#datepicker").datepicker({
                    minDate: 0,
                    onClose: function (selectedDate) {
                        $("#datepicker1").datepicker("option", "minDate", selectedDate);
                    }
                });
                $("#datepicker1").datepicker({
                    minDate: 0,
                    onClose: function (selectedDate) {
                        $("#datepicker").datepicker("option", "maxDate", selectedDate);
                    }
                });


                $("#jobdatepicker").datepicker({
                    minDate: 0,
                    onClose: function (selectedDate) {
                        $("#jobdatepicker1").datepicker("option", "minDate", selectedDate);
                    }
                });
                $("#jobdatepicker1").datepicker({
                    minDate: 0,
                    onClose: function (selectedDate) {
                        $("#jobdatepicker").datepicker("option", "maxDate", selectedDate);
                    }
                });
            });
        </script>
    </head>
    <body>
    <header class="header_outer">
        <div class="container">
            <div class="header_inner clearfix">
                <div class="social_top col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <ul>
                        <li><a href="https://instagram.com/oursitterlistnashville/" target="_blank"><span class="fa fa-instagram instagrm"></span></a>
                        </li>
                        <li><a href="https://www.facebook.com/oursitterlistnashville" target="_blank"><span class="fa fa-facebook facebok"></span></a>
                        </li>
                    </ul>
                    <ul>
                        <li><a href="https://twitter.com/@whschickling08"><span class="fa fa-twitter twitr"></span></a></li>
                        <li><a href="https://www.pinterest.com/whschickling08/" target="_blank"><span class="fa fa-pinterest pinta"></span></a></li>
                    </ul>
                </div>
                <div class="logo col-lg-6 col-md-6 col-sm-6 col-xs-12"><a href="<?= $base_path ?>"><img src="<?= $base_path ?>/images/logo.png"
                                                                                                        alt=""/></a></div>
                <div class="login col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <?php
                    $open_modal = "	  <div class='md-modal md-show autohide' id='modal-book_details'>
				            <div class='md-close book_details_close'></div>
				            <div class='md-content' id='md-content'>";
                    $close_modal = "</div>
				</div>";
                    ?>

                    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != '') {
                        $isSignedIn = true;
                        $A_USER = $db->get('select * from  user_management where user_id = :user_id', ['user_id' => $_SESSION['user_id']]);
                        ?>
                        <ul class="clearfix">
                            <?php if ($_SESSION['user_type'] == 'sitter') {
                                ?>
                                <li><a href="<?= $base_path ?>/sitter_dashboard.php">Hi,
                                        <?= $_SESSION['user_name'] ?>
                                    </a></li>
                                <?php
                            }
                            if ($_SESSION['user_type'] == 'family') {
                                ?>
                                <li><a href="<?= $base_path ?>/family_dashboard.php">Hi,
                                        <?= $_SESSION['user_name'] ?>
                                    </a></li>
                                <?php
                            }
                            ?>
                            <li>/</li>
                            <li><a href="<?= $base_path ?>/logout.php">Logout</a></li>
                        </ul>
                        <?php
                    } else {
                        ?>
                        <ul class="clearfix">
                            <li><a id="loginLink" href="#" class="md-trigger" data-modal="modal-16" onclick="toggleLoginPane()">Login</a></li>
                            <li>/</li>
                            <li><a href="<?= $base_path ?>/#signuparea">Sign Up</a></li>
                        </ul>
                        <?php
                    }
                    ?>
                    <?php if (isset($_REQUEST['reset_pass']) && $_REQUEST['reset_pass'] == 1) {
                        echo '<script>$("document").ready(function() { $("#modal-password-retrieve").addClass("md-show");});</script>';
                    }
                    ?>
                    <?php if (isset($_POST['sitter_loginForm']) && $_POST['sitter_loginForm'] == 'yes') {
                        $user_name = (isset($_POST['user_name'])) ? $_POST['user_name'] : NULL;
                        $user_password = (isset($_POST['user_password'])) ? $_POST['user_password'] : NULL;

                        $R = $db->first('select * from user_management where 
			  			user_name=:user_name 
						AND user_password=:user_password
						AND user_type = "sitter"', [
                            'user_name' => $user_name,
                            'user_password' => md5($user_password)
                        ]);

                        if ($R) {
                            if ($R->user_status != 1) {
                                echo "
				<div class='md-modal md-effect-book_details md-show' id='modal-book_details'>
				            <div class='md-close book_details_close'></div>
				            <div class='md-content' id='md-content'>
				                              <div class='error-login' style='box-shadow: none !important;'>Your Account is Not Activated Yet.<br>An email has been sent and you are waiting for approval.</div>
				            </div>
				</div>";

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
                            } else {
                                $_SESSION['user_id'] = $R->user_id;
                                $_SESSION['user_name'] = $R->user_name;
                                $_SESSION['user_type'] = 'sitter';

                                if (isset($_REQUEST['redirect']) && $_REQUEST['redirect']) {
                                    $redirect = urldecode($_REQUEST['redirect']);
                                } else {
                                    $redirect = '/sitter_dashboard.php';
                                }
                                header('Location:' . $base_path . $redirect);
                                exit();
                            }
                        } else {
                            echo "$open_modal<div class='error-login' style='box-shadow: none !important;'>Username & Password Doesn't match</div>$close_modal";
                        }
                    }

                    if (isset($_REQUEST['passchange']) && $_REQUEST['passchange'] == 1) {
                        echo "$open_modal<div class='error-login' style='box-shadow: none !important;'>Your password has been reset.</div>$close_modal";
                    }
                    if (isset($_SESSION['family_acc_create']) && $_SESSION['family_acc_create'] == 1) {
                        echo "$open_modal<div class='error-login' style='box-shadow: none !important;'>Family account has been created. Wait For approval.</div>$close_modal";
                        unset($_SESSION['family_acc_create']);
                    }

                    if (isset($_SESSION['sitter_acc_create']) && $_SESSION['sitter_acc_create'] == 1) {
                        echo "$open_modal<div class='error-login' style='box-shadow: none !important;'>Sitter account has been created. Wait For approval.</div>$close_modal";
                        unset($_SESSION['sitter_acc_create']);
                    }

                    if (isset($_POST['family_loginForm']) && $_POST['family_loginForm'] == 'yes') {
                        $user_name = (isset($_POST['user_name'])) ? $_POST['user_name'] : NULL;
                        $user_password = (isset($_POST['user_password'])) ? $_POST['user_password'] : NULL;

                        $R = $db->first('select * from user_management where 
									  user_name=:user_name  
									  AND user_password=:user_password 
									  AND user_type = "family"', [
                            'user_name' => $user_name,
                            'user_password' => md5($user_password)
                        ]);

                        if ($R) {
                            if ($R->user_status != 1) {
                                // echo "<div class='error-login'>Your Account is Not Activated Yet</div>";
                                echo "
						<div class='md-modal md-effect-book_details md-show' id='modal-book_details'>
						            <div class='md-close book_details_close'></div>
						            <div class='md-content' id='md-content'>
						                              <div class='error-login' style='box-shadow: none !important;'>Your Account is Not Activated Yet.<br>An email has been sent and you are waiting for approval.</div>
						            </div>
						</div>";
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

                            } else if ($R->is_payment_status != 1) {
                                $_SESSION['user_id_member_choose'] = $R->user_id;
                                $_SESSION['user_name_member_choose'] = $R->user_name;
                                $_SESSION['user_type_member_choose'] = 'family';
//echo date('d M, Y',$R->user_expierydate);exit;
                                header('Location:' . $base_path . '/family_app_member.php');
                            } else if ($R->user_expierydate && $R->user_expierydate < strtotime('now')) {
                                echo "$open_modal<div class='error-login' style='box-shadow: none !important;'>Your Account is expired</div>$close_modal";
                            } else {
                                $_SESSION['user_id'] = $R->user_id;
                                $_SESSION['user_name'] = $R->user_name;
                                $_SESSION['user_type'] = 'family';
//echo date('d M, Y',$R->user_expierydate);exit;

                                if (!$R->user_subscriberid) {
                                    $_SESSION['user_id_member_choose'] = $R->user_id;
                                    $_SESSION['user_name_member_choose'] = $R->user_name;
                                    $_SESSION['user_type_member_choose'] = 'family';
                                    $_SESSION['user_old_subscriberid'] = $R->user_subscriberid;
                                    $_SESSION['_sub_expired'] = true;
                                    header('Location:' . $base_path . '/family_app_member.php?expired=65432');
                                    exit;
                                }

                                // check suscription
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


                                                if ($status === 'expired' || $status === 'canceled') {
                                                    mail('sethcriedel@gmail.com', 'EXPIRED OSL SUBSCRIPTION', print_r($R, true), 'From: oursitterlist@gmail.com');
                                                    $_SESSION['_sub_expired'] = true;

                                                    $_SESSION['user_id_member_choose'] = $R->user_id;
                                                    $_SESSION['user_name_member_choose'] = $R->user_name;
                                                    $_SESSION['user_type_member_choose'] = 'family';
                                                    $_SESSION['user_old_subscriberid'] = $R->user_subscriberid;
                                                    header('Location:' . $base_path . '/family_app_member.php?expired=123456');
                                                    exit;
                                                } else {
                                                    $_SESSION['_sub_expired'] = false;
                                                }
                                            } else {
                                                $_SESSION['_sub_expired'] = false;
                                                return true;
                                            }
                                        } else {
                                            $_SESSION['_sub_expired'] = false;
                                        }
                                    }
                                } catch (Exception $terr) {
                                    // do nothing
                                    $_SESSION['_sub_expired'] = false;
                                }

                                // redirect
                                if (isset($_REQUEST['redirect']) && $_REQUEST['redirect']) {
                                    $redirect = urldecode($_REQUEST['redirect']);
                                } else {
                                    $redirect = $base_path.'/family_dashboard.php';
                                }
                                header('Location:' . $base_path . $redirect);
                                exit();
                            }
                        } else {
                            echo "$open_modal<div class='error-login' style='box-shadow: none !important;'>Username & Password Doesn't match</div>$close_modal";
                        }
                    }
                    ?>
                    <?php if (isset($_POST['sitter_forgetForm']) && $_POST['sitter_forgetForm'] == 'yes') {
                        // print_r($_POST); die;
                        $admin_contact_email = $db->first("SELECT `settingValue` FROM `setting` WHERE `id`='1'");
                        $admin_contact_name = $db->first("SELECT `settingValue` FROM `setting` WHERE `id`='4'");
                        $R = $db->first("select * from user_management where user_name=:user_name AND user_type = 'sitter' AND user_status = '1'", [
                            'user_name' => $_POST['user_name']
                        ]);
                        if ($R) {
                            $generate_code = time() . rand(0, 100000000);
                            $db->update("user_management set user_code='" . $generate_code . "' where user_name=:user_name AND user_type = 'sitter' AND user_status = '1'", [
                                'user_name' => $_POST['user_name']
                            ]);
                            $message = file_get_contents('contact-form.html');
                            $message = str_replace('%FULL_NAME%', $R->user_name, $message);
                            $message = str_replace('%EMAIL%', $R->user_email, $message);
                            $message = str_replace('%AS%', 'Sitter', $message);
                            

                            $message = str_replace('%COMMENT%', 'To Reset Your Password <a href ="https://www.oursitterlist.com/?reset_pass=1&reset_code=' . $generate_code . '">Click Here</a> or copy this link in your browser https://www.oursitterlist.com/?reset_pass=1&reset_code=' . $generate_code, $message);
                            // echo "$open_modal<div class='error-login' style='box-shadow: none !important;'>A email has been sent to your registered account</div>$close_modal";
                            require_once BASEPATH . 'class.MailUtil.php';
                            $mail = MailUtil::getMailerWhitney();
                            $mail->Debugoutput = 'html';
//				  $mail->setFrom($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
                            $mail->addAddress($R->user_email, $R->user_name);
                            //$mail->addAddress('sethcriedel@gmail.com', 'Seth Riedel');

                            //$mail->addAddress('chrisperando@gmail.com');
                            //$mail->addAddress('crisperando@yahoo.com');
                            $mail->Subject = 'Reset - Sitter Account Password';
                            $mail->msgHTML($message);
                            $mail->AltBody = 'This is a plain-text message body';
                            if (!$mail->send()) {
                                echo "<div class='error-login'>" . $mail->ErrorInfo . "</div>";

                            } else {
                                echo "$open_modal<div class='error-login' style='box-shadow: none !important;'>A email has been sent to your registered account</div>$close_modal";
                            }
                        } else {
                            echo "$open_modal<div class='error-login' style='box-shadow: none !important;'>Username Doesn't exist</div>$close_modal";
                        }
                    }

                    if (isset($_POST['family_forgetForm']) && $_POST['family_forgetForm'] == 'yes') {
                        $admin_contact_email = $db->first("SELECT `settingValue` FROM `setting` WHERE `id`='1'");
                        $admin_contact_name = $db->first("SELECT `settingValue` FROM `setting` WHERE `id`='4'");
                        $R = $db->first("select * from user_management where user_name=:user_name  AND user_type = 'family' AND user_status = '1'",[
                                'user_name' => $_POST['user_name']
                        ]);
                        if ($R) {
                            $generate_code = time() . rand(0, 100000000);
                            $db->update("user_management set user_code='" . $generate_code . "' where user_name=:user_name AND user_type = 'family' AND user_status = '1'",[
                                    'user_name' => $_POST['user_name']
                            ]);
                            $message = file_get_contents('contact-form.html');
                            $message = str_replace('%FULL_NAME%', $R->user_name, $message);
                            $message = str_replace('%EMAIL%', $R->user_email, $message);
                            $message = str_replace('%AS%', 'Family', $message);
                            $message = str_replace('%COMMENT%', 'To Reset Your Password <a href ="https://www.oursitterlist.com/?reset_pass=1&reset_code=' . $generate_code . '">Click Here</a> or copy this link in your browser https://www.oursitterlist.com/?reset_pass=1&reset_code=' . $generate_code, $message);

                            require_once BASEPATH . 'class.MailUtil.php';
                            $mail = MailUtil::getMailerWhitney();
                            $mail->Debugoutput = 'html';
//				  $mail->setFrom($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
                            $mail->addAddress($R->user_email, $R->user_name);
                            //$mail->addAddress('sethcriedel@gmail.com', 'Seth Riedel');

                            //$mail->addAddress('chrisperando@gmail.com');
                            //$mail->addAddress('crisperando@yahoo.com');
                            $mail->Subject = 'Reset - Family Account Password';
                            $mail->msgHTML($message);
                            $mail->AltBody = 'This is a plain-text message body';
                            if (!$mail->send()) {
                                echo "<div class='error-login'>" . $mail->ErrorInfo . "</div>";
                            } else {
                                echo "$open_modal<div class='error-login' style='box-shadow: none !important;'>A email has been sent to your registered account</div>$close_modal";

                            };
                        } else {
                            echo "$open_modal<div class='error-login' style='box-shadow: none !important;'>Username Doesn't exist</div>$close_modal";
                        }

                    }
                    ?>
                    <div class="md-modal md-effect-16" id="modal-16">
                        <div class="md-close">X</div>
                        <div id="loginLoader" style="display: none">Please wait while we sign you in... <br/><br/><img
                                    src="/images/ajax-loader-blue.gif"/></div>
                        <div class="md-content" id="loginWindowContent">
                            <div class="sitter_log">
                                <div class="log_head"><span></span>
                                    <h3>Sitter Login</h3>
                                    <div id="sitter_login_error" class="alert alert-danger" style="display: none; margin-bottom: 0px;"></div>
                                </div>
                                <div class="sitter_form" id="sitter_login_form">
                                    <form action="action.php?do<?php if (isset($_REQUEST['redirect']) && $_REQUEST['redirect']) echo "&redirect=" . urlencode($_REQUEST['redirect']); ?>"
                                          id="sitter_loginForm" method="post">
                                        <input type="hidden" name="sitter_loginForm" value="yes">
                                        <input type="text" placeholder="Enter Username" class="sitter_input" name="user_name"
                                               id="sitter_login_username"/>
                                        <input type="password" placeholder="Enter Password" class="sitter_input" name="user_password"
                                               id="sitter_login_password"/>
                                        <div id="sitter_login_buttons">
                                            <input type="button" value="Login" class="login_sub_btn" id="sitter_login_button"/>
                                            <input type="button" value="Forget Password" class="login_sub_btn" onClick="call_forget_area('sitter')"/>
                                        </div>
                                        <div id="sitter_login_loader" style="display: none; color: #005982;"><img src="/images/ajax-loader-blue.gif"/>
                                            Signing in...
                                        </div>
                                    </form>
                                </div>
                                <div class="sitter_form" id="sitter_forget_form" style="display:none;">
                                    <form action="<?= $_SERVER['PHP_SELF'] ?>" id="sitter_forgetForm" method="post">
                                        <input type="hidden" name="sitter_forgetForm" value="yes">
                                        <input type="text" placeholder="Enter Username" class="sitter_input" name="user_name"
                                               id="sitter_forget_username"/>
                                        <input type="submit" value="Send" class="login_sub_btn"/>
                                        <input type="button" value="Back to Login" class="login_sub_btn" onClick="call_login_area('sitter')"/>
                                    </form>
                                </div>
                            </div>
                            <div class="family_log">
                                <div class="log_head"><span></span>
                                    <h3>Family Login</h3>
                                    <div id="family_login_error" class="alert alert-danger" style="display: none; margin-bottom: 0px;"></div>
                                </div>
                                <div class="sitter_form" id="family_login_form">
                                    <form action="action.php?<?php if (isset($_REQUEST['redirect']) && $_REQUEST['redirect']) echo "redirect=" . urlencode($_REQUEST['redirect']); ?>"
                                    " id="sitter_loginForm" method="post">
                                    <input type="hidden" name="family_loginForm" value="yes">
                                    <input type="text" placeholder="Enter Username" class="sitter_input" name="user_name" id="family_login_username"/>
                                    <input type="password" placeholder="Enter Password" class="sitter_input" name="user_password"
                                           id="family_login_password"/>
                                    <div id="family_login_buttons">
                                        <input type="button" value="Login" class="login_sub_btn" id="family_login_button"/>
                                        <input type="button" value="Forget Password" class="login_sub_btn" onClick="call_forget_area('family')"/>
                                    </div>
                                    <div id="family_login_loader" style="display: none; color: #005982;"><img src="/images/ajax-loader-blue.gif"/>
                                        Signing in...
                                    </div>
                                    </form>
                                </div>
                                <div class="sitter_form" id="family_forget_form" style="display:none;">
                                    <form action="<?= $_SERVER['PHP_SELF'] ?>" id="family_forgetForm" method="post">
                                        <input type="hidden" name="family_forgetForm" value="yes">
                                        <input type="text" placeholder="Enter Username" class="sitter_input" name="user_name"
                                               id="family_forget_username"/>
                                        <input type="submit" value="Send" class="login_sub_btn"/>
                                        <input type="button" value="Back to Login" class="login_sub_btn" onClick="call_login_area('family')"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="md-content" style="display: none; font-weight:bold" id="loginErrorPane"></div>
                    </div>

                    <div class="md-modal md-effect-customer-signup family-signup" id="modal-customer-signup">
                        <div class="md-close">X</div>
                        <div class="md-content">
                            <div class="sitter_log">
                                <div class="log_head family-head"><span></span>
                                    <h3>Get A Sitter - Sign Up As Family</h3>
                                </div>
                                <div class="sitter_form">
                                    <form action="<?= $base_path ?>/family_app_register.php" method="post" id="familysignupForm">
                                        <input type="email" name="family_email" id="family_email" placeholder="Enter Email Adress"
                                               class="sitter_input"/>
                                        <input type="text" name="family_username" id="family_username" placeholder="Enter Username"
                                               class="sitter_input"/>
                                        <input type="password" name="family_password" id="family_password" placeholder="Enter Password"
                                               class="sitter_input"/>
                                        <input type="password" name="family_cpassword" id="family_cpassword" placeholder="Enter Confirmed Password"
                                               class="sitter_input"/>
                                        <input type="submit" value="Sign Up" class="login_sub_btn"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--sign-up-form-->


                    <div class="md-modal md-effect-sitter-signup sitter-signup" id="modal-sitter-signup">
                        <div class="md-close">X</div>
                        <div class="md-content">
                            <div class="sitter_log">
                                <div class="log_head"><span></span>
                                    <h3>Watch a Child - Sign Up As Sitter</h3>
                                </div>
                                <div class="sitter_form">
                                    <form action="<?= $base_path ?>/sitter_app_register.php" method="post" id="signupForm">

                                        <input type="email" name="sitter_email" id="sitter_email" placeholder="Enter Email Adress"
                                               class="sitter_input"/>
                                        <input type="text" name="sitter_username" id="sitter_username" placeholder="Enter Username"
                                               class="sitter_input"/>
                                        <input type="password" name="sitter_password" id="sitter_password" placeholder="Enter Password"
                                               class="sitter_input"/>
                                        <input type="password" name="sitter_cpassword" id="sitter_cpassword" placeholder="Enter Confirmed Password"
                                               class="sitter_input"/>
                                        <input type="submit" value="Sign Up" class="login_sub_btn"/>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="md-modal md-effect-sitter-signup sitter-signup" id="modal-password-retrieve">
                        <div class="md-close password_retrieve_close"></div>
                        <div class="md-content">
                            <div class="sitter_log">
                                <div class="log_head"><span></span>
                                    <h3>Reset Password</h3>
                                </div>
                                <div class="sitter_form">
                                    <form action="<?= $base_path ?>/sitter/reset_password.php" method="post" id="ResetpassForm">
                                        <input type="hidden" name="hidden_code" id="hidden_code"
                                               value="<?php if (isset($_REQUEST['reset_code'])) echo $_REQUEST['reset_code']; ?>">
                                        <input type="password" name="sitter_new_password" id="sitter_new_password" placeholder="New Password"
                                               class="sitter_input"/>
                                        <input type="password" name="sitter_new_cpassword" id="sitter_new_cpassword"
                                               placeholder="Confirmed New Password" class="sitter_input"/>
                                        <input type="submit" value="Reset" class="login_sub_btn"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md-modal md-effect-search" id="modal-search">
                        <div class="md-close">X</div>
                        <div class="md-content">
                            <div class="sitter_log">
                                <div class="log_head"><span></span>
                                    <h3>Search For Sitter</h3>
                                </div>
                                <div class="sitter_form">
                                    <form action="<?= $base_path ?>/sitter_list.php" method="post" id="searchForm">
                                        <div class="form-field1">
                                            <label>From</label>
                                            <input type="text" id="datepicker" name="search_from_date">
                                        </div>
                                        <div class="form-field2">
                                            <label>To</label>
                                            <input type="text" id="datepicker1" name="search_to_date">
                                        </div>
                                        <div class="form-field">
                                            <label>Zipcode</label>
                                            <select class="input_lrg" name="search_location_code" id="search_location_code">
                                                <option value="" <?php $loc = "";
                                                if (isset($R) && is_object($R)) {
                                                    $loc = ($R->location_code == '') ? 'selected' : '';
                                                    echo $loc;
                                                } ?> >Select Zipcode
                                                </option>
                                                <?php
                                                $states = $db->get('select * from states order by state');
                                                if (count($states) > 0) {
                                                    foreach ($states as $state) { ?>
                                                        <option value="<?= $state->state_code ?>" <?= $state->state_code == $loc ? 'selected' : '' ?> >
                                                            <?= $state->state ?>
                                                        </option>
                                                    <?php }
                                                }
                                                ?>
                                            </select>
                                            <div class="form-field1">
                                                <label>Firstaid Training</label>
                                                <select class="input_lrg" name="search_user_firstaid_training">
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="form-field2">
                                                <label>Cpr Training</label>
                                                <select class="input_lrg" name="search_user_cpr_training">
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="form-field1">
                                                <label>Infant Newborn CPR Certified</label>
                                                <select class="input_lrg" name="search_user_newborn_cpr_training">
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="form-field2">
                                                <label>Experience with child food allergies</label>
                                                <select class="input_lrg" name="search_user_food_allergies">
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="form-field1">
                                                <label>Willing to do overnight babysitting</label>
                                                <select class="input_lrg" name="search_user_overnight">
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="form-field2">
                                                <label>Willing to travel with families</label>
                                                <select class="input_lrg" name="search_user_travel">
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="form-field1">
                                                <label>Available for semi-permanent/permanent placement</label>
                                                <select class="input_lrg" name="search_user_permanent">
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="form-field2">
                                                <label>Newborn experience</label>
                                                <select class="input_lrg" name="search_user_newborn_exp">
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="form-field">
                                                <label>Willing to care for sick kids</label>
                                                <select class="input_lrg" name="search_user_sick_kids">
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="form-fieldb">
                                            <input type="submit" value="Search" class="login_sub_btn"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="md-modal md-effect-search" id="modal-book" style="min-width: 400px;">
                        <div class="overlay-one" style="display:none;"><img src="<?= $base_path ?>/images/loading.gif" alt=""/></div>
                        <div class="md-close">X</div>
                        <div class="md-content">
                            <div class="sitter_log">
                                <div class="log_head"><span></span>
                                    <h3>Book A Sitter</h3>
                                </div>
                                <div class="error" id="bookForm_error"></div>
                                <div class="sitter_form">
                                    <form action="<?= $base_path ?>/sitter_details.php?sitter_id=<?php if (isset($_REQUEST['sitter_id'])) echo base64_decode($_REQUEST['sitter_id']); ?>"
                                          method="post" id="bookForm">
                                        <input type="hidden" name="sitter_main_id" id="sitter_main_id"
                                               value="<?php if (isset($_REQUEST['sitter_id'])) echo base64_decode($_REQUEST['sitter_id']); ?>">
                                        <div class="left" style="min-width: 300px;">
                                            <input type="hidden" name="bookForm" value="yes">
                                            <div id='calendar'></div>
                                            <input type="hidden" id="altField" value="" name="calender_val" required>
                                            <div id="time_area0"></div>
                                        </div>
                                        <div class="right" style="min-width: 300px;">
                                            <div class="form-field">
                                                <label>No Of Kids</label>
                                                <input type="text" id="no_of_kids" name="no_of_kids" required>
                                            </div>
                                            <div class="form-field">
                                                <label>Zipcode</label>
                                                <select class="input_lrg" name="location_code" id="location_code">
                                                    <?php
                                                    $states = $db->get('select * from states order by state ');
                                                    if (count($states) > 0) {
                                                        foreach ($states as $state) {
                                                            ?>
                                                            <option value="<?= $state->state ?>">
                                                                <?= $state->state ?>
                                                            </option>
                                                        <?php }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-field">
                                                <label>Remarks</label>
                                                <input type="text" id="remarks" name="remarks">
                                            </div>
                                            <input type="submit" value="Book" class="login_sub_btn"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md-modal md-effect-search" id="modal-directmsg">
                        <div class="overlay-one" style="display:none;"><img src="<?= $base_path ?>/images/loading.gif" alt=""/></div>
                        <div class="md-close">X</div>
                        <div class="md-content">
                            <div class="sitter_log">
                                <div class="log_head"><span></span>
                                    <h3>
                                        Contact <?= ((isset($_SESSION) && isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'sitter') ? 'Family' : 'Sitter'); ?></h3>
                                </div>
                                <div class="error" id="msgForm_error"></div>
                                <div class="sitter_form">
                                    <form action="<?= $base_path ?>/contact_user.php" method="post" id="msgUserForm">
                                        <input type="hidden" name="user_main_id" value="<?php
                                        if (isset($_REQUEST['sitter_id']))
                                            echo base64_decode($_REQUEST['sitter_id']);
                                        elseif (isset($_REQUEST['fid']))
                                            echo $_REQUEST['fid'];
                                        ?>">
                                        <div class="form-field">
                                            <label>Message</label><br/>
                                            <textarea id="usermsg" name="usermsg" style="width: 90%; color: #000000;" rows="5"></textarea>
                                        </div>
                                        <input type="submit" value="Send Message" class="user_message_send"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Start Messsaging-->
                    <div class="md-modal md-effect-search" id="modal-messaging">
                        <div class="overlay-one" style="display:none;"><img src="<?= $base_path ?>/images/loading.gif" alt=""/></div>
                        <div class="md-close">X</div>
                        <div class="md-content">
                            <div class="sitter_log">
                                <div class="log_head"><span></span>
                                    <h3>Send a Message</h3>
                                </div>
                                <div class="sitter_form">
                                    <form>
                                        <div class="form-field"><textarea class="form-control" rows="5"></textarea></div>
                                        <div class="form-field">
                                            <button class="btn btn-default" type="submit">Send</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Messageing-->
                    <div class="md-modal md-effect-search" id="modal-post-job">
                        <div class="overlay-one" style="display:none;"><img src="<?= $base_path ?>/images/loading.gif" alt=""/></div>
                        <div class="md-close">X</div>
                        <div class="md-content">
                            <div class="sitter_log">
                                <div class="log_head"><span></span>
                                    <h3>Post A Job</h3>
                                </div>
                                <div class="error" id="job_bookForm_error"></div>
                                <div class="sitter_form">
                                    <form action="<?= $base_path ?>/family_jobposting.php" method="post" id="PostjobForm">
                                        <div class="left">
                                            <input type="hidden" name="PostjobForm" value="yes">
                                            <div id='job_calendar'></div>
                                            <input type="hidden" id="jobaltField" value="" name="job_calender_val">
                                            <div id="job_time_area0"></div>
                                        </div>
                                        <div class="right">
                                            <div class="form-field">
                                                <label>No Of Kids</label>
                                                <input type="text" id="job_no_of_kids" name="job_no_of_kids" required>
                                            </div>
                                            <div class="form-field">
                                                <label>Zipcode</label>
                                                <select class="input_lrg" name="job_location_code" id="job_location_code">
                                                    <?php
                                                    $states = $db->get('select * from states order by state ');
                                                    if (count($states) > 0) {
                                                        foreach ($states as $state) {
                                                            ?>
                                                            <option value="<?= $state->state ?>">
                                                                <?= $state->state ?>
                                                            </option>
                                                        <?php }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-field">
                                                <label>Remarks</label>
                                                <input type="text" id="job_remarks" name="job_remarks">
                                            </div>
                                            <input type="submit" value="Book" class="login_sub_btn"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md-modal md-effect-search" id="modal-edit-job">
                        <div class="overlay-one" style="display:none;"><img src="<?= $base_path ?>/images/loading.gif" alt=""/></div>
                        <div class="md-close">X</div>
                        <div class="md-content">
                            <div class="sitter_log">
                                <div class="log_head"><span></span>
                                    <h3>Edit Job</h3>
                                </div>
                                <div class="error" id="job_bookForm_error"></div>
                                <div class="sitter_form">
                                    <form action="<?= $base_path ?>/family_jobediting.php" method="post" id="edit_PostjobForm">
                                        <input type="hidden" name="edit_job_id" id="edit_job_id">
                                        <div class="left">
                                            <input type="hidden" name="edit_PostjobForm" value="yes">
                                            <div id='edit_job_calendar'></div>
                                            <input type="hidden" id="edit_jobaltField" value="" name="edit_job_calender_val">
                                            <div id="edit_job_time_area0"></div>
                                        </div>
                                        <div class="right">
                                            <div class="form-field">
                                                <label>No Of Kids</label>
                                                <input type="text" id="edit_job_no_of_kids" name="edit_job_no_of_kids" required>
                                            </div>
                                            <div class="form-field">
                                                <label>Zipcode</label>
                                                <select class="input_lrg" name="edit_job_location_code" id="edit_job_location_code">
                                                    <?php
                                                    $states = $db->get('select * from states order by state ');
                                                    if (count($states) > 0) {
                                                        foreach ($states as $state) {
                                                            ?>
                                                            <option value="<?= $state->state ?>">
                                                                <?= $state->state ?>
                                                            </option>
                                                        <?php }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-field">
                                                <label>Remarks</label>
                                                <input type="text" id="edit_job_remarks" name="edit_job_remarks">
                                            </div>
                                            <input type="submit" value="Book" class="login_sub_btn"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md-modal md-effect-search" id="modal-search-job">
                        <div class="md-close">X</div>
                        <div class="md-content">
                            <div class="sitter_log">
                                <div class="log_head"><span></span>
                                    <h3>Search For Job</h3>
                                </div>
                                <div class="sitter_form">
                                    <form action="<?= $base_path ?>/job_list.php" method="post" id="jobsearchForm">
                                        <div class="form-field1">
                                            <label>From</label>
                                            <input type="text" id="jobdatepicker" name="job_search_from_date">
                                        </div>
                                        <div class="form-field2">
                                            <label>To</label>
                                            <input type="text" id="jobdatepicker1" name="job_search_to_date">
                                        </div>
                                        <div class="form-field">
                                            <label>Zipcode</label>
                                            <select class="input_lrg" name="job_search_location_code" id="job_search_location_code">
                                                <?php
                                                $states = $db->get('select * from states order by state ');
                                                if (count($states) > 0) {
                                                    foreach ($states as $state) {
                                                        ?>
                                                        <option value="<?= $state->state ?>">
                                                            <?= $state->state ?>
                                                        </option>
                                                    <?php }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-fieldb">
                                            <input type="submit" value="Search" class="login_sub_btn"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md-modal md-effect-book_details" id="modal-book_details">
                        <div class="md-close book_details_close"></div>
                        <div class="md-content-sidebar" id="md-content-sidebar"></div>
                        <div class="md-content">
                            <div class="sitter_log">
                                <div class="log_head"><span></span>
                                    <h3>Booking information for <font id="book_info_date"></font></h3>
                                </div>
                                <div class="sitter_form" id="book_details_area"></div>
                                <div class="sitter_form" id="book_rating_area"></div>
                                <div class="sitter_form" id="book_confirmation_area"></div>
                                <div class="" id="book_message_system">
                                    <div class="" id="book_message_part">
                                        <ul id="book_message_part_ul">
                                        </ul>
                                    </div>
                                    <div class="" id="book_message_form"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md-modal md-effect-search" id="apply-job">
                        <div class="md-close">X</div>
                        <div class="md-content">
                            <div class="sitter_log">
                                <div class="log_head"><span></span>
                                    <h3>Apply For Job - <br>
                                        <div id="job_code_area"></div>
                                    </h3>
                                </div>
                                <div class="sitter_form">
                                    <form action="<?= $base_path ?>/apply_job.php" method="post" id="applyjobForm">
                                        <input type="hidden" name="job_code_input" id="job_code_input" value="">
                                        <div class="form-field">
                                            <label>Remarks</label>
                                            <textarea name="job_remarks" id="job_remarks"></textarea>
                                        </div>
                                        <div class="form-fieldb">
                                            <input type="submit" value="Apply" class="login_sub_btn"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md-overlay"></div>


                    <!-- the overlay element -->
                    <ul class="top-menu-list">
                        <li><a href="<?= $base_path ?>/about_us.php"><span class="img-span"><img src="<?= $base_path ?>/images/cycle.png"/></span>
                                <span>About</span></a></li>
                        <li><a href="<?= $base_path ?>/how-it-works.php"><span class="img-span"><img
                                            src="<?= $base_path ?>/images/teddy-bear.png"/></span> <span>How It Works</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!--inner-menu-->
<?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != '') : ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                <ul class="inner-navmenu-list">
                    <?php if ($_SESSION['user_type'] == 'sitter') {
                        ?>
                        <li><a href="<?= $base_path ?>/sitter_dashboard.php">Job Feed</a></li>
                        <li><a href="<?= $base_path ?>/sitter_application.php">Edit Account Info</a></li>
                        <li><a href="<?= $base_path ?>/sitter_booking.php">Check booking Information</a></li>
                        <li><a href="<?= $base_path ?>/sitter_reviews.php">Check Reviews</a></li>
                        <li><a href="<?= $base_path ?>/applied_job_list.php">Applied Job</a></li>
                        <?php
                    }
                    if ($_SESSION['user_type'] == 'family') {
                        ?>
                        <li><a href="<?= $base_path ?>/family_dashboard.php">Sitter Feed</a></li>
                        <li><a href="<?= $base_path ?>/family_application.php">Edit Account Info</a></li>
                        <li><a href="<?= $base_path ?>/family_booking.php">Check booking Information</a></li>
                        <li><a href="#" class="md-trigger" data-modal="modal-post-job">Post Job</a></li>
                        <li><a href="<?= $base_path ?>/family_posting.php">Check Posted Jobs</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <div class="search-box1">
                    <?php if ($_SESSION['user_type'] == 'sitter') {
                        ?>
                        <a data-modal="modal-search-job" class="md-trigger" href="javascript:void(0);"> <img
                                    src="<?= $base_path ?>/images/inner-search-bg.png" alt=""/><span class="search-subject">Search Job</span></a>
                        <?php
                    }
                    if ($_SESSION['user_type'] == 'family') {
                        ?>
                        <a data-modal="modal-search" class="md-trigger" href="javascript:void(0);"> <img
                                    src="<?= $base_path ?>/images/inner-search-bg.png" alt=""/><span class="search-subject">Search Sitter</span></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php endif;

?>