<footer class="footer_outer">
	<section class="footer-top-bg"></section>
	<section class="footer-inner-bg">
		<div class="container">
    	<div class="footer_inner">
        	<ul class="clearfix">
           	<!--<li><a href="<?=$base_path?>/about_us.php"><span class="img-span"><img src="<?=$base_path?>/images/cycle.png" /></span> <span>About</span></a></li>-->
                <li><a href="<?=$base_path?>/House-Rules.php"><span class="img-span"><img src="<?=$base_path?>/images/home.png" /></span> <span>House Rules</span></a></li>
                <li><a href="<?=$base_path?>/contact-us.php"><span class="img-span"><img src="<?=$base_path?>/images/care.png" /></span> <span>Contact</span></a></li>
                <!--<li><a href="<?=$base_path?>/how-it-works.php"><span class="img-span"><img src="<?=$base_path?>/images/care.png" /></span> <span>How It Works</span></a></li>-->
<!-- Removed Search button -->
<?php if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']): ?>
                <li style="vertical-align: bottom;"><!-- (c) 2005, 2015. Authorize.Net is a registered trademark of CyberSource Corporation --> <div class="AuthorizeNetSeal"> <script type="text/javascript" language="javascript">var ANS_customer_id="2f13eca1-b545-45f7-bdb4-9e432ce91ea6";</script> <script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script> <a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Accept Online Payments</a> </div>	</li>
<?php endif; ?>                
            </ul>
        </div>
       <div><span class="copyright">&copy; <?=date('Y');?> Our Sitter List LLC</span></div>
    </div>
    </section>
</footer>

<script src="<?=$base_path?>/js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="<?=$base_path?>/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?=$base_path?>/js/jquery.validate.js"></script>

<script src="<?=$base_path?>/js/classie.js" type="text/javascript"></script>
<script src="<?=$base_path?>/js/modalEffects.js" type="text/javascript"></script>

<script src="<?=$base_path?>/js/custom.js" type="text/javascript"></script>
<link href="<?=$base_path;?>/css/jquery.smartmarquee.css" rel="stylesheet">
<script src="<?=$base_path;?>/js/jquery.smartmarquee.js"></script> 
<script type="text/javascript">
$(document).ready(function () {
	$(".hscroller").smartmarquee({
		duration: 1000,   
		loop : true,      
		interval : 2000, 
		axis : "horizontal", 
	});
});
</script>

