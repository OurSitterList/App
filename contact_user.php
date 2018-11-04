<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php

if (!isset($_SESSION['user_id']) && $_SESSION['user_id']=='')
{
//    die('not authorized..');
    header('Location:/');
    exit;
}

$templatePath = BASEPATH.'templates/notification/';

// get user
$usql = "SELECT i.user_first_name, i.user_last_name, m.user_email
FROM user_information i
JOIN user_management m ON m.user_id = i.user_id
WHERE i.user_id = '" . $_REQUEST['user_main_id'] . "'";
$search_query = mysql_query($usql);
if (mysql_num_rows($search_query) < 1)
{
//    die('FROM User not found. ' . $usql);
//    mail('sethcriedel@gmail.com', 'Contact user issue', 'FROM User not found. ' . $usql, 'From: noreply@oursitterlistnashville.com');
    header('Location:/');
    exit;
}

$user_to = mysql_fetch_object($search_query);


// get from user
$usql = "SELECT i.user_first_name, i.user_last_name, m.user_email
FROM user_information i
JOIN user_management m ON m.user_id = i.user_id
WHERE i.user_id = '" . $_SESSION['user_id'] . "'";
$search_query = mysql_query($usql);
if (mysql_num_rows($search_query) < 1)
{
    mail('sethcriedel@gmail.com', 'Contact user issue', 'User not found. ' . $usql, 'From: noreply@oursitterlistnashville.com');
    header('Location:/');
    exit;
}

$user_from = mysql_fetch_object($search_query);

//print_r($user_from);
//echo '<br /><br />';
//print_r($user_to);
//die($templatePath);
$email = file_get_contents($templatePath . 'user-contact.html');

$email = str_replace(
    array(
        '%FROM%',
        '%USERTYPE%',
        '%USERTYPE2%',
        '%MESSAGE%',
        '%LINK%',
    ),
    array(
        $user_from->user_first_name . ' ' . $user_from->user_last_name,
        $_SESSION['user_type'],
        ucfirst($_SESSION['user_type']),
        strip_tags($_POST['usermsg']),
        $https_base_path . '/' . (($_SESSION['user_type'] === 'sitter') ? 'sitter_details.php?sitter_id=' . base64_encode($_SESSION['user_id']) : 'family.php?fid=' . $_SESSION['user_id'])
    ),
    $email
);
//die($email);


require_once 'class.MailUtil.php';
$mail = MailUtil::getMailer();

$mail->Debugoutput = 'html';
$mail->setFrom('noreply@oursitterlistnashville.com', 'Our Sitter List');

$mail->addAddress($user_to->user_email, $user_to->user_first_name . ' ' . $user_to->user_last_name);
//$mail->addBCC('sethcriedel@gmail.com', 'Seth Riedel');
$mail->Subject = 'Message from Our Sitter List';
$mail->msgHTML($email);
$mail->AltBody = 'This is a plain-text message body';


//die('ABOUT TO SEND POST EMAIL!');
if (!$mail->send()) {
    echo 'Email could not be sent.' . $mail->ErrorInfo;
    die();
}
else
{
//    echo "SENT!";

    if ($_SESSION['user_type'] === 'family')
    {
        $redirect = '/sitter_details.php?sitter_id=' . base64_encode($_REQUEST['user_main_id']);
    }
    else
    {
        $redirect = '/family.php?fid=' . $_REQUEST['user_main_id'];
    }
//    die($redirect);
    $redirect .= '&sent=1';
    header('Location: ' . $redirect);
}
exit();

?>