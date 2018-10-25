// JavaScript Document
$(document).ready(function(){
	var cpage=window.location.href;
	cpage=cpage.substring(cpage.lastIndexOf('/')+1);
	if(cpage.lastIndexOf('?')>-1)
		cpage=cpage.substring(0,cpage.lastIndexOf('?'));
	cpage=cpage.toLowerCase();
	$('.leftlink').each(function(){
		if($(this).attr('title').toLowerCase()==cpage)
			$(this).parent().find('td').addClass('leftNav');
	});
	$('.leftlink').mouseover(function(){
		if($(this).attr('title').toLowerCase()!=cpage)
			$(this).parent().find('td').addClass('leftNav');
	});
	$('.leftlink').mouseout(function(){
		if($(this).attr('title').toLowerCase()!=cpage)
			$(this).parent().find('td').removeClass('leftNav');
	});
	$('.leftlink').click(function(){
		window.location.href=$(this).attr('title');
	});
});