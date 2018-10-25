function AdminManagement(type)
{
	this._adminType=type;
	this._tmpl=new Templetes(this);
	this._block=$('<div style="display:none; cursor:default;"></div>').prependTo('body');
	
	this._ids=new Array();
	this._admins=new Array();
	this._types=new Array();
	
	this._editIndex=-1;
	this._newType=-1;
	
	this._naname='';
	this._napwd='';
	this._natype='';
}
AdminManagement.prototype.resetAdmin=function()
{
	var idarr=new Array();
	var admarr=new Array();
	var typarr=new Array();
	
	for(var i in this._ids)
	{
		if(i==this._editIndex)
			continue;
		idarr.push(this._ids[i]);
		admarr.push(this._admins[i]);
		typarr.push(this._types[i]);
	}
	this._ids=idarr;
	this._admins=admarr;
	this._types=typarr;
}
AdminManagement.prototype.setUsers=function(id,admin,type)
{
	this._ids.push(id);
	this._admins.push(admin);
	this._types.push(type);
}
AdminManagement.prototype.toggleAdd=function()
{
	if(this._adminType)
	{
		$(this._tmpl.addNewButton())
			.appendTo('#mainTable tr:first td:last')
			.click(addNewButtonAction);
	}
}
AdminManagement.prototype.countSuperAdmins=function()
{
	var count=0;
	for(var i in this._types)
	{
		if(this._types[i]==1)
			count++;
	}
	return count;
}
AdminManagement.prototype.isAdminExists=function(adminID)
{
	for(var i in this._admins)
	{
		if(this._admins[i].toLowerCase()==adminID.toLowerCase())
			return true;
	}
	return false;
}

