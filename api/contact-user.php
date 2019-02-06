<?php 

include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

/*
  * POST: (all required, even if empty)
  * 
  * $user_id
  * $to
  * $user_type
  * $usermsg
  * thread_id
*/

extract($_POST);

if (!$user_id) {
  echo json_encode(array('code' => 401, 'message' => 'User ID is required.'));
  exit;
}

$templatePath = $_SERVER["DOCUMENT_ROOT"] . '/templates/notification/';

// get user
$usql = "SELECT i.user_first_name, i.user_last_name, m.user_email
FROM user_information i
JOIN user_management m ON m.user_id = i.user_id
WHERE i.user_id = '" . $to . "'";
$search_query = mysql_query($usql);
if (mysql_num_rows($search_query) < 1) {
  echo json_encode(array('code' => 401, 'message' => 'User not found.'));
  exit;
}

$user_to = mysql_fetch_object($search_query);

// get from user
$usql = "SELECT i.user_first_name, i.user_last_name, m.user_email
FROM user_information i
JOIN user_management m ON m.user_id = i.user_id
WHERE i.user_id = '" . $user_id . "'";
$search_query = mysql_query($usql);
if (mysql_num_rows($search_query) < 1)
{
  echo json_encode(array('code' => 401, 'message' => 'User not found.'));
  exit;
}

$user_from = mysql_fetch_object($search_query);

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
        $user_type,
        ucfirst($user_type),
        strip_tags($usermsg),
        $https_base_path . '/' . (($user_type === 'sitter') ? 'sitter_details.php?sitter_id=' . $user_id : 'family.php?fid=' . $user_id)
    ),
    $email
);

require_once $_SERVER["DOCUMENT_ROOT"] . '/class.MailUtil.php';
$mail = MailUtil::getMailer();

$mail->Debugoutput = 'html';
$mail->setFrom('oursitterlist@gmail.com', 'Our Sitter List');

$mail->addAddress($user_to->user_email, $user_to->user_first_name . ' ' . $user_to->user_last_name);
$mail->Subject = 'Message from Our Sitter List';
$mail->msgHTML($email);
$mail->AltBody = 'This is a plain-text message body';

if (!$mail->send()) {
  echo json_encode(array('code' => 400, 'message' => 'Email failed to send.'));
  exit;
} else {
  $sql = "INSERT INTO messages (user_id, recipient_id, thread_id, message, created_at)
  VALUES ('" . $user_id . "', '" . $to . "', '" . $thread_id . "', '" . $usermsg . "', '" . date('Y-m-d H:i:s',time()) . "')";

  mysql_query($sql);  

  echo json_encode(array('code' => 200, 'message' => 'Email sent.'));
  exit;
}
