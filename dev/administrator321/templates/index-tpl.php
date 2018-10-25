<?
	include("classes/AdminStructure.php");
	class Index extends AdminStructure
	{
		function Index($title)
		{
			parent::AdminStructure($title);
		}
		function conDition()
		{
			if($_SESSION['AID'])
				header("Location: home.php");
		}
		function jScripts()
		{
?>
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript" src="js/index.js"></script>
<script language="javascript">
var login;
	$(document).ready(function(){
		login=new Login();
		$('#uid').focus();
<?
	if(isset($_COOKIE['uid']))
	{
		echo '$("#uid").val("'.addslashes($_COOKIE['uid']).'");';
		echo '$("#pwd").val("'.addslashes($_COOKIE['pwd']).'");';
		echo '$("#remember_me").attr("checked",true);';
	}
	if(isset($_GET['error']))
	{
		if($_GET['error']==1)
			echo 'alert("- Invalid Username/Password.");';
	}
?>
		$("#frm").submit(function(){
			return login.check();
		});
	});
</script>
<?
		}
		function body()
		{
?><style type="text/css">
div.roundedCornersDiv
{
 width: 500px;
 margin:70px auto 0 auto;
 padding: 0;
 background-color: #a2171c;
 -moz-border-radius: 10px;
 -webkit-border-radius: 10px;
 border-radius: 10px;
}
.adminstyle
{
	margin:0px;
	font-weight:normal;
	font-size: 25px;
	color:#FFF;
	font-style: normal;
	font-family:Arial, Helvetica, sans-serif;
}
span.username{color:#fff;font-family:Arial, Helvetica, sans-serif;font-size:13px; font-weight:bold;}
.loginbutton{background-color:#ffde00;padding:5px;border:none;outline:none;font-size:12px;font-weight:bold;color:#000;border-radius:6px;cursor:pointer;}
.company{font-style: normal;
	font-family:Arial, Helvetica, sans-serif;font-size:12px;}

.lg-body {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background: url(img/login-bg.jpg) repeat scroll 0 0 transparent;
    border-color: #444444 #444444 #333333;
    border-image: none;
    border-radius: 5px 5px 5px 5px;
    border-style: solid;
    border-width: 1px 1px 4px;
    box-shadow: 0 1px 0 0 #999999 inset;
    height: 235px;
    margin-top: 10px;
}
.lg-body #lg-head {
    background: url(img/login-sprite.png) no-repeat scroll 0 0 transparent;
    height: 26px;
    margin: 10px auto;
	width:460px;
}
.lg-body #lg-head p {
    color: #D3D3D3;
    font-size: 17px;
    padding: 6px 0 0 34px;
    text-shadow: 0 1px 0 #292929;
}
.lg-body .separator {
    background: url(img/separator-dark-hz.png) repeat-x scroll 0 0 transparent;
    height: 2px;
    margin: 14px 0;
}
.lg-body .login {
    margin: auto;
    padding-top: 5px;
    width: 460px;
}
.lg-body .login ul li {
    margin-top: 14px;
}
.lg-body #usr-field,.lg-body #psw-field {
    background: url(img/nav-hover.png) repeat scroll 0 0 transparent;
    border-radius: 3px 3px 3px 3px;
    box-shadow: 0 0 1px 0 #000000 inset;
    height: 32px;
    position: relative;
}
.lg-body #usr-field-icon {
    background: url(img/login-sprite.png) no-repeat scroll 0 -28px transparent;
    display: block;
    height: 18px;
    left: 8px;
    position: absolute;
    top: 8px;
    width: 22px;
}
.lg-body #psw-field-icon {
    background: url(img/login-sprite.png) no-repeat scroll 0 -48px transparent;
    display: block;
    height: 20px;
    left: 8px;
    position: absolute;
    top: 6px;
    width: 22px;
}
.lg-body .input {
    background: none repeat scroll 0 0 transparent;
    border: medium none;
    box-shadow: none;
    color: #CCCCCC;
    font-size: 12px;
    height: 32px;
    padding: 0;
    position: relative;
    text-indent: 40px;
    text-shadow: 0 1px 0 #292929;
    width: 100%;
}
.lg-body #checkbox {
    margin: 16px 0 16px 4px;
}
.lg-body .checkbox-text {
    color: #D3D3D3;
    float: none;
    font-size: 13px;
    margin-left: 6px;
}
.lg-body .submit {
    border: 1px solid #444444 !important;
    font-size: 13px !important;
    height: 26px;
    padding: 0;
    width: 82px;
}
.lg-body #lost-psw {
    float: right;
    margin-top: -24px;
}
.lg-body #lost-psw a {
    color: #D3D3D3;
    font-size: 13px;
}
</style>
<p style="height:100px">&nbsp;</p>
<div class="lg-body" style="margin:0 auto;width:500px;">
     <div class="inner">
       <div id="lg-head">
         <p>  <span class="login_logo"><img src="img/logo.png" id="usr-avatar" alt=""></span></p><br /><?php echo $GLOBALS['err_msg']; ?>
         <div class="separator"></div>
       </div>
       <div class="login">
         <form action="login.php" method="post" name="frm" id="frm">
           <fieldset>
              <ul>
                 <li id="usr-field">
                  <input type="text" placeholder="Username..." minlength="1" size="26" name="uid" id="uid" class="input required" required="required">
                  <span id="usr-field-icon"></span>
                 </li>
                 <li id="psw-field">
                  <input type="password" placeholder="Password..." minlength="1" size="26" name="pwd" id="pwd" class="input required" required="required">
                  <span id="psw-field-icon"></span>
                 </li>
                 <li class="checkbox" style="text-align:left;">
                  <input type="checkbox" value="1" id="remember_me" name="remember_me" class="checkbox"> 
                  <label class="checkbox-text" for="remember-me">Remember Me</label>
                 </li>
                 <li style="text-align:left;">
                  <input type="submit" name="bLogin" id="bLogin" value="LOGIN" class="submit button orange loginbutton">
          		<input name="reset" value="Clear" class="submit button grey loginbutton" type="reset" />
                 </li>
              </ul>
           </fieldset>
          </form>
      
        </div>
     </div>
    </div>

<?
		}
		function bodyAdmin()
		{
?>
<? //$this->head(); ?>

<? $this->body(); ?>
<?
		}
	}
?>