<script>
$().ready(function() {
	
		$("#sitter_loginForm").validate({
			rules: {
				sitter_login_username: {
					required: true,
				},
				sitter_login_password: {
					required: true
				}
			},
			messages: {
				sitter_login_username: {
					required: 'Please enter username'
				},
			    sitter_login_password: {
					required: "Please provide a password"
				}
			}
		});
		$("#signupForm").validate({
			rules: {
				sitter_username: {
					required: true,
					remote: "<?=$base_path?>/check-username.php?mode=username"
				},
				sitter_password: {
					required: true,
					minlength: 5
				},
				sitter_cpassword: {
					required: true,
					minlength: 5,
					equalTo: "#sitter_password"
				},
				sitter_email: {
					required: true,
					email: true,
					remote: "<?=$base_path?>/check-username.php?mode=email"
				}
			},
			messages: {
				sitter_username: {
					required: 'Please enter username',
					remote: "Username is taken"
				},
			    sitter_password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				sitter_cpassword: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				sitter_email:  {
					required: "Please enter a valid email address",
					email: "Please enter a valid email address",
					remote: "This Email adress is already registered"
				},
			}
		});
		$("#sittersignupappForm").validate({
			rules: {
				user_first_name: {
					required: true,
				},
				user_last_name: {
					required: true,
				},
		
				user_cell_phone: {
					required: true,
				},
				cardNumber: {
					required: true,
				},
				expirationDate_month: {
					required: true,
				},
				expirationDate_year: {
					required: true,
				},
				cardCode: {
					required: true,
					minlength: 3,
				},
				is_agree:{
					required: true,
				}
			},
			messages: {
				user_first_name: {
					required: 'Please enter First Name',
				},
				user_last_name: {
					required: 'Please enter Last Name',
				},
				
			   user_cell_phone: {
					required: "Please provide Contact No",
				},
				cardNumber: {
					required: "Please provide Valid Card Number",
				},
				expirationDate_month: {
					required: "Choose Month",
				},
				expirationDate_year: {
					required: "Choose Year",
				},
				cardCode:  {
					required: "Enter CVV No",
					minlength: "Enter Valid CVV No",
				},
				is_agree:{
					required: "You have to agree to Our Sitter List LLC House Rules",
				}
			}
		});
		$("#sitter_forgetForm").validate({
			rules: {
				sitter_forget_username: {
					required: true,
				},
				
			},
			messages: {
				sitter_forget_username: {
					required: 'Please enter username'
				},
			   
			   
			}
		});
		
		
		
		$("#family_loginForm").validate({
			rules: {
				family_login_username: {
					required: true,
				},
				family_login_password: {
					required: true
				}
			},
			messages: {
				family_login_username: {
					required: 'Please enter username'
				},
			    family_login_password: {
					required: "Please provide a password"
				}
			}
		});
		$("#familysignupForm").validate({
			rules: {
				family_username: {
					required: true,
					remote: "<?=$base_path?>/check-username.php?mode=username_family"
				},
				family_password: {
					required: true,
					minlength: 5
				},
				family_cpassword: {
					required: true,
					minlength: 5,
					equalTo: "#family_password"
				},
				family_email: {
					required: true,
					email: true,
					remote: "<?=$base_path?>/check-username.php?mode=email_family"
				}
			},
			messages: {
				family_username: {
					required: 'Please enter username',
					remote: "Username is taken"
				},
			   family_password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				family_cpassword: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				family_email:  {
					required: "Please enter a valid email address",
					email: "Please enter a valid email address",
					remote: "This Email adress is already registered"
				}
			}
		});
		$("#familysignupappForm").validate({
			rules: {
				user_first_name: {
					required: true,
				},
				user_last_name: {
					required: true,
				},
				user_current_address: {
					required: true,
				},
				user_cell_phone: {
					required: true,
				},
				user_contact_email: {
					required: true,
					email: true
				},
				cardNumber: {
					required: true,
				},
				expirationDate_month: {
					required: true,
				},
				expirationDate_year: {
					required: true,
				},
				cardCode: {
					required: true,
					minlength: 3,
				}
			},
			messages: {
				user_first_name: {
					required: 'Please enter First Name',
				},
				user_last_name: {
					required: 'Please enter Last Name',
				},
				user_current_address: {
					required: 'Please enter Address',
				},
			   user_cell_phone: {
					required: "Please provide Contact No",
				},
				cardNumber: {
					required: "Please provide Valid Card Number",
				},
				expirationDate_month: {
					required: "Choose Month",
				},
				expirationDate_year: {
					required: "Choose Year",
				},
				cardCode:  {
					required: "Enter CVV No",
					minlength: "Enter Valid CVV No",
				},
				card_information:  {
					required: "Please select check box"
				}
			}
		});

		$("#familysignupappForm").on('submit', function(e){
			var invalidEmail = 'Please enter a valid email address.';
			var val = $('#user_contact_email').val();
			val = (val + '');
			if (!val || val.length < 4 || val.indexOf('@') === -1)
			{
				e.preventDefault();
				e.stopPropagation();
				e.stopImmediatePropagation();

				alert(invalidEmail);
				$('#user_contact_email').focus()
				return;
			}

			var tsplit = val.split(/@/);
			if (tsplit.length !== 2)
			{
				e.preventDefault();
				e.stopPropagation();
				e.stopImmediatePropagation();

				alert(invalidEmail);
				$('#user_contact_email').focus()
				return;
			}

			var tsplit2 = (tsplit[1].split(/\./));
			if (tsplit2.length !== 2)
			{
				e.preventDefault();
				e.stopPropagation();
				e.stopImmediatePropagation();

				alert(invalidEmail);
				$('#user_contact_email').focus()
				return;
			}

			// if we get here, then the email address has been validated.
			return true;
		});

		$("#familymemberappForm").validate({
			rules: {
				user_first_name: {
					required: true,
				},
				user_last_name: {
					required: true,
				},
			
				cardNumber: {
					required: true,
				},
				expirationDate_month: {
					required: true,
				},
				expirationDate_year: {
					required: true,
				},
				cardCode: {
					required: true,
					minlength: 3,
				}
			},
			messages: {
				user_first_name: {
					required: 'Please enter First Name',
				},
				user_last_name: {
					required: 'Please enter Last Name',
				},
			
				cardNumber: {
					required: "Please provide Valid Card Number",
				},
				expirationDate_month: {
					required: "Choose Month",
				},
				expirationDate_year: {
					required: "Choose Year",
				},
				cardCode:  {
					required: "Enter CVV No",
					minlength: "Enter Valid CVV No",
				},
			}
		});
		$("#family_forgetForm").validate({
			rules: {
				family_forget_username: {
					required: true,
				},
				
			},
			messages: {
				family_forget_username: {
					required: 'Please enter username'
				},
			   
			   
			}
		});
		
		
		$("#ResetpassForm").validate({
			rules: {
				
				sitter_new_password: {
					required: true,
					minlength: 5
				},
				sitter_new_cpassword: {
					required: true,
					minlength: 5,
					equalTo: "#sitter_new_password"
				},
				
			},
			messages: {
				
			    sitter_new_password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},
				sitter_new_cpassword: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long",
					equalTo: "Please enter the same password as above"
				},
				
			}
		});
		
		
		$("#searchForm").validate({
			rules: {
				search_from_date: {
					required: true,
				},
				search_to_date: {
					required: true
				}
			},
			messages: {
				search_from_date: {
					required: 'Please enter From Date'
				},
			    search_to_date: {
					required: "Please enter To Date"
				}
			}
		});
		$("#bookForm").validate({
			submitHandler: function(form) {
				$('.overlay-one').css('display','block');
        //alert($('form').serialize());
       
		 $.ajax({
                        url: "<?=$base_path?>/check-username.php?mode=date_time_check",
                        type: "post",
                        data: $('form').serialize(),
                        success: function(d) {
							$('.overlay-one').css('display','none');
                           if(d==1)
						   {
							    
								form.submit();
								return true;
						   }
						   else
						   {
							  $('#bookForm_error').html(d);
							    return false;
						   }
                        }
						
                    });
					
    }
		});
		
		$("#jobsearchForm").validate({
			rules: {
				job_search_from_date: {
					required: true,
				},
				job_search_to_date: {
					required: true
				}
			},
			messages: {
				job_search_from_date: {
					required: 'Please enter From Date'
				},
			    job_search_to_date: {
					required: "Please enter To Date"
				}
			}
		});
		$("#PostjobForm").validate({
			submitHandler: function(form) {
				$('.overlay-one').css('display','block');
        //alert($('form').serialize());
       
		 $.ajax({
                        url: "<?=$base_path?>/check-username.php?mode=job_date_time_check",
                        type: "post",
                        data: $('form').serialize(),
                        success: function(d) {
							$('.overlay-one').css('display','none');
                           if(d==1)
						   {
							    
								form.submit();
								return true;
						   }
						   else
						   {
							  $('#job_bookForm_error').html(d);
							    return false;
						   }
                        }
						
                    });
					
    }
		});
		
		
		$("#contact_form").validate({
			rules: {
				contact_name: {
					required: true,
				},
				contact_email: {
					required: true,
					email: true,
				}
			},
			messages: {
				contact_name: {
					required: 'Please enter Name'
				},
			    contact_email: {
					required: "Please enter a valid email address",
					email: "Please enter a valid email address",
				}
			}
		});
		
		
		


		//code to hide topic selection, disable for demo
	
	});
