<?

	include("classes/AdminStructure.php");

	class Home extends AdminStructure{
		function Home($title){
			parent::AdminStructure($title);
		}

		function conDition(){
			if(!$_SESSION['AID'])
				header("Location: ./");
		}

		function jScripts(){}

		function body(){
			$page='dash';
?>

<!--************************PAGE BODY***************************-->
<?php
	extract($_REQUEST);
	$ll_total_amt =0;
	function send_email($as_email_address, $as_email_subject, $as_email_text) {		
		$mail_headers  = 'MIME-Version: 1.0' . "\r\n";
		$mail_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		// send email
		mail($as_email_address, $as_email_subject, $as_email_text, $mail_headers);
	}
	
	 if(isset($_REQUEST['PageAction']) && $_REQUEST['PageAction'] == "AdminAction"){
		if($hmode == 'pickup'){	
			$cart_result = mysql_fetch_object(mysql_query("select * from user_cart where id_cart = '$DataID'"));
			
			$admin_mail = mysql_fetch_object(mysql_query("SELECT settingValue from  setting where id = '1'"))->settingValue;
		   if($DataAction == 'ap'){
				mysql_query("update user_cart set is_approve = '1' where id_cart = '$DataID'");
				$cart_query = mysql_query("Select * from temp_cart where id_cart = '$cart_result->id_cart'");	
			while($row = mysql_fetch_object($cart_query)){
					$ll_total_amt += $row->price;
			}
			$msg_cust = '';
			$msg = '';
			$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>email</title>
								</head>
								
								<body style="margin:0 auto; padding:0px; background-color:#f1f1f1;">
								
								<div style="margin:0 auto; padding:0px; width:90%; height:auto; border:1px solid #eee;">
									<div style="margin:0 auto; padding:0px; width:100%; height:81px; background:
									url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;">
										<div style="padding-top:10px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#FFF; font-weight:bold;">
										<span style="font-size:16px">Resturant Portal</span>
										</div>
									</div><!--header-->
									<div style="margin:0 auto; padding-top:20px; padding-bottom:20px; width:100%; height:auto; background-color:#f9f9f9;								
									border:none 5px #000000;
									-moz-border-radius: 15px;
									-webkit-border-radius: 15px;
									border-radius: 15px;
								 	margin:10px auto;							
									-moz-box-shadow: 0px 3px 5px #ccc;
									-webkit-box-shadow: 0px 3px 5px #ccc;
									box-shadow: 0px 3px 5px #ccc;">
									 <div style="margin:0 auto; width:98%;  font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#5b5b5b; ">
									 <table width="100%" border="0">
										The following email come from Resturant Portal:<br><br>';
						$msg_cust = $msg;				
						$msg_cust .= '<b>Your Order Number :</b> '.$cart_result->id_cart.' has been approved.Our Employee will call you soon<br>
										<b>Total Amount is :</b> '.$ll_total_amt.'</div><!--1st table-->';
										
						$msg .= '<b>Order Number :</b> '.$cart_result->id_cart.' has been approved.<br>
								 <b>Total Amount is :</b> '.$ll_total_amt.'</div><!--1st table-->';
								 
						$msg_cust .= '<div style="margin:0 auto; width:98%;  margin-top:20px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#5b5b5b; ">
									 <table width="100%" border="0">
									 
										<tr>
											<td width="170" height="25" bgcolor="#fefefe" style="padding-left:10px;">IP address of this mail: </td>
											
											<td bgcolor="#fefefe" style="padding-left:10px;">'.$_SERVER['SERVER_ADDR'].'</td>
										</tr>
									 </table>
									 </div><!--2nd table-->
									</div><!--content-->
									<div style="margin:0 auto; padding:0px; width:100%; height:40px; background:url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;
									-webkit-border-bottom-right-radius: 10px;
								-webkit-border-bottom-left-radius: 10px;
								-moz-border-radius-bottomright: 10px;
								-moz-border-radius-bottomleft: 10px;
								border-bottom-right-radius: 10px;
								border-bottom-left-radius: 10px;">
										<div style="padding-top:7px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; ">
										Powered by:&nbsp;  <span style="font-size:13px"><a href="http://supercloudten.com/" target="_blank" style="color:#FFF; text-decoration:none; border:none;">Super Cloud Ten</a></span>
										</div>
									</div><!--footer-->
								</div><!--main-->
								</body>
								</html>';
									 
						$msg .= '<div style="margin:0 auto; width:98%;  margin-top:20px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#5b5b5b; ">
									 <table width="100%" border="0">
									 
										<tr>
											<td width="170" height="25" bgcolor="#fefefe" style="padding-left:10px;">IP address of this mail: </td>
											
											<td bgcolor="#fefefe" style="padding-left:10px;">'.$_SERVER['SERVER_ADDR'].'</td>
										</tr>
									 </table>
									 </div><!--2nd table-->
									</div><!--content-->
									<div style="margin:0 auto; padding:0px; width:100%; height:40px; background:url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;
									-webkit-border-bottom-right-radius: 10px;
								-webkit-border-bottom-left-radius: 10px;
								-moz-border-radius-bottomright: 10px;
								-moz-border-radius-bottomleft: 10px;
								border-bottom-right-radius: 10px;
								border-bottom-left-radius: 10px;">
										<div style="padding-top:7px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; ">
										Powered by:&nbsp;  <span style="font-size:13px"><a href="http://supercloudten.com/" target="_blank" style="color:#FFF; text-decoration:none; border:none;">Super Cloud Ten</a></span>
										</div>
									</div><!--footer-->
								</div><!--main-->
								</body>
								</html>';

			@send_email($cart_result->email,'Contact Information',$msg_cust);
			@send_email($admin_mail,'Contact Information',$msg);			
				header("Location:".$_SESSION['PHP_SELF']);
				return;
			}else{
				mysql_query("update user_cart set is_approve = '-1' where id_cart = '$DataID'");
				$msg_cust = '';
			$msg = '';
			$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>email</title>
								</head>
								
								<body style="margin:0 auto; padding:0px; background-color:#f1f1f1;">
								
								<div style="margin:0 auto; padding:0px; width:90%; height:auto; border:1px solid #eee;">
									<div style="margin:0 auto; padding:0px; width:100%; height:81px; background:
									url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;">
										<div style="padding-top:10px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#FFF; font-weight:bold;">
										<span style="font-size:16px">Resturant Portal</span>
										</div>
									</div><!--header-->
									<div style="margin:0 auto; padding-top:20px; padding-bottom:20px; width:100%; height:auto; background-color:#f9f9f9;								
									border:none 5px #000000;
									-moz-border-radius: 15px;
									-webkit-border-radius: 15px;
									border-radius: 15px;
								 	margin:10px auto;							
									-moz-box-shadow: 0px 3px 5px #ccc;
									-webkit-box-shadow: 0px 3px 5px #ccc;
									box-shadow: 0px 3px 5px #ccc;">
									 <div style="margin:0 auto; width:98%;  font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#5b5b5b; ">
									 <table width="100%" border="0">
										The following email come from Resturant Portal:<br><br>';
						$msg_cust = $msg;				
						$msg_cust .= '<b>Your Order Number :</b> '.$cart_result->id_cart.' has been Canceled.<br>';
										
						$msg .= '<b>Order Number :</b> '.$cart_result->id_cart.' has been Canceled.<br>';
								 
						$msg_cust .= '<div style="margin:0 auto; width:98%;  margin-top:20px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#5b5b5b; ">
									 <table width="100%" border="0">
									 
										<tr>
											<td width="170" height="25" bgcolor="#fefefe" style="padding-left:10px;">IP address of this mail: </td>
											
											<td bgcolor="#fefefe" style="padding-left:10px;">'.$_SERVER['SERVER_ADDR'].'</td>
										</tr>
									 </table>
									 </div><!--2nd table-->
									</div><!--content-->
									<div style="margin:0 auto; padding:0px; width:100%; height:40px; background:url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;
									-webkit-border-bottom-right-radius: 10px;
								-webkit-border-bottom-left-radius: 10px;
								-moz-border-radius-bottomright: 10px;
								-moz-border-radius-bottomleft: 10px;
								border-bottom-right-radius: 10px;
								border-bottom-left-radius: 10px;">
										<div style="padding-top:7px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; ">
										Powered by:&nbsp;  <span style="font-size:13px"><a href="http://supercloudten.com/" target="_blank" style="color:#FFF; text-decoration:none; border:none;">Super Cloud Ten</a></span>
										</div>
									</div><!--footer-->
								</div><!--main-->
								</body>
								</html>';
									 
						$msg .= '<div style="margin:0 auto; width:98%;  margin-top:20px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#5b5b5b; ">
									 <table width="100%" border="0">
									 
										<tr>
											<td width="170" height="25" bgcolor="#fefefe" style="padding-left:10px;">IP address of this mail: </td>
											
											<td bgcolor="#fefefe" style="padding-left:10px;">'.$_SERVER['SERVER_ADDR'].'</td>
										</tr>
									 </table>
									 </div><!--2nd table-->
									</div><!--content-->
									<div style="margin:0 auto; padding:0px; width:100%; height:40px; background:url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;
									-webkit-border-bottom-right-radius: 10px;
								-webkit-border-bottom-left-radius: 10px;
								-moz-border-radius-bottomright: 10px;
								-moz-border-radius-bottomleft: 10px;
								border-bottom-right-radius: 10px;
								border-bottom-left-radius: 10px;">
										<div style="padding-top:7px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; ">
										Powered by:&nbsp;  <span style="font-size:13px"><a href="http://supercloudten.com/" target="_blank" style="color:#FFF; text-decoration:none; border:none;">Super Cloud Ten</a></span>
										</div>
									</div><!--footer-->
								</div><!--main-->
								</body>
								</html>';

			@send_email($cart_result->email,'Contact Information',$msg_cust);
			@send_email($admin_mail,'Contact Information',$msg); 
				header("Location:".$_SESSION['PHP_SELF']);
				return;
		   }
		}
		
		if($hmode == 'delivery'){
			$cart_result = mysql_fetch_object(mysql_query("select * from user_cart where id_cart = '$DataID'"));
			
			$admin_mail = mysql_fetch_object(mysql_query("SELECT settingValue from  setting where id = '1'"))->settingValue;
		   if($DataAction == 'ap'){
				mysql_query("update user_cart set is_approve = '1' where id_cart = '$DataID'");
				$cart_query = mysql_query("Select * from temp_cart where id_cart = '$cart_result->id_cart'");	
			while($row = mysql_fetch_object($cart_query)){
					$ll_total_amt += $row->price;
			}
			$msg_cust = '';
			$msg = '';
			$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>email</title>
								</head>
								
								<body style="margin:0 auto; padding:0px; background-color:#f1f1f1;">
								
								<div style="margin:0 auto; padding:0px; width:90%; height:auto; border:1px solid #eee;">
									<div style="margin:0 auto; padding:0px; width:100%; height:81px; background:
									url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;">
										<div style="padding-top:10px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#FFF; font-weight:bold;">
										<span style="font-size:16px">Resturant Portal</span>
										</div>
									</div><!--header-->
									<div style="margin:0 auto; padding-top:20px; padding-bottom:20px; width:100%; height:auto; background-color:#f9f9f9;								
									border:none 5px #000000;
									-moz-border-radius: 15px;
									-webkit-border-radius: 15px;
									border-radius: 15px;
								 	margin:10px auto;							
									-moz-box-shadow: 0px 3px 5px #ccc;
									-webkit-box-shadow: 0px 3px 5px #ccc;
									box-shadow: 0px 3px 5px #ccc;">
									 <div style="margin:0 auto; width:98%;  font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#5b5b5b; ">
									 <table width="100%" border="0">
										The following email come from Resturant Portal:<br><br>';
						$msg_cust = $msg;				
						$msg_cust .= '<b>Your Order Number :</b> '.$cart_result->id_cart.' has been approved.Our Employee will call you soon<br>
										<b>Total Amount is :</b> '.$ll_total_amt.'</div><!--1st table-->';
										
						$msg .= '<b>Order Number :</b> '.$cart_result->id_cart.' has been approved.<br>
								 <b>Total Amount is :</b> '.$ll_total_amt.'</div><!--1st table-->';
								 
						$msg_cust .= '<div style="margin:0 auto; width:98%;  margin-top:20px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#5b5b5b; ">
									 <table width="100%" border="0">
									 
										<tr>
											<td width="170" height="25" bgcolor="#fefefe" style="padding-left:10px;">IP address of this mail: </td>
											
											<td bgcolor="#fefefe" style="padding-left:10px;">'.$_SERVER['SERVER_ADDR'].'</td>
										</tr>
									 </table>
									 </div><!--2nd table-->
									</div><!--content-->
									<div style="margin:0 auto; padding:0px; width:100%; height:40px; background:url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;
									-webkit-border-bottom-right-radius: 10px;
								-webkit-border-bottom-left-radius: 10px;
								-moz-border-radius-bottomright: 10px;
								-moz-border-radius-bottomleft: 10px;
								border-bottom-right-radius: 10px;
								border-bottom-left-radius: 10px;">
										<div style="padding-top:7px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; ">
										Powered by:&nbsp;  <span style="font-size:13px"><a href="http://supercloudten.com/" target="_blank" style="color:#FFF; text-decoration:none; border:none;">Super Cloud Ten</a></span>
										</div>
									</div><!--footer-->
								</div><!--main-->
								</body>
								</html>';
									 
						$msg .= '<div style="margin:0 auto; width:98%;  margin-top:20px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#5b5b5b; ">
									 <table width="100%" border="0">
									 
										<tr>
											<td width="170" height="25" bgcolor="#fefefe" style="padding-left:10px;">IP address of this mail: </td>
											
											<td bgcolor="#fefefe" style="padding-left:10px;">'.$_SERVER['SERVER_ADDR'].'</td>
										</tr>
									 </table>
									 </div><!--2nd table-->
									</div><!--content-->
									<div style="margin:0 auto; padding:0px; width:100%; height:40px; background:url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;
									-webkit-border-bottom-right-radius: 10px;
								-webkit-border-bottom-left-radius: 10px;
								-moz-border-radius-bottomright: 10px;
								-moz-border-radius-bottomleft: 10px;
								border-bottom-right-radius: 10px;
								border-bottom-left-radius: 10px;">
										<div style="padding-top:7px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; ">
										Powered by:&nbsp;  <span style="font-size:13px"><a href="http://supercloudten.com/" target="_blank" style="color:#FFF; text-decoration:none; border:none;">Super Cloud Ten</a></span>
										</div>
									</div><!--footer-->
								</div><!--main-->
								</body>
								</html>';

			@send_email($cart_result->email,'Contact Information',$msg_cust);
			@send_email($admin_mail,'Contact Information',$msg);		
				header("Location:".$_SESSION['PHP_SELF']);
				return;
			}else{
				mysql_query("update user_cart set is_approve = '-1' where id_cart = '$DataID'");
				$msg_cust = '';
			$msg = '';
			$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>email</title>
								</head>
								
								<body style="margin:0 auto; padding:0px; background-color:#f1f1f1;">
								
								<div style="margin:0 auto; padding:0px; width:90%; height:auto; border:1px solid #eee;">
									<div style="margin:0 auto; padding:0px; width:100%; height:81px; background:
									url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;">
										<div style="padding-top:10px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#FFF; font-weight:bold;">
										<span style="font-size:16px">Resturant Portal</span>
										</div>
									</div><!--header-->
									<div style="margin:0 auto; padding-top:20px; padding-bottom:20px; width:100%; height:auto; background-color:#f9f9f9;								
									border:none 5px #000000;
									-moz-border-radius: 15px;
									-webkit-border-radius: 15px;
									border-radius: 15px;
								 	margin:10px auto;							
									-moz-box-shadow: 0px 3px 5px #ccc;
									-webkit-box-shadow: 0px 3px 5px #ccc;
									box-shadow: 0px 3px 5px #ccc;">
									 <div style="margin:0 auto; width:98%;  font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#5b5b5b; ">
									 <table width="100%" border="0">
										The following email come from Resturant Portal:<br><br>';
						$msg_cust = $msg;				
						$msg_cust .= '<b>Your Order Number :</b> '.$cart_result->id_cart.' has been Canceled.<br>';
										
						$msg .= '<b>Order Number :</b> '.$cart_result->id_cart.' has been Canceled.<br>';
								 
						$msg_cust .= '<div style="margin:0 auto; width:98%;  margin-top:20px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#5b5b5b; ">
									 <table width="100%" border="0">
									 
										<tr>
											<td width="170" height="25" bgcolor="#fefefe" style="padding-left:10px;">IP address of this mail: </td>
											
											<td bgcolor="#fefefe" style="padding-left:10px;">'.$_SERVER['SERVER_ADDR'].'</td>
										</tr>
									 </table>
									 </div><!--2nd table-->
									</div><!--content-->
									<div style="margin:0 auto; padding:0px; width:100%; height:40px; background:url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;
									-webkit-border-bottom-right-radius: 10px;
								-webkit-border-bottom-left-radius: 10px;
								-moz-border-radius-bottomright: 10px;
								-moz-border-radius-bottomleft: 10px;
								border-bottom-right-radius: 10px;
								border-bottom-left-radius: 10px;">
										<div style="padding-top:7px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; ">
										Powered by:&nbsp;  <span style="font-size:13px"><a href="http://supercloudten.com/" target="_blank" style="color:#FFF; text-decoration:none; border:none;">Super Cloud Ten</a></span>
										</div>
									</div><!--footer-->
								</div><!--main-->
								</body>
								</html>';
									 
						$msg .= '<div style="margin:0 auto; width:98%;  margin-top:20px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#5b5b5b; ">
									 <table width="100%" border="0">
									 
										<tr>
											<td width="170" height="25" bgcolor="#fefefe" style="padding-left:10px;">IP address of this mail: </td>
											
											<td bgcolor="#fefefe" style="padding-left:10px;">'.$_SERVER['SERVER_ADDR'].'</td>
										</tr>
									 </table>
									 </div><!--2nd table-->
									</div><!--content-->
									<div style="margin:0 auto; padding:0px; width:100%; height:40px; background:url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;
									-webkit-border-bottom-right-radius: 10px;
								-webkit-border-bottom-left-radius: 10px;
								-moz-border-radius-bottomright: 10px;
								-moz-border-radius-bottomleft: 10px;
								border-bottom-right-radius: 10px;
								border-bottom-left-radius: 10px;">
										<div style="padding-top:7px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; ">
										Powered by:&nbsp;  <span style="font-size:13px"><a href="http://supercloudten.com/" target="_blank" style="color:#FFF; text-decoration:none; border:none;">Super Cloud Ten</a></span>
										</div>
									</div><!--footer-->
								</div><!--main-->
								</body>
								</html>';

			@send_email($cart_result->email,'Contact Information',$msg_cust);
			@send_email($admin_mail,'Contact Information',$msg);   
				header("Location:".$_SESSION['PHP_SELF']);
				return;
		   }
		}
		
		if($hmode == 'booktable'){
			$booktable_result = mysql_fetch_object(mysql_query("select * from booktable where id_booktable = '$DataID'"));
			
			$admin_mail = mysql_fetch_object(mysql_query("SELECT settingValue from  setting where id = '1'"))->settingValue;
		   if($DataAction == 'ap'){
				mysql_query("update 
							 booktable 
							 set is_approve = '1'
							 where id_booktable = '$DataID'");
				$msg_cust = '';
			$msg = '';
			$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>email</title>
								</head>
								
								<body style="margin:0 auto; padding:0px; background-color:#f1f1f1;">
								
								<div style="margin:0 auto; padding:0px; width:90%; height:auto; border:1px solid #eee;">
									<div style="margin:0 auto; padding:0px; width:100%; height:81px; background:
									url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;">
										<div style="padding-top:10px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#FFF; font-weight:bold;">
										<span style="font-size:16px">Resturant Portal</span>
										</div>
									</div><!--header-->
									<div style="margin:0 auto; padding-top:20px; padding-bottom:20px; width:100%; height:auto; background-color:#f9f9f9;								
									border:none 5px #000000;
									-moz-border-radius: 15px;
									-webkit-border-radius: 15px;
									border-radius: 15px;
								 	margin:10px auto;							
									-moz-box-shadow: 0px 3px 5px #ccc;
									-webkit-box-shadow: 0px 3px 5px #ccc;
									box-shadow: 0px 3px 5px #ccc;">
									 <div style="margin:0 auto; width:98%;  font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#5b5b5b; ">
									 <table width="100%" border="0">
										The following email come from Resturant Portal:<br><br>';
						$msg_cust = $msg;				
						$msg_cust .= '<b>Your Order Number :</b> '.$booktable_result->id_booktable.' has been approved.Our Employee will call you soon<br>';
										
						$msg .= '<b>Order Number :</b> '.$booktable_result->id_booktable.' has been approved.<br>';
								 
						$msg_cust .= '<div style="margin:0 auto; width:98%;  margin-top:20px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#5b5b5b; ">
									 <table width="100%" border="0">
									 
										<tr>
											<td width="170" height="25" bgcolor="#fefefe" style="padding-left:10px;">IP address of this mail: </td>
											
											<td bgcolor="#fefefe" style="padding-left:10px;">'.$_SERVER['SERVER_ADDR'].'</td>
										</tr>
									 </table>
									 </div><!--2nd table-->
									</div><!--content-->
									<div style="margin:0 auto; padding:0px; width:100%; height:40px; background:url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;
									-webkit-border-bottom-right-radius: 10px;
								-webkit-border-bottom-left-radius: 10px;
								-moz-border-radius-bottomright: 10px;
								-moz-border-radius-bottomleft: 10px;
								border-bottom-right-radius: 10px;
								border-bottom-left-radius: 10px;">
										<div style="padding-top:7px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; ">
										Powered by:&nbsp;  <span style="font-size:13px"><a href="http://supercloudten.com/" target="_blank" style="color:#FFF; text-decoration:none; border:none;">Super Cloud Ten</a></span>
										</div>
									</div><!--footer-->
								</div><!--main-->
								</body>
								</html>';
									 
						$msg .= '<div style="margin:0 auto; width:98%;  margin-top:20px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#5b5b5b; ">
									 <table width="100%" border="0">
									 
										<tr>
											<td width="170" height="25" bgcolor="#fefefe" style="padding-left:10px;">IP address of this mail: </td>
											
											<td bgcolor="#fefefe" style="padding-left:10px;">'.$_SERVER['SERVER_ADDR'].'</td>
										</tr>
									 </table>
									 </div><!--2nd table-->
									</div><!--content-->
									<div style="margin:0 auto; padding:0px; width:100%; height:40px; background:url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;
									-webkit-border-bottom-right-radius: 10px;
								-webkit-border-bottom-left-radius: 10px;
								-moz-border-radius-bottomright: 10px;
								-moz-border-radius-bottomleft: 10px;
								border-bottom-right-radius: 10px;
								border-bottom-left-radius: 10px;">
										<div style="padding-top:7px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; ">
										Powered by:&nbsp;  <span style="font-size:13px"><a href="http://supercloudten.com/" target="_blank" style="color:#FFF; text-decoration:none; border:none;">Super Cloud Ten</a></span>
										</div>
									</div><!--footer-->
								</div><!--main-->
								</body>
								</html>';	
									
			@send_email($booktable_result->booking_email,$msg,'Restrurent Website Contact');
			@send_email($admin_mail,$msg_cust,'Restrurent Website Contact');		
				header("Location:".$_SESSION['PHP_SELF']);
				return;
			}else{
				mysql_query("update 
							 booktable 
							 set is_approve = '-1' 
							 where id_booktable = '$DataID'");
				$msg_cust = '';
			$msg = '';
			$msg = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
								<html xmlns="http://www.w3.org/1999/xhtml">
								<head>
								<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
								<title>email</title>
								</head>
								
								<body style="margin:0 auto; padding:0px; background-color:#f1f1f1;">
								
								<div style="margin:0 auto; padding:0px; width:90%; height:auto; border:1px solid #eee;">
									<div style="margin:0 auto; padding:0px; width:100%; height:81px; background:
									url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;">
										<div style="padding-top:10px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#FFF; font-weight:bold;">
										<span style="font-size:16px">Resturant Portal</span>
										</div>
									</div><!--header-->
									<div style="margin:0 auto; padding-top:20px; padding-bottom:20px; width:100%; height:auto; background-color:#f9f9f9;								
									border:none 5px #000000;
									-moz-border-radius: 15px;
									-webkit-border-radius: 15px;
									border-radius: 15px;
								 	margin:10px auto;							
									-moz-box-shadow: 0px 3px 5px #ccc;
									-webkit-box-shadow: 0px 3px 5px #ccc;
									box-shadow: 0px 3px 5px #ccc;">
									 <div style="margin:0 auto; width:98%;  font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#5b5b5b; ">
									 <table width="100%" border="0">
										The following email come from Resturant Portal:<br><br>';
						$msg_cust = $msg;				
						$msg_cust .= '<b>Your Order Number :</b> '.$booktable_result->id_booktable.' has been Canceled.Our Employee will call you soon<br>';
										
						$msg .= '<b>Order Number :</b> '.$booktable_result->id_booktable.' has been Canceled.<br>';
								 
						$msg_cust .= '<div style="margin:0 auto; width:98%;  margin-top:20px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#5b5b5b; ">
									 <table width="100%" border="0">
									 
										<tr>
											<td width="170" height="25" bgcolor="#fefefe" style="padding-left:10px;">IP address of this mail: </td>
											
											<td bgcolor="#fefefe" style="padding-left:10px;">'.$_SERVER['SERVER_ADDR'].'</td>
										</tr>
									 </table>
									 </div><!--2nd table-->
									</div><!--content-->
									<div style="margin:0 auto; padding:0px; width:100%; height:40px; background:url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;
									-webkit-border-bottom-right-radius: 10px;
								-webkit-border-bottom-left-radius: 10px;
								-moz-border-radius-bottomright: 10px;
								-moz-border-radius-bottomleft: 10px;
								border-bottom-right-radius: 10px;
								border-bottom-left-radius: 10px;">
										<div style="padding-top:7px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; ">
										Powered by:&nbsp;  <span style="font-size:13px"><a href="http://supercloudten.com/" target="_blank" style="color:#FFF; text-decoration:none; border:none;">Super Cloud Ten</a></span>
										</div>
									</div><!--footer-->
								</div><!--main-->
								</body>
								</html>';
									 
						$msg .= '<div style="margin:0 auto; width:98%;  margin-top:20px; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#5b5b5b; ">
									 <table width="100%" border="0">
									 
										<tr>
											<td width="170" height="25" bgcolor="#fefefe" style="padding-left:10px;">IP address of this mail: </td>
											
											<td bgcolor="#fefefe" style="padding-left:10px;">'.$_SERVER['SERVER_ADDR'].'</td>
										</tr>
									 </table>
									 </div><!--2nd table-->
									</div><!--content-->
									<div style="margin:0 auto; padding:0px; width:100%; height:40px; background:url('.mysql_fetch_object(mysql_query("select * from setting where id = 3"))->settingValue.'images/fot-re.jpg) repeat-x;
									-webkit-border-bottom-right-radius: 10px;
								-webkit-border-bottom-left-radius: 10px;
								-moz-border-radius-bottomright: 10px;
								-moz-border-radius-bottomleft: 10px;
								border-bottom-right-radius: 10px;
								border-bottom-left-radius: 10px;">
										<div style="padding-top:7px; padding-left:10px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#FFF; ">
										Powered by:&nbsp;  <span style="font-size:13px"><a href="http://supercloudten.com/" target="_blank" style="color:#FFF; text-decoration:none; border:none;">Super Cloud Ten</a></span>
										</div>
									</div><!--footer-->
								</div><!--main-->
								</body>
								</html>';				
			@send_email($booktable_result->booking_email,$msg,'Restrurent Website Contact');
			@send_email($admin_mail,$msg_cust,'Restrurent Website Contact');     
				header("Location:".$_SESSION['PHP_SELF']);
				return;
		   }
		 }
	  }	  
?>
<script type="application/javascript">
$(document).ready(function(){
$( "#tabs" ).tabs();
$('.show-option').tipTip({attribute: "value", delay: "100", defaultPosition: "bottom"}); 

 $( ".accordion" ).accordion({ fillSpace: true });
});
function adminaction(as_cartid,as_action,as_ordertype){
	if(as_ordertype == 'pickup'){		
			$('#DataID').val(as_cartid);
			$('#DataAction').val(as_action);
			$('#PageAction').val('AdminAction');
			$('#hmode').val(as_ordertype);			
			$('#page_submit').submit(); 
			return true;
	}
	if(as_ordertype == 'delivery'){
			$('#DataID').val(as_cartid);
			$('#DataAction').val(as_action);
			$('#PageAction').val('AdminAction');
			$('#hmode').val(as_ordertype);
			$('#page_submit').submit(); 
			return true;
	}
	if(as_ordertype == 'booktable'){
			$('#DataID').val(as_cartid);
			$('#DataAction').val(as_action);
			$('#PageAction').val('AdminAction');
			$('#hmode').val(as_ordertype);
			$('#page_submit').submit(); 
			return true;
	}
}
</script>

<div class="ad-notif-info grid_12">
  <p>Welcome To Nashville Admin Panel** You can dismiss me by clicking me!</p>
</div>
<?php $admin_val = mysql_fetch_object(mysql_query("select * from `admin_login` where id='".$_SESSION['AID']."'")); 
if($admin_val->user_type!='superadmin')
{
	
	
	?>
    <div class="box grid_3">
        <div class="box-head">
          <h2>Total Sitter</h2></div>
        <div class="box-content ad-stats">
                <ul>
             <?php $circular_search  = mysql_query("select * from file_master as FM JOIN file_assign as FA where FM.file_id=FA.file_id and FM.file_type='circular' and FA.assign_to_type='".$admin_val->user_type."' and FA.assign_to_id='".$admin_val->department_id."' and FA.assign_to_mode_internal='1'");
			if(mysql_num_rows($circular_search)>0)
			{
			 while($C = mysql_fetch_object($circular_search))
						{?>
                        <li class="stats-up"><div class="new"></div><a href="../file_doc/<?=$C->file_doc?>" target="_blank"><strong><?=$C->file_title?></strong> - <?=$C->file_description?></a></li>
                        <?php
						}
			}
			else
			{
				?>
			 <li class="stats-up">No Downloadable Files</li>	
             <?php
			}
						?>
          
            
            
          </ul>
            <br clear="all" />
          </div>
      </div>
     <div class="box grid_3">
        <div class="box-head">
          <h2>Total family</h2>
       </div>
        <div class="box-content ad-stats">
                <ul>
            
            <?php $notice_search  = mysql_query("select * from file_master as FM JOIN file_assign as FA where FM.file_id=FA.file_id and FM.file_type='notice' and FA.assign_to_type='".$admin_val->user_type."' and FA.assign_to_id='".$admin_val->department_id."' and FA.assign_to_mode_internal='1'");
			if(mysql_num_rows($notice_search)>0)
			{
			?>
          
                        <?php while($N = mysql_fetch_object($notice_search))
						{?>
                        <li class="stats-up"><div class="new"></div><a href="../file_doc/<?=$N->file_doc?>" target="_blank"><strong><?=$N->file_title?></strong> - <?=$N->file_description?></a></li>
                        <?php
						}
						}
			else
			{
				?>
			 <li class="stats-up">No Downloadable Files</li>	
             <?php
			}
						?>
                        
            
            
            
          </ul>
            <br clear="all" />
          </div>
      </div> 


 <div class="box grid_3">
        <div class="box-head">
          <h2>Total Posted Job</h2>
   </div>
        <div class="box-content ad-stats">
                <ul>
            
            <?php $scheme_search  = mysql_query("select * from file_master as FM JOIN file_assign as FA where FM.file_id=FA.file_id and FM.file_type='scheme' and FA.assign_to_type='".$admin_val->user_type."' and FA.assign_to_id='".$admin_val->department_id."' and FA.assign_to_mode_internal='1'");
			if(mysql_num_rows($scheme_search)>0)
			{
			?>
            <?php while($S = mysql_fetch_object($scheme_search))
						{?>
                        <li class="stats-up"><div class="new"></div><a href="../file_doc/<?=$S->file_doc?>" target="_blank"><strong><?=$S->file_title?></strong> - <?=$S->file_description?></a></li>
                        <?php
						}
						}
			else
			{
				?>
			 <li class="stats-up">No Downloadable Files</li>	
             <?php
			}
						?>
            
          </ul>
            <br clear="all" />
          </div>
      </div>
     <div class="box grid_2">
        <div class="box-head">
          <h2>Total Booking</h2>
       </div>
        <div class="box-content ad-stats">
                <ul>
            
            <?php $tender_search  = mysql_query("select * from file_master as FM JOIN file_assign as FA where FM.file_id=FA.file_id and FM.file_type='tender' and FA.assign_to_type='".$admin_val->user_type."' and FA.assign_to_id='".$admin_val->department_id."' and FA.assign_to_mode_internal='1'");
			if(mysql_num_rows($tender_search)>0)
			{
			?>
           
                        <?php while($T = mysql_fetch_object($tender_search))
						{?>
                        <li class="stats-up"><div class="new"></div><a href="../file_doc/<?=$T->file_doc?>" target="_blank"><strong><?=$T->file_title?></strong> - <?=$T->file_description?></a></li>
                        <?php
						}
						}
			else
			{
				?>
			 <li class="stats-up">No Downloadable Files</li>	
             <?php
			}
						?>
            
            
            
          </ul>
            <br clear="all" />
          </div>
      </div> 
    <?php 
}
else
{
?>
<div class="box grid_1">
        <div class="box-head"><h2>Shortcut</h2></div>
        <div style="min-height:130px;" class="box-content">
         	<div class="dashboard_thumb">
            		<ul>
                	<li><a href="cms_management.php"><img src="img/dashboard/resturant.png"> <p>Manage CMS</p>
                	</a></li>
                    <li><a href="news_management.php"><img src="img/dashboard/item.png"> <p>News and Event</p></a></li>
                    
                    <li><a href="service_management.php"><img src="img/dashboard/settings.png"> <p>Manage Service</p></a></li>
                    
                   
                    <br clear="all" />
                </ul>
                
            <br clear="all" />
            </div>
        </div>
      </div>
      
<div class="box grid_2">
        <div class="box-head"><h2>Stats</h2></div>
        <div class="box-content ad-stats">
                <ul>
            
            <li class="stats-up"><h3>
            <center>
				<?=mysql_num_rows(mysql_query("select * from `employee_master`"))?>
            </center></h3><br /> Total Employee</li>
            
            
            
          </ul>
            <br clear="all" />
          </div>
      </div>

<?php
}
?>

<!--************************EndPAGE BODY***************************-->

<?

		}

		function bodyAdmin()

		{

?>

<?php$this->head(); ?>

 <?php$this->toppanel(); ?>

  <?php$this->menu(); ?>

  <?php$this->body(); ?>

  <?php//$this->footer(); ?>
 <!--

              <td width="175" height="450" align="left" valign="top" class="bg_leftpan"></td>

              <td width="100%" align="center" valign="middle"></td>

            </tr>

          </table></td>

        </tr>

    </table></td>

  </tr>

  <tr>

    <td align="center" valign="middle" class="company"></td>

  </tr>

</table>-->

<?

		}

	}

?>