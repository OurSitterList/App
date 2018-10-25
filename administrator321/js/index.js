// JavaScript Document
function Login()
{
	
}
Login.prototype.check=function()
{
	if(jQuery.trim($("#uid").val()).length==0)
	{
		alert("- Enter Username.");
		$("#uid").val("");
		$("#uid").focus();
		return false;
	}
	else if(jQuery.trim($("#pwd").val()).length==0)
	{
		alert("- Enter Password.");
		$("#pwd").val("");
		$("#pwd").focus();
		return false;
	}
	else
		return true;
}