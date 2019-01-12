<?php
class Booking {
	private 	$user_id,
				$book_id;

	protected	$tablename = 'book_management';


	public function __construct($user_id = null) {
		if ($user_id !== null) {
			$this->user_id 		= $user_id;
		} else {
			if(!isset($_SESSION['user_id'])) return false;
			$this->user_id 		= $_SESSION['user_id'];
		}
	}

	public function set_booking() {
		$sitter_user_id				= (int) $_POST['sitter_main_id'];
		$family_user_id				= (int) $this->user_id;
		$booking_placed_date		= time();
		$no_of_kids					= (int) $_POST['no_of_kids'];
		$location_code				= $_POST['location_code'];
		$remarks					= $_POST['remarks'];
		$booking_status				= 1;
		$calender_val_arr 			= explode(',',$_POST['calender_val']);
		$nonce						= base64_encode('sdfgjkasdfknljasdfklnjasdfknlj');
		$sql						= "INSERT INTO
										$this->tablename (sitter_user_id, family_user_id, booking_date, booking_placed_date, booking_status, start_time, end_time, no_of_kids, location_code, remarks, nonce)
										VALUES ";
		$sql_insert					= array();
		$data						= new stdClass();

		if(isset($_POST['calender_val']) && $_POST['calender_val'] != "") {
			foreach($calender_val_arr as $k)
			{
				$make_id 		= str_replace('/','',trim($k));
				$booking_date	= trim($k);
				$start_time		= $_POST['start_time'.$make_id];
				$end_time		= $_POST['end_time'.$make_id];
				$sql_insert[]	= "('$sitter_user_id', '$family_user_id', '$booking_date', '$booking_placed_date', '$booking_status', '$start_time', '$end_time', '$no_of_kids', '$location_code', '$remarks', '$nonce')";

				$data->booking_details[] ='<tr><td><span>'.trim($k).'</span></td><td><span>'.date("h:i a",mktime($start_time,0,0,0,0,0)).' - '.date("h:i a",mktime($end_time,0,0,0,0,0)).'</span></td></tr>';
			}
			$sql .= join(',', $sql_insert);

			mysql_query($sql);
			$data->first_inserted_id 	= mysql_insert_id();
			$data->row_count			= mysql_affected_rows()-1;
			$data->nonce 				= $nonce;

			return $data;
		}
		else {
			return false;
		}
	}

	public function get_booking_details_by_nonce($nonce = NULL) {
		$nonce		= (string) $nonce;
		$nonce		=  mysql_real_escape_string($nonce);

		$sql		= "SELECT * FROM $this->tablename WHERE nonce = '$nonce'";

		mysql_query($sql);
		$results	= mysql_query($sql);
		$num_rows 	= mysql_num_rows($results);

		if( $num_rows > 0) {
			return mysql_fetch_object($results);
		}
		else {
			return false;
		}
	}

	public function get_booking_details_by_id($id = 0) {
		$id		= (int) $id;
		$sql	= "SELECT * FROM $this->tablename WHERE book_id = $id";

		mysql_query($sql);
		$results	= mysql_query($sql);
		$num_rows 	= mysql_num_rows($results);

		if( $num_rows > 0) {
			return mysql_fetch_object($results);
		}
		else {
			return false;
		}
	}

	public function update_booking_status($value = 1, $nonce = NULL) {
		$value		= (int) $value;
		$nonce		= (string) $nonce;
		$nonce		=  mysql_real_escape_string($nonce);

		$sql		= "UPDATE $this->tablename
						SET booking_status = '$value'
						WHERE nonce = '$nonce'";

		if(mysql_affected_rows()) {
			return $nonce;
		}
		else {
			return false;
		}
	}

	public function update_booking_approval($value = 0, $nonce = NULL) {
		$value		= (int) $value;
		$nonce		= (string) $nonce;
		$nonce		=  mysql_real_escape_string($nonce);

		$sql		= "UPDATE $this->tablename
						SET sitter_approval = '$value'
						WHERE nonce = '$nonce'";

		mysql_query($sql);

		if(mysql_affected_rows()) {
			return $nonce;
		}
		else {
			return false;
		}
	}
}
?>