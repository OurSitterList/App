// JavaScript Document
function MyFunctions()
{
	this._ext=new Array();
}
// Removes leading whitespaces
MyFunctions.prototype.LTriming=function(value)
{
	var re = /\s*((\S+\s*)*)/;
	return value.replace(re, "$1");
}
// Removes ending whitespaces
MyFunctions.prototype.RTriming=function(value)
{
	var re = /((\s*\S+)*)\s*/;
	return value.replace(re, "$1");
}

// Removes leading and ending whitespaces
MyFunctions.prototype.triming=function(value)
{
	return this.LTriming(this.RTriming(value));
}
MyFunctions.prototype.isvalidemail=function(value)
{
	var emailexpr=/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
	return emailexpr.test(value);
}
MyFunctions.prototype.isvalidfile=function(value)
{
	var ext=value.substring(value.lastIndexOf('.')+1).toLowerCase();
	var flag=false;
	for(var i in this._ext)
	{
		if(ext==this._ext[i].toLowerCase())
		{
			flag=true;
			break;
		}
	}
	return flag;
}
MyFunctions.prototype.isvalizipfile=function(value)
{
	var fileexpr=/^.*(\.(zip|ZIP))$/;
	return fileexpr.test(value);
}
MyFunctions.prototype.isvalidimgfile=function(value)
{
	var fileexpr=/^.*(\.(gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG))$/;
	return fileexpr.test(value);
}
MyFunctions.prototype.isvalidimgfileadd=function(value)
{
	var fileexpr=/^.*(\.(gif|jpg|jpeg|png|swf|GIF|JPG|JPEG|PNG|SWF))$/;
	return fileexpr.test(value);
}
MyFunctions.prototype.isvalidimgfile1=function(value)
{
	var fileexpr=/^.*(\.(gif|jpg|jpeg|GIF|JPG|JPEG|swf))$/;
	return fileexpr.test(value);
}
MyFunctions.prototype.isvalidvideofile=function(value)
{
	var fileexpr=/^.*(\.(avi|dat|mgp|mpeg|wmv|mp3|AVI|DAT|MPG|MPEG|WMV|MP3|flv))$/;
	return fileexpr.test(value);
}
MyFunctions.prototype.isvaliddoc2file=function(value)
{
	var fileexpr=/^.*(\.(PDF|DOC|DOCX|XLS|XLSX|XML|TXT|pdf|doc|docx|xls|xlsx|xml|txt))$/;
	return fileexpr.test(value);
}
MyFunctions.prototype.isvalidmusicfile=function(value)
{
	var fileexpr=/^.*(\.(mp3|MP3))$/;
	return fileexpr.test(value);
}

//USE: onKeyPress="JavaScript: return keyRestrict(event,'0123456789');"
MyFunctions.prototype.keyRestrict=function(e, validchars)
{
	var key='', keychar='';
	key = this.getKeyCode(e);
	if (key == null) return true;
	keychar = String.fromCharCode(key);
	keychar = keychar.toLowerCase();
	validchars = validchars.toLowerCase();
	if (validchars.indexOf(keychar) != -1)
	  return true;
	if ( key==null || key==0 || key==8 || key==9 || key==13 || key==27 )
	  return true;
	return false;
}
MyFunctions.prototype.getKeyCode=function(e)
{
	if (window.event)
		return window.event.keyCode;
	else if (e)
		return e.which;
	else
		return null;
}
MyFunctions.prototype.url_check=function(url)
{
	var urlRegxp = /^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([\w]+)(.[\w]+){1,2}$/;
	return urlRegxp.test(url);
}
MyFunctions.prototype.isProper=function(string)
{
	if (!string)
		return false;
	var iChars = "*|,\":<>[]{}`\';()@&$#% ";
	for (var i = 0; i < string.length; i++)
	{
		if (iChars.indexOf(string.charAt(i)) != -1)
			return false;
	}
	return true;
}
MyFunctions.prototype.AddToOptionList=function(OptionList, OptionValue, OptionText)
{
	// Add option to the bottom of the list
	OptionList[OptionList.length] = new Option(OptionText, OptionValue);
}
MyFunctions.prototype.ClearOptions=function(OptionList)
{
	// Always clear an option list from the last entry to the first
	for (x=OptionList.length; x >= 0; x--)
		OptionList[x] = null;
}
MyFunctions.prototype.selcheckbox=function(initial,num)
{
	var check="";
	var id;
	for(var i=0;i<num;i++)
	{
		id=initial+i;
		if($('#'+id).attr('checked'))
			check+=$('#'+id).val()+",";
	}
	return this.rtrim(check,",");
}
MyFunctions.prototype.numselcheckbox=function(initial,num)
{
	var count=0;
	var id;
	for(var i=0;i<num;i++)
	{
		id=initial+i;
		if($('#'+id).attr('checked'))
			count++;
	}
	return count;
}
MyFunctions.prototype.ltrim=function(str,char)
{
	if(str.length>0)
	{
		while(str.substring(0,1)==char)
			str=str.substring(1,str.length);
	}
	return str;
}
MyFunctions.prototype.rtrim=function(str,char)
{
	if(str.length>0)
	{
		while(str.substring(str.length-1,str.length)==char)
			str=str.substring(0,str.length-1);
	}
	return str;
}
MyFunctions.prototype.trim=function(str,char)
{
	return this.rtrim(this.ltrim(str,char),char);
}
MyFunctions.prototype.isValidImageFile=function(image)
{
	var ext=image.substring(image.length-4,image.length);
	var allowed=Array(".jpg",".gif",".png");
	for(var i=0;i<allowed.length;i++)
	{
		if(ext.toLowerCase()==allowed[i])
			break;
	}
	if(i==allowed.length)
		return false;
	else
		return true;
}
MyFunctions.prototype.num2round=function(num,dec)
{
	var n=num.toString();
	var pos=n.indexOf(".");
	if(pos==-1)
	{
		var decval="";
		for(var i=0;i<dec;i++)
			decval+="0";
		return num+"."+decval;
	}
	else
	{
		var decval=n.substring(pos+1);
		for(var i=decval.length;i<dec;i++)
			decval+="0";
		return n.substring(0,pos)+"."+decval.substring(0,dec);
	}
}
MyFunctions.prototype.checkAll=function(status,prechk,num)
{
	for(var i=0;i<num;i++)
		$('#'+prechk+i).attr('checked',status);
}
MyFunctions.prototype.chkAllStat=function(allchk,prechk,num,atleast)
{
	if(num>atleast)
	{
		if(this.numselcheckbox(prechk,num)==num)
			$('#'+allchk).attr('checked',true);
		else
			$('#'+allchk).attr('checked',false);
	}
}