function Templetes(obj)
{
	this._adminobj=obj;
}
Templetes.prototype.loading=function()
{
	return '<img src="images/loading-red.gif" alt="Loading" width="32" height="32">';
}
Templetes.prototype.addNewButton=function()
{
	return '<a href="#" class="link11"></a>';
}
Templetes.prototype.addNewForm=function()
{
	return '<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1"> <tr>    <td colspan="2" align="left" valign="middle" class="heading1">Add New Admin:</td>  </tr>    <tr>    <td width="150" align="right" valign="middle" class="leftH">Name:</td>    <td align="left" valign="middle" class="bg11"><input type="text" class="textarea" id="tName" maxlength="25"></td>  </tr>  <tr>    <td align="right" valign="middle" class="leftH">Password:</td>    <td align="left" valign="middle" class="bg11"><input type="password" class="textarea" id="tPass" size="25"></td>  </tr>  <tr>    <td align="right" valign="middle" class="leftH">Confirm Password:</td>    <td align="left" valign="middle" class="bg11"><input type="password" class="textarea" id="tCPass" size="25"></td>  </tr>  <tr>    <td align="right" valign="middle" class="leftH">Admin Type:</td>    <td align="left" valign="middle" class="bg11"><select class="dob" id="admTypeNew">                                    <option value="0">Sales Manager</option>                                    <option value="1">Super</option>                                  </select></td>  </tr>  <tr>    <td align="right" valign="middle" class="leftH">&nbsp;</td>    <td align="left" valign="middle" class="bg11"><input type="button" class="button" id="bAddNew" value="Add User" />    <input type="button" class="button" id="bCancNew" value="Cancel" /></td>  </tr></table>';
}
Templetes.prototype.editForm=function()
{
	return '<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1"> <tr>    <td colspan="2" align="left" valign="middle" class="heading1">Edit Admin ['+this._adminobj._admins[this._adminobj._editIndex]+']:</td>  </tr>    <tr>    <td width="100" align="right" valign="middle" class="leftH">Name:</td>    <td align="left" valign="middle" class="bg11">'+this._adminobj._admins[this._adminobj._editIndex]+'</td>  </tr><tr>    <td align="right" valign="middle" class="leftH">Admin Type:</td>    <td align="left" valign="middle" class="bg11"><select class="dob" id="admTypeNew">                                    <option value="0">Sales Manager</option>                                    <option value="1">Super</option>                                  </select></td>  </tr>  <tr>    <td align="right" valign="middle" class="leftH">&nbsp;</td>    <td align="left" valign="middle" class="bg11"><input type="button" class="button" id="bAddNew" value="Update User" />    <input type="button" class="button" id="bCancNew" value="Cancel" /></td>  </tr></table>';
}
Templetes.prototype.newRow=function(id)
{
	return '<tr>        <td align="left" valign="middle" class="bg11">'+this._adminobj._naname+'</td>        <td align="left" valign="middle" class="bg11"><a href="#" class="link1" onClick="JavaScript: changePassAction('+id+'); return false;">Change Password</a></td>        <td align="left" valign="middle" class="bg11">N/A</td>        <td align="left" valign="middle" class="bg11">'+(this._adminobj._natype==0?"Sales Manager":"Super")+'</td>        <td align="center" valign="middle" class="bg11"><a href="#" id="edit'+id+'" onClick="JavaScript: editAction('+id+'); return false;"><img src="images/edit.png" alt="Edit" width="16" height="16" border="0"></a></td>        <td align="center" valign="middle" class="bg11"><a href="#" onClick="JavaScript: delAction('+id+'); return false;"><img src="images/drop.png" alt="Delete" width="16" height="16" border="0"></a></td>      </tr>';
}
Templetes.prototype.changePassTemplate=function()
{
	return '<table width="100%" border="0" align="left" cellpadding="3" cellspacing="1">		<tr>                                  <td colspan="2" align="left" valign="top" class="heading1">Change Password ['+this._adminobj._admins[this._adminobj._editIndex]+']</td>                                </tr>							   							                                   <tr>                                  <td width="150" align="right" valign="top" class="leftH">New Password *:</td>                                  <td align="left" valign="top" class="bg11"><input type="password" class="textarea" id="NP" maxlength="90" /></td>                                </tr>								<tr>                                  <td width="150" align="right" valign="top" class="leftH">Confirm Password *:</td>                                  <td align="left" valign="top" class="bg11"><input type="password" class="textarea" id="CP" maxlength="90" /></td>                                </tr>																<tr>								  <td align="right" valign="top" class="leftH">&nbsp;</td>								  <td align="left" valign="top" class="bg11">Fields with (<span class="err">*</span>) are required.</td>    </tr>								<tr>								  <td align="right" valign="top" class="leftH">&nbsp;</td>								  <td align="left" valign="top" class="bg11"><input type="button" class="button blue_passchange" id="bPassU" value="Change" />							      &nbsp;<input type="button" class="button red_passcancel" id="bCancU" value="Cancel" /></td>    </tr>                              </table>';
}
Templetes.prototype.stopDelTemplate=function()
{
	return '<table width="100%" border="0" align="left" cellpadding="3" cellspacing="1">	<tr>	<td align="left" valign="top" class="heading1">- Stop:</td>    </tr>						   <tr>	<td align="center" valign="top" class="errMsg">- Unable to Delete user: '+this._adminobj._admins[this._adminobj._editIndex]+'<br /><br />    <input type="button" class="button" id="bConfC" value="Ok" /></td>    </tr>                                                                </table>';
}
Templetes.prototype.confirmTemplate=function()
{
	return '<table width="100%" border="0" align="left" cellpadding="3" cellspacing="1">	<tr>	<td align="left" valign="top" class="heading1">- Confirmation:</td>    </tr>						   <tr>	<td align="center" valign="top" class="errMsg">- Are you Confirm to Delete user: '+this._adminobj._admins[this._adminobj._editIndex]+'<br />    <br />    <input type="button" class="button" id="bConfO" value="Yes" />&nbsp;<input type="button" class="button" id="bConfC" value="No" /></td>    </tr>                                                                </table>';
}
Templetes.prototype.msgTemplate=function(msg)
{
	return '<tr id="msgBox"><td class="errMsg">&nbsp;</td><td align="left" valign="middle" class="errMsg">'+msg+'</td></tr>';
}

