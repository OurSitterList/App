<?php include('includes/connection.php');?>
<?php include('includes/header.php');?>
<?php

require_once 'class.MailUtil.php';

if((!isset($_POST['contact_name']) && trim($_POST['contact_name'])==''))
			{
				
			header('Location:'.$base_path);
				
			}
			$admin_contact_email = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='1'"));
			$admin_contact_name = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='4'"));


 $message = file_get_contents('contact-form.html');
	$message = str_replace('%FULL_NAME%', $_POST['contact_name'], $message);
	$message = str_replace('%EMAIL%', $_POST['contact_email'], $message);
	$message = str_replace('%AS%', $_POST['contact_as'], $message);
	$message = str_replace('%COMMENT%',$_POST['contact_comment'], $message);
//	$mail = new PHPMailer;
//	$mail->isSMTP();

	$mail = MailUtil::getMailerInquiry();

	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	//$mail->SMTPDebug = 0;
	//$mail->Debugoutput = 'html';
	/*$mail->Host = "mail.oursitterlistnashville.com";
	//Set the SMTP port number - likely to be 25, 465 or 587
	$mail->Port = 25;
	$mail->SMTPAuth = true;
	$mail->Username = "inquiry@oursitterlistnashville.com";
	$mail->Password = "BNTLTw3HF_M!";*/
	//$mail->setFrom($_POST['contact_email'], $_POST['contact_name']);
	//$mail->addReplyTo('replyto@example.com', 'First Last');
	//$mail->addAddress($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
	//$mail->addAddress('pgurjar007@gmail.com');
	$mail->addAddress('chrisperando@gmail.com');
	$mail->addAddress('jon@thinkvaughn.com');
	$mail->addAddress('oursitterlistnashville@gmail.com');
	$mail->Subject = 'Contact Request';
	//Replace the plain text body with one created manually
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	$mail->msgHTML($message);
	//Replace the plain text body with one created manually
	$mail->AltBody = 'This is a plain-text message body';
	
	//Attach an image file
	//$mail->addAttachment('images/phpmailer_mini.png');
	
	if (!$mail->send()) {
		$_SESSION['is_mail']=$mail->ErrorInfo;
		
	}
	else
	{
$_SESSION['is_mail']='Your message sent successfully';
	
	}
	
header('Location:'.$base_path.'/contact-us.php');
?>


<?php include('includes/footer.php');?>