</script>

<script type="text/javascript" src="<?=$base_path?>/js/jquery-ui-1.11.1.js"></script>
<script src='<?=$base_path?>/js/jquery-ui.multidatespicker.js'></script>
 <script>
$(function() {
var today = new Date();
$('#calendar').multiDatesPicker({
<?php if(isset($val) && $val!=''): ?>
	addDisabledDates: [<?=$val?>],
<?php endif; ?>
	altField: '#altField',
	minDate: 0,
	onSelect: function(dateText, inst) { 
	var str = $('#altField').val();
	var str = str.replace(/\s/g, '');
	var selected_date = str.split(',');
	//alert($.inArray(dateText, selected_date));
	var make_id = dateText.replace(/\//g,'');
	if($.inArray(dateText, selected_date)<0)
	{
		
		$('#time_inner_area'+make_id).remove();
	}
	else
	{
	$('#time_area0').append('<div class="form-box1" id="time_inner_area'+make_id+'"><label>For '+dateText+'</label><select id="start_time'+make_id+'" name="start_time'+make_id+'" required><option value="" selected>Start Time</option><option value="0">12:00 am</option><option value="1">01:00 am</option><option value="2">02:00 am</option><option value="3">03:00 am</option><option value="4">04:00 am</option><option value="5">05:00 am</option><option value="6">06:00 am</option><option value="7">07:00 am</option><option value="8">08:00 am</option><option value="9">09:00 am</option><option value="10">10:00 am</option><option value="11">11:00 am</option><option value="12">12:00 pm</option><option value="13">01:00 pm</option><option value="14">02:00 pm</option><option value="15">03:00 pm</option><option value="16">04:00 pm</option><option value="17">05:00 pm</option><option value="18">06:00 pm</option><option value="19">07:00 pm</option><option value="20">08:00 pm</option><option value="21">09:00 pm</option><option value="22">10:00 pm</option><option value="23">11:00 pm</option><option value="24">12:00 am</option></select> - <select id="end_time'+make_id+'" name="end_time'+make_id+'" required><option value="" selected>Start Time</option><option value="0">12:00 am</option><option value="1">01:00 am</option><option value="2">02:00 am</option><option value="3">03:00 am</option><option value="4">04:00 am</option><option value="5">05:00 am</option><option value="6">06:00 am</option><option value="7">07:00 am</option><option value="8">08:00 am</option><option value="9">09:00 am</option><option value="10">10:00 am</option><option value="11">11:00 am</option><option value="12">12:00 pm</option><option value="13">01:00 pm</option><option value="14">02:00 pm</option><option value="15">03:00 pm</option><option value="16">04:00 pm</option><option value="17">05:00 pm</option><option value="18">06:00 pm</option><option value="19">07:00 pm</option><option value="20">08:00 pm</option><option value="21">09:00 pm</option><option value="22">10:00 pm</option><option value="23">11:00 pm</option><option value="24">12:00 am</option></select></div>');
	}
        //alert(dateText);
    }
});

$('#job_calendar').multiDatesPicker({
	altField: '#jobaltField',
	minDate: 0,
	onSelect: function(dateText, inst) { 
	var str = $('#jobaltField').val();
	var str = str.replace(/\s/g, '');
	var selected_date = str.split(',');
	//alert($.inArray(dateText, selected_date));
	var make_id = dateText.replace(/\//g,'');
	if($.inArray(dateText, selected_date)<0)
	{
		
		$('#job_time_inner_area'+make_id).remove();
	}
	else
	{
	$('#job_time_area0').append('<div class="form-box1" id="job_time_inner_area'+make_id+'"><label>For '+dateText+'</label><select id="job_start_time'+make_id+'" name="job_start_time'+make_id+'" required><option value="" selected>Start Time</option><option value="0">12:00 am</option><option value="1">01:00 am</option><option value="2">02:00 am</option><option value="3">03:00 am</option><option value="4">04:00 am</option><option value="5">05:00 am</option><option value="6">06:00 am</option><option value="7">07:00 am</option><option value="8">08:00 am</option><option value="9">09:00 am</option><option value="10">10:00 am</option><option value="11">11:00 am</option><option value="12">12:00 pm</option><option value="13">01:00 pm</option><option value="14">02:00 pm</option><option value="15">03:00 pm</option><option value="16">04:00 pm</option><option value="17">05:00 pm</option><option value="18">06:00 pm</option><option value="19">07:00 pm</option><option value="20">08:00 pm</option><option value="21">09:00 pm</option><option value="22">10:00 pm</option><option value="23">11:00 pm</option><option value="24">12:00 am</option></select> - <select id="job_end_time'+make_id+'" name="job_end_time'+make_id+'" required><option value="" selected>Start Time</option><option value="0">12:00 am</option><option value="1">01:00 am</option><option value="2">02:00 am</option><option value="3">03:00 am</option><option value="4">04:00 am</option><option value="5">05:00 am</option><option value="6">06:00 am</option><option value="7">07:00 am</option><option value="8">08:00 am</option><option value="9">09:00 am</option><option value="10">10:00 am</option><option value="11">11:00 am</option><option value="12">12:00 pm</option><option value="13">01:00 pm</option><option value="14">02:00 pm</option><option value="15">03:00 pm</option><option value="16">04:00 pm</option><option value="17">05:00 pm</option><option value="18">06:00 pm</option><option value="19">07:00 pm</option><option value="20">08:00 pm</option><option value="21">09:00 pm</option><option value="22">10:00 pm</option><option value="23">11:00 pm</option><option value="24">12:00 am</option></select></div>');
	}
        //alert(dateText);
    }
});

/*$('#booking_calender').multiDatesPicker({
<?php if($val!='')
{?>
	addDates: [<?=$val?>],
<?php
}
?>
minDate: 0,
onSelect:function(a,b){}
});*/

});
function open_part(type,to,from)
{
	

	$('#'+type+'_form_'+from+'_part').css('display','none');
	$('#'+type+'_form_'+to+'_part').css('display','block');
}
</script>
<style>

	#calendar , #job_calendar, #edit_job_calendar{
		max-width: 900px;
		margin: 0 auto;
	}

</style>
<script src='<?=$base_path?>/js/moment.min.js'></script>

<script src='<?=$base_path?>/js/fullcalendar.min.js'></script>
<script>

	$(document).ready(function() {
		
		$('#booking_calender').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: '<?=date('Y-m-d')?>',
			editable: false, // allow "more" link when too many events
			<?php if(isset($calender_event) && $calender_event !== '') :?>
			events: [<?=$calender_event?>],
			<?php endif; ?>
			eventClick: function(calEvent, jsEvent, view) {
$('#book_info_date').html(calEvent.date);
       // alert('Event: ' + calEvent.title);
        //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
        //alert('View: ' + view.name);
			$.ajax({
			type:'post',
			url:'<?=$base_path?>/ajax.php',
			data:'mode=get_bookibg_info&cal_date='+calEvent.date+'&cal_id='+calEvent.id,
			success:function(msg){
			//alert(msg);
			$('#md-content-sidebar').html(msg);
			$('#book_message_part_ul').html('');
		//alert(calEvent.id);
		call_info(calEvent.id,calEvent.status);
			}
			});
		
		
		
		
		/** retrieve message **/

		
		
		
		$("#modal-book_details").addClass("md-show");
		

    }
		});
		$('#family_booking_calender').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: '<?=date('Y-m-d')?>',
			editable: false, // allow "more" link when too many events
			<?php if(isset($calender_event) && $calender_event !== '') :?>
			events: [<?=$calender_event?>],
			<?php endif; ?>
			eventClick: function(calEvent, jsEvent, view) {
$('#book_info_date').html(calEvent.date);
       // alert('Event: ' + calEvent.title);
        //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
        //alert('View: ' + view.name);
			$.ajax({
			type:'post',
			url:'<?=$base_path?>/ajax.php',
			data:'mode=get_bookibg_info_family&cal_date='+calEvent.date+'&cal_id='+calEvent.id,
			success:function(msg){
			//alert(msg);
			$('#md-content-sidebar').html(msg);
			$('#book_message_part_ul').html('');
		//alert(calEvent.id);
		call_info_family(calEvent.id,calEvent.status,calEvent);
			}
			});
		
		
		
		
		/** retrieve message **/

		
		
		
		$("#modal-book_details").addClass("md-show");
		

    }
		});

		$('.book_details_close').on('click', function () {
       		$("#modal-book_details").removeClass("md-show");
	   		$(".md-overlay").removeClass("md-show");
    	});

		$('.info-box_close').on('click', function () {
       		$("#modal-info-box").removeClass("md-show");
	   		$(".md-overlay").removeClass("md-show");
    	});
		
	$('.password_retrieve_close').on('click', function () {
       $("#modal-password-retrieve").removeClass("md-show");
	   $(".md-overlay").removeClass("md-show");
    });
			
		
		
	$('.md-overlay').on('click', function () {
	$("#modal-book_details").removeClass("md-show");
	$("#modal-password-retrieve").removeClass("md-show");
	});
	});
