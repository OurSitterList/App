<?php error_reporting(E_ALL);
ini_set("display_errors", 1);
include('includes/connection.php');?>
<?php
$user_details			= array (
	"user_name"				=> 'family_username',
	"user_password"			=> 'family_password',
	"user_email"			=> 'family_email',
	"join_date"				=> time(),
	"user_type"				=> 'family',
	
	"user_first_name"		=> 'user_first_name',
	"user_last_name"		=> 'user_last_name',
	"location_code"			=> 'user_zip',
	"user_current_address"	=> 'user_current_address',
	"user_cell_phone"		=> 'user_cell_phone',
	"user_biography"		=> 'user_first_name',
	"user_contact_email"	=> 'user_contact_email',
	"user_hear_about"		=> 'user_hear_about'
);

$notification		= new Notification();
$result 			= $notification->test($user_details);
?>