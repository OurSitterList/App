<?php
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
<div id="header">
<div id="logo">
<img src="image/logo.jpg" height="115px">
</div>
<div id="logo1">
<?=stripslashes($R->settingValue)?>
</div>
</div>
<!--*********************END HEADER***************************-->

<?
			$con->closeConnection();
		}
		function toppanel()
		{
?>
<!--**********************SUB HEADER*********************-->
<div id="sub_header">
<div id="Time">Last Login: <?=$_SESSION['ALOG']?date("M d, Y h:i:s A",$_SESSION['ALOG']):"First Login";?></div>
<div id="Date">Logged in As: <?=$_SESSION['ANAME']?> </div>
<div id="log_out">[<a href="./" style="text-decoration:none; color:#FFFFFF;">Dashboard</a>]&nbsp;[<a href="logout.php" style="text-decoration:none; color:#FFFFFF;"><?php /*?><img src="image/logout.png" alt="Log Out" title="Log Out"/><?php */?>logout</a>]</div>

</div>

<!--*********************END SUB HEADER***************************-->

<?
		}
		function menu()
		{?>
		<!--**********************Menu*********************-->

<div id="menu_list">
<?php /*?><ul class="menu">
	<li class="top"><a href="./" class="top_link"><span>Home</span></a></li>
 
	<li class="top"><a href="#" class="top_link"><span>Category Manager</span></a>
		<ul class="sub">
			<li> <a href="category.php">Category Management</a></li>			
            <li> <a href="sub_category.php">Sub Category Management</a></li>
		</ul>
	</li>

	<li class="top"><a href="area.php" class="top_link"><span>Area Management</span></a>
		
	</li>
    <li class="top"><a href="company.php" class="top_link"><span>Company Management</span></a>
   </li>
<li class="top"><a href="#" class="top_link"><span>Company Details Management</span></a>
		<ul class="sub">
			<li><a href="settings.php">Setting</a></li>			
            <li><a href="admin-mgmt.php">Passsword Change</a></li>
		</ul>
	</li>

</ul><?php */?>
<p style="height:5px;">&nbsp;</p>
<span><strong>General Site Setup</strong></span><br>
<a href="settings.php">Site Settings</a><br>
<a href="admin-mgmt.php">Theme & Language Options</a><br>
<!--<a href="#">Date Functions & Timezone</a><br>
<a href="#">Support Departments</a><br>
<a href="#">Manage Categories</a><br>
<a href="#">Meta Tags</a><br>-->
<br />
<span><strong>Product/Configurations</strong></span><br>
<a href="group_management.php">Group Management</a><br>
<a href="category_management.php">Category Management</a><br>
<a href="subcategory_management.php">Sub Category Management</a><br>
<a href="product_entry.php">Product Entry</a><br>
<a href="product_management.php">Product Management</a><br>
<br />
<span><strong>Admin Management</strong></span><br>
<a href="admin-mgmt.php">Admin User Management</a><br>
<!--<a href="#">Admin Logs</a>--><br>
<br/>
<span><strong>User Management</strong></span><br>
<!--<a href="member_registration.php">Member Registration</a><br>
<a href="membership_group_registration.php">Membership Groups</a><br>-->
<a href="member_management.php">Member Management</a><br>
<!--<a href="#">Member Approval Queue</a><br>
<a href="#">Send Activation Emails</a><br>-->
<br/>
<span><strong>Order Management</strong></span><br>
<a href="order_management.php">Order Management</a><br>
<br />
<span><strong>Page Management</strong></span><br>
<a href="page_management.php">Page Management</a><br></br>

<span><strong>Banner Management</strong></span><br>
<a href="banner_management.php">banner Management</a><br>


<?php /*?><a href="news_letter_management.php">Newsletter</a><br>
<br/>

<span><strong>Project Management</strong></span><br>
<a href="category_management.php">category Management</a><br>
<a href="subcategory_management.php">Sub Category Management</a><br><br>
<span><strong>Listing Management</strong></span><br>
<!--<a href="#">Listing Budgets</a><br>
<a href="#">Listing Approval Queue</a><br>-->
<a href="open_listing.php">Open Listingsv</a><br>
<a href="close_listing.php">Closed Listings</a><br>
<a href="#">Listing History</a><br>
<br/>
<span><strong>Accounting/Transactions</strong></span><br>
<a href="payment_get_way.php">Payment Gateways</a><br>
<!--<a href="#">Escrow Mediation</a><br>
<a href="#">Income Report</a><br>
<a href="#">Create Invoice</a><br>
<a href="#">Manual Transaction</a><br>
<a href="#">Pending Transactions</a><br>
<a href="#">Transaction History</a><br>
<br/>
<span><strong>Disputes & Reports</strong></span><br>
<a href="#">Violation Reports</a><br>
<br />
<span><strong>Support Center</strong></span><br>
<a href="#">Open Support Tickets</a><br>
<a href="#">Closed Support Tickets</a><br>
<a href="#">Create Support Ticket</a><br>

<br/>
-->
<span><strong>Custom Fields</strong></span><br>
<a href="#">Custom Fields</a><br>
<br/>-->
<br>
<span><strong>Site Content</strong></span><br>
<a href="news_announcements.php">News & Announcements</a><br>
<!--<a href="#">Knowledgebase</a><br>-->
<?php 
    $con=new DBConnection(host,user,pass,db);
			$conObj=$con->connectDB();
	$sql="select * from static_site_content";
	$result=mysql_query($sql);
	while($rows=mysql_fetch_array($result))
	{ ?>
  
<a href="site_static.php?id=<?=$rows['static_id'];?>"><?= $rows['static_title'];?></a><br>
  <?php } ?>
<!--<a href="#">Custom Pages Management</a><br>
<br/>

<span><strong>Maintenance</strong></span><br>
<a href="#">Database Backup</a><br>
<a href="#">Repair / Optimize Tables</a><br>
<a href="#">Update Counters</a><br>
<a href="#">View PHP Info</a><br>
<br/>-->
<br>
<span><strong>Tools</strong></span><br>
<!--<a href="#">IP Deny List</a><br>-->
<a href="currency_list_management.php">Currency List</a><br>
<!--<a href="#">Reset Category Count</a><br>-->
<a href="violation_reason_management.php">Violation Reasons</a><br>
<a href="country_list.php">Country List</a><br><?php */?>
<br/>
</div>

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
<link href="style/default.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>
<link href="style/ui.datepicker.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="style/menu_style.css" type="text/css" />
<script language="javascript" type="text/javascript" src="js/ui.datepicker.js"></script>
<script language="javascript" type="text/javascript" src="js/MyFunctions.js"></script>
<script type="text/javascript">
/*$(document).ready(function() {
	$("ul#navi li").click(function(){
	$(this).css({ 'background' : '#FFFFFF url(images/navi-c.gif) repeat-x'}); //Add background color + image on hovered list item
	$(this).find("a").css({ 'color' : '#6e6e5f'});
	$(this).find("span").find("a").css({ 'color' : '#ffffff'});
	$(this).find("span").show();
	$('#a_value').val('1');
	
});
$("ul#navi li").hover(function() { 
//Hover over event on list item

	$(this).css({ 'background' : '#FFFFFF url(images/navi-c.gif) repeat-x'}); //Add background color + image on hovered list item
	$(this).find("a").css({ 'color' : '#6e6e5f'});
	$(this).find("span").find("a").css({ 'color' : '#ffffff'});
	$(this).find("span").show(); 
	$('#a_value').val('0');
	//Show the navi
} , function() {
if($('#a_value').val()==0)
{
$(this).css({ 'background' : '#6e6e5f'}); //Ditch the background
	$(this).find("a").css({ 'color' : '#FFFFFF'});
	$(this).find("span").hide(); //Hide the navi
}
else
{

}
//on hover out...
	
});

});*/
</script>
<?
		}
	}
?>