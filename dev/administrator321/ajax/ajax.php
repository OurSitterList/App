<?
	chdir("..");
	include("config/admin-includes.php");
	 require('../tools/PHPMailer-master/PHPMailerAutoload.php');
	chdir("ajax");
	
	
	$con=new DBConnection(host,user,pass,db);
	$conObj=$con->connectDB();


	
$html_base=mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue;
function createRandomCodeprint() { 
    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $code = '' ; 
    while ($i <= 10) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $code = $code . $tmp; 
        $i++; 
    } 
    return $code; 
} 
	if(isset($_POST['mode']))
	{
		extract($_POST);
		switch($mode)
		{	
		
			case 'change_approval':
			$msg='<option value="0">Select Area</option>';
		
			if($Fieldname=='user_status')
			{
				$search_current_stat = mysql_fetch_array(mysql_query("select * from user_management where user_id='".$Fieldid."'"));
				
			if($search_current_stat['user_status']==1)
			{
				$newstat =0;
				$msg = 'Activate';
				$msg_formail = 'Your account is Deactivated';
				$sub_formail = 'Account Deactivate';
			}
			else
			{
				$newstat =1;
				$msg = 'Suspend Account';
				$msg_formail = 'Your account is Activated';
				$sub_formail = 'Account Activate';
			}
			
			mysql_query("update user_management set user_status='".$newstat."' where user_id='".$Fieldid."'");
			

			
	$admin_contact_email = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='1'"));
	$admin_contact_name = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='4'"));
	
	$message = file_get_contents('../account-activation.html');
	$message = str_replace('%USERNAME%', $search_current_stat['user_name'], $message);
	$message = str_replace('%ACCOUNT_STATUS%', $msg_formail, $message);
//echo $search_current_stat['user_email'];
	$mail = new PHPMailer;
	$mail->Debugoutput = 'html';
	$mail->setFrom($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
	$mail->addAddress($search_current_stat['user_email'], $search_current_stat['user_name']);
	$mail->AddBCC("subhodeep@lnsel.net");
	$mail->Subject = $sub_formail;
	//echo $message;
	$mail->msgHTML($message);
	$mail->AltBody = 'This is a plain-text message body';
	
	//Attach an image file
	//$mail->addAttachment('images/phpmailer_mini.png');
	if (!$mail->send()) {
		
	}
	//echo $msg;
			}
			else
			{
			$search_current_stat = mysql_fetch_array(mysql_query("select * from user_information where user_id='".$Fieldid."'"));
			if($search_current_stat[$Fieldname]==1)
			{
				$newstat =0;
				$msg = 'Approve';
			}
			else
			{
				$newstat =1;
				$msg = 'Cancel Certifiecation';
			}
			
			mysql_query("update user_information set ".$Fieldname."='".$newstat."' where user_id='".$Fieldid."'");
			}
			echo $msg;
			break;
			default:
					echo "- ERROR.";
				break;
				
		}
	}
	else
		echo "- ERROR.";
	ob_flush();
?>