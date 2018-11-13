<?php
error_reporting(0);
ini_set("display_errors", 0);
	include("PageStructure.php");

	//include_once("./fckeditor/fckeditor.php");

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

<!--**********************HEADER*********************-->
<?php /*?><div class="header"><a href="#"><img src="img/logo.jpg" alt="Logo" style="height:80px"></a></div><?php */?>
<div class="top-bar">
  <ul id="nav">
    <li id="user-panel"><img src="img/logo.png" id="usr-avatar" alt="">
      <div id="usr-info">
        <p id="usr-name">Welcome back,
          <?php echo $_SESSION['ANAME']?>
          </p>
       <?php $admin_query = mysql_fetch_object(mysql_query("select * from `admin_login` where id='".$_SESSION['AID']."'")); ?>
        <p><?=$admin_query->user_type!='superadmin'?'':'<a href="settings.php">Setting</a>'?><a href="logout.php">Log out</a></p>
      </div>
    </li>
    <li>
      <ul id="top-nav">
        <li class="nav-item"><a href="./"><img src="img/adminico/Dashboard_<?=$this->title=='Dashboard'?'on':'off'?>.png" alt="">
          <p>Dashboard</p>
          </a></li>
        <?php 
  if($_SESSION['ATYPE']=='sub_admin')
  {
  $result=mysql_fetch_object(mysql_query("SELECT * FROM user_management WHERE user_id=".$_SESSION['AID']));
  }
  else
  {
	  if($_SESSION['ANAME']=='admin')
	  {
	  $result->user_access='5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,23,24,25';
	  }
  }
  $myarr=explode(",",$result->user_access);

  $panel_head=mysql_query("select * from `panel_management` where parent_id='0'");
  if(mysql_num_rows($panel_head)>0)
	{
  while($P=mysql_fetch_object($panel_head))
  {?>
        <li class="nav-item"><a href="<?=$P->panel_link?>"><img src="img/adminico/<?=$P->panel_icon?>_<?=$this->title==$P->panel_icon?'on':'off'?>.png" alt="">
          <p>
            <?=$P->panel_name?>
          </p>
          </a>
          <?php $panel=mysql_query("select * from `panel_management` where parent_id='".$P->panel_id."' order by panel_id");
	if(mysql_num_rows($panel)>0)
	{
	echo '<ul style="display: none;" class="sub-nav">';
	while($PP=mysql_fetch_object($panel))
	{
	
	$checked = (in_array ($PP->panel_id , $myarr )) ? 'online' : 'offline';
	?>
        <li><a href="<?=$PP->panel_link?>" class="<?=$checked?>">
          <?=$PP->panel_name?>
          </a></li>
        <?php
	}
	echo '</ul>';
	}
	echo '</li>';
  } 
  }?>
        
        <!--<li><a href="subcategory_management.php">Sub Category Management</a></li>-->
        
        <li class="nav-item" style="width:120px;"><a href="#"><img src="img/adminico/Setting_<?=$this->title=='Setting'?'on':'off'?>.png" alt="">
          <p>Administrator Setting</p>
          </a>
          <ul style="display: none;" class="sub-nav">
            <li><a href="logout.php" class="online">Logout</a></li>
            <li><a href="settings.php" class="<?=$_SESSION['ATYPE']=='sub_admin'?'offline':'online'?>">Site Settings</a></li>
            <li><a href="admin-mgmt.php" class="<?=$_SESSION['ATYPE']=='sub_admin'?'offline':'online'?>">Password Change</a></li>
           
          </ul>
        </li>
        
 
      </ul>
    </li>
  </ul>
</div>