function confirm_appointment(stat,id)
{
	//alert(stat);
	$.ajax({
type:'post',
url:'<?=$base_path?>/ajax.php',
data:'mode=appointment_approval&stat='+stat+'&id='+id,
success:function(msg){
	//alert(msg);
$('#book_confirmation_area').html('Status : '+msg);
window.location.reload();

}
});
}

function get_message(id,enquired_by)
{
	//alert(stat);
	$.ajax({
type:'post',
url:'<?=$base_path?>/ajax.php',
data:'mode=get_message&id='+id+'&enquired_by='+enquired_by,
success:function(msg){
//	alert(msg);
$('#book_message_part_ul').html(msg);

$('#book_message_part_ul li:last-child').focus();
$('#notify_me'+id).remove();
}
});
}

function call_info(id,stat)
{
	//alert(id);
	$('.all_date_time').removeClass('active');
	$('#spe_date_time_'+id).addClass('active');
	$.ajax({
type:'post',
url:'<?=$base_path?>/ajax.php',
data:'mode=call_info&id='+id,
success:function(msg){
	//alert(msg);
$('#book_details_area').html(msg);
$('#book_message_form').html("<div id='book_message_form_textarea'><textarea name='book_message_text_"+id+"' id='book_message_text_"+id+"'></textarea><div id='book_message_text_error'></div></div><div id='book_message_form_submit'><input type='button' value='Send' onClick='send_message("+id+",\"S\")'></div></form>");	
		//alert(calEvent.status);
		if(stat=='Expired')
		{
			
			$('#book_message_form').html("This Appointment date has been expired");
			$('#book_confirmation_area').html('Status : Expired');
		}
		else if(stat=='Declined')
		{

			$('#book_message_form').html("This Appointment date has been Declined");
			$('#book_confirmation_area').html('Status : Declined');
		}
		else if(stat=='Cancelled')
		{

			$('#book_message_form').html("This Appointment date has been Cancelled");
			$('#book_confirmation_area').html('Status : Cancelled');
		}
		else if(stat=='Not Confirmed')
		{
			
			$('#book_confirmation_area').html('Do you Want to confirm this Appointment <input type="button" onClick="confirm_appointment(1,'+id+')" value="Yes"> &nbsp; <input type="button" onClick="confirm_appointment(0,'+id+')" value="No">');
			
		}
		else
		{
		$('#book_confirmation_area').html('Status : Confirmed');
		
		}
				get_message(id,'S');

}
});
}

