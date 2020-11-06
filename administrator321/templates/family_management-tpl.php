<?php



	include("classes/AdminStructure.php");

	include_once("./fckeditor/fckeditor.php");

	class Settings extends AdminStructure



	{



		function Home($title)



		{



			parent::AdminStructure($title);



		}



		function conDition()



		{

		$page_id=18;

		$con=new DBConnection(host,user,pass,db);



		$conObj=$con->connectDB(true);

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



		function jScripts()



		{



			



		}



		function body()



		{



?>



<!--************************PAGE BODY***************************-->



<?php

$page_id=18;

$access_val=mysql_fetch_object(mysql_query("SELECT * FROM user_management WHERE user_id=".$_SESSION['AID']));

$child_action=explode(',',$access_val->child_action);

$view=0;



		$con=new DBConnection(host,user,pass,db);



		$conObj=$con->connectDB(true);

		extract($_REQUEST);

		

	

		if(isset($_POST['hmode']))



		{



			extract($_POST);



			if($hmode == 'view')



			  $view=1;





			elseif($hmode == 'edit')



				$view=2;



			     elseif($hmode == 'drop')



				{	

						

				  $sql2 = "delete from user_management where user_id ='".$hid."'";

				  			

				    

						mysql_query($sql2);

					

					 header("location:".$_SERVER['PHP_SELF']);



						



				}



				elseif($hmode=='muldel')



				{



				foreach($chk as $val)



				{	

					

				  	$sql2 = "delete from user_management where user_id='".$val."'";



				    

						mysql_query($sql2);

				    

				}  



				   header("location:".$_SERVER['PHP_SELF']);		



				   exit;



				}



				elseif($hmode == 'addnew')



					$view=3;



			  



			



	 }	
	 
	 



	 



	    



?>



<script language="javascript" type="text/javascript" src="js/jquery.js"></script> 



<script language="javascript" type="text/javascript" src="js/MyFunctions.js"></script>


<script src="js/jquery.dataTables.min.js"></script>
<script language="javascript" type="text/javascript">



	var mf;



	mf=new MyFunctions;



			$(document).ready(function(){				



				$('.view').click(function(){



					 $('#hmode').val('view');



					 $('#hid').val($(this).attr('name'));



					 document.frmCategory.submit();



				  });



				 		  				  



			    $('.drop').click(function(){



			    $('#hmode').val('drop');



				$('#hid').val($(this).attr('id'));



				 if(confirm('Are You Sure To Delete?'))



				      document.frmCategory.submit();



				 else



					  return false; 



			   });



				$('#check').click(function(){



					  $('.chk').attr('checked',$(this).is(':checked'));



					});



				$('.chk').click(function(){



					 if($('.chk').length==$('.chk:checked').length)



					   $('#check').attr('checked',true);



					 else



					   $('#check').attr('checked',false);   



					});



				$('.dell').click(function(){



				 if($('.chk:checked').length==0)



				 {



				  alert('please select one check box');



				  



				  return false;



				 }



				 else



				 {



				 	if(confirm('Do You Want to Delete these Courier Company?'))



				 		{



						$('#hmode').val('muldel');



						document.frmCategory.submit();



						}



					else



					    return false;	



				 }	



				});

 $('#progress_list').dataTable( {
        "bJQueryUI": true   
    });

$("#quote_standard_approved_time").datetimepicker();
$("#quote_expedited_approved_time").datetimepicker();
$("#quote_rush_approved_time").datetimepicker();
$("#quote_promised_data_of_delivery").datetimepicker();

			});



						



		function del(value,hid,id)	



			{



				if(confirm('Are you delete this?'))



				{



					$('#hmode').val(value);



					$('#hid').val(hid);



					$('#himg').val(id);



					$('#frmCategory').submit();



				}



			}

			function check_registration()
			{

				

				var status=$('input:radio[name="case_status"]:checked').val();

				
				

				$.ajax({

					type: "POST",

					url: "ajax/ajax.php",

					data: "mode=do_registration&case_id="+$('#case_id').val()+"&status="+status,

					success: function(msg){

						if(msg==1)
						{
						$.sticky('The Case - '+$('#case_id').val()+' is Active');
						}
						else
						{
						$.sticky('The Case - '+$('#case_id').val()+' is Inactive');
						}

					}

					});



			

			}
			
			function update_analysis(id)
			{
			
var splashArray = new Array();
var splashArray_extra = new Array();


$(".analysis").each(function(){

		

    var $this = $(this);



    if($this.is(":checked")){

	

		splashArray.push($this.attr("value"));

	}

	});

var str =splashArray.join(',');


$(".extra_analysis").each(function(){

		

    var $this = $(this);



    if($this.is(":checked")){

	
var value = $('#extra_analysis_name'+$this.attr("value")).val();
 if(jQuery.trim(value).length==0)
 {
 }
 else
 {
		splashArray_extra.push(value);
		}

	}

	});

var str_extra =splashArray_extra.join(',');
//alert(str_extra);

$.ajax({

					type: "POST",

					url: "ajax/ajax.php",

					data: "mode=update_analysis&analysis="+str+"&analysis_extra="+str_extra+"&case="+id+"&prob_nature="+$('#prob_nature').val(),

					success: function(msg){

						//alert(msg);

			if(msg==1)
			{
			$.sticky($('#case_id').val()+'  -  Analysis Report is Updated');
			}
					}

						
					});

		}
		
			function update_progress(id)
			{
			
var splashArray = new Array();


$(".progress").each(function(){

		

    var $this = $(this);



    if($this.is(":checked")){

	

		splashArray.push($this.attr("value"));

	}

	});

var str =splashArray.join(',');
$.ajax({

					type: "POST",

					url: "ajax/ajax.php",

					data: "mode=update_progress&progress="+str+"&case="+id,

					success: function(msg){

						//alert(msg);
						$(".progress").each(function(){

		

    var $this = $(this);



    if($this.is(":checked")){

	
		$this.attr('disabled','disabled');
		$('#update_time_'+$this.attr("value")).html(msg);

	}

	});

			
					}

						
					});

		}
		
			function update_quote(id)
			{

		$.ajax({

					type: "POST",

					url: "ajax/ajax.php",

					data: "mode=update_quote&quote_approval_progress="+$('#quote_approval_progress').val()+"&quote_standard_price="+$('#quote_standard_price').val()+"&quote_standard_days="+$('#quote_standard_days').val()+"&quote_standard_approved_time="+$('#quote_standard_approved_time').val()+"&quote_expedited_price="+$('#quote_expedited_price').val()+"&quote_expedited_days="+$('#quote_expedited_days').val()+"&quote_expedited_approved_time="+$('#quote_expedited_approved_time').val()+"&quote_rush_price="+$('#quote_rush_price').val()+"&quote_rush_days="+$('#quote_rush_days').val()+"&quote_rush_approved_time="+$('#quote_rush_approved_time').val()+"&quote_discount_type="+$('#quote_discount_type').val()+"&quote_promised_data_of_delivery="+$('#quote_promised_data_of_delivery').val()+"&quote_discount_value="+$('#quote_discount_value').val()+'&case='+id,

					success: function(msg){

						//alert(msg);

			if(msg==1)
			{
			$.sticky($('#case_id').val()+'  -  Quote is Updated');
			}
					}

						
					});

		}
		
			function call_approveal(id)
			{
			

if($('#'+id).is(":checked"))
{
	$('.call_approveal_class').attr('disabled','disabled');
	$('#'+id).removeAttr('disabled');
	var val = 1;
		
}
else
{
	$('.call_approveal_class').removeAttr('disabled');
	var val = 0;
}

$.ajax({

					type: "POST",

					url: "ajax/ajax.php",

					data: "mode=call_approveal&aproval_field="+id+"&val="+val+"&case="+$('#case_id').val(),

					success: function(msg){

						//alert(msg);

			if(msg==1)
			{
			$.sticky($('#case_id').val()+'  -  Quote Approved');
			}
					}

						
					});

		}
		




	

function change_approval(Fieldname,Fieldid)
{
	///alert(Fieldname);
	$.ajax({

					type: "POST",

					url: "ajax/ajax.php",

					data: "mode=change_approval&Fieldname="+Fieldname+'&Fieldid='+Fieldid,

					success: function(msg){
						//alert(msg);
						$('#'+Fieldname+'_area_'+Fieldid).html(msg);
						}

					});
}

		</script>

<form action="<?=$_SERVER['PHP_SELF']?>" method="post" id="frmCategory" name="frmCategory" enctype="multipart/form-data">



<input name="hmode" type="hidden" id="hmode">



 <input type="hidden" name="DataID" id="DataID">



 <input type="hidden" name="PageAction" id="PageAction" />



<input name="hid" type="hidden" id="hid">



<input type="hidden" name="himg" id='himg'/>





  

  

 	



  <?php if($_GET['mode'] == 'view'){

	$result_row=mysql_fetch_object(mysql_query("select * from user_management where case_id = ".$case_id));

 ?>  

<div class="box grid_8">

    <div class="box-head">

      <h2>Case Details</h2>

    </div>

    <div class="box-content ad-stats" style="display:none;">

      <table width="100%" class="border">

			<tr class="innertable">

			  <td width="25%"><strong>Case ID </strong>:</td>

			  <td><input type="hidden" name="case_id" id="case_id" value="<?=$result_row->case_id?>" /><?=$result_row->case_id?></td>

			</tr>

	

        	<tr class="innertable">

			  <td width="25%"><strong> Name </strong>:</td>

			  <td><?=$result_row->case_first_name.' '.$result_row->case_last_name?></td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>Email </strong>:</td>

			  <td><?=$result_row->case_email?></td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>Address </strong>:</td>

			  <td><?=$result_row->case_address1.'<br>'.$result_row->case_address2?></td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>City </strong>:</td>

			  <td><?=$result_row->case_city?></td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>State </strong>:</td>

			  <td><?=$result_row->case_state?></td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>Country </strong>:</td>

			  <td><?=mysql_fetch_object(mysql_query("select * from cuntry_managment where id='".$result_row->case_country."'"))->name?></td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>Zipcode </strong>:</td>

			  <td><?=$result_row->case_zipcode?></td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>Organization </strong>:</td>

			  <td><?=$result_row->case_organization?></td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>Contact No </strong>:</td>

			  <td><?=$result_row->case_contact_no?></td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>Miobile No </strong>:</td>

			  <td><?=$result_row->case_cell_no?></td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>Media Type </strong>:</td>

			  <td><?=mysql_fetch_object(mysql_query("select * from form_management where form_option_id='".$result_row->case_media_type."'"))->form_option_name?></td>

			</tr>

          <?php   if($result_row->case_media_type==12)

{?>

		<tr class="innertable">

			  <td width="25%">&nbsp;</td>

			  <td>Raid Type - <?=mysql_fetch_object(mysql_query("select * from form_management where form_option_id='".$result_row->mul_raid_type."'"))->form_option_name?><br />

              Total Drive - <?=$result_row->mul_total_drive?><br />

              Failed Drive - <?=$result_row->mul_failed_drive?><br />

              Drive Size - <?=$result_row->mul_sized_drive?><br />

              </td>

			</tr>

            

            <?php

			}

			?>

			<tr class="innertable">

			  <td width="25%"><strong>Operating System </strong>:</td>

			  <td><?=mysql_fetch_object(mysql_query("select * from form_management where form_option_id='".$result_row->case_operating_system."'"))->form_option_name?></td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>Capacity </strong>:</td>

			  <td><?=$result_row->case_capacity.' '.mysql_fetch_object(mysql_query("select * from form_management where form_option_id='".$result_row->case_capacity_type."'"))->form_option_name?></td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>Circumstances</strong>:</td>

			  <td><?=$result_row->case_circumstances?></td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>Important File </strong>:</td>

			  <td><?=$result_row->case_imp_file?></td>

			</tr>

			

       

      </table>	  

    </div>

  </div>

  <div class="box grid_8">

    <div class="box-head">

      <h2>Case Status</h2>

    </div>

    <div class="box-content ad-stats" style="display:none;">

      <table width="100%" class="border">

			<tr class="innertable">

			  <td width="25%"><strong>Case Status </strong>:</td>

			  <td><input type="radio" name="case_status" <?=$result_row->case_status=='1'?'checked="checked"':''?> value="1" onchange="check_registration()"  />Active

              <input type="radio" name="case_status" <?=$result_row->case_status=='0'?'checked="checked"':''?> value="0" onchange="check_registration()"  />Inactive</td>

			</tr>

	

        	

			

       

      </table>	  

    </div>

  </div>
  
  <div class="box grid_8">

    <div class="box-head">

      <h2>Analysis</h2>

    </div>

    <div class="box-content ad-stats" style="display:none;">

      <table width="100%" class="border">

			<tr class="innertable">
            <?php
			$analysis_query = mysql_query("select * from `analysis_management`");
			$acount =0;
			$result_analysis = explode(',',$result_row->analysis_id);
			$result_analysis_extra = explode(',',$result_row->extra_analysis_id);
			if(mysql_num_rows($analysis_query)>0)
			{
				while($A = mysql_fetch_object($analysis_query))
				{
				if(in_array($A->analysis_id,$result_analysis))
				{
				$chck_stat = 'checked="checked"';				
				}
				else
				{
				$chck_stat = '';
				}
				$acount++;
				if($acount==4)
				{
				?>
				</tr>
				<tr class="innertable">
				<?php 
				$acount=1;
				}	
			?>
			  <td width="33%"><input type="checkbox" name="analysis[]" class="analysis" value="<?=$A->analysis_id?>" <?=$chck_stat?> /> <?=$A->analysis_name?></td>
              <?php
			  }
			  }
			  ?>
              
 
			</tr>

	<tr class="innertable">
    <td width="33%"><input type="checkbox" name="extra_analysis[]" class="extra_analysis" value="1" <?=$result_analysis_extra[0]==''?'':'checked="checked"'?> /> <input type="text" name="extra_analysis_name1" id="extra_analysis_name1" style="width:90%;"  value="<?=$result_analysis_extra[0]?>"/></td>
    <td width="33%"><input type="checkbox" name="extra_analysis[]" class="extra_analysis" value="2" <?=$result_analysis_extra[1]==''?'':'checked="checked"'?> /> <input type="text" name="extra_analysis_name2" id="extra_analysis_name2" style="width:90%;" value="<?=$result_analysis_extra[1]?>"/></td>
    <td width="33%"><input type="checkbox" name="extra_analysis[]" class="extra_analysis" value="3" <?=$result_analysis_extra[2]==''?'':'checked="checked"'?> /> <input type="text" name="extra_analysis_name3" id="extra_analysis_name3" style="width:90%;" value="<?=$result_analysis_extra[2]?>"/></td>
    </tr>
    <tr class="innertable">
    <td width="33%"><input type="checkbox" name="extra_analysis[]" class="extra_analysis" value="4" <?=$result_analysis_extra[3]==''?'':'checked="checked"'?> /> <input type="text" name="extra_analysis_name4" id="extra_analysis_name4" style="width:90%;" value="<?=$result_analysis_extra[3]?>"/></td>
    <td width="33%"><input type="checkbox" name="extra_analysis[]" class="extra_analysis" value="5" <?=$result_analysis_extra[4]==''?'':'checked="checked"'?> /> <input type="text" name="extra_analysis_name5" id="extra_analysis_name5" style="width:90%;" value="<?=$result_analysis_extra[4]?>"/></td>
    <td width="33%"><input type="checkbox" name="extra_analysis[]" class="extra_analysis" value="6" <?=$result_analysis_extra[5]==''?'':'checked="checked"'?> /> <input type="text" name="extra_analysis_name6" id="extra_analysis_name6" style="width:90%;" value="<?=$result_analysis_extra[5]?>"/></td>
    </tr>
<tr class="innertable">
<td>Problem Category:</td>
<td colspan="2">
<script language="javascript">
function load_prob_nature()
{
	if($('#prob_cat').val()==0)
	{
		$('#prob_nature').html('<option value="0">Select Nature</option>');
	}
	else
	{
		
				$.ajax({

					type: "POST",

					url: "ajax/ajax.php",

					data: "mode=load_prob_nature&prob_cat="+$('#prob_cat').val(),

					success: function(msg){
						$('#prob_nature').html(msg);
						}

					});
	}
}


</script>
<?php
if($result_row->prob_nature==0 || $result_row->prob_nature=='')
{
	$p_cat = 0;
	$p_nat = 0;
}
else
{
	$p_cat = mysql_fetch_object(mysql_query("select * from `problem_management` where problem_id='".$result_row->prob_nature."'"))->problem_parent;
	$p_nat = $result_row->prob_nature;
	
}
?>
<select name="prob_cat" id="prob_cat" onchange="load_prob_nature()">
<option value="0">Select Category</option>
<?php $prob_category = mysql_query("select * from `problem_management` where problem_parent='0'");
if(mysql_num_rows($prob_category)>0)
{
	while($P=mysql_fetch_object($prob_category))	
	{
	?>
    <option value="<?=$P->problem_id?>" <?=$P->problem_id==$p_cat?'selected="selected"':''?>><?=$P->problem_title?></option>
   <?php	
	}
}?>
</select>
</td>
</tr>
<tr class="innertable">
<td>Problem Nature:</td>
<td colspan="2">
<select name="prob_nature" id="prob_nature">
<option value="0">Select Nature</option>
<?php if($p_nat!=0)
{
	$prob_nature = mysql_query("select * from `problem_management` where problem_parent='".$p_cat."'");
if(mysql_num_rows($prob_nature)>0)
{
	while($PN=mysql_fetch_object($prob_nature))	
	{
	?>
    <option value="<?=$P->problem_id?>" <?=$PN->problem_id==$p_nat?'selected="selected"':''?>><?=$PN->problem_title?></option>
   <?php	
	}
}
}
?>
</select>
</td>
</tr>

<tr class="innertable">
<td colspan="3">
<input type="button" class="save_button button blue_update" name="category"  style="cursor:pointer;" value="Update" title="" onclick="update_analysis(<?=$result_row->case_id?>)" />
</td>
</tr>			

       

      </table>	  

    </div>

  </div>
  
  <div class="box grid_8">
        <div class="box-head"><h2>Progress</h2></div>

    <div class="box-content no-pad ad-stats" style="display:none;">

      <table width="100%" class="border" id="progress_list" >

<thead>

<tr bordercolor="#000000"  class="border header" border="1">


<th class="tablehead" width="15%">Progress stage</th>
<th class="tablehead" width="60%">Details</th>
<th class="tablehead" width="20%">Date</th>
<th class="tablehead" width="5%">&nbsp;</th>
</tr>

</thead>
<tbody>
<?php
$progress_query = mysql_query("select * from `progress_management` order by progress_priority");
$N_prog = mysql_num_rows($progress_query);
if($N_prog>0)
{?>
<script type="text/javascript">
        $(document).ready(function () {
         				 
 $('#progress_paginate').smartpaginator({ totalrecords: <?=$N_prog?>, recordsperpage: 5,  length: 1, datacontainer: 'progress_list', dataelement: 'tr', initval: 0, next: 'Next', prev: 'Prev', first: 'First', last: 'Last', theme: 'black',controlsalways: true,display:'single' });
});
</script>
<?php
while($P = mysql_fetch_object($progress_query))
{
$exist_prog = mysql_query("select * from case_progress_status_management where case_id='".$result_row->case_id."' and progress_id='".$P->progress_id."'");
$exist_prog_n = mysql_num_rows($exist_prog);
if($exist_prog_n>0)
{
$exist_prog_time = mysql_fetch_object($exist_prog);
}
?>
<tr class="innertable" >

<td><?=$P->progress_title?></td>
<td><?=$P->progress_details?></td>
<td id="update_time_<?=$P->progress_id?>"><?=$exist_prog_n>0?date('d/m/Y h:i:s a',$exist_prog_time->status_time):''?></td>
<td><input type="checkbox" name="progress[]" class="progress" value="<?=$P->progress_id?>" <?=$exist_prog_n>0?'disabled="disabled" checked="checked"':''?>   /></td>
</tr>
<?php
}
}
?>
</tbody>
		

       

      </table>	  
 <ul class="table-toolbar">
            <li><input type="button" class="save_button button blue_update" name="category"  style="cursor:pointer; float:left;" value="Update" title="" onclick="update_progress(<?=$result_row->case_id?>)" /></li>
        
          </ul>
    </div>

  </div>
  
  
 <div class="box grid_8">

    <div class="box-head">

      <h2>Quote</h2>

    </div>

    <div class="box-content ad-stats" style="display:none;">
<?php $Q = mysql_fetch_object(mysql_query("select * from `quote_management` where case_id='".$result_row->case_id."'"));?>
      <table width="100%" class="border">

			<tr class="innertable">

			  <td width="25%"><strong>Quote Approval Progress</strong>:</td>

			  <td><textarea name="quote_approval_progress" id="quote_approval_progress"><?=$Q->quote_approval_progress?></textarea></td>

			</tr>

	

        	<tr class="innertable">

			  <td width="25%"><strong> Quote Sent Date / Time </strong>:</td>

			  <td><select name="quote_is_sent" id="quote_is_sent" style="width:10%;" disabled="disabled">
              <option value="0" <?=$Q->quote_is_sent=='0'?'selected="selected"':''?> >No</option>
              <option value="1" <?=$Q->quote_is_sent=='1'?'selected="selected"':''?>>Yes</option>
              </select> <input type="text" name="quote_sent_time" id="quote_sent_time" style="width:85%;" disabled="disabled" value="<?=$Q->quote_sent_time?>" /></td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>Standard Quote </strong>:</td>

			  <td>
              $<input type="text" name="quote_standard_price" id="quote_standard_price" style="width:10%;" value="<?=$Q->quote_standard_price?>" /> 
              Days(ex:4-5) <input type="text" name="quote_standard_days" id="quote_standard_days" style="width:10%;" value="<?=$Q->quote_standard_days?>"  /> 
              <input type="text" id="quote_standard_approved_time" name="quote_standard_approved_time" style="width:30%;" value="<?=$Q->quote_standard_approved_time?>"  /> 
               <span class="form-icon fugue-2 calendar-day"></span>
              Approved <input type="checkbox" name="quote_standard_is_approved" id="quote_standard_is_approved" value="1" <?=$Q->quote_standard_is_approved=='1'?'checked="checked"':''?>  onclick="call_approveal('quote_standard_is_approved')" class="call_approveal_class" /> 
              <input type="button" class="button purple_email"  value="Send Email" />
             
              </td>

			</tr>
            <tr class="innertable">

			  <td width="25%"><strong>Expedited Quote </strong>:</td>

			  <td>
              $<input type="text" name="quote_expedited_price" id="quote_expedited_price" style="width:10%;" value="<?=$Q->quote_expedited_price?>" /> 
              Days(ex:4-5) <input type="text" name="quote_expedited_days" id="quote_expedited_days" style="width:10%;" value="<?=$Q->quote_expedited_days?>"  /> 
              <input type="text" id="quote_expedited_approved_time" name="quote_expedited_approved_time" style="width:30%;" value="<?=$Q->quote_expedited_approved_time?>"  /> 
               <span class="form-icon fugue-2 calendar-day"></span>
              Approved <input type="checkbox" name="quote_expedited_is_approved" id="quote_expedited_is_approved" value="1" <?=$Q->quote_expedited_is_approved=='1'?'checked="checked"':''?>  onclick="call_approveal('quote_expedited_is_approved')"  class="call_approveal_class"/> 
              <input type="button" class="button purple_email"  value="Send Email"  />
              
              </td>

			</tr>
            <tr class="innertable">

			  <td width="25%"><strong>Rush Quote </strong>:</td>

			  <td>
              $<input type="text" name="quote_rush_price" id="quote_rush_price" style="width:10%;" value="<?=$Q->quote_rush_price?>" /> 
              Days(ex:4-5) <input type="text" name="quote_rush_days" id="quote_rush_days" style="width:10%;" value="<?=$Q->quote_rush_days?>"  /> 
              <input type="text" id="quote_rush_approved_time" name="quote_rush_approved_time" style="width:30%;" value="<?=$Q->quote_rush_approved_time?>"  /> 
               <span class="form-icon fugue-2 calendar-day"></span>
              Approved <input type="checkbox" name="quote_rush_is_approved" id="quote_rush_is_approved" value="1" <?=$Q->quote_rush_is_approved=='1'?'checked="checked"':''?> onclick="call_approveal('quote_rush_is_approved')"  class="call_approveal_class" /> 
              <input type="button" class="button purple_email"  value="Send Email" />
              
              </td>

			</tr>

			<tr class="innertable">

			  <td width="25%"><strong>Discount Offered</strong>:</td>

			  <td><select name="quote_discount_type" id="quote_discount_type" style="width:8%;"  >
              
              <option value="0"  <?=$Q->quote_discount_type=='0'?'selected="selected"':''?>>Percentage</option>
              <option value="1"  <?=$Q->quote_discount_type=='1'?'selected="selected"':''?>>Fixed</option>
              </select> &nbsp;<input type="text" name="quote_discount_value" id="quote_discount_value" style="width:20%;" value="<?=$Q->quote_discount_value?>" /> 
              
               <input type="button" class="button green_generate"  value="Generate Quote" />
                <input type="button" class="button purple_recal"  value="Re Calculate" /> </td>

			</tr>
            
            <tr class="innertable">

			  <td width="25%"><strong>Promised Date of Delivery </strong>:</td>

			  <td>
           
              <input type="text" id="quote_promised_data_of_delivery" name="quote_promised_data_of_delivery" value="<?=$Q->quote_promised_data_of_delivery?>" /> 
               <span class="form-icon fugue-2 calendar-day"></span>
             
              </td>

			</tr>
            
            <tr class="innertable">

			  <td width="25%"><strong>Total </strong>:</td>

			  <td>
           
              <input type="text" id="quote_total" name="quote_total" /> 
              
              </td>

			</tr>

<tr class="innertable">
<td colspan="3">
<input type="button" class="save_button button blue_update" name="category"  style="cursor:pointer;" value="Update" title="" onclick="update_quote(<?=$result_row->case_id?>)" />
</td>
</tr>	
			

       

      </table>	  

    </div>

  </div>

<?php }

else

{ 



$Q="SELECT * FROM `user_management` where user_type='family' order by join_date desc";

	

?>

<div class="box grid_8">

 <div class="box-head">

   <h2>Family List</h2>

 </div>

        <div class="box-content ad-stats">

        

<table border="0"  class="border" style="margin:0px; width:100%;">

<thead>

<tr bordercolor="#000000"  class="border" border="1">



<th class="tablehead"  align="center"><input type="checkbox" id="check" name="check" /></th>



<th  align="center" class="tablehead">Registration Date</th>

<th  align="center" class="tablehead">User ID </th>



<th  align="center" class="tablehead">Family Username</th>

<th  align="center" class="tablehead">Email </th>




<th  align="center" class="tablehead">Membership Status</th>


<th  align="center" class="tablehead">Status</th>


<th width="150" align="center"  class="tablehead">Delete</th>



</tr>

</thead>



<?php	



	//$Q="SELECT * FROM `prduct_mul_image` order by 'id_prduct_mul_image'";



	



	$Rec=mysql_query($Q,$conObj) or die(mysql_error());



	$paging=new Pagination('ui-state-disabled','fg-button ui-button ui-state-default','next fg-button ui-button ui-state-default');



	$paging->numData=mysql_num_rows($Rec);



	$paging->toShowData=20;



	$paging->toShowNumbers=9;



	$paging->numSeperator='';



	$Q=$paging->queryBuilder($Q);



	$Rec=mysql_query($Q,$conObj) or die(mysql_error());



	?>



	<!--============================================-->



	<!--===============================================-->



	



	

<tbody>

	<?php



	$N=mysql_num_rows($Rec);



	if($N)



	{



	mysql_data_seek($Rec,0);

	$count=0;



	while($R=mysql_fetch_object($Rec))



	{

$count++;

if($count==1)

{

	$class='odd';

}

else

{

	$class='even';

	$count=0;

}

	
	$user_info = mysql_fetch_object(mysql_query("select * from user_information where user_id='".$R->user_id."'"));

	?>

	

	



<tr class="<?=$class?>">



<td  align="center"><input type="checkbox" name="chk[]"  class="chk" id="chk" value="<?=$R->user_id?>"/></td>



<td><?=date('d M, Y',$R->join_date)?></td>

<td><?=$R->user_id?></td>

<td><?=$R->user_name?></td>
<td><?=$R->user_email?></td>



<td>
<?php if($R->is_payment_status==1)
{
	echo $R->user_plan.' Month';
}
else
{
	echo  'Not Member';
}
?>
</td>


<td><a href="javascript:void(0)" onclick="change_approval('user_status',<?=$R->user_id?>)" id="user_status_area_<?=$R->user_id?>"><?=$R->user_status==1?'Suspend Account':'Activate'?></a></td>




<?php /* <td  align="center"><?php if(in_array ($page_id.'view' , $child_action ) ||  $_SESSION['ATYPE']!='sub_admin') 

{?><a href="sitter_entry.php?mode=edit&case_id=<?=$R->user_id?>" class="view_new" name="<?=$R->case_id?>"><input  type="button" class="button green_edit"  name="view" value="Edit" /></a><?php }else { echo '<input  type="button" class="button grey_view"  name="edit" value="View" />';}?></td>

*/?>

<td  align="center"><?php if(in_array ($page_id.'delete' , $child_action ) || $_SESSION['ATYPE']!='sub_admin') 

{?><a href="#" id=<?=$R->user_id?> 



	class="drop"><input  type="button" class="button red_delete"  name="delete" value="Delete" /></a><?php }else { echo '<input  type="button" class="button grey_delete"  name="delete" value="Delete" />';}?></td>



</tr>



<?php } ?>



<tr>



	<td  align="center"><?php if(in_array ($page_id.'delete' , $child_action ) || $_SESSION['ATYPE']!='sub_admin') 

{?><a href="#" name="dell[]" class="dell" title=""><input  type="button" class="button red_deleteall"  name="delete all" value="Delete All" /></a><?php }else { echo '<input  type="button" class="button grey_deleteall"  name="delete all" value="Delete All" />';}?></td>



	<td align="center" colspan="8" ><div class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_full_numbers" id="dt3_paginate">

    

    <?=$paging->paginationPanel();?></div></td>



	</tr>



	



	<?php



	}



	



	else



	{



	?>



	<tr id="trempty">



	<td colspan="9" align="center" >Sorry! No Records Found.</td>



	</tr>



	<?php



	



	}



	?>



</tbody>

</table>

        </div>

</div>

<?php



	}

?>

<!--************************Edit***************************-->





</form>



<!--************************EndPAGE BODY***************************-->



<?php

}



		function bodyAdmin(){



?>



<?php $this->head(); ?>



 <?php $this->toppanel(); ?>



  <?php $this->menu(); ?>



  <?php //$this->sub_menu(); ?>



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



<?php



		}



	}



?>