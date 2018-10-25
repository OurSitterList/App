<?php
//phpinfo();
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once('class.phpmailer.php');


$to      = 'santa@lnsel.net';
$subject = 'Password Retrieving';
$message = '<h3>Auto Email for Password Reset</h3>';


$mail = new PHPMailer();

$body = $mail->getFile('mail.html');

$body = str_replace('[mail_body_replace]',$message,$body);


 $mail->isSMTP();                                      // Set mailer to use SMTP
 $mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->SMTPSecure = "ssl";
$mail->SMTPAuth = true;
                          // Enable SMTP authentication
 $mail->Username = 'webmaster.elh@gmail.com';                            // SMTP username
 $mail->Password = 'EARTH@54';                           // SMTP password

$mail->From = 'mail@elh.co.in';
$mail->FromName = 'Eastern Law House [elh.co.in]';

$mail->Subject = $subject;

$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$mail->AddAddress($to, "User");
echo $mail->Send();
exit;?>