function call_info_family(id,stat,calEvent)
{
	//alert(id);
	//alert(id + ' ' + stat);
	$('.all_date_time').removeClass('active');
	$('#spe_date_time_'+id).addClass('active');
	$.ajax({
type:'post',
url:'<?=$base_path?>/ajax.php',
data:'mode=call_info_family&id='+id,
success:function(msg){
	//alert(msg);
$('#book_details_area').html(msg);
$('#book_message_form').html("<div id='book_message_form_textarea'><textarea name='book_message_text_"+id+"' id='book_message_text_"+id+"'></textarea><div id='book_message_text_error'></div></div><div id='book_message_form_submit'><input type='button' value='Send' onClick='send_message("+id+",\"F\")'></div></form>");	
		//alert(calEvent.status);
		if(calEvent.review=='true')
		{
			$('#book_rating_area').html('<div class="ratings" id="'+calEvent.bookingId+'">'+
				'<p class="title">Rate: '+calEvent.name+' </p>'+
				'<div class="rate_widget" sitter_user_id="'+calEvent.sitter_user_id+'" booking_id="'+calEvent.booking_id+'" family_user_id="'+calEvent.family_user_id+'" >'+
				'	<div class="star_1 ratings_stars"></div>'+
				'	<div class="star_2 ratings_stars"></div>'+
				'	<div class="star_3 ratings_stars"></div>'+
				'	<div class="star_4 ratings_stars"></div>'+
				'	<div class="star_5 ratings_stars"></div>'+
				'</div>'+
				'<p class="title">Leave a comment<textarea id="review_message"></textarea></p>'+
			'</div>');
		}

		if(stat=='Expired')
		{
			
			$('#book_message_form').html("This Appointment date has been expired");
			$('#book_confirmation_area').html('Status : Expired');
		}
		else if(stat=='Cancelled')
		{
			
			$('#book_message_form').html("This Appointment date has been Cancelled");
			$('#book_confirmation_area').html('Status : Cancelled');
		}
		else if(stat=='Declined')
		{
			
			$('#book_message_form').html("This Appointment date has been Declined");
			$('#book_confirmation_area').html('Status : Declined');
		}
		else if(stat=='Not Confirmed')
		{
			
			$('#book_confirmation_area').html('Status : Not Confirmed');
			
		}
		else
		{
		$('#book_confirmation_area').html('Status : Confirmed');
		
		}
				get_message(id,'F');

}
});
}

