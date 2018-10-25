// JavaScript Document

function Settings(type)

{

	this._admType=type;

	this._name=new Array();

	this._value=new Array();

	this._edit=0;

	this._div=$('#divSett');

}

Settings.prototype.setInfo=function(id,name,value)

{

	this._name[id]=name;

	this._value[id]=value;

}

Settings.prototype.setDiv=function()

{
if(this._edit=='15' || this._edit=='16' || this._edit=='17' || this._edit=='18'|| this._edit=='24'|| this._edit=='27')
{
	this._div.html('<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">  <tr>    <td colspan="2" align="left" valign="middle" class="heading1">Change '+this._name[this._edit]+' Settings:</td>  </tr>  <tr>    <td align="right" valign="middle" class="linkBg">&nbsp;</td>    <td align="left" valign="middle" class="err" id="error">&nbsp;</td>  </tr>  <tr>    <td align="right" valign="middle" class="linkBg">Settings Name:</td>    <td align="left" valign="middle" class="bg11">'+this._name[this._edit]+'</td>  </tr>  <tr>    <td width="150" align="right" valign="middle" class="linkBg">New Value:</td>    <td align="left" valign="middle" class="bg11"><textarea name="tName" type="text" class="textarea" id="tName" cols="25" rows="5">'+this._value[this._edit]+'</textarea></td>  </tr>    <tr>    <td align="right" valign="middle" class="linkBg">&nbsp;</td>    <td align="left" valign="middle" class="bg11"><input name="bSet" type="button" class="linkBg" id="bSet" value="Set" style="cursor:pointer;">    <input name="bCancNew" type="button" class="linkBg" id="bCancNew" value="Cancel" style="cursor:pointer;"></td>  </tr></table>');
}
else
{
	this._div.html('<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">  <tr>    <td colspan="2" align="left" valign="middle" class="heading1">Change '+this._name[this._edit]+' Settings:</td>  </tr>  <tr>    <td align="right" valign="middle" class="linkBg">&nbsp;</td>    <td align="left" valign="middle" class="err" id="error">&nbsp;</td>  </tr>  <tr>    <td align="right" valign="middle" class="linkBg">Settings Name:</td>    <td align="left" valign="middle" class="bg11">'+this._name[this._edit]+'</td>  </tr>  <tr>    <td width="150" align="right" valign="middle" class="linkBg">New Value:</td>    <td align="left" valign="middle" class="bg11"><input name="tName" type="text" class="textarea" id="tName" maxlength="100" value="'+this._value[this._edit]+'"></td>  </tr>    <tr>    <td align="right" valign="middle" class="linkBg">&nbsp;</td>    <td align="left" valign="middle" class="bg11"><input name="bSet" type="button" class="linkBg" id="bSet" value="Set" style="cursor:pointer;">    <input name="bCancNew" type="button" class="linkBg" id="bCancNew" value="Cancel" style="cursor:pointer;"></td>  </tr></table>');
}

}





Settings.prototype.setDivoption=function()

{

	this._div.html('<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">  <tr>    <td colspan="2" align="left" valign="middle" class="heading1">Change '+this._name[this._edit]+' Settings:</td>  </tr>  <tr>    <td align="right" valign="middle" class="linkBg">&nbsp;</td>    <td align="left" valign="middle" class="err" id="error">&nbsp;</td>  </tr>  <tr>    <td align="right" valign="middle" class="linkBg">Settings Name:</td>    <td align="left" valign="middle" class="bg11">'+this._name[this._edit]+'</td>  </tr>  <tr>    <td width="150" align="right" valign="middle" class="linkBg">New Value:</td>    <td align="left" valign="middle" class="bg11"><select name="tName" id="tName"><option value="gallery">Gallery</option> <option value="list">List </option> </td>  </tr>    <tr>    <td align="right" valign="middle" class="linkBg">&nbsp;</td>    <td align="left" valign="middle" class="bg11"><input name="bSet" type="button" class="linkBg" id="bSet" value="Set" style="cursor:pointer;">    <input name="bCancNew" type="button" class="linkBg" id="bCancNew" value="Cancel" style="cursor:pointer;"></td>  </tr></table>');

}