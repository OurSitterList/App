var promoto;

$(function(){
    $('#promoCode').on('keyup', onPromoKeyup);


    $("#familysignupappForm").validate({
			rules: {
				user_first_name: {
					required: true,
				},
				user_last_name: {
					required: true,
				},
                user_zip: {
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
				user_zip: {
					required: 'Please enter ZIP Code',
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
		}
    );
});

function onPromoKeyup(e)
{
    if (promoto)
    {
        try
        {
            clearTimeout(promoto);
        }
        catch (err){}
    }
    
    // reset
    promoto = setTimeout(onPromoTimeout, 800);
}

function onPromoTimeout()
{
    $('#promoloader').show();
    $.ajax({
        url: '/ajax-promo.php',
        data: {
            code: $('#promoCode').val()
        },
        dataType: 'json',
        method: 'post',
        success: function(data)
        {
            var err;
            if (!data || typeof data.error == 'undefined')
            {
                err = 'Unexpected error has occurred.';
            }
            else if (data.error === true)
            {
                err = data.msg || 'Unexpected error has occurred.';
            }

            $('#promoloader').hide();
            
            if (err)
            {
                $('#promomessage').removeAttr('class');
                $('#promomessage').addClass('alert alert-danger');
                $('#promomessage').html(err).show();
            }
            else 
            {
                $('#promomessage').removeAttr('class');
                $('#promomessage').addClass('alert alert-success');
                $('#promomessage').html('Promo code accepted. No payment required.').show();
                onPromoCodeAccepted();
            }
        },
        error: function()
        {
            $('#promoloader').hide();
            $('#promomessage').html('An unexpected error has occurred. Please try again.').show();
            //loginError(type, 'An unexpected error has occurred. Please try again.');
        }
    });
}

function onPromoCodeAccepted()
{
    hasValidPromo = true;
    $('#packageOptions, #paymentDetails, #saveCCGroup').hide();
    $('#submit_val').val('Register Now');
    $('#promoCode').attr('disabled', 'disabled');
}