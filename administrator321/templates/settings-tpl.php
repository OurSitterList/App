<?
	include("classes/AdminStructure.php");
	class Settings extends AdminStructure
	{
		function Settings($title)
		{
			parent::AdminStructure($title);
		}
		function conDition()
		{
			if(!$_SESSION['AID'])
				header("Location: ./");
					if($_SESSION['ATYPE']=='sub_admin')
			{
			  header("Location: ./");
			}
		}
		function body()
		{
			$con=new DBConnection(host,user,pass,db);
			$conObj=$con->connectDB();
			$Q="SELECT

				A.id AS id,

				A.settingName AS name,

				A.settingValue AS value

				FROM

				setting AS A";
			$Rec=mysql_query($Q,$conObj) or die(mysql_error());
?>
<script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>
<script language="javascript" type="text/javascript" src="js/ui.datepicker.js"></script>
<script language="javascript" type="text/javascript" src="js/new_jquery.blockUI.js"></script>
<script language="javascript" type="text/javascript" src="js/settings.js"></script>
<script language="javascript" type="text/javascript">
	var ob;
	$(document).ready(function(){
		ob=new Settings(<?=$_SESSION['ATYPE']?>);
<?
	while($R=mysql_fetch_object($Rec))
		echo 'ob.setInfo('.$R->id.',"'.addslashes($R->name).'","'.addslashes($R->value).'");'."\n";
?>
	});
</script>

<div class="box grid_8">

<div class="box-head"><h2>General Site Setup</h2></div>
        <div class="box-content ad-stats">
<table width="100%" class="border">
<thead>
    <tr>
        <th width="40%" align="center" class="tablehead">Setting Name</th>
        <th width="40%"  align="center" class="tablehead">Setting Value</th>
       <th width="20%" align="center" class="tablehead">Edit</th>
      </tr>
</thead>
<tbody>
<?
	mysql_data_seek($Rec,0);
	while($R=mysql_fetch_object($Rec))
	{
?>
      <tr>
        <td align="left" valign="middle" class="innertable"><?=$R->name?></td>
        <td align="left" valign="middle" class="innertable" id="val<?=$R->id?>"><?=$R->value?></td>
        <td align="center" valign="middle" class="innertable" id="click<?=$R->id?>"><input  type="button" class="button green_edit"  name="edit" value="Edit" onclick="set_box(<?=$R->id?>)" /></td>
	
   <script language="javascript" type="text/javascript">
function set_box(id)
{
var input_value=$('#val'+id).html();
$('#val'+id).html('<input type="text" name="input'+id+'" id="input'+id+'" value="'+input_value+'" />');
$('#click'+id).html('<input type="button" class="button blue_update"  name="update" value="Update" onclick="set_update('+id+')" />');
}


function set_update(id)
{
var input_value=$('#input'+id).val();
$.ajax({
						type: "POST",
						url: "ajax/settings.php",
						data: "mode=setVal&id="+id+"&newVal="+input_value,
						success: function(msg){
							$('#val'+id).html(input_value);
						}
					});


$('#click'+id).html('<input  type="button" class="button green_edit"  name="edit" value="Edit" onclick="set_box('+id+')" />');
}
	/*$(document).ready(function(){
		$('#click<?$R->id?>').click(function(){
			ob._edit=$(this).attr('href');
			ob.setDiv();
			$.blockUI(ob._div,{ width:'500px' });
			$('#bSet').click(function(){
				if(jQuery.trim($('#tName').val()).length==0)
				{
					$('#error').html('- Enter '+ob._name[ob._edit]+' Settings Value.');
					$('#tName').val('');
					$('#tName').focus();
				}
				else
				{
					$('#error').html('<img src="images/loading-red.gif" alt="Loading" width="32" height="32">');
					$.ajax({
						type: "POST",
						url: "ajax/settings.php",
						data: "mode=setVal&id="+ob._edit+"&newVal="+$('#tName').val(),
						success: function(msg){
							ob._value[ob._edit]=$('#tName').val();
							$('#val'+ob._edit).html(ob._value[ob._edit]);
							$.unblockUI();
						}
					});
				}
			});
			$('#bCancNew').click($.unblockUI);
			return false;
		});
	});*/
</script> 
	

	  </tr>
<?
	}
?>
   </tbody> </table></div>
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
<?
		}
	}
?>