/* Actions */
function addNewButtonAction()
{
	admin._block.html(admin._tmpl.addNewForm());
	$.blockUI(admin._block,{ width:'500px' });
	$('#bAddNew').click(addNew);
	$('#bCancNew').click($.unblockUI);
	return false;
}
function addNew()
{
	$('#msgBox').remove();
	var msgID=$('#tName').parent().parent();
	if(jQuery.trim($('#tName').val()).length==0)
	{
		msgID.before(admin._tmpl.msgTemplate("- Enter Name for Admin."));
		$('#tName').val('');
		$('#tName').focus();
	}
	else if(jQuery.trim($('#tPass').val()).length==0)
	{
		msgID.before(admin._tmpl.msgTemplate("- Enter Password for Admin."));
		$('#tPass').val('');
		$('#tPass').focus();
	}
	else if($('#tPass').val().length<5)
	{
		msgID.before(admin._tmpl.msgTemplate("- Password Should > 4 Characters."));
		$('#tPass').focus();
	}
	else if(jQuery.trim($('#tCPass').val()).length==0)
	{
		msgID.before(admin._tmpl.msgTemplate("- Confirm Password for Admin."));
		$('#tCPass').val('');
		$('#tCPass').focus();
	}
	else if($('#tPass').val()!=$('#tCPass').val())
	{
		msgID.before(admin._tmpl.msgTemplate("- Passwords not Matched."));
		$('#tPass').select();
	}
	else if(admin.isAdminExists($('#tName').val()))
	{
		msgID.before(admin._tmpl.msgTemplate("- Admin Exists. Enter Another Name."));
		$('#tName').select();
	}
	else
	{
		admin._naname=$('#tName').val();
		admin._napwd=$('#tPass').val();
		admin._natype=$('#admTypeNew').val();
		admin._block.html(admin._tmpl.loading());
		
		$.ajax({
			type: "POST",
			url: "ajax/admin-mgmt.php",
			data: "mode=newAdmin&name="+admin._naname+"&pass="+admin._napwd+"&type="+admin._natype,
			success: function(msg){
				$('#mainTable table tr:first').after(admin._tmpl.newRow(msg));
				admin.setUsers(msg,admin._naname,admin._natype);
				admin._naname='';
				admin._napwd='';
				admin._natype='';
				$.unblockUI();
			}
		});
	}
}
function editAction(id)
{
	admin._editIndex=jQuery.inArray(id,admin._ids);
	admin._block.html(admin._tmpl.editForm());
	$.blockUI(admin._block,{ width:'500px' });
	$('#admTypeNew').val(admin._types[admin._editIndex]);
	$('#bAddNew').click(updateAdmin);
	$('#bCancNew').click($.unblockUI);
}
function updateAdmin()
{
	if($('#admTypeNew').val()==0 && admin._types[admin._editIndex]==1 && admin.countSuperAdmins()==1 && admin._adminType)
	{
		$('#msgBox').remove();
		$('#admTypeNew').parent().parent().prev().before(admin._tmpl.msgTemplate("- Can't change Type."));
	}
	else
	{
		admin._newType=$("#admTypeNew").val();
		admin._block.html(admin._tmpl.loading());
		$.ajax({
			type: "POST",
			url: "ajax/admin-mgmt.php",
			data: "mode=edit&type="+admin._newType+"&aid="+admin._ids[admin._editIndex],
			success: function(msg){
				admin._types[admin._editIndex]=admin._newType;
				$("#edit"+admin._ids[admin._editIndex]).parent().prev().html(admin._newType==1?"Super":"Sales Manager");
				admin._editIndex=-1;
				admin._newType=-1;
				$.unblockUI();
			}
		});
	}
}
function changePassAction(id)
{
	admin._editIndex=jQuery.inArray(id,admin._ids);
	admin._block.html(admin._tmpl.changePassTemplate());
	$.blockUI(admin._block,{ width:'500px' });
	$('#admTypeNew').val(admin._types[admin._editIndex]);
	$('#bPassU').click(cpassAdmin);
	$('#bCancU').click($.unblockUI);
}
function cpassAdmin()
{
	$('#msgBox').remove();
	var msgID=$('#NP').parent().parent();
	
	if(jQuery.trim($("#NP").val()).length==0)
	{
		msgID.before(admin._tmpl.msgTemplate("- Enter New Password."));
		$("#NP").val('');
		$("#NP").focus();
	}
	else if($("#NP").val().length<5)
	{
		msgID.before(admin._tmpl.msgTemplate("- Password must be of > 4 Characters."));
		$("#NP").focus();
	}
	else if(jQuery.trim($("#CP").val()).length==0)
	{
		msgID.before(admin._tmpl.msgTemplate("- Enter Confirm Password."));
		$("#CP").val('');
		$("#CP").focus();
	}
	else if($("#NP").val()!=$("#CP").val())
		msgID.before(admin._tmpl.msgTemplate("- Passwords not matched."));
	else
	{
		admin._napwd=$('#NP').val();
		admin._block.html(admin._tmpl.loading());
		$.ajax({
			type: "POST",
			url: "ajax/admin-mgmt.php",
			data: "mode=change&NP="+admin._napwd+"&aid="+admin._ids[admin._editIndex],
			success: function(msg){
				admin._editIndex=-1;
				admin._napwd='';
				$.unblockUI();
			}
		});
	}
}
function delAction(id)
{
	admin._editIndex=jQuery.inArray(id,admin._ids);
	if(admin._types[admin._editIndex]==1 &&  admin.countSuperAdmins()==1)
	{
		admin._block.html(admin._tmpl.stopDelTemplate());
		$.blockUI(admin._block,{ width:'400px' });
		$('#bConfC').click($.unblockUI);
	}
	else
	{
		admin._block.html(admin._tmpl.confirmTemplate());
		$.blockUI(admin._block,{ width:'400px' });
		$('#bConfO').click(function(){
			admin._napwd=$('#NP').val();
			admin._block.html(admin._tmpl.loading());
			$.ajax({
				type: "POST",
				url: "ajax/admin-mgmt.php",
				data: "mode=delete&aid="+admin._ids[admin._editIndex],
				success: function(msg){
					$('#edit'+admin._ids[admin._editIndex]).parent().parent().remove();
					admin.resetAdmin();
					admin._editIndex=-1;
					$.unblockUI();
				}
			});
		});
		$('#bConfC').click($.unblockUI);
	}
}