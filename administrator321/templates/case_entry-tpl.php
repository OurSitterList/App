<?

	include("classes/AdminStructure.php");

	include_once("./fckeditor/fckeditor.php");

	class Home extends AdminStructure

	{

		function Settings($title)

		{

			parent::AdminStructure($title);

		}

		function conDition()

		{$page_id=13;
		$con=new DBConnection(host,user,pass,db);

		$conObj=$con->connectDB();
			if(!$_SESSION["AID"])

				header("Location: ./");
				
				if($_SESSION['ATYPE']=='sub_admin')
			{
			 $access_val=mysql_fetch_object(mysql_query("SELECT * FROM user_management WHERE user_id=".$_SESSION['AID']));
			 // $access_val->user_access;
 			 $myaccess=explode(",",$access_val->user_access);
			 if(in_array ($page_id , $myaccess )) 
			 {  }else{ header("Location: ./home.php");}
		
			}
}

		function body()

		{
$page_id=13;
$access_val=mysql_fetch_object(mysql_query("SELECT * FROM user_management WHERE user_id=".$_SESSION['AID']));
$child_action=explode(',',$access_val->child_action);
			$con=new DBConnection(host,user,pass,db);

			$conObj=$con->connectDB();

?>


<?php

if($_POST['page_value_sended']=='page_value_sended')

{

extract($_POST);

if($mode_table=='table_update')

{	
		
						
						$sql_case_insert = "update
											case_registration
											set
											customer_type = '".mysql_real_escape_string($account_related)."',
											org_com_name = '".mysql_real_escape_string($related_value)."',
											first_name = '".mysql_real_escape_string($first_name)."',							
											phone = '".mysql_real_escape_string($phone)."',
											email = '".mysql_real_escape_string($email)."',
											address = '".mysql_real_escape_string($address)."',
											state_city = '".mysql_real_escape_string($city)."',
											zipcode = '".mysql_real_escape_string($zipcode)."',
											model = '".mysql_real_escape_string($model)."'
											where id_case_registratioin  = '".mysql_real_escape_string($case_id)."'
											";
									
									//die($sql_case_insert);	
								mysql_query($sql_case_insert) or die(mysql_error());	
						
								header("location:case_entry.php?mode=edit&case_id=".$case_id);
								return;
}

else

{		

						$is_exist = mysql_query("select * from users where id_users = '".mysql_real_escape_string($id_users)."'");
			
						if(mysql_num_rows($is_exist) > 0){
							$ll_id_user = mysql_fetch_object($is_exist)->id_users;
						}else{
							header('Location:'.$_SERVER['PHP_SELF'].'?error=1');
							return;
						}

						$case_id = time().rand(0,150);
						$sql_case_insert = "insert
											into
											case_registration
											set
											id_case_registratioin  = '".mysql_real_escape_string($case_id)."',
											customer_type = '".mysql_real_escape_string($account_related)."',
											org_com_name = '".mysql_real_escape_string($related_value)."',
											first_name = '".mysql_real_escape_string($first_name)."',							
											phone = '".mysql_real_escape_string($phone)."',
											email = '".mysql_real_escape_string($email)."',
											address = '".mysql_real_escape_string($address)."',
											country = '".mysql_real_escape_string($country)."',
											state_city = '".mysql_real_escape_string($city)."',
											zipcode = '".mysql_real_escape_string($zipcode)."',
											media_type = '".mysql_real_escape_string($media_type)."',
											manufacturer = '".mysql_real_escape_string($media_make)."',
											storage_capacity = '".mysql_real_escape_string($media_capacity)."',
											os_file_system = '".mysql_real_escape_string($media_os)."',
											leading_failure = '".mysql_real_escape_string($steps_during_failure)."',
											spcl_req_com = '".mysql_real_escape_string($spcl_req_comm)."',	
											service_level = '".mysql_real_escape_string($priority_level)."',
											return_data_via = '".mysql_real_escape_string($data_return_by)."',
											id_users = '".mysql_real_escape_string($ll_id_user)."',
											model = '".mysql_real_escape_string($model)."'
											";
									
									//die($sql_case_insert);	
								mysql_query($sql_case_insert) or die(mysql_error());	
						
								header("location:case-submission.php?case_id=".$case_id);
								return;
}				

							//header('Location:'.$_SERVER['PHP_SELF']);

						//exit;





 }





?>

<script language="javascript" type="text/javascript" src="js/new_jquery.blockUI.js"></script>

<script language="javascript" type="text/javascript" src="js/settings.js"></script>

<script lnguage="javascript" type="text/javascript">

var mf;
		mf = new MyFunctions;
		
 	function valid_page(){	
		
				if (!$("input[name='account_related']:checked").val()) {
			   alert('Please select who you are!');
			   $(".related").focus();
			   return false;
			}else {
				 if($("input[name='account_related']:checked").val() == 'business'){	
					if($.trim($('#related_value').val()) == ''){
						alert('Please enter your organisation name');
						$('#related_value').focus();
						$('#related_value').val('');
						return false;
					}
				 }	
			}
			
			if($.trim($('#first_name').val()) == ''){
				alert('Please enter first name');
				$('#first_name').focus();
				$('#first_name').val('');
				return false;
			}else if($.trim($('#phone').val()) == ''){
				alert('Please enter phone number');
				$('#phone').focus();
				$('#phone').val('');
				return false;
			}/*else if($.trim($('#phone').val()) != ''){
				 inputtext = $('#phone').val();
				 var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;  
 					 if(!(inputtext.value.match(phoneno))){        				
        				alert('Please enter valid phone number');
						$('#phone').focus();
						$('#phone').val('');  
						return false;
        			}
			}*/else if($.trim($('#email').val()) == ''){
				alert('Please enter email');
				$('#email').focus();
				$('#email').val('');
				return false;
			}else if(!mf.isvalidemail($('#email').val())){
				alert('Please enter valid email');						
				$('#email').val('');
				$('#email').focus();
				return false;
			}else if($.trim($('#address').val()) == ''){
				alert('Please enter address');
				$('#address').focus();
				$('#address').val('');
				return false;
			}else if($.trim($('#country').val()) == ''){
				alert('Please select country');
				$('#country').focus();
				$('#country').val('');
				return false;
			}else if($.trim($('#city').val()) == ''){
				alert('Please enter city');
				$('#city').focus();
				$('#city').val('');
				return false;
			}else if($.trim($('#zipcode').val()) == ''){
				alert('Please enter zipcode');
				$('#zipcode').focus();
				$('#zipcode').val('');
				return false;
			}else if(mf.isvalidemail($('#email').val())){
				 $.ajax({
						type:'post',			
						url:'case_submission.php',			
						data:'mode=is_exist&&email_val='+$('#email').val(),			
						success:function(msg){
							if(msg == 'exist'){
								alert('Please login! You are a register customer');
								return false;
							}						
						}			
					  });
			}
			
			if($.trim($('#media_type').val()) == ''){
				alert('Please select media type');
				$('#media_type').focus();
				$('#media_type').val('');
				return false;
			}else if($.trim($('#media_make').val()) == ''){
				alert('Please select media make company');
				$('#media_make').focus();
				$('#media_make').val('');
				return false;
			}else if($.trim($('#media_capacity').val()) == ''){
				alert('Please select media capacity');
				$('#media_capacity').focus();
				$('#media_capacity').val('');
				return false;
			}else if($.trim($('#media_os').val()) == ''){
				alert('Please select media OS');
				$('#media_os').focus();
				$('#media_os').val('');
				return false;
			}
			
			if($.trim($('#steps_during_failure').val()) == ''){
				alert('Please enter steps during failure');
				$('#steps_during_failure').focus();
				$('#steps_during_failure').val('');
				return false;
			}else if($.trim($('#spcl_req_comm').val()) == ''){
				alert('Please enter special request or comment');
				$('#spcl_req_comm').focus();
				$('#spcl_req_comm').val('');
				return false;
			}else if($.trim($('#priority_level').val()) == ''){
				alert('Please select service level');
				$('#priority_level').focus();
				$('#priority_level').val('');
				return false;
			}else if($.trim($('#data_return_by').val()) == ''){
				alert('Please select data return by');
				$('#data_return_by').focus();
				$('#data_return_by').val('');
				return false;
			}else{
				$('#page_value_sended').val('page_value_sended');
				$('#mode_table').val('table_insert');
				$('#registration_form').submit();
				return true;
			}
		
	}
	function valid_page_edit(){	
		
			
			if($.trim($('#first_name').val()) == ''){
				alert('Please enter first name');
				$('#first_name').focus();
				$('#first_name').val('');
				return false;
			}else if($.trim($('#phone').val()) == ''){
				alert('Please enter phone number');
				$('#phone').focus();
				$('#phone').val('');
				return false;
			}else if($.trim($('#email').val()) == ''){
				alert('Please enter email');
				$('#email').focus();
				$('#email').val('');
				return false;
			}else if(!mf.isvalidemail($('#email').val())){
				alert('Please enter valid email');						
				$('#email').val('');
				$('#email').focus();
				return false;
			}else if($.trim($('#address').val()) == ''){
				alert('Please enter address');
				$('#address').focus();
				$('#address').val('');
				return false;
			}else if($.trim($('#city').val()) == ''){
				alert('Please enter city');
				$('#city').focus();
				$('#city').val('');
				return false;
			}else if($.trim($('#zipcode').val()) == ''){
				alert('Please enter zipcode');
				$('#zipcode').focus();
				$('#zipcode').val('');
				return false;
			}
			else if($.trim($('#model').val()) == ''){
				alert('Please enter Model/Serial No');
				$('#model').focus();
				$('#model').val('');
				return false;
			}
			
			else{
				$('#page_value_sended').val('page_value_sended');
				$('#mode_table').val('table_update');
				$('#registration_form').submit();
				return true;
			}
		
	}		

			function checkRelated(as_val){
				if( as_val == 'business' ){
					$('.org-com').css('display','block');
					$('.org-com').addClass('innertable');
				}else{
					$('.org-com').css('display','none');
					$('.org-com').addClass('innertable');
				}			
			}

			
</script>

<form name="registration_form" action="<?=$_SERVER['PHP_SELF']?>" method="post" id="registration_form" enctype="multipart/form-data">

<input type="hidden" name="page_value_sended" id="page_value_sended" /> 



 <?php 

 if($_GET['mode']=='edit')

{

$result_row=mysql_fetch_object(mysql_query("select * from case_registration where id_case_registratioin=".$_GET['case_id']));



?><input type="hidden" name="mode_table" id="mode_table" value="table_edit" />

<input type="hidden" name="case_id" id="case_id" value="<?=$_GET['case_id']?>" />
<div class="ad-notif-info grid_12"><p>Edit Case</p></div>
<div class="box grid_8">
<div class="box-head">
  <h2>User ID</h2>
</div>
        <div class="box-content ad-stats">	
<table width="100%" class="border">
         
<tr class="innertable" >
<td width="25%"><strong>User Id</strong>:</td>
<td><?=$result_row->id_users?></td>
</tr>
</table>
</div>
</div>

<div class="box grid_8">
<div class="box-head"><h2>Contact information</h2></div>
        <div class="box-content ad-stats">
<table width="100%" class="border">

 <tr class="innertable">
        
        <td width="25%"><strong>Personal, business or government related: </strong>:</td>
        
        <td>
		<input type="radio" class="related" style="width:20px;" onclick="checkRelated('personal');" id="personal" value="Personal" <?=$result_row->customer_type=='Personal'?'checked="checked"':''?> name="account_related" >
        <label for="personal">Personal</label>
		<input type="radio" class="related" style="width: 20px;" onclick="checkRelated('business');" id="business" value="business" <?=$result_row->customer_type=='business'?'checked="checked"':''?> name="account_related" >
        <label for="business">Business</label>
		<input type="radio" class="related" style="width: 20px;" onclick="checkRelated('government');" id="government" value="government" <?=$result_row->customer_type=='government'?'checked="checked"':''?> name="account_related" >
        <label for="government">Government</label>
		</td>
      </tr>
 	
	<tr class="innertable org-com" style="display:none;">

  	<td width="25%"><strong>Organization / Company: </strong>:</td>

    <td><input type="text" name="related_value" id="related_value" style="width: 30%;" value="<?=$result_row->org_com_name?>" ></td>

 </tr>
 
 <tr class="innertable">

  	<td width="25%"><strong>Full Name: </strong>:</td>

    <td><input type="text" name="first_name" id="first_name" style="width: 30%;" value="<?=$result_row->first_name?>" ></td>

 </tr>

 <tr class="innertable">

  	<td width="25%"><strong>Phone:</strong>:</td>

    <td><input type="text" name="phone" id="phone" style="width: 30%;" value="<?=$result_row->phone?>"></td>

 </tr>
<tr class="innertable">

  	<td width="25%"><strong>Email:</strong>:</td>

    <td><input type="text" name="email" id="email" style="width: 30%;" value="<?=$result_row->email?>" ></td>

 </tr>
 <tr class="innertable">

  	<td width="25%"><strong>Address</strong>:</td>

    <td><input name="address" id="address" style="width: 30%;" value="<?=$result_row->address?>"></td>

 </tr>
 <tr class="innertable">

  	<td width="25%"><strong>Country</strong>:</td>

    <td><?=$result_row->country?></td>

 </tr>
 <tr class="innertable">

  	<td width="25%"><strong>State/City</strong>:</td>

    <td><input name="city" id="city" style="width: 30%;" value="<?=$result_row->state_city?>"></td>

 </tr>
  <tr class="innertable">

  	<td width="25%"><strong>Zip code</strong>:</td>

    <td><input name="zipcode" id="zipcode" style="width: 30%;" value="<?=$result_row->zipcode?>"></td>

 </tr>
 
 </table>
 </div>
 </div>
 
<div class="box grid_8">
<div class="box-head"><h2>Media spec. information</h2></div>
        <div class="box-content ad-stats">
<table width="100%" class="border">
	
	<tr class="innertable">
	
	<td width="25%"><strong>Media Type</strong>:</td>
	
	<td><?=$result_row->media_type?></td>
	</tr>
	
<tr class="innertable">
	
	<td width="25%"><strong>Manufacturer Brand Make</strong>:</td>
	
	<td><?=$result_row->manufacturer?></td>
	</tr>
     <tr class="innertable">

  	<td width="25%"><strong>Model/Serial Number</strong>:</td>

    <td><input name="model" id="model" style="width: 30%;" value="<?=$result_row->model?>"></td>

 </tr>
	
 <tr class="innertable">

  	<td width="25%"><strong>Storage Size Capacity</strong>:</td>

    <td><?=$result_row->storage_capacity?></td>

 </tr>
 <tr class="innertable">

  	<td width="25%"><strong>OS or File System</strong>:</td>

    <td><?=$result_row->os_file_system?></td>

 </tr>
 

 
  </table>
  </div>
 </div>
  
<div class="box grid_8">
<div class="box-head">
  <h2>Circumstances, details and data to be Letosystem</h2>
</div>
        <div class="box-content ad-stats">	
<table width="100%" class="border">
         
<tr class="innertable" >
<td width="25%"><strong>If known; describe problem circumstances leading to failure and/or steps taken since failure</strong>:</td>
<td><?=$result_row->leading_failure?></td>
</tr>

<tr class="innertable" >
<td width="25%"><strong>Special request or comments</strong>:</td>
<td><?=$result_row->spcl_req_com?></td>
</tr>

<tr class="innertable"  >
<td width="25%"><strong>Service Level</strong>:</td>
<td><?=$result_row->service_level?></td>
</tr>

<tr class="innertable"  >
<td width="25%"><strong>Return my data via</strong>:</td>
<td><?=$result_row->return_data_via?></td>
</tr>

</table>
</div>
</div>
 
 <br /><br />
 <p align="right"><?php if(in_array ($page_id.'edit' , $child_action ) ||  $_SESSION['ATYPE']!='sub_admin') 
{?><input name="button_save" class="button blue_update"  value="Update Value" type="button" onclick="javascript:return valid_page_edit();"><?php }else { echo '<input  type="button" class="button grey_update"  value="Update Value" />';}?></p>

 <?php
}
else{
?>
<input type="hidden" name="mode_table" id="mode_table" value="table_insert" />
<?php if($_REQUEST['error']==1){
?>
<div class="ad-notif-error grid_12 small-mg"><p>Please Enter a valid user ID.</p></div>
<?php
}
?>

<?php if($_REQUEST['success']==1)
{
?>
<div class="ad-notif-success grid_12 small-mg"><p>Case submited successfully.</p></div>
<?php
}
if($_REQUEST['success']==''){
?>
<div class="ad-notif-info grid_12"><p>Add Case</p></div>
<?php } ?>
<div class="box grid_8">
<div class="box-head">
  <h2>User ID</h2>
</div>
        <div class="box-content ad-stats">	
<table width="100%" class="border">
         
<tr class="innertable" >
<td width="25%"><strong>User Id</strong>:</td>
<td><input type="text" name="id_users" id="id_users" style="width:30%;" /></td>
</tr>
</table>
</div>
</div>

<div class="box grid_8">
<div class="box-head"><h2>Contact information</h2></div>
        <div class="box-content ad-stats">
<table width="100%" class="border">

 <tr class="innertable">
        
        <td width="25%"><strong>Personal, business or government related: </strong>:</td>
        
        <td>
		<input type="radio" class="related" style="width:20px;" onclick="checkRelated('personal');" id="personal" value="Personal" name="account_related" >
        <label for="personal">Personal</label>
		<input type="radio" class="related" style="width: 20px;" onclick="checkRelated('business');" id="business" value="business" name="account_related" >
        <label for="business">Business</label>
		<input type="radio" class="related" style="width: 20px;" onclick="checkRelated('government');" id="government" value="government" name="account_related" >
        <label for="government">Government</label>
		</td>
      </tr>
 	
	<tr class="innertable org-com" style="display:none;">

  	<td width="25%"><strong>Organization / Company: </strong>:</td>

    <td><input type="text" name="related_value" id="related_value" style="width: 30%;" ></td>

 </tr>
 
 <tr class="innertable">

  	<td width="25%"><strong>Full Name: </strong>:</td>

    <td><input type="text" name="first_name" id="first_name" style="width: 30%;" ></td>

 </tr>

 <tr class="innertable">

  	<td width="25%"><strong>Phone:</strong>:</td>

    <td><input type="text" name="phone" id="phone" style="width: 30%;"></textarea></td>

 </tr>
<tr class="innertable">

  	<td width="25%"><strong>Email:</strong>:</td>

    <td><input type="text" name="email" id="email" style="width: 30%;"></td>

 </tr>
 <tr class="innertable">

  	<td width="25%"><strong>Address</strong>:</td>

    <td><input name="address" id="address" style="width: 30%;"></td>

 </tr>
 <tr class="innertable">

  	<td width="25%"><strong>Country</strong>:</td>

    <td><select id="country" class="required" name="country" style="width:30%;">
			<option value="" label="-- Please select --">-- Please select --</option>
			<option value="USA" label="UNITED STATES">UNITED STATES</option>
			<option value="CANADA" label="CANADA">CANADA</option>
			<option value="ABU DHABI" label="ABU DHABI">ABU DHABI</option>
			<option value="ADEN" label="ADEN">ADEN</option>
			<option value="AFGHANISTAN" label="AFGHANISTAN">AFGHANISTAN</option>
			<option value="ALBANIA" label="ALBANIA">ALBANIA</option>
			<option value="ALGERIA" label="ALGERIA">ALGERIA</option>
			<option value="AMERICAN SAMOA" label="AMERICAN SAMOA">AMERICAN SAMOA</option>
			<option value="ANDORRA" label="ANDORRA">ANDORRA</option>
			<option value="ANGOLA" label="ANGOLA">ANGOLA</option>
			<option value="ANTARCTICA" label="ANTARCTICA">ANTARCTICA</option>
			<option value="ANTIGUA" label="ANTIGUA">ANTIGUA</option>
			<option value="ARGENTINA" label="ARGENTINA">ARGENTINA</option>
			<option value="ARMENIA" label="ARMENIA">ARMENIA</option>
			<option value="ARUBA" label="ARUBA">ARUBA</option>
			<option value="AUSTRALIA" label="AUSTRALIA">AUSTRALIA</option>
			<option value="AUSTRIA" label="AUSTRIA">AUSTRIA</option>
			<option value="AZERBAIJAN" label="AZERBAIJAN">AZERBAIJAN</option>
			<option value="BAHAMAS" label="BAHAMAS">BAHAMAS</option>
			<option value="BAHRAIN" label="BAHRAIN">BAHRAIN</option>
			<option value="BANGLADESH" label="BANGLADESH">BANGLADESH</option>
			<option value="BARBADOS" label="BARBADOS">BARBADOS</option>
			<option value="BELARUS" label="BELARUS">BELARUS</option>
			<option value="BELGIUM" label="BELGIUM">BELGIUM</option>
			<option value="BELIZE" label="BELIZE">BELIZE</option>
			<option value="BENIN" label="BENIN">BENIN</option>
			<option value="BERMUDA" label="BERMUDA">BERMUDA</option>
			<option value="BHUTAN" label="BHUTAN">BHUTAN</option>
			<option value="BOLIVIA" label="BOLIVIA">BOLIVIA</option>
			<option value="BOSNIA" label="BOSNIA">BOSNIA</option>
			<option value="BOTSWANA" label="BOTSWANA">BOTSWANA</option>
			<option value="BOUVET ISLAND" label="BOUVET ISLAND">BOUVET ISLAND</option>
			<option value="BRAZIL" label="BRAZIL">BRAZIL</option>
			<option value="BRITISH ANTARCTICA TERRITORY" label="BRITISH ANTARCTICA TERRITORY">BRITISH ANTARCTICA TERRITORY</option>
			<option value="BRITISH INDIAN OCEAN TERRITORY" label="BRITISH INDIAN OCEAN TERRITORY">BRITISH INDIAN OCEAN TERRITORY</option>
			<option value="BRITISH VIRGIN ISLANDS" label="BRITISH VIRGIN ISLANDS">BRITISH VIRGIN ISLANDS</option>
			<option value="BRITISH WEST INDIES" label="BRITISH WEST INDIES">BRITISH WEST INDIES</option>
			<option value="BRUNEI" label="BRUNEI">BRUNEI</option>
			<option value="BULGARIA" label="BULGARIA">BULGARIA</option>
			<option value="BURKINA FASO" label="BURKINA FASO">BURKINA FASO</option>
			<option value="BURUNDI" label="BURUNDI">BURUNDI</option>
			<option value="CAMBODIA" label="CAMBODIA">CAMBODIA</option>
			<option value="CAMEROON" label="CAMEROON">CAMEROON</option>
			<option value="CANAL ZONE" label="CANAL ZONE">CANAL ZONE</option>
			<option value="CANARY ISLAND" label="CANARY ISLAND">CANARY ISLAND</option>
			<option value="CAPE VERDI ISLANDS" label="CAPE VERDI ISLANDS">CAPE VERDI ISLANDS</option>
			<option value="CAYMAN ISLANDS" label="CAYMAN ISLANDS">CAYMAN ISLANDS</option>
			<option value="CEVLON" label="CEVLON">CEVLON</option>
			<option value="CHAD" label="CHAD">CHAD</option>
			<option value="CHANNEL ISLAND UK" label="CHANNEL ISLAND UK">CHANNEL ISLAND UK</option>
			<option value="CHILE" label="CHILE">CHILE</option>
			<option value="CHINA" label="CHINA">CHINA</option>
			<option value="CHRISTMAS ISLAND" label="CHRISTMAS ISLAND">CHRISTMAS ISLAND</option>
			<option value="COCOS (KEELING) ISLAND" label="COCOS ( KEELING ) ISLAND">COCOS ( KEELING ) ISLAND</option>
			<option value="COLOMBIA" label="COLOMBIA">COLOMBIA</option>
			<option value="COMORO ISLANDS" label="COMORO ISLANDS">COMORO ISLANDS</option>
			<option value="CONGO" label="CONGO">CONGO</option>
			<option value="CONGO KINSHASA" label="CONGO KINSHASA">CONGO KINSHASA</option>
			<option value="COOK ISLANDS" label="COOK ISLANDS">COOK ISLANDS</option>
			<option value="COSTA RICA" label="COSTA RICA">COSTA RICA</option>
			<option value="CROATIA" label="CROATIA">CROATIA</option>
			<option value="CUBA" label="CUBA">CUBA</option>
			<option value="CURACAO" label="CURACAO">CURACAO</option>
			<option value="CYPRUS" label="CYPRUS">CYPRUS</option>
			<option value="CZECH REPUBLIC" label="CZECH REPUBLIC">CZECH REPUBLIC</option>
			<option value="DAHOMEY" label="DAHOMEY">DAHOMEY</option>
			<option value="DENMARK" label="DENMARK">DENMARK</option>
			<option value="DJIBOUTI" label="DJIBOUTI">DJIBOUTI</option>
			<option value="DOMINICA" label="DOMINICA">DOMINICA</option>
			<option value="DOMINICAN REPUBLIC" label="DOMINICAN REPUBLIC">DOMINICAN REPUBLIC</option>
			<option value="DUBAI" label="DUBAI">DUBAI</option>
			<option value="ECUADOR" label="ECUADOR">ECUADOR</option>
			<option value="EGYPT" label="EGYPT">EGYPT</option>
			<option value="EL SALVADOR" label="EL SALVADOR">EL SALVADOR</option>
			<option value="EQUATORIAL GUINEA" label="EQUATORIAL GUINEA">EQUATORIAL GUINEA</option>
			<option value="ESTONIA" label="ESTONIA">ESTONIA</option>
			<option value="ETHIOPIA" label="ETHIOPIA">ETHIOPIA</option>
			<option value="FAEROE ISLANDS" label="FAEROE ISLANDS">FAEROE ISLANDS</option>
			<option value="FALKLAND ISLANDS" label="FALKLAND ISLANDS">FALKLAND ISLANDS</option>
			<option value="FIJI" label="FIJI">FIJI</option>
			<option value="FINLAND" label="FINLAND">FINLAND</option>
			<option value="FRANCE" label="FRANCE">FRANCE</option>
			<option value="FRENCH GUIANA" label="FRENCH GUIANA">FRENCH GUIANA</option>
			<option value="FRENCH POLYNESIA" label="FRENCH POLYNESIA">FRENCH POLYNESIA</option>
			<option value="GABON" label="GABON">GABON</option>
			<option value="GAMBIA" label="GAMBIA">GAMBIA</option>
			<option value="GEORGIA" label="GEORGIA">GEORGIA</option>
			<option value="GERMANY" label="GERMANY">GERMANY</option>
			<option value="GHANA" label="GHANA">GHANA</option>
			<option value="GIBRALTAR" label="GIBRALTAR">GIBRALTAR</option>
			<option value="GREECE" label="GREECE">GREECE</option>
			<option value="GREENLAND" label="GREENLAND">GREENLAND</option>
			<option value="GUADELOUPE" label="GUADELOUPE">GUADELOUPE</option>
			<option value="GUAM" label="GUAM">GUAM</option>
			<option value="GUATEMALA" label="GUATEMALA">GUATEMALA</option>
			<option value="GUINEA" label="GUINEA">GUINEA</option>
			<option value="GUYANA" label="GUYANA">GUYANA</option>
			<option value="HAITI" label="HAITI">HAITI</option>
			<option value="HONDURAS" label="HONDURAS">HONDURAS</option>
			<option value="HONG KONG" label="HONG KONG">HONG KONG</option>
			<option value="HUNGARY" label="HUNGARY">HUNGARY</option>
			<option value="ICELAND" label="ICELAND">ICELAND</option>
			<option value="IFNI" label="IFNI">IFNI</option>
			<option value="INDIA" label="INDIA">INDIA</option>
			<option value="INDONESIA" label="INDONESIA">INDONESIA</option>
			<option value="IRAN" label="IRAN">IRAN</option>
			<option value="IRAQ" label="IRAQ">IRAQ</option>
			<option value="IRELAND" label="IRELAND">IRELAND</option>
			<option value="ISRAEL" label="ISRAEL">ISRAEL</option>
			<option value="ITALY" label="ITALY">ITALY</option>
			<option value="IVORY COAST" label="IVORY COAST">IVORY COAST</option>
			<option value="JAMAICA" label="JAMAICA">JAMAICA</option>
			<option value="JAPAN" label="JAPAN">JAPAN</option>
			<option value="JORDAN" label="JORDAN">JORDAN</option>
			<option value="KAZAKHSTAN" label="KAZAKHSTAN">KAZAKHSTAN</option>
			<option value="KENYA" label="KENYA">KENYA</option>
			<option value="KOREA" label="KOREA">KOREA</option>
			<option value="KOREA, SOUTH" label="KOREA, SOUTH">KOREA, SOUTH</option>
			<option value="KUWAIT" label="KUWAIT">KUWAIT</option>
			<option value="KYRGYZSTAN" label="KYRGYZSTAN">KYRGYZSTAN</option>
			<option value="LAOS" label="LAOS">LAOS</option>
			<option value="LATVIA" label="LATVIA">LATVIA</option>
			<option value="LEBANON" label="LEBANON">LEBANON</option>
			<option value="LEEWARD ISLANDS" label="LEEWARD ISLANDS">LEEWARD ISLANDS</option>
			<option value="LESOTHO" label="LESOTHO">LESOTHO</option>
			<option value="LIBYA" label="LIBYA">LIBYA</option>
			<option value="LIECHTENSTEIN" label="LIECHTENSTEIN">LIECHTENSTEIN</option>
			<option value="LITHUANIA" label="LITHUANIA">LITHUANIA</option>
			<option value="LUXEMBOURG" label="LUXEMBOURG">LUXEMBOURG</option>
			<option value="MACAO" label="MACAO">MACAO</option>
			<option value="MACEDONIA" label="MACEDONIA">MACEDONIA</option>
			<option value="MADAGASCAR" label="MADAGASCAR">MADAGASCAR</option>
			<option value="MALAWI" label="MALAWI">MALAWI</option>
			<option value="MALAYSIA" label="MALAYSIA">MALAYSIA</option>
			<option value="MALDIVES" label="MALDIVES">MALDIVES</option>
			<option value="MALI" label="MALI">MALI</option>
			<option value="MALTA" label="MALTA">MALTA</option>
			<option value="MARTINIQUE" label="MARTINIQUE">MARTINIQUE</option>
			<option value="MAURITANIA" label="MAURITANIA">MAURITANIA</option>
			<option value="MAURITIUS" label="MAURITIUS">MAURITIUS</option>
			<option value="MELANESIA" label="MELANESIA">MELANESIA</option>
			<option value="MEXICO" label="MEXICO">MEXICO</option>
			<option value="MOLDOVIA" label="MOLDOVIA">MOLDOVIA</option>
			<option value="MONACO" label="MONACO">MONACO</option>
			<option value="MONGOLIA" label="MONGOLIA">MONGOLIA</option>
			<option value="MOROCCO" label="MOROCCO">MOROCCO</option>
			<option value="MOZAMBIQUE" label="MOZAMBIQUE">MOZAMBIQUE</option>
			<option value="MYANAMAR" label="MYANAMAR">MYANAMAR</option>
			<option value="NAMIBIA" label="NAMIBIA">NAMIBIA</option>
			<option value="NEPAL" label="NEPAL">NEPAL</option>
			<option value="NETHERLANDS" label="NETHERLANDS">NETHERLANDS</option>
			<option value="NETHERLANDS ANTILLES" label="NETHERLANDS ANTILLES">NETHERLANDS ANTILLES</option>
			<option value="NETHERLANDS ANTILLES NEUTRAL ZONE" label="NETHERLANDS ANTILLES NEUTRAL ZONE">NETHERLANDS ANTILLES NEUTRAL ZONE</option>
			<option value="NEW CALADONIA" label="NEW CALADONIA">NEW CALADONIA</option>
			<option value="NEW HEBRIDES" label="NEW HEBRIDES">NEW HEBRIDES</option>
			<option value="NEW ZEALAND" label="NEW ZEALAND">NEW ZEALAND</option>
			<option value="NICARAGUA" label="NICARAGUA">NICARAGUA</option>
			<option value="NIGER" label="NIGER">NIGER</option>
			<option value="NIGERIA" label="NIGERIA">NIGERIA</option>
			<option value="NORFOLK ISLAND" label="NORFOLK ISLAND">NORFOLK ISLAND</option>
			<option value="NORWAY" label="NORWAY">NORWAY</option>
			<option value="OMAN" label="OMAN">OMAN</option>
			<option value="OTHER" label="OTHER">OTHER</option>
			<option value="PACIFIC ISLAND" label="PACIFIC ISLAND">PACIFIC ISLAND</option>
			<option value="PAKISTAN" label="PAKISTAN">PAKISTAN</option>
			<option value="PANAMA" label="PANAMA">PANAMA</option>
			<option value="PAPUA NEW GUINEA" label="PAPUA NEW GUINEA">PAPUA NEW GUINEA</option>
			<option value="PARAGUAY" label="PARAGUAY">PARAGUAY</option>
			<option value="PERU" label="PERU">PERU</option>
			<option value="PHILIPPINES" label="PHILIPPINES">PHILIPPINES</option>
			<option value="POLAND" label="POLAND">POLAND</option>
			<option value="PORTUGAL" label="PORTUGAL">PORTUGAL</option>
			<option value="PORTUGUESE TIMOR" label="PORTUGUESE TIMOR">PORTUGUESE TIMOR</option>
			<option value="PUERTO RICO" label="PUERTO RICO">PUERTO RICO</option>
			<option value="QATAR" label="QATAR">QATAR</option>
			<option value="REPUBLIC OF BELARUS" label="REPUBLIC OF BELARUS">REPUBLIC OF BELARUS</option>
			<option value="REPUBLIC OF SOUTH AFRICA" label="REPUBLIC OF SOUTH AFRICA">REPUBLIC OF SOUTH AFRICA</option>
			<option value="REUNION" label="REUNION">REUNION</option>
			<option value="ROMANIA" label="ROMANIA">ROMANIA</option>
			<option value="RUSSIA" label="RUSSIA">RUSSIA</option>
			<option value="RWANDA" label="RWANDA">RWANDA</option>
			<option value="RYUKYU ISLANDS" label="RYUKYU ISLANDS">RYUKYU ISLANDS</option>
			<option value="SABAH" label="SABAH">SABAH</option>
			<option value="SAN MARINO" label="SAN MARINO">SAN MARINO</option>
			<option value="SAUDI ARABIA" label="SAUDI ARABIA">SAUDI ARABIA</option>
			<option value="SENEGAL" label="SENEGAL">SENEGAL</option>
			<option value="SERBIA" label="SERBIA">SERBIA</option>
			<option value="SEYCHELLES" label="SEYCHELLES">SEYCHELLES</option>
			<option value="SIERRA LEONE" label="SIERRA LEONE">SIERRA LEONE</option>
			<option value="SINGAPORE" label="SINGAPORE">SINGAPORE</option>
			<option value="SLOVAKIA" label="SLOVAKIA">SLOVAKIA</option>
			<option value="SLOVENIA" label="SLOVENIA">SLOVENIA</option>
			<option value="SOMALILIAND" label="SOMALILIAND">SOMALILIAND</option>
			<option value="SOUTH AFRICA" label="SOUTH AFRICA">SOUTH AFRICA</option>
			<option value="SOUTH YEMEN" label="SOUTH YEMEN">SOUTH YEMEN</option>
			<option value="SPAIN" label="SPAIN">SPAIN</option>
			<option value="SPANISH SAHARA" label="SPANISH SAHARA">SPANISH SAHARA</option>
			<option value="SRI LANKA" label="SRI LANKA">SRI LANKA</option>
			<option value="ST. KITTS AND NEVIS" label="ST. KITTS AND NEVIS">ST. KITTS AND NEVIS</option>
			<option value="ST. LUCIA" label="ST. LUCIA">ST. LUCIA</option>
			<option value="SUDAN" label="SUDAN">SUDAN</option>
			<option value="SURINAM" label="SURINAM">SURINAM</option>
			<option value="SW AFRICA" label="SW AFRICA">SW AFRICA</option>
			<option value="SWAZILAND" label="SWAZILAND">SWAZILAND</option>
			<option value="SWEDEN" label="SWEDEN">SWEDEN</option>
			<option value="SWITZERLAND" label="SWITZERLAND">SWITZERLAND</option>
			<option value="SYRIA" label="SYRIA">SYRIA</option>
			<option value="TAIWAN" label="TAIWAN">TAIWAN</option>
			<option value="TAJIKISTAN" label="TAJIKISTAN">TAJIKISTAN</option>
			<option value="TANZANIA" label="TANZANIA">TANZANIA</option>
			<option value="THAILAND" label="THAILAND">THAILAND</option>
			<option value="TONGA" label="TONGA">TONGA</option>
			<option value="TRINIDAD" label="TRINIDAD">TRINIDAD</option>
			<option value="TUNISIA" label="TUNISIA">TUNISIA</option>
			<option value="TURKEY" label="TURKEY">TURKEY</option>
			<option value="UGANDA" label="UGANDA">UGANDA</option>
			<option value="UKRAINE" label="UKRAINE">UKRAINE</option>
			<option value="UNITED ARAB EMIRATES" label="UNITED ARAB EMIRATES">UNITED ARAB EMIRATES</option>
			<option value="UNITED KINGDOM" label="UNITED KINGDOM">UNITED KINGDOM</option>
			<option value="UPPER VOLTA" label="UPPER VOLTA">UPPER VOLTA</option>
			<option value="URUGUAY" label="URUGUAY">URUGUAY</option>
			<option value="US PACIFIC ISLAND" label="US PACIFIC ISLAND">US PACIFIC ISLAND</option>
			<option value="US VIRGIN ISLANDS" label="US VIRGIN ISLANDS">US VIRGIN ISLANDS</option>
			<option value="UZBEKISTAN" label="UZBEKISTAN">UZBEKISTAN</option>
			<option value="VANUATU" label="VANUATU">VANUATU</option>
			<option value="VATICAN CITY" label="VATICAN CITY">VATICAN CITY</option>
			<option value="VENEZUELA" label="VENEZUELA">VENEZUELA</option>
			<option value="VIETNAM" label="VIETNAM">VIETNAM</option>
			<option value="WAKE ISLAND" label="WAKE ISLAND">WAKE ISLAND</option>
			<option value="WEST INDIES" label="WEST INDIES">WEST INDIES</option>
			<option value="WESTERN SAHARA" label="WESTERN SAHARA">WESTERN SAHARA</option>
			<option value="YEMEN" label="YEMEN">YEMEN</option>
			<option value="ZAIRE" label="ZAIRE">ZAIRE</option>
			<option value="ZAMBIA" label="ZAMBIA">ZAMBIA</option>
			<option value="ZIMBABWE" label="ZIMBABWE">ZIMBABWE</option>
			</select></td>

 </tr>
 <tr class="innertable">

  	<td width="25%"><strong>State/City</strong>:</td>

    <td><input name="city" id="city" style="width: 30%;"></td>

 </tr>
  <tr class="innertable">

  	<td width="25%"><strong>Zip code</strong>:</td>

    <td><input name="zipcode" id="zipcode" style="width: 30%;"></td>

 </tr>
 
 </table>
 </div>
 </div>
 
<div class="box grid_8">
<div class="box-head"><h2>Media spec. information</h2></div>
        <div class="box-content ad-stats">
<table width="100%" class="border">
	
	<tr class="innertable">
	
	<td width="25%"><strong>Media Type</strong>:</td>
	
	<td><select  class="required" id="media_type" name="media_type" style="width:30%;">
		<option value="" label="-- Please select --">-- Please select --</option>
		<option value="Computer Hard Drive (Single Desktop Drive)" label="Computer Hard Drive (Single Desktop Drive)">Computer Hard Drive (Single Desktop Drive)</option>
		<option value="Laptop Hard Drive (Single Laptop Drive)" label="Laptop Hard Drive (Single Laptop Drive)">Laptop Hard Drive (Single Laptop Drive)</option>
		<option value="External Hard Drive (USB / FireWire Drive)" label="External Hard Drive (USB / FireWire Drive)">External Hard Drive (USB / FireWire Drive)</option>
		<option value="Server Single Drive" label="Server Single Drive">Server Single Drive</option>
		<option value="Server Drive (one of multiple)" label="Server Drive (one of multiple)">Server Drive (one of multiple)</option>
		<option value="RAID Server Multiple Disk Set (Array of Disks)" label="RAID Server Multiple Disk Set (Array of Disks)">RAID Server Multiple Disk Set (Array of Disks)</option>
		<option value="Solid State Drive" label="Solid State Drive">Solid State Drive</option>
		<option value="NAS / SAN (Network Attached Storage)" label="NAS / SAN (Network Attached Storage)">NAS / SAN (Network Attached Storage)</option>
		<option value="USB Flash Drive / Memory card" label="USB Flash Drive / Memory card">USB Flash Drive / Memory card</option>
		<option value="Floppy / Zip Disk" label="Floppy / Zip Disk">Floppy / Zip Disk</option>
		<option value="Tape / Jazz Backup media" label="Tape / Jazz Backup media">Tape / Jazz Backup media</option>
		<option value="Microdrive" label="Microdrive">Microdrive</option>
		<option value="DVD / CD" label="DVD / CD">DVD / CD</option>
		<option value="PDA / Cell / iPod" label="PDA / Cell / iPod">PDA / Cell / iPod</option>
		<option value="Other" label="Other">Other</option>
		</select></td>
	</tr>
	
<tr class="innertable">
	
	<td width="25%"><strong>Manufacturer Brand Make</strong>:</td>
	
	<td><select class="required" id="media_make" name="media_make" style="width:30%;">
<option value="" label="-- Please select --">-- Please select --</option>
<option value="Apple" label="Apple">Apple</option>
<option value="Buffalo" label="Buffalo">Buffalo</option>
<option value="Compaq" label="Compaq">Compaq</option>
<option value="Conner" label="Conner">Conner</option>
<option value="Dell" label="Dell">Dell</option>
<option value="Digital" label="Digital">Digital</option>
<option value="Epson" label="Epson">Epson</option>
<option value="Fujitsu" label="Fujitsu">Fujitsu</option>
<option value="Exabyte Digital" label="Exabyte Digital">Exabyte Digital</option>
<option value="Hitachi" label="Hitachi">Hitachi</option>
<option value="Hewlett Packard" label="Hewlett Packard">Hewlett Packard</option>
<option value="IBM" label="IBM">IBM</option>
<option value="Imprimis" label="Imprimis">Imprimis</option>
<option value="Imation" label="Imation">Imation</option>
<option value="Iomega" label="Iomega">Iomega</option>
<option value="Lacie" label="Lacie">Lacie</option>
<option value="Lexar" label="Lexar">Lexar</option>
<option value="Maxtor" label="Maxtor">Maxtor</option>
<option value="Memorex" label="Memorex">Memorex</option>
<option value="Micropolis" label="Micropolis">Micropolis</option>
<option value="NEC" label="NEC">NEC</option>
<option value="OnStream" label="OnStream">OnStream</option>
<option value="ORB" label="ORB">ORB</option>
<option value="Palm" label="Palm">Palm</option>
<option value="Panasonic" label="Panasonic">Panasonic</option>
<option value="Pinnacle" label="Pinnacle">Pinnacle</option>
<option value="Quantum" label="Quantum">Quantum</option>
<option value="Rodime" label="Rodime">Rodime</option>
<option value="Samsung" label="Samsung">Samsung</option>
<option value="Sandisk" label="Sandisk">Sandisk</option>
<option value="Seagate" label="Seagate">Seagate</option>
<option value="SimpleTec" label="SimpleTec">SimpleTec</option>
<option value="Sony" label="Sony">Sony</option>
<option value="Syquest" label="Syquest">Syquest</option>
<option value="Travan" label="Travan">Travan</option>
<option value="Toshiba" label="Toshiba">Toshiba</option>
<option value="Western Digital" label="Western Digital">Western Digital</option>
<option value="Other" label="Other">Other</option>
</select></td>
	</tr>
     <tr class="innertable">

  	<td width="25%"><strong>Model/Serial Number</strong>:</td>

    <td><input name="model" id="model" style="width: 30%;"></td>

 </tr>
	
 <tr class="innertable">

  	<td width="25%"><strong>Storage Size Capacity</strong>:</td>

    <td><select class="required" id="media_capacity" name="media_capacity" style="width:30%;">
<option value="" label="-- Please select --">-- Please select --</option>
<option value="Less than 500 MB" label="Less than 500 MB">Less than 500 MB</option>
<option value="0.5 GB - 1.0 GB" label="0.5 GB - 1.0 GB">0.5 GB - 1.0 GB</option>
<option value="1.01 GB - 5.0 GB" label="1.01 GB - 5.0 GB">1.01 GB - 5.0 GB</option>
<option value="5.01 GB - 10.0 GB" label="5.01 GB - 10.0 GB">5.01 GB - 10.0 GB</option>
<option value="10.01 GB - 20.0 GB" label="10.01 GB - 20.0 GB">10.01 GB - 20.0 GB</option>
<option value="20.01 GB - 40.0 GB" label="20.01 GB - 40.0 GB">20.01 GB - 40.0 GB</option>
<option value="40.01 GB - 80.0 GB" label="40.01 GB - 80.0 GB">40.01 GB - 80.0 GB</option>
<option value="80.01 GB - 120.0 GB" label="80.01 GB - 120.0 GB">80.01 GB - 120.0 GB</option>
<option value="120.01 GB - 160.0 GB" label="120.01 GB - 160.0 GB">120.01 GB - 160.0 GB</option>
<option value="160.01 GB - 220.0 GB" label="160.01 GB - 220.0 GB">160.01 GB - 220.0 GB</option>
<option value="220.01 GB - 250.0 GB" label="220.01 GB - 250.0 GB">220.01 GB - 250.0 GB</option>
<option value="250.01 GB - 300.0 GB" label="250.01 GB - 300.0 GB">250.01 GB - 300.0 GB</option>
<option value="300.01 GB - 500.0 GB" label="300.01 GB - 500.0 GB">300.01 GB - 500.0 GB</option>
<option value="500.01 GB - 1.0 TB" label="500.01 GB - 1.0 TB">500.01 GB - 1.0 TB</option>
<option value="1.1 TB - 1.5 TB" label="1.1 TB - 1.5 TB">1.1 TB - 1.5 TB</option>
<option value="1.51 TB - 2.0 TB" label="1.51 TB - 2.0 TB">1.51 TB - 2.0 TB</option>
<option value="2.01 TB - 3.0 TB" label="2.01 TB - 3.0 TB">2.01 TB - 3.0 TB</option>
<option value="RAID less than 500MB" label="RAID less than 500MB">RAID less than 500MB</option>
<option value="RAID 0.5 GB - 1.0 GB" label="RAID 0.5 GB - 1.0 GB">RAID 0.5 GB - 1.0 GB</option>
<option value="RAID 1.1 GB - 5.0 GB" label="RAID 1.1 GB - 5.0 GB">RAID 1.1 GB - 5.0 GB</option>
<option value="RAID 5.1 GB - 10.0 GB" label="RAID 5.1 GB - 10.0 GB">RAID 5.1 GB - 10.0 GB</option>
<option value="RAID 10.01 GB - 20.0 GB" label="RAID 10.01 GB - 20.0 GB">RAID 10.01 GB - 20.0 GB</option>
<option value="RAID 20.01 GB - 40.0 GB" label="RAID 20.01 GB - 40.0 GB">RAID 20.01 GB - 40.0 GB</option>
<option value="RAID 40.01 GB - 80.0 GB" label="RAID 40.01 GB - 80.0 GB">RAID 40.01 GB - 80.0 GB</option>
<option value="RAID 80.01 GB - 120.0 GB" label="RAID 80.01 GB - 120.0 GB">RAID 80.01 GB - 120.0 GB</option>
<option value="RAID 120.01 GB - 160.0 GB" label="RAID 120.01 GB - 160.0 GB">RAID 120.01 GB - 160.0 GB</option>
<option value="RAID 160.01 GB - 220.0 GB" label="RAID 160.01 GB - 220.0 GB">RAID 160.01 GB - 220.0 GB</option>
<option value="RAID 220.01 GB - 250.0 GB" label="RAID 220.01 GB - 250.0 GB">RAID 220.01 GB - 250.0 GB</option>
<option value="RAID 250.01 GB - 300.0 GB" label="RAID 250.01 GB - 300.0 GB">RAID 250.01 GB - 300.0 GB</option>
<option value="RAID 300.01 GB - 500.0 GB" label="RAID 300.01 GB - 500.0 GB">RAID 300.01 GB - 500.0 GB</option>
<option value="RAID 500.01 GB - 1.0 TB" label="RAID 500.01 GB - 1.0 TB">RAID 500.01 GB - 1.0 TB</option>
<option value="RAID 1.01 TB - 1.5 TB" label="RAID 1.01 TB - 1.5 TB">RAID 1.01 TB - 1.5 TB</option>
<option value="RAID 1.51 TB - 2.0 TB" label="RAID 1.51 TB - 2.0 TB">RAID 1.51 TB - 2.0 TB</option>
<option value="RAID 2.01 TB - 3.0 TB" label="RAID 2.01 TB - 3.0 TB">RAID 2.01 TB - 3.0 TB</option>
</select></td>

 </tr>
 <tr class="innertable">

  	<td width="25%"><strong>OS or File System</strong>:</td>

    <td><select class="required" id="media_os" name="media_os" style="width:30%;">
<option value="" label="-- Please select --">-- Please select --</option>
<option value="Windows 8" label="Windows 8">Windows 8</option>
<option value="Windows 7" label="Windows 7">Windows 7</option>
<option value="Windows Vista" label="Windows Vista">Windows Vista</option>
<option value="Windows XP" label="Windows XP">Windows XP</option>
<option value="Apple MacOS" label="Apple MacOS">Apple MacOS</option>
<option value="Mac OS X" label="Mac OS X">Mac OS X</option>
<option value="Apple iOS" label="Apple iOS">Apple iOS</option>
<option value="Android" label="Android">Android</option>
<option value="Chrome OS" label="Chrome OS">Chrome OS</option>
<option value="NT 4.X" label="NT 4.X">NT 4.X</option>
<option value="NT 3.X" label="NT 3.X">NT 3.X</option>
<option value="Windows 98 SE" label="Windows 98 SE">Windows 98 SE</option>
<option value="Windows 98" label="Windows 98">Windows 98</option>
<option value="Windows 95" label="Windows 95">Windows 95</option>
<option value="Windows 3.X" label="Windows 3.X">Windows 3.X</option>
<option value="Windows 2000" label="Windows 2000">Windows 2000</option>
<option value="Windows 2003" label="Windows 2003">Windows 2003</option>
<option value="Windows 2008" label="Windows 2008">Windows 2008</option>
<option value="Windows Server 2012" label="Windows Server 2012">Windows Server 2012</option>
<option value="WANG" label="WANG">WANG</option>
<option value="VMS" label="VMS">VMS</option>
<option value="UNIXWARE" label="UNIXWARE">UNIXWARE</option>
<option value="Tape" label="Tape">Tape</option>
<option value="SUN" label="SUN">SUN</option>
<option value="SGI" label="SGI">SGI</option>
<option value="SSP/SYS36" label="SSP/SYS36">SSP/SYS36</option>
<option value="SCO" label="SCO">SCO</option>
<option value="OS/400" label="OS/400">OS/400</option>
<option value="OS/2" label="OS/2">OS/2</option>
<option value="NetWare Lite" label="NetWare Lite">NetWare Lite</option>
<option value="NetWare 6.X" label="NetWare 6.X">NetWare 6.X</option>
<option value="NetWare 5.X" label="NetWare 5.X">NetWare 5.X</option>
<option value="NetWare 4.X" label="NetWare 4.X">NetWare 4.X</option>
<option value="NetWare 3.X" label="NetWare 3.X">NetWare 3.X</option>
<option value="NetWare 2.X" label="NetWare 2.X">NetWare 2.X</option>
<option value="Linux" label="Linux">Linux</option>
<option value="HP/UX" label="HP/UX">HP/UX</option>
<option value="DR/Dos" label="DR/Dos">DR/Dos</option>
<option value="DOS 3.X-6.X" label="DOS 3.X-6.X">DOS 3.X-6.X</option>
<option value="DOS 2.X" label="DOS 2.X">DOS 2.X</option>
<option value="Banyan Vines" label="Banyan Vines">Banyan Vines</option>
<option value="AIX" label="AIX">AIX</option>
<option value="AS/400" label="AS/400">AS/400</option>
<option value="Other..." label="Other">Other</option>
<option value="N.A." label="Not available">Not available</option>
</select></td>

 </tr>
 

 
  </table>
  </div>
 </div>
  
<div class="box grid_8">
<div class="box-head">
  <h2>Circumstances, details and data to be Letosystem</h2>
</div>
        <div class="box-content ad-stats">	
<table width="100%" class="border">
         
<tr class="innertable" >
<td width="25%"><strong>If known; describe problem circumstances leading to failure and/or steps taken since failure</strong>:</td>
<td><textarea name="steps_during_failure" id="steps_during_failure" style="width:580px; border: 1px solid #CCCCCC; height:145px; resize:none;" cols="" rows=""></textarea></td>
</tr>

<tr class="innertable" >
<td width="25%"><strong>Special request or comments</strong>:</td>
<td><textarea name="spcl_req_comm" id="spcl_req_comm" style="width:580px; border: 1px solid #CCCCCC; height:50px; resize:none;" cols="" rows=""></textarea></td>
</tr>

<tr class="innertable"  >
<td width="25%"><strong>Service Level</strong>:</td>
<td><select id="priority_level" name="priority_level" class="required" style="width:30%;">
	<option value="" label="-- Please select --">-- Please select --</option>
	<option value="Unsure" label="Unsure">Unsure</option>
	<option value="Standard Priority" label="Standard Priority">Standard Priority</option>
	<option value="Critical Expedited" label="Critical Expedited">Critical Expedited</option>
	<option value="EcoSalvage" label="EcoSalvage">EcoSalvage</option>
	</select></td>
</tr>

<tr class="innertable"  >
<td width="25%"><strong>Return my data via</strong>:</td>
<td><select id="data_return_by" name="data_return_by" class="required" style="width:30%;">
	<option value="" label="-- Please select --">-- Please select --</option>
	<option value="External USB/eSATA/FireWire Drive" label="External USB/eSATA/FireWire Drive">External USB/eSATA/FireWire Drive</option>
	<option value="Optical DVD Disk Storage Media" label="Optical DVD Disk Storage Media">Optical DVD Disk Storage Media</option>
	<option value="I will provide storage media" label="I will provide storage media">I will provide storage media</option>
	<option value="I will decide later, after evaluation" label="I will decide later, after evaluation">I will decide later, after evaluation</option>
	</select></td>
</tr>

</table>
</div>
</div>
 
 <br /><br />
 <p align="right"><?php if(in_array ($page_id.'add' , $child_action )  ||  $_SESSION['ATYPE']!='sub_admin') 
{ ?><input name="button_save" class="button blue_add" value="Add Value" type="button" onclick="javascript:return valid_page();"><?php
}else
{
echo '<input type="button" class="button grey_add" value="Add New"  />';
}
?></p>
  <?php 
} ?>

 

  </form>

  </div>

<?

			

			$con->closeConnection();

		}

		function bodyAdmin()

		{

?>

<?php $this->head(); ?>

 <?php $this->toppanel(); ?>

  <?php $this->menu(); ?>

  <?php $this->body(); ?>

  <?php //$this->side_bar(); ?><!--

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