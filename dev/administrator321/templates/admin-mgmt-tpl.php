<?php
	include("classes/AdminStructure.php");
	
	class AdminMgmt extends AdminStructure
	{
		function AdminMgmt($title)
		{
			parent::AdminStructure($title);
		}
		function conDition()
		{
			if(!$_SESSION['AID'])
			{
				header("Location: ./");
				exit;
			}
				if($_SESSION['ATYPE']=='sub_admin')
			{
			  header("Location: ./");
			}
		}
		function jScripts()
		{
?>
<script language="javascript" type="text/javascript" src="js/jquery.blockUI.js"></script>
<script language="javascript" type="text/javascript" src="js/admin-mgmt.js"></script>
<script language="javascript" type="text/javascript">
	var admin;
	$(document).ready(function(){
		admin=new AdminManagement(<?=$_SESSION['ATYPE']?'true':'false'?>);
		admin.toggleAdd();
	});
</script>
<?php
		}
		function body()
		{
			$con=new DBConnection(host,user,pass,db);
			$conObj=$con->connectDB(true);
			$Q="SELECT
				A.id AS id,
				A.updtime AS lastlogin,
				A.adminid AS adminid,
				A.atype AS atype
				FROM
				admin_login AS A";
			if($_SESSION['ATYPE']==0)
				$Q.=" WHERE A.id='".$_SESSION['AID']."'";
			$Q.=" ORDER BY A.id DESC";
			$Rec=mysql_query($Q,$conObj) or die(mysql_error());
?>

<div class="box-head"><h2>Admin Password Setup</h2></div>
        <div class="box-content ad-stats">
<table width="100%" class="border">
<thead>
 <tr>
    <th width="350" bgcolor="#fffae3" align="center" class="tablehead">Admin Name</th>
   <th width="350" bgcolor="#fffae3" align="center" class="tablehead">Password</th>
    <th width="350" bgcolor="#fffae3" align="center" class="tablehead">Last Login</th>
</tr>
</thead>
<tbody>
<?php
	while($R=mysql_fetch_object($Rec))
	{
?>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		admin.setUsers(<?=$R->id?>,"<?=addslashes($R->adminid)?>",<?=$R->atype?>);
		$('#changeP<?=$R->id?>').click(function(){
			changePassAction(<?=$R->id?>);
			return false;
		});
	});
</script>
      <tr>
        <td  align="center"><?=$R->adminid?></td>
        <td  align="center"><a href="#" id="changeP<?=$R->id?>" class="link1">Change Password</a></td>
        <td  align="center"><?=$R->lastlogin?date("M d, Y h:i:s A",$R->lastlogin):"N/A"?></td>
     </tr>
<?php
	}
?>
    </tbody></table>
    </div></div>
<?php
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
<?php
		}
	}
?>