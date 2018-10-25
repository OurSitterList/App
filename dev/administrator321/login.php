<?
	include("config/admin-includes.php");
	include("classes/PageStructure.php");
	
	$con=new DBConnection(host,user,pass,db);
	$conObj=$con->connectDB();
	
	$login=new PageStructure("Login");
	$login->pageTop();
	if(isset($_POST['bLogin']))
	{
		$auth=new Authentication($conObj);
		$cond="adminid='".$_POST['uid']."' AND BINARY password='".md5($_POST['pwd'])."'";
		if($auth->login(DBPrefix."admin_login",$cond,array("id"=>"AID","updtime"=>"ALOG","adminid"=>"ANAME","atype"=>"ATYPE"),"updtime"))
		{
			setcookie("uid",$_POST['uid'],mktime()-60);
			setcookie("pwd",$_POST['pwd'],mktime()-60);
			if($_POST['remember_me']==1)
			{
				setcookie("uid",$_POST['uid'],mktime()+cookietime);
				setcookie("pwd",$_POST['pwd'],mktime()+cookietime);
			}
			$con->closeConnection();
			header("Location: home.php");
		}
		else
		{
		$subuser=mysql_query("select * from `user_management` where user_name='".$_POST['uid']."' and user_pass='".$_POST['pwd']."'");
		if(mysql_num_rows($subuser)>0)
		{
		$U=mysql_fetch_object($subuser);
		$_SESSION['AID']=$U->user_id ;
		$_SESSION['ANAME']=$U->user_name ;
		$_SESSION['ATYPE']='sub_admin' ;
		$con->closeConnection();
		header("Location: home.php");
		}
		else
		{
		$con->closeConnection();
		header("Location: ./?error=1");
		}
		
			
		}
	}
?>