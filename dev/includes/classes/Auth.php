<?php
class Auth {
	protected static
			  $_user_id,
			  $_user_name,
			  $_user_password,
			  $_user_type,
			  $_user_email,
			  $_user_status,
			  $_user_first_name,
			  $_user_middle_name,
			  $_user_last_name,
			  $_user_current_address,
			  $_user_registration_details,
			  $_is_payment_test = FALSE,
			  $_payment_details
			;
	
	
	public function __construct() 
	{
		
	}

	public static function _set_user_id() {
		$user_id 		= $_SESSION['user_id'];
		$user_id		= (int) $user_id;
		if($user_id) {
			self::$_user_id = $user_id;
		}
		else {
			return false;
		}
	}
	
	public static function _get_user_id() {
		return self::$_user_id;
	}

	public static function _is_valid_user_type($user_type) {
		$valid_user_type	= array('sitter', 'family');
		
		if(in_array($user_type, $valid_user_type)) {
			return true;
		}
		else {
			return false;
		}
	}	
	
	public function register($user_details, $payment_details) 
	{	
		$user_type	= $user_details['user_type'];
		$result		= new stdClass();
		
		if(	!(self::_is_valid_user_type($user_type)) || 
			!(is_array($user_details)) || 
			!(is_array($payment_details))
		)  return false;
				
		self::$_is_payment_test		= ($payment_details['is_payment_test'] == 1) ? 1 : 0;
		self::$_payment_details		= $payment_details;
		$response	= self::_process_payment($payment_details, TRUE);
		
		if($response[0]==2 || $response[0]==3) 
		//if($response[0]==1000) 
		{
			$result->success	= false;
			$result->reason		= $response[3];
			return $result;
		}
		else
		{		
			$user_details['user_subscriberid'] 		= $response[6];
			$ptidmd5 			= $response[7];
			$result->success	= true;
	

			self::$_user_registration_details 	= $user_details;
			self::$_user_name					= $user_details['user_name'];

			switch($user_type) {
				case 'family':
					self::_family_register();
					$result->reason		= "Our Sitter List Founders are working hard at processing your application and we will respond your application within 36 hours.";
				break;
				
				case 'sitter':
					self::_sitter_register();
					$result->reason		= "Our Sitter List Founders are working hard at processing your application and we will respond your application within 36 hours.";
				break;
				
				default:
					$result->success	= false;
					$result->reason		= 'Invalid user type';
					return false;
			}
						
			return $result;

		}
	}		
	
	public function is_login() 
	{
		if($this->_user_id) return true;
	}

	public function login() {
		$user_name		= mysql_real_escape_string($_POST['user_name']);
		$user_password	= mysql_real_escape_string($_POST['user_password']);
		
		$sql	= "
					SELECT
						um.user_id,
						um.user_name,
						um.user_password,
						um.user_type,
						um.user_email,
						um.user_status,
						ui.user_first_name,
						ui.user_middle_name,
						ui.user_last_name,
						ui.user_current_address
					FROM
						user_management AS um
					INNER JOIN user_information AS ui ON ui.user_id = um.user_id
					WHERE
						(
							um.user_name = '$user_name'
							OR um.user_email = '$user_name'
						)
					AND um.user_password = MD5('$user_password')
					";

		mysql_query($sql);
		$results	= mysql_query($sql);
		$num_rows 	= mysql_num_rows($results);
		
		if( $num_rows > 0) {
			$row	= mysql_fetch_object($results);
			$this->_user_id					= $row->user_id;
			$this->_user_name				= $row->user_name;
			$this->_user_password			= $row->user_password;
			$this->_user_type				= $row->user_type;
			$this->_user_email				= $row->user_email;
			$this->_user_status				= $row->user_status;
			$this->_user_first_name			= $row->user_first_name;
			$this->_user_middle_name		= $row->user_middle_name;
			$this->_user_last_name			= $row->user_last_name;
			$this->_user_current_address	= $row->user_current_address;
			
			session_start();
		}
		else 
		{
			return false;
		}
		
		
		$this->user_id = $_SESSION['user_id'];
	}

	public function logout() 
	{
		unset($_SESSION);
		session_unset();
		session_destroy();
		session_write_close();
				
		header("location: ".HTTP);
	}
	
