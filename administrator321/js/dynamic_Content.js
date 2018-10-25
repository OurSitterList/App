// JavaScript Document
function NewsManagement(type,form)
{
	this._type=type;
	this._template=new Template();
	
	this._form=$('#'+form);
	
	this._mode=$('<input name="hmode" type="hidden">').prependTo(this._form);
	this._id=$('<input name="hid" type="hidden">').prependTo(this._form);
}
NewsManagement.prototype.listAllButton=function(url)
{
	$(this._template.addNewTmpl('List All'))
		.appendTo($('#tabM tr:first td:last'))
		.attr('href',url);
}
NewsManagement.prototype.addNewButton=function()
{
	$(this._template.addNewTmpl('Add New'))
		.appendTo($('#tabM tr:first td:last'))
		.click(addNewAction);
}

function Template()
{
	
}
Template.prototype.addNewTmpl=function(text)
{
	return '<a href="#" class="link11">'+text+'</a>';
}
Template.prototype.msg4AddTmpl=function(msg)
{
	return '<tr id="msgBox">    <td align="right" valign="middle" class="errMsg">&nbsp;</td>    <td align="left" valign="middle" class="errMsg">'+msg+'</td>  </tr>';
}

//Actions
function addNewAction()
{
	ob._mode.val('addnews');
	ob._form.submit();
	return false;
}
function viewAction(id)
{
	ob._mode.val('view');
	ob._id.val(id);
	ob._form.submit();
}
function editAction(id)
{
	ob._mode.val('edit');
	ob._id.val(id);
	ob._form.submit();
}
function deleteAction(id)
{
	if(confirm('- Are you Confirm to Delete this News?'))
	{
		ob._mode.val('delete');
		ob._id.val(id);
		ob._form.submit();
	}
	return false;
}