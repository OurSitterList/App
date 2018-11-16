<!DOCTYPE html><head>
<meta charset="UTF-8">
<meta name="description" content="" />
<meta name="author" content="" />
<meta name="viewport" content="width=device-width, initial-scale=1.0," />
<title><?=mysql_fetch_object(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='2'"))->settingValue?></title>
<link href="<?=$base_path?>/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="<?=$base_path?>/css/fonts.css" rel="stylesheet" type="text/css" />
<link href="<?=$base_path?>/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="<?=$base_path?>/css/bootstrap-theme.css" rel="stylesheet" type="text/css" />
<link href="<?=$base_path?>/css/modal.css" rel="stylesheet" type="text/css" />
<link href="<?=$base_path?>/css/custom.css" rel="stylesheet" type="text/css" />
<link href="<?=$base_path?>/css/responsive.css" rel="stylesheet" type="text/css" />
<link href="<?=$base_path?>/css/fullcalendar.css" rel='stylesheet' />
<link href="<?=$base_path?>/css/fullcalendar.print.css" rel='stylesheet' media='print' />
<link rel="stylesheet" type="text/css" href="<?=$base_path?>/css/mdp.css">
<link rel="shortcut icon" type="image/x-icon" href="<?=$base_path?>/images/favicon.ico">
<strong></strong>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
  $(function() {
	  var today = new Date();
    $( "#datepicker" ).datepicker({
			minDate: 0,
	       onClose: function( selectedDate ) {
        $( "#datepicker1" ).datepicker( "option", "minDate", selectedDate );
      }});
	 $( "#datepicker1" ).datepicker({
		 minDate: 0,
		       onClose: function( selectedDate ) {
        $( "#datepicker" ).datepicker( "option", "maxDate", selectedDate );
      }
		 });
		 
		 
		  $( "#jobdatepicker" ).datepicker({
			minDate: 0,
	       onClose: function( selectedDate ) {
        $( "#jobdatepicker1" ).datepicker( "option", "minDate", selectedDate );
      }});
	 $( "#jobdatepicker1" ).datepicker({
		 minDate: 0,
		       onClose: function( selectedDate ) {
        $( "#jobdatepicker" ).datepicker( "option", "maxDate", selectedDate );
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
          <li><a href="https://instagram.com/oursitterlistnashville/" target="_blank"><span class="fa fa-instagram instagrm"></span></a></li>
          <li><a href="https://www.facebook.com/oursitterlistnashville" target="_blank" ><span class="fa fa-facebook facebok"></span></a></li>
        </ul>
        <ul>
          <li><a href="https://twitter.com/@whschickling08"><span class="fa fa-twitter twitr"></span></a></li>
          <li><a href="https://www.pinterest.com/whschickling08/" target="_blank"><span class="fa fa-pinterest pinta"></span></a></li>
        </ul>
      </div>
      <div class="logo col-lg-6 col-md-6 col-sm-6 col-xs-12"> <a href="/"><img src="<?=$base_path?>/images/logo.png" alt="" /></a> </div>
      <div class="login col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <?php  if(isset($_SESSION['user_id']) && $_SESSION['user_id']!='')
			{
			//echo var_dump($_SESSION);
			$A_USER = mysql_fetch_object(mysql_query("select * from  user_management where user_id='".$_SESSION['user_id']."'"));
				?>
        <ul class="clearfix">
          <?php if($_SESSION['user_type']=='sitter')
				{
				?>
          <li><a href="<?=$base_path?>/sitter_dashboard.php">Hi,
            <?=$_SESSION['user_name']?>
            </a> </li>
          <?php
				}
				if($_SESSION['user_type']=='family')
				{
				?>
          <li><a href="<?=$base_path?>/family_dashboard.php">Hi,
            <?=$_SESSION['user_name']?>
            </a> </li>
          <?php
				}
				?>
          <li>/</li>
          <li><a href="<?=$base_path?>/logout.php">Logout</a></li>
        </ul>
        <?php
			}
			else
			{
			?>
        <ul class="clearfix">
          <li><a href="#" class="md-trigger" data-modal="modal-16">Login</a> </li>
          <li>/</li>
          <li><a href="<?=$base_path?>/#signuparea">Sign Up</a></li>
        </ul>
        <?php
			}
			?>
        <?php if($_REQUEST['reset_pass']==1)
			 {
				 echo '<script>$("document").ready(function() { $("#modal-password-retrieve").addClass("md-show");});</script>';
			 }
			 ?>
        <?php  if(isset($_POST['sitter_loginForm']) && $_POST['sitter_loginForm']=='yes')
		  {
			  $user_search = mysql_query("select * from user_management where user_name='".mysql_real_escape_string($_POST['sitter_login_username'])."' AND user_password='".mysql_real_escape_string(md5($_POST['sitter_login_password']))."' AND user_type = 'sitter'");
			  if(mysql_num_rows($user_search)>0)
			  {
				  $R=  mysql_fetch_object($user_search);
				  if( $R->user_status!=1 ) {
				  echo "
				<div class='md-modal md-effect-book_details md-show' id='modal-book_details'>
				            <div class='md-close book_details_close'></div>
				            <div class='md-content' id='md-content'>
				                              <div class='error-login' style='box-shadow: none !important;'>Your Account is Not Activated Yet.<br>An email has been sent and you are waiting for approval.</div>
				            </div>
				</div>";
				 	 
				 }
				 else
				 {
				  $_SESSION['user_id'] = $R->user_id;
$_SESSION['user_name'] = $R->user_name;
$_SESSION['user_type'] = 'sitter';
header('Location:'.$base_path.'/sitter_dashboard.php');
			  }
			  }
			  else
			  {
				  echo "<div class='error-login'>Username & Password Doesn't match</div>";
			  }
		  }
		  
		  if($_REQUEST['passchange']==1)
		  {
				  echo "<div class='error-login'>Your password has been reset.</div>";
			  }
		 if( $_SESSION['family_acc_create']==1)
		  {
				  echo "<div class='error-login'>Family account has been created. Wait For approval.</div>";
				  unset($_SESSION['family_acc_create']);
			  }	  
			 
		  if( $_SESSION['sitter_acc_create']==1)
		  {
				  echo "<div class='error-login'>Sitter account has been created. Wait For approval.</div>";
				  unset($_SESSION['sitter_acc_create']);
			  }	 
			  
	if(isset($_POST['family_loginForm']) && $_POST['family_loginForm']=='yes')
		  {
			  $user_search = mysql_query("select * from user_management where user_name='".mysql_real_escape_string($_POST['family_login_username'])."' AND user_password='".mysql_real_escape_string(md5($_POST['family_login_password']))."' AND user_type = 'family'");
			  if(mysql_num_rows($user_search)>0)
			  {
				 
				  $R=  mysql_fetch_object($user_search);
				 if( $R->user_status!=1 ) {
				 // echo "<div class='error-login'>Your Account is Not Activated Yet</div>";
				  echo "
						<div class='md-modal md-effect-book_details md-show' id='modal-book_details'>
						            <div class='md-close book_details_close'></div>
						            <div class='md-content' id='md-content'>
						                              <div class='error-login' style='box-shadow: none !important;'>Your Account is Not Activated Yet.<br>An email has been sent and you are waiting for approval.</div>
						            </div>
						</div>";	 
				 }
				 else if( $R->is_payment_status!=1 ) 
				 {
				  $_SESSION['user_id_member_choose'] = $R->user_id;
$_SESSION['user_name_member_choose'] = $R->user_name;
$_SESSION['user_type_member_choose'] = 'family';
//echo date('d M, Y',$R->user_expierydate);exit;
header('Location:'.$base_path.'/family_app_member.php');
				 }
				 else if( $R->user_expierydate < strtotime('now') ) {
				  echo "<div class='error-login'>Your Account is expired</div>";	 
				 }
				  
				 else
				 {
				  $_SESSION['user_id'] = $R->user_id;
$_SESSION['user_name'] = $R->user_name;
$_SESSION['user_type'] = 'family';
//echo date('d M, Y',$R->user_expierydate);exit;
header('Location:'.$base_path.'/family_dashboard.php');
				 }
			  }
			  else
			  {
				  echo "<div class='error-login'>Username & Password Doesn't match</div>";
			  }
		  }
		  ?>
        <?php  if(isset($_POST['sitter_forgetForm']) && $_POST['sitter_forgetForm']=='yes')
		  {
			   require('tools/PHPMailer-master/PHPMailerAutoload.php');	
			   $admin_contact_email = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='1'"));
	$admin_contact_name = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='4'"));
			  //echo "select * from user_management where user_name='".mysql_real_escape_string($_POST['sitter_forget_username'])."' AND user_type = 'sitter' AND user_status = '1'";
			  $user_search = mysql_query("select * from user_management where user_name='".mysql_real_escape_string($_POST['sitter_forget_username'])."' AND user_type = 'sitter' AND user_status = '1'");
			  if(mysql_num_rows($user_search)>0)
			  {
				  $R=  mysql_fetch_object($user_search);
				  $generate_code = time().rand(0,100000000);
				  mysql_query("update user_management set user_code='".$generate_code."' where user_name='".mysql_real_escape_string($_POST['sitter_forget_username'])."' AND user_type = 'sitter' AND user_status = '1'");
				  $message = file_get_contents('contact-form.html');
				  $message = str_replace('%FULL_NAME%', $R->user_name, $message);
				  $message = str_replace('%EMAIL%', $R->user_email, $message);
				  $message = str_replace('%AS%', 'Sitter', $message);
				  $message = str_replace('%COMMENT%','To Reset Your Password <a href ="https://www.oursitterlist.com/?reset_pass=1&reset_code='.$generate_code.'">Click Here</a> or copy this link in your browser https://www.oursitterlist.com/?reset_pass=1&reset_code='.$generate_code, $message);
				 
				  $mail = new PHPMailer;
				  $mail->Debugoutput = 'html';
				  $mail->setFrom($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
				  $mail->addAddress($R->user_email, $R->user_name);
				  $mail->addAddress('pgurjar007@gmail.com');
				  //$mail->addAddress('chrisperando@gmail.com');
				  //$mail->addAddress('crisperando@yahoo.com');
				  $mail->Subject = 'Reset - Sitter Account Password';
				  $mail->msgHTML($message);
				  $mail->AltBody = 'This is a plain-text message body';
				if (!$mail->send()) {
				echo "<div class='error-login'>".$mail->ErrorInfo."</div>"; 
				
				}
				else
				{
				echo "<div class='error-login'>A email has been sent to your registered account</div>"; 
				}
			  }
			  else
			  {
				  echo "<div class='error-login'>Username Doesn't exist</div>";
				  die;
			  }
		  }
		  
		   if(isset($_POST['family_forgetForm']) && $_POST['family_forgetForm']=='yes')
		  {
			   require('tools/PHPMailer-master/PHPMailerAutoload.php');	
			   $admin_contact_email = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='1'"));
	$admin_contact_name = mysql_fetch_array(mysql_query("SELECT `settingValue` FROM `setting` WHERE `id`='4'"));
			  //echo "select * from user_management where user_name='".mysql_real_escape_string($_POST['family_forget_username'])."'  AND user_type = 'family' AND user_status = '1'";
			  $user_search = mysql_query("select * from user_management where user_name='".mysql_real_escape_string($_POST['family_forget_username'])."'  AND user_type = 'family' AND user_status = '1'");
			 			  if(mysql_num_rows($user_search)>0)
			  {
				  $R=  mysql_fetch_object($user_search);
				  $generate_code = time().rand(0,100000000);
				  mysql_query("update user_management set user_code='".$generate_code."' where user_name='".mysql_real_escape_string($_POST['family_forget_username'])."' AND user_type = 'family' AND user_status = '1'");
				  $message = file_get_contents('contact-form.html');
				  $message = str_replace('%FULL_NAME%', $R->user_name, $message);
				  $message = str_replace('%EMAIL%', $R->user_email, $message);
				  $message = str_replace('%AS%', 'Family', $message);
				  $message = str_replace('%COMMENT%','To Reset Your Password <a href ="https://www.oursitterlist.com/?reset_pass=1&reset_code='.$generate_code.'">Click Here</a>or copy this link in your browser https://www.oursitterlist.com/?reset_pass=1&reset_code='.$generate_code, $message);
				 
				  $mail = new PHPMailer;
				  $mail->Debugoutput = 'html';
				  $mail->setFrom($admin_contact_email['settingValue'], $admin_contact_name['settingValue']);
				  $mail->addAddress($R->user_email, $R->user_name);
				  $mail->addAddress('pgurjar007@gmail.com');
				  //$mail->addAddress('chrisperando@gmail.com');
				  //$mail->addAddress('crisperando@yahoo.com');
				  $mail->Subject = 'Reset - Family Account Password';
				  $mail->msgHTML($message);
				  $mail->AltBody = 'This is a plain-text message body';
				if (!$mail->send()) {
				echo "<div class='error-login'>".$mail->ErrorInfo."</div>"; 
				}
				else
				{
				echo "<div class='error-login'>A email has been sent to your registered account</div>"; 
				
				}
				; 
			  }
			  else
			  {
				  echo "<div class='error-login'>Username Doesn't exist</div>";
			  }
 
		  }
		  ?>
            <div class="md-modal md-effect-16" id="modal-16">
            <div class="md-close">X</div>
            <div class="md-content">
            <div class="sitter_log">
            <div class="log_head"> <span></span>
            <h3>Sitter Login</h3>
            </div>
            <div class="sitter_form"  id="sitter_login_form" >
            <form action="<?=$_SERVER['PHP_SELF']?>" id="sitter_loginForm" method="post">
              <input type="hidden" name="sitter_loginForm" value="yes">
              <input type="text" placeholder="Enter Username" class="sitter_input" name="sitter_login_username" id="sitter_login_username"/>
              <input type="password" placeholder="Enter Password" class="sitter_input" name="sitter_login_password" id="sitter_login_password"/>
              <input type="submit" value="Login" class="login_sub_btn" />
              <input type="button" value="Forget Password" class="login_sub_btn" onClick="call_forget_area('sitter')" />
            </form>
            </div>
            <div class="sitter_form"  id="sitter_forget_form" style="display:none;">
            <form action="<?=$_SERVER['PHP_SELF']?>" id="sitter_forgetForm" method="post">
              <input type="hidden" name="sitter_forgetForm" value="yes">
              <input type="text" placeholder="Enter Username" class="sitter_input" name="sitter_forget_username" id="sitter_forget_username"/>
              <input type="submit" value="Send" class="login_sub_btn" />
              <input type="button" value="Back to Login" class="login_sub_btn" onClick="call_login_area('sitter')" />
            </form>
            </div>
            </div>
            <div class="family_log">
            <div class="log_head"> <span></span>
            <h3>Family Login</h3>
            </div>
            <div class="sitter_form" id="family_login_form">
            <form action="<?=$_SERVER['PHP_SELF']?>" id="family_loginForm" method="post">
              <input type="hidden" name="family_loginForm" value="yes">
              <input type="text" placeholder="Enter Username" class="sitter_input" name="family_login_username" id="family_login_username"/>
              <input type="password" placeholder="Enter Password" class="sitter_input" name="family_login_password" id="family_login_password"/>
              <input type="submit" value="Login" class="login_sub_btn" />
              <input type="button" value="Forget Password" class="login_sub_btn" onClick="call_forget_area('family')" />
            </form>
            </div>
            <div class="sitter_form"  id="family_forget_form" style="display:none;">
            <form action="<?=$_SERVER['PHP_SELF']?>" id="family_forgetForm" method="post">
              <input type="hidden" name="family_forgetForm" value="yes">
              <input type="text" placeholder="Enter Username" class="sitter_input" name="family_forget_username" id="family_forget_username"/>
              <input type="submit" value="Send" class="login_sub_btn" />
              <input type="button" value="Back to Login" class="login_sub_btn" onClick="call_login_area('family')" />
            </form>
            </div>
            </div>
            </div>
            </div>
            <div class="md-modal md-effect-customer-signup family-signup" id="modal-customer-signup">
                <div class="md-close">X</div>
                <div class="md-content">
                    <div class="sitter_log">
                        <div class="log_head family-head"> <span></span>
                        <h3>Get A Sitter -  Sign Up As Family</h3>
                        </div>
                        <div class="sitter_form">
                        <form action="<?=$base_path?>/family_app_register.php" method="post" id="familysignupForm">
                            <input type="email" name="family_email" id="family_email" placeholder="Enter Email Adress" class="sitter_input"/>
                            <input type="text"   name="family_username" id="family_username" placeholder="Enter Username" class="sitter_input"/>
                            <input type="password" name="family_password" id="family_password" placeholder="Enter Password" class="sitter_input"/>
                            <input type="password"  name="family_cpassword" id="family_cpassword" placeholder="Enter Confirmed Password" class="sitter_input"/>
                            <input type="submit" value="Sign Up" class="login_sub_btn" />
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
            <div class="log_head"> <span></span>
            <h3>Watch a Child -  Sign Up As Sitter</h3>
            </div>
            <div class="sitter_form">
            <form action="<?=$base_path?>/sitter_app_register.php" method="post" id="signupForm">
         
            <input type="email" name="sitter_email" id="sitter_email" placeholder="Enter Email Adress" class="sitter_input"/>
            <input type="text"   name="sitter_username" id="sitter_username" placeholder="Enter Username" class="sitter_input"/>
            <input type="password" name="sitter_password" id="sitter_password" placeholder="Enter Password" class="sitter_input"/>
            <input type="password"  name="sitter_cpassword" id="sitter_cpassword" placeholder="Enter Confirmed Password" class="sitter_input"/>
            <input type="submit" value="Sign Up" class="login_sub_btn" />
           
            </form>
            </div>
            </div>
            </div>
            </div>
            
            
            
            <div class="md-modal md-effect-sitter-signup sitter-signup" id="modal-password-retrieve">
            <div class="md-close password_retrieve_close"></div>
            <div class="md-content">
            <div class="sitter_log">
            <div class="log_head"> <span></span>
            <h3>Reset Password</h3>
            </div>
            <div class="sitter_form">
            <form action="<?=$base_path?>/reset_password.php" method="post" id="ResetpassForm">
            <input type="hidden" name="hidden_code" id="hidden_code" value="<?=$_REQUEST['reset_code']?>">
            <input type="password" name="sitter_new_password" id="sitter_new_password" placeholder="New Password" class="sitter_input"/>
            <input type="password"  name="sitter_new_cpassword" id="sitter_new_cpassword" placeholder="Confirmed New Password" class="sitter_input"/>
            <input type="submit" value="Reset" class="login_sub_btn" />
            </form>
            </div>
            </div>
            </div>
            </div>
            <div class="md-modal md-effect-search" id="modal-search">
            <div class="md-close">X</div>
            <div class="md-content">
            <div class="sitter_log">
            <div class="log_head"> <span></span>
            <h3>Search For Sitter</h3>
            </div>
            <div class="sitter_form">
            <form action="<?=$base_path?>/sitter_list.php" method="post" id="searchForm">
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
            <select class="input_lrg" name="search_location_code" id="search_location_code"  >
            <option value="" <?=$R->location_code==''?'selected':''?> >Select Zipcode</option>
            <?php  $state_query =  mysql_query("select * from states order by state ");
            if(mysql_num_rows($state_query)>0)
            {
            while($S = mysql_fetch_object($state_query))
            {
                ?>
            <option value="<?=$S->state_code?>" <?=$S->state_code==$R->location_code?'selected':''?> >
            <?=$S->state?>
            </option>
            <?php
            }
            }
            ?>
            </select>
            </div>
            <div class="form-fieldb">
            <input type="submit" value="Search" class="login_sub_btn" />
            </div>
            </form>
            </div>
            </div>
            </div>
            </div>
            <div class="md-modal md-effect-search" id="modal-book">
            <div class="overlay-one" style="display:none;"> <img src="<?=$base_path?>/images/loading.gif" alt="" /> </div>
            <div class="md-close">X</div>
            <div class="md-content">
            <div class="sitter_log">
            <div class="log_head"> <span></span>
            <h3>Book A Sitter</h3>
            </div>
            <div class="error" id="bookForm_error"></div>
            <div class="sitter_form">
            <form action="<?=$base_path?>/sitter_details.php?sitter_id=<?=$_REQUEST['sitter_id']?>" method="post" id="bookForm">
            <input type="hidden" name="sitter_main_id" id="sitter_main_id" value="<?=base64_decode($_REQUEST['sitter_id'])?>">
            <div class="left">
            <input type="hidden" name="bookForm" value="yes">
            <div id='calendar'></div>
            <input type="hidden" id="altField" value="" name="calender_val" required>
            <div id="time_area0"></div>
            </div>
            <div class="right">
            <div class="form-field">
            <label>No Of Kids</label>
            <input type="text" id="no_of_kids" name="no_of_kids" required>
            </div>
            <div class="form-field">
            <label>Zipcode</label>
            <select class="input_lrg" name="location_code" id="location_code"  >
            <?php  $state_query =  mysql_query("select * from states order by state ");
            if(mysql_num_rows($state_query)>0)
            {
            while($S = mysql_fetch_object($state_query))
            {
                ?>
            <option value="<?=$S->state?>" >
            <?=$S->state?>
            </option>
            <?php
            }
            }
            ?>
            </select>
            </div>
            <div class="form-field">
            <label>Remarks</label>
            <input type="text" id="remarks" name="remarks">
            </div>
            <input type="submit" value="Book" class="login_sub_btn" />
            </div>
            </form>
            </div>
            </div>
            </div>
            </div>
            <div class="md-modal md-effect-search" id="modal-post-job">
            <div class="overlay-one" style="display:none;"> <img src="<?=$base_path?>/images/loading.gif" alt="" /> </div>
            <div class="md-close">X</div>
            <div class="md-content">
            <div class="sitter_log">
            <div class="log_head"> <span></span>
            <h3>Post A Job</h3>
            </div>
            <div class="error" id="job_bookForm_error"></div>
            <div class="sitter_form">
            <form action="<?=$base_path?>/family_jobposting.php" method="post" id="PostjobForm">
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
            <select class="input_lrg" name="job_location_code" id="job_location_code"  >
            <?php  $state_query =  mysql_query("select * from states order by state ");
            if(mysql_num_rows($state_query)>0)
            {
            while($S = mysql_fetch_object($state_query))
            {
                ?>
            <option value="<?=$S->state?>" >
            <?=$S->state?>
            </option>
            <?php
            }
            }
            ?>
            </select>
            </div>
            <div class="form-field">
            <label>Remarks</label>
            <input type="text" id="job_remarks" name="job_remarks">
            </div>
            <input type="submit" value="Book" class="login_sub_btn" />
            </div>
            </form>
            </div>
            </div>
            </div>
            </div>
            <div class="md-modal md-effect-search" id="modal-edit-job">
            <div class="overlay-one" style="display:none;"> <img src="<?=$base_path?>/images/loading.gif" alt="" /> </div>
            <div class="md-close">X</div>
            <div class="md-content">
            <div class="sitter_log">
            <div class="log_head"> <span></span>
            <h3>Edit Job</h3>
            </div>
            <div class="error" id="job_bookForm_error"></div>
            <div class="sitter_form">
            <form action="<?=$base_path?>/family_jobediting.php" method="post" id="edit_PostjobForm">
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
            <select class="input_lrg" name="edit_job_location_code" id="edit_job_location_code"  >
            <?php  $state_query =  mysql_query("select * from states order by state ");
            if(mysql_num_rows($state_query)>0)
            {
            while($S = mysql_fetch_object($state_query))
            {
                ?>
            <option value="<?=$S->state?>" >
            <?=$S->state?>
            </option>
            <?php
            }
            }
            ?>
            </select>
            </div>
            <div class="form-field">
            <label>Remarks</label>
            <input type="text" id="edit_job_remarks" name="edit_job_remarks">
            </div>
            <input type="submit" value="Book" class="login_sub_btn" />
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
            <div class="log_head"> <span></span>
            <h3>Search For Job</h3>
            </div>
            <div class="sitter_form">
            <form action="<?=$base_path?>/job_list.php" method="post" id="jobsearchForm">
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
            <select class="input_lrg" name="job_search_location_code" id="job_search_location_code"  >
            <option value="" >Select Zipcode</option>
            <?php  $state_query =  mysql_query("select * from states order by state ");
            if(mysql_num_rows($state_query)>0)
            {
            while($S = mysql_fetch_object($state_query))
            {
                ?>
            <option value="<?=$S->state?>" >
            <?=$S->state?>
            </option>
            <?php
            }
            }
            ?>
            </select>
            </div>
            <div class="form-fieldb">
            <input type="submit" value="Search" class="login_sub_btn" />
            </div>
            </form>
            </div>
            </div>
            </div>
            </div>
            <div class="md-modal md-effect-book_details" id="modal-book_details">
            <div class="md-close book_details_close"></div>
            <div class="md-content-sidebar" id="md-content-sidebar"> </div>
            <div class="md-content">
            <div class="sitter_log">
            <div class="log_head"> <span></span>
            <h3>Booking information for <font id="book_info_date"></font></h3>
            </div>
            <div class="sitter_form" id="book_details_area"> </div>
            <div class="sitter_form" id="book_confirmation_area"> </div>
            <div class="" id="book_message_system">
            <div class="" id="book_message_part">
            <ul id="book_message_part_ul">
            </ul>
            </div>
            <div class="" id="book_message_form"> </div>
            </div>
            </div>
            </div>
            </div>
            <div class="md-modal md-effect-search" id="apply-job">
            <div class="md-close">X</div>
            <div class="md-content">
            <div class="sitter_log">
            <div class="log_head"> <span></span>
            <h3>Apply For Job - <br>
            <div id="job_code_area"></div>
            </h3>
            </div>
            <div class="sitter_form">
            <form action="<?=$base_path?>/apply_job.php" method="post" id="applyjobForm">
            <input type="hidden" name="job_code_input" id="job_code_input" value="">
            <div class="form-field">
            <label>Remarks</label>
            <textarea name="job_remarks" id="job_remarks"></textarea>
            </div>
            <div class="form-fieldb">
            <input type="submit" value="Apply" class="login_sub_btn" />
            </div>
            </form>
            </div>
            </div>
            </div>
            </div>
          
        <div class="md-overlay"></div>
        
        
        <!-- the overlay element -->
        <ul class="top-menu-list">
          <li><a href="<?=$base_path?>/about_us.php"><span class="img-span"><img src="<?=$base_path?>/images/cycle.png" /></span> <span>About</span></a></li>
          <li><a href="<?=$base_path?>/how-it-works.php"><span class="img-span"><img src="<?=$base_path?>/images/teddy-bear.png" /></span> <span>How It Works</span></a></li>
        </ul>
      </div>
    </div>
  </div>
</header>
<!--inner-menu-->
<?php if((!isset($_SESSION['user_id']) && $_SESSION['user_id']==''))
			{
			}
			else
			{
		?>
<div class="container">
  <div class="row">
    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
      <ul class="inner-navmenu-list">
        <?php if($_SESSION['user_type']=='sitter')
					{
					?>
        <li><a href="<?=$base_path?>/sitter_dashboard.php">Job Feed</a></li>
        <li><a href="<?=$base_path?>/sitter_application.php">Edit Account Info</a></li>
        <li><a href="<?=$base_path?>/sitter_booking.php">Check booking Information</a></li>
        <li><a href="#">Check Reviews</a></li>
        <li><a href="<?=$base_path?>/applied_job_list.php">Applied Job</a></li>
        <?php
					}
					if($_SESSION['user_type']=='family')
					{
					?>
        <li><a href="<?=$base_path?>/family_dashboard.php">Sitter Feed</a></li>
        <li><a href="<?=$base_path?>/family_application.php">Edit Account Info</a></li>
        <li><a href="<?=$base_path?>/family_booking.php">Check booking Information</a></li>
        <li><a href="#" class="md-trigger" data-modal="modal-post-job">Post Job</a></li>
        <li><a href="<?=$base_path?>/family_posting.php">Check Posted Jobs</a></li>
        <?php
					}
					?>
      </ul>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
      <div class="search-box1">
        <?php if($_SESSION['user_type']=='sitter')
					{
					?>
        <a data-modal="modal-search-job" class="md-trigger" href="javascript:void(0);"> <img src="<?=$base_path?>/images/inner-search-bg.png" alt="" /><span class="search-subject">Search Job</span></a>
        <?php
					}
					if($_SESSION['user_type']=='family')
					{
					?>
        <a data-modal="modal-search" class="md-trigger" href="javascript:void(0);"> <img src="<?=$base_path?>/images/inner-search-bg.png" alt="" /><span class="search-subject">Search Sitter</span></a>
        <?php
					}
					?>
      </div>
    </div>
  </div>
</div>
<?php
			}
			?>