	protected static function _family_register() {
		$details 			= self::$_user_registration_details;
		$new_user_name		= self::_check_username_exist();
		$username			= self::$_user_name;
		
		if($username == '') return false;
		
		$sql	= "INSERT INTO user_management 
					SET user_name = '{$username}', user_password = '".md5($details['user_password'])."', user_type = 'family', user_email = '{$details['user_email']}', 
					user_subscriberid = '{$details['user_subscriberid']}', user_status = '0', join_date = '{$details['join_date']}', is_payment_status = '0'
					";						
		mysql_query($sql);
		
		$user_id = mysql_insert_id();

		$sql	= "INSERT INTO user_information 
					SET user_id = '{$user_id}', user_first_name = '{$details['user_first_name']}', user_last_name = '{$details['user_last_name']}', 
					location_code = '{$details['location_code']}', user_current_address = '{$details['user_current_address']}', 
					user_cell_phone = '{$details['user_cell_phone']}', user_biography = '{$details['user_biography']}', user_contact_email = '{$details['user_contact_email']}'
					";						
		mysql_query($sql);
		
		return mysql_affected_rows();
		
	}

	protected static function _sitter_register() {
		$details 			= self::$_user_registration_details;
		$new_user_name		= self::_check_username_exist();
		$username			= self::$_user_name;		
		
		$sql	= "INSERT INTO user_management 
					SET user_name = '{$username}', user_password = '".md5($details['user_password'])."', user_type = 'sitter', user_email = '{$details['user_email']}', 
					user_subscriberid = '{$details['user_subscriberid']}', user_status = '0', join_date = '{$details['join_date']}', is_payment_status = '0'
					";
						
		mysql_query($sql);
		
		$user_id = mysql_insert_id();

		$sql	= "INSERT INTO user_information 
					SET user_id = '{$user_id}', user_first_name = '{$details['user_first_name']}', user_last_name = '{$details['user_last_name']}', 
					user_driver_license = '{$details['user_driver_license']}', user_firstaid_training = '{$details['user_firstaid_training']}', 
					user_date_of_certification = '{$details['user_date_of_certification']}', is_user_willing_to_certified = '{$details['is_user_willing_to_certified']}', 
					user_cpr_training = '{$details['user_cpr_training']}', user_date_of_certification_cpr = '{$details['user_date_of_certification_cpr']}', 
					is_user_willing_to_certified_cpr = '{$details['is_user_willing_to_certified_cpr']}', user_description = '{$details['user_description']}', 
					user_cell_phone = '{$details['user_cell_phone']}', user_high_school = '{$details['user_high_school']}', 
					user_high_school_name = '{$details['user_high_school_name']}', user_college = '{$details['user_college']}', 
					user_ref1_role = '{$details['user_ref1_role']}', user_ref1_age = '{$details['user_ref1_age']}', 
					user_ref1_length = '{$details['user_ref1_length']}', user_ref2_name = '{$details['user_ref2_name']}', 
					user_ref2_role = '{$details['user_ref2_role']}', user_ref2_age = '{$details['user_ref2_age']}', 
					user_ref2_length = '{$details['user_ref2_length']}', user_biography = '{$details['user_biography']}', 
					user_newborn_exp = '{$details['user_newborn_exp']}', user_emergency_contact = '{$details['user_emergency_contact']}'
					";						
		mysql_query($sql);
		
		return mysql_affected_rows();
	}
	
	protected static function _check_username_exist() {
		
		$username	= self::$_user_name;
		
		if($username == '') return false;
		
		$sql = "
				SELECT
					user_name
				FROM
					user_management
				WHERE
					user_name = '$username'
				";

		$results	= mysql_query($sql);
		$num_rows 	= mysql_num_rows($results);
		if( $num_rows > 0) {
			$row = mysql_fetch_object($results);
			self::$_user_name = $row->user_name.rand(1000, 3000);
		}
		else {
			return false;
		}
	}
	
	protected static function _process_payment() 
	{
		$test				= self::$_is_payment_test;
		$payment_details	= self::$_payment_details;

		$x_delim_char		= $payment_details["x_delim_char"];
		$payment_details	= http_build_query($payment_details);
						
		if($test) {
			$post_url 		= "https://test.authorize.net/gateway/transact.dll"; 
		}
		else {
			$post_url 		= "https://secure.authorize.net/gateway/transact.dll"; 
		}
	
		$request = curl_init($post_url);
		
		curl_setopt($request, CURLOPT_HEADER, 0); 
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($request, CURLOPT_POSTFIELDS, $payment_details); 
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); 
		$post_response = curl_exec($request);
		curl_close ($request); 

		$response = explode($x_delim_char, $post_response);
		
		return $response;
	}	
}
?>