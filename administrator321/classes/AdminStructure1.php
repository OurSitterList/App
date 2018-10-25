<?php

	include("PageStructure.php");
	class AdminStructure extends PageStructure
	{
		function AdminStructure($title)
		{
			parent::PageStructure($title);
		}
		function css()
		{
			
		}
		function jScripts()
		{
			
		}
		function head()
		{
			$con=new DBConnection(host,user,pass,db);
			$conObj=$con->connectDB();
			$Q="SELECT settingValue FROM ".DBPrefix."setting WHERE `id`=2";
			$Rec=mysql_query($Q,$conObj) or die(mysql_error());
			$R=mysql_fetch_object($Rec);
?>

<?
			$con->closeConnection();
		}
		function toppanel()
		{
?>
 
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="left" valign="middle" class="separatorbar.jpg" style="padding-left:10px;">Last Login: <?=$_SESSION['ALOG']?date("M d, Y h:i:s A",$_SESSION['ALOG']):"First Login";?></td>
            <td align="right" valign="middle" class="separatorbar.jpg" style="padding-right:10px;">Logged in As: <?=$_SESSION['ANAME']?> <span class="mailto1">|</span> <a href="logout.php" class="separatorbar.jpg">Logout</a></td>
          </tr>
        </table>
<?
		}
		function leftpanel()
		{
			#,'Content Management'=>'dynamic-contents.php','Gallery Management'=>'gallery-mgmt.php'
			$leftLink0=array('Home'=>'home.php');
			$leftLink1=array('Admin Management'=>'admin-mgmt.php');
			
?>
<table width="173" border="0" cellspacing="0" cellpadding="0" id="leftMenuTab">
  <tr>
    <td height="22" colspan="2" align="left" valign="middle" class="heading1">Menu</td>
  </tr>
   <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"></td>
  </tr>
  <?
	foreach($leftLink0 as $title=>$link)
	{
	
?>
  <tr>
    <td height="22" align="center" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" title="home.php" class="leftlink" style="cursor:pointer;font-size:12px;font-weight:normal;" ><?=$title?></td>
  </tr>
  <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg"  /></td>
  </tr>
  
<?
	}
	
?>
  <?
  	if($_SESSION['ATYPE']==1)
	{
  ?>
   <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"></td>
  </tr>
<?
	foreach($leftLink1 as $title=>$link)
	{
	
?>
  <tr>
    <td height="22" align="center" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" title="<?=$link?>" class="leftlink" style="cursor:pointer;font-size:12px;font-weight:normal;"><?=$title?></td>
  </tr>
  <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg"  /></td>
  </tr>
  <tr>
    <td height="22" align="center" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" title="settings.php" class="leftlink" style="cursor:pointer;font-size:12px;font-weight:normal;">Setting Management</td></tr>
	<tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg"  /></td>
  </tr>
<?
	}
	}
?>
  <!--================================================================================================================-->

  <tr>
    <td height="22" colspan="2" align="left" valign="middle" class="heading1">Site Manager</td>
  </tr>
   <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg"  /></td>
  </tr>
  <tr>
    <td height="22" align="center" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" title="content.php" class="leftlink" style="cursor:pointer;font-size:12px;font-weight:normal;">Content Management</td>
  </tr>
  
  <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg" alt=""  /></td>
  </tr>
   <tr>
    <td height="22" align="center" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" title="banner.php" class="leftlink" style="cursor:pointer;font-size:12px;font-weight:normal;">banner Management</td>
  </tr>
   <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg" alt=""  /></td>
  </tr>
   <tr>
    <td height="22" align="center" valign="middle">&nbsp;</td>
    <td align="left" valign="middle" title="archive.php" class="leftlink" style="cursor:pointer;font-size:12px;font-weight:normal;">Archive Management</td>
  </tr>
  
  <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg" alt=""  /></td>
  </tr>
  
  <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"></td>
  </tr>
  <!--================================================================================================================-->

  <tr>
    <td height="22" colspan="2" align="left" valign="middle" class="heading1">User Manager</td>
  </tr>
   <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg" alt=""  /></td>
  </tr>
  <tr>
    <td height="22" align="center" valign="middle"></td>
    <td align="left" valign="middle" title="news.php" class="leftlink" style="cursor:pointer;font-size:12px;font-weight:normal;">News Subscriber Management</td>
  </tr>
  <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg" alt=""  /></td>
  </tr>
  
  <tr>
  <!--================================================================================================================-->
  <tr>
    <td height="22" colspan="2" align="left" valign="middle" class="heading1">Blog Manager</td>
  </tr>
   <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg" alt=""  /></td>
  </tr>
  <tr>
    <td height="22" align="center" valign="middle"></td>
    <td align="left" valign="middle" title="category.php" class="leftlink" style="cursor:pointer;font-size:12px;font-weight:normal;">Category Management</td>
  </tr>
  <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg" alt=""  /></td>
  </tr>
  <tr>
    <td height="22" align="center" valign="middle"></td>
    <td align="left" valign="middle" title="sub_category.php" class="leftlink" style="cursor:pointer;font-size:12px;font-weight:normal;">Sub Category Management</td>
  </tr>
  <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg" alt=""  /></td>
  </tr>
  <tr>
    <td height="22" align="center" valign="middle"></td>
    <td align="left" valign="middle" title="blog.php" class="leftlink" style="cursor:pointer;font-size:12px;font-weight:normal;">Blog Post Management</td>
  </tr>
  <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg" alt=""  /></td>
  </tr>
  <tr>
    <td height="22" colspan="2" align="left" valign="middle" class="heading1">Question Manager</td>
  </tr>
   <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg" alt=""  /></td>
  </tr>
  <tr>
    <td height="22" align="center" valign="middle"></td>
    <td align="left" valign="middle" title="question.php" class="leftlink" style="cursor:pointer;font-size:12px;font-weight:normal;">Question Management</td>
  </tr>
  <tr>
    <td height="1" colspan="2" align="center" valign="middle" bgcolor="#FFFFFF"><img src="images/separatorbar.jpg" alt=""  /></td>
  </tr>
</table>
<?
		}
		function footer()
		{
			$con=new DBConnection(host,user,pass,db);
			$conObj=$con->connectDB();
			$Q="SELECT settingValue FROM ".DBPrefix."setting WHERE `id`=5";
			$Rec=mysql_query($Q,$conObj) or die(mysql_error());
			$R=mysql_fetch_object($Rec);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <!--DWLayoutTable-->
      
      <tr>
        <td width="390" height="59" align="center" valign="middle" class="footer">&nbsp;</td>
		<td width="568" align="right" valign="middle" class="footer">&nbsp;</td>
      </tr>
      
    </table>
<?
			$con->closeConnection();
		}
		function pageAdmin()
		{
			$this->pageTop();
			$this->conDition();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<? 
	$this->pageHeadTag();
	$this->jScripts();
	$this->css();
?>
</head>
<body>
<? 
	$this->bodyAdmin();
?>
</body>
</html>
<?
			ob_flush();
		}
		function pageHeadTag()
		{
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$this->title?></title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>
<link href="style/ui.datepicker.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/ui.datepicker.js"></script>
<script language="javascript" type="text/javascript" src="js/MyFunctions.js"></script>
<script language="javascript" type="text/javascript" src="js/leftPanel.js"></script>
<?
		}
	}
?>