function send_message(id,send)
{
	if($.trim($('#book_message_text_'+id).val()).length==0)
	{
		$('#book_message_text_error').html('Please write message then click send');
		return false;
	}
	else
	{
		$('#book_message_text_error').html('');
$.ajax({
type:'post',
url:'<?=$base_path?>/ajax.php',
data:'mode=send_message&id='+id+'&msg='+$('#book_message_text_'+id).val()+'&send_by='+send,
success:function(msg){
//	alert(msg);
msg = msg.split("|");
				if(send == 'S')
				{
					var print_username_class = 'sitter_msg';
				
				}
				else
				{
					var print_username_class = 'family_msg';
				}
			if(msg[0]==0)
			{	
			$('#book_message_part_ul').html('<li class="'+print_username_class+'"><span>'+msg[1]+' : </span>'+$('#book_message_text_'+id).val()+'</li>');
			}
			else
			{
			$('#book_message_part_ul').append('<li class="'+print_username_class+'"><span>'+msg[1]+' : </span>'+$('#book_message_text_'+id).val()+'</li>');
			}
			$('#book_message_text_'+id).val('');
}

});
	}
}
function  set_the_code(input_val)
{
$('#job_code_area').html(input_val);
$('#job_code_input').val(input_val);	
}
function call_edit(job_id,kids_no,location_code,remarks,totaldate,totaldate_start,totaldate_end)
{
	$('#edit_job_time_area0').html('');
//var newtotaldate = totaldate.replace(/\*/g, "'");
var totaldate_arr  = new Array();
 totaldate_arr = totaldate.split(',');
 
 var totaldate_arr_start  = new Array();
 totaldate_arr_start = totaldate_start.split(',');
 
 var totaldate_arr_end  = new Array();
 totaldate_arr_end = totaldate_end.split(',');
//console.log(totaldate_arr);
$('#edit_job_id').val(job_id);
$('#edit_job_no_of_kids').val(kids_no);
 $("#edit_job_location_code option[value='"+location_code+"']").prop('selected', true);
 $('#edit_job_remarks').val(remarks);

 $('#edit_job_calendar').multiDatesPicker('resetDates');
 $('#edit_job_calendar').multiDatesPicker({
	altField: '#edit_jobaltField',
	minDate: 0,
	addDates: totaldate_arr,
	onSelect: function(dateText, inst) { 
	var str = $('#edit_jobaltField').val();
	var str = str.replace(/\s/g, '');
	var selected_date = str.split(',');
	//alert($.inArray(dateText, selected_date));
	var make_id = dateText.replace(/\//g,'');
	if($.inArray(dateText, selected_date)<0)
	{
		
		$('#edit_job_time_inner_area'+make_id).remove();
	}
	else
	{
	$('#edit_job_time_area0').append('<div class="form-box1" id="edit_job_time_inner_area'+make_id+'"><label>For '+dateText+'</label><select id="edit_job_start_time'+make_id+'" name="edit_job_start_time'+make_id+'" required><option value="" selected>Start Time</option><option value="0">12:00 am</option><option value="1">01:00 am</option><option value="2">02:00 am</option><option value="3">03:00 am</option><option value="4">04:00 am</option><option value="5">05:00 am</option><option value="6">06:00 am</option><option value="7">07:00 am</option><option value="8">08:00 am</option><option value="9">09:00 am</option><option value="10">10:00 am</option><option value="11">11:00 am</option><option value="12">12:00 pm</option><option value="13">01:00 pm</option><option value="14">02:00 pm</option><option value="15">03:00 pm</option><option value="16">04:00 pm</option><option value="17">05:00 pm</option><option value="18">06:00 pm</option><option value="19">07:00 pm</option><option value="20">08:00 pm</option><option value="21">09:00 pm</option><option value="22">10:00 pm</option><option value="23">11:00 pm</option><option value="24">12:00 am</option></select> - <select id="edit_job_end_time'+make_id+'" name="edit_job_end_time'+make_id+'" required><option value="" selected>Start Time</option><option value="0">12:00 am</option><option value="1">01:00 am</option><option value="2">02:00 am</option><option value="3">03:00 am</option><option value="4">04:00 am</option><option value="5">05:00 am</option><option value="6">06:00 am</option><option value="7">07:00 am</option><option value="8">08:00 am</option><option value="9">09:00 am</option><option value="10">10:00 am</option><option value="11">11:00 am</option><option value="12">12:00 pm</option><option value="13">01:00 pm</option><option value="14">02:00 pm</option><option value="15">03:00 pm</option><option value="16">04:00 pm</option><option value="17">05:00 pm</option><option value="18">06:00 pm</option><option value="19">07:00 pm</option><option value="20">08:00 pm</option><option value="21">09:00 pm</option><option value="22">10:00 pm</option><option value="23">11:00 pm</option><option value="24">12:00 am</option></select></div>');
	
	
	}
        //alert(dateText);
    }


});

jQuery.each( totaldate_arr, function( i, val ) {
	var make_id = val.replace(/\//g,'');
  $('#edit_job_time_area0').append('<div class="form-box1" id="edit_job_time_inner_area'+make_id+'"><label>For '+val+'</label><select id="edit_job_start_time'+make_id+'" name="edit_job_start_time'+make_id+'" required><option value="" selected>Start Time</option><option value="0">12:00 am</option><option value="1">01:00 am</option><option value="2">02:00 am</option><option value="3">03:00 am</option><option value="4">04:00 am</option><option value="5">05:00 am</option><option value="6">06:00 am</option><option value="7">07:00 am</option><option value="8">08:00 am</option><option value="9">09:00 am</option><option value="10">10:00 am</option><option value="11">11:00 am</option><option value="12">12:00 pm</option><option value="13">01:00 pm</option><option value="14">02:00 pm</option><option value="15">03:00 pm</option><option value="16">04:00 pm</option><option value="17">05:00 pm</option><option value="18">06:00 pm</option><option value="19">07:00 pm</option><option value="20">08:00 pm</option><option value="21">09:00 pm</option><option value="22">10:00 pm</option><option value="23">11:00 pm</option><option value="24">12:00 am</option></select> - <select id="edit_job_end_time'+make_id+'" name="edit_job_end_time'+make_id+'" required><option value="" selected>Start Time</option><option value="0">12:00 am</option><option value="1">01:00 am</option><option value="2">02:00 am</option><option value="3">03:00 am</option><option value="4">04:00 am</option><option value="5">05:00 am</option><option value="6">06:00 am</option><option value="7">07:00 am</option><option value="8">08:00 am</option><option value="9">09:00 am</option><option value="10">10:00 am</option><option value="11">11:00 am</option><option value="12">12:00 pm</option><option value="13">01:00 pm</option><option value="14">02:00 pm</option><option value="15">03:00 pm</option><option value="16">04:00 pm</option><option value="17">05:00 pm</option><option value="18">06:00 pm</option><option value="19">07:00 pm</option><option value="20">08:00 pm</option><option value="21">09:00 pm</option><option value="22">10:00 pm</option><option value="23">11:00 pm</option><option value="24">12:00 am</option></select></div>');
  
 $("#edit_job_start_time"+make_id+" option[value='"+totaldate_arr_start[i]+"']").prop('selected', true);
  $("#edit_job_end_time"+make_id+" option[value='"+totaldate_arr_end[i]+"']").prop('selected', true);
  
});
	
}

function call_forget_area(type)
{
	$('#'+type+'_forget_form').css('display','block');
	$('#'+type+'_login_form').css('display','none');
}
function call_login_area(type)
{
	$('#'+type+'_forget_form').css('display','none');
	$('#'+type+'_login_form').css('display','block');
}

$(document).ready(function(e) {
	$('#modal-book_details').on('mouseover', '.ratings_stars', function() {
			$(this).prevAll().andSelf().addClass('ratings_over');
			$(this).nextAll().removeClass('ratings_vote'); 
	});
	$('#modal-book_details').on('mouseout', '.ratings_stars',  function() {
			$(this).prevAll().andSelf().removeClass('ratings_over');
			set_votes($(this).parent());
		}
	);
	
	$('#modal-book_details').on('click', '.ratings_stars ', function() {
		var star = this;
		var widget = $(this).parent();
		 
		var clicked_data = {
			clicked_on					: $(star).attr('class'),
			booking_id					: widget.attr('booking_id'),
			sitter_user_id				: widget.attr('sitter_user_id'),
			family_user_id				: widget.attr('family_user_id'),
			review_message				: $('#review_message').val(),
			mode						: 'add_rating'
		};
		$.post(
			'ajax.php',
			clicked_data,
			function(data) {
				widget.html(data);
			},
			'html'
		); 
	});	
	
	if($('.autohide').is(':visible')) {
    	setTimeout(function() {
			$("#modal-book_details, #modal-info-box").removeClass("md-show")
		}, 3000);
	}
});
</script>

</body>
</html>