<!--*********************END HEADER***************************-->
<div class="content container_12">
<?php

			//$con->closeConnection();

		}

		function toppanel()

		{

?>

<!--**********************SUB HEADER*********************-->

<!--*********************END SUB HEADER***************************-->

<?php

		}

		function menu()


		{?>
<?php /*?><script  type="text/javascript"
        src="http://ajax.microsoft.com/ajax/jquery/jquery-1.4.2.min.js"></script>
        <script type="text/javascript">
   $(document).ready(function(){
       $(document).mousemove(function(e){
          //$('#spnCursor').html("X Axis : " + e.pageX + "<br/> Y Axis : " + e.pageY);
		   $('#cursorx').val(e.pageX);
   		   $('#cursory').val(e.pageY);
       });
	   
	   
    });
	//window.setInterval(yourfunction, 1000);
	 setInterval(function(){
                    if($('#cursorx').val()==$('#cursoroldx').val() && $('#cursory').val()==$('#cursoroldy').val())
 {
 window.location="home.php";
 }
  else
  {
 
  }
   $('#cursoroldx').val($('#cursorx').val());
   $('#cursoroldy').val($('#cursory').val());
                }, 60000);
  </script>
<?php */?>
<input type="hidden" name="cursoroldx" id="cursoroldx"  />
<input type="hidden" name="cursoroldy" id="cursoroldy" />
<input type="hidden" name="cursorx" id="cursorx" />
<input type="hidden" name="cursory" id="cursory" />

<!--**********************Menu*********************-->

<?php /*?><ul class="menu">

	<li><a href="./" style="background: url(img/docs.png) no-repeat 6px center;padding: 0 10px 0 40px;">My dashboard</a></li>
	
  <?php 
  if($_SESSION['ATYPE']=='sub_admin')
  {
  $result=mysql_fetch_object(mysql_query("SELECT * FROM user_management WHERE user_id=".$_SESSION['AID']));
  }
  else
  {
	  if($_SESSION['ANAME']=='admin')
	  {
	  $result->user_access='5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,23,24,25';
	  }
  }
  $myarr=explode(",",$result->user_access);
  
  $panel_head=mysql_query("select * from `panel_management` where parent_id='0'");
  if(mysql_num_rows($panel_head)>0)
	{
  while($P=mysql_fetch_object($panel_head))
  {?>
  <li><a href="<?=$P->panel_link?>" style="background: url(img/master.png) no-repeat 6px center;padding: 0 10px 0 40px;"><?=$P->panel_name?></a>
	<?php $panel=mysql_query("select * from `panel_management` where parent_id='".$P->panel_id."'");
	if(mysql_num_rows($panel)>0)
	{
	echo '<ul>';
	while($PP=mysql_fetch_object($panel))
	{
	
	$checked = (in_array ($PP->panel_id , $myarr )) ? 'online' : 'offline';
	?>
	 <li><a href="<?=$PP->panel_link?>" class="<?=$checked?>" <?=$PP->panel_id==15||$PP->panel_id==12?'style="width:150px;"':''?>><?=$PP->panel_name?></a></li>
	 <?php
	}
	echo '</ul>';
	}
	echo '</li>';
  } 
  }?>
   
     
      
        <!--<li><a href="subcategory_management.php">Sub Category Management</a></li>-->
     
   
    
	
	
 
     <li><a href="#" style="background: url(img/admin.png) no-repeat 6px center;padding: 0 10px 0 40px;">Logged in As: <?=$_SESSION['ANAME']?></a>

		<ul>
			<li><a href="logout.php" class="online">Logout</a></li>
            <li><a href="settings.php" class="<?=$_SESSION['ATYPE']=='sub_admin'?'offline':'online'?>">Site Settings</a></li>
            <li><a href="admin-mgmt.php" class="<?=$_SESSION['ATYPE']=='sub_admin'?'offline':'online'?>" style="width:150px;">Password Change</a></li>
			<li><a href="create_user.php" class="<?=$_SESSION['ATYPE']=='sub_admin'?'offline':'online'?>">Create User</a></li>
		</ul>

	</li>

</ul><?php */?>

<!--*********************END MENU***************************-->

<?php

}



		

		function pageAdmin()

		{

			$this->pageTop();

			$this->conDition();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php

	$this->pageHeadTag();

	$this->jScripts();

	$this->css();

?>
</head>

<body>
<input type="hidden" name="a_value" id="a_value" />
<div id="page">
  <?php

	$this->bodyAdmin();

?>
</div>
</div>

</body>
</html>
<?

			ob_flush();

		}

		function pageHeadTag()

		{

?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?=$this->title?> - Nashville
</title>
<link rel="stylesheet" href="css/master.css">
<link rel="stylesheet" href="css/tables.css">
<link rel="stylesheet" href="css/iphone-check.css">
	<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<script src="js/jquery-1.js"></script>
<script src="js/jquery-ui-1.js"></script>
<script src="js/styler.js"></script>
<script src="js/jquery_004.js"></script>
<script src="js/colorpicker.js"></script>
<script src="js/sticky.js"></script>
<script src="js/global.js"></script>
<script src="js/jquery_002.js"></script>
<script src="js/jquery_003.js"></script>
<script src="js/jquery.js"></script>
<script src="js/fileinput.js"></script>
<script src="js/iphone-check.js"></script>
<script src="js/lightbox.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css" />
<script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
<script language="javascript" type="text/javascript" src="js/MyFunctions.js"></script>

<link href="css/css.css" rel="stylesheet" type="text/css">
<link href="css/css_002.css" rel="stylesheet" type="text/css">
<link href="css/icons.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" type="image/x-icon" href="../images/favicon.ico">
<?php

		}

	}

?>
