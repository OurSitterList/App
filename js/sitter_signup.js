
$(function(){
	$("#sittersignupappForm").validate({
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
				user_zip: {
					required: 'Please enter ZIP Code',
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
});