<?php

class MyAccount {

	private $user_id;

	

	public function __construct() {

		$this->user_id = Auth::_get_user_id();

	}



	public function get_user_details_old_password($user_code = NULL, $user_password) {

		$user_code			= mysql_real_escape_string(trim($user_code));

		$user_password		= md5(mysql_real_escape_string(trim($user_password)));



		$sql		= "SELECT * FROM `user_management` 

						WHERE 	user_code='$user_code' AND

								user_password='$user_password'";

		$results	= mysql_query($sql);

		$num_rows 	= mysql_num_rows($results);

		if( $num_rows > 0) {

			$row = mysql_fetch_object($results);

			return $row;

		}

		else {

			return false;

		}

	}



	public function get_user_details_by_user_name($user_name = NULL) {

		$user_name	= mysql_real_escape_string(trim($user_name));

		$sql		= "SELECT * FROM `user_management` WHERE user_name='$user_name'";

		$results	= mysql_query($sql);

		$num_rows 	= mysql_num_rows($results);

		if( $num_rows > 0) {

			$row = mysql_fetch_object($results);

			return $row;

		}

		else {

			return false;

		}

	}



	public function get_user_details_by_user_email($user_email = NULL) {

		if(!filter_var($user_email, FILTER_VALIDATE_EMAIL)) return false;

		

		$user_name	= mysql_real_escape_string(trim($user_email));

		$sql		= "SELECT * FROM `user_management` WHERE user_email='$user_email'";

		$results	= mysql_query($sql);

		$num_rows 	= mysql_num_rows($results);

		if( $num_rows > 0) {

			$row = mysql_fetch_object($results);

			return $row;

		}

		else {

			return false;

		}

	}

	

	public function get_user_details_by_id($user_id = 0) {

		$user_id	= (int) $user_id;

		

		if(!$user_id) {

			return false;			

		}

		

		$sql		= "

						SELECT

							um.user_id,

							um.user_name,

							um.user_password,

							um.user_access,

							um.child_action,

							um.user_type,

							um.user_email,

							um.user_status,

							um.join_date,

							um.expiery_date,

							um.is_payment_status,

							um.user_code,

							um.user_plan,

							um.user_expierydate,

							um.user_subscriberid,

							ui.user_information_id,

							ui.user_first_name,

							ui.user_middle_name,

							ui.user_last_name,

							ui.user_driver_license,

							ui.user_firstaid_training,

							ui.user_date_of_certification,

							ui.is_user_willing_to_certified,

							ui.user_cpr_training,

							ui.user_newborn_cpr_training,

							ui.user_food_allergies,

							ui.user_overnight,

							ui.user_travel,

							ui.user_permanent,

							ui.user_newborn_exp,

							ui.user_sick_kids,

							ui.user_date_of_certification_cpr,

							ui.is_user_willing_to_certified_cpr,

							ui.user_cell_phone,

							ui.user_contact_email,

							ui.user_emergency_contact,

							ui.is_user_agree_to_houseplans,

							ui.user_age,

							ui.user_school_affliation,

							ui.user_image,

							ui.user_biography,

							ui.user_description,

							ui.user_high_school,

							ui.user_high_school_name,

							ui.user_college,

							ui.user_college_name,

							ui.user_ref1_name,

							ui.user_ref1_role,

							ui.user_ref1_age,

							ui.user_ref1_length,

							ui.user_ref2_name,

							ui.user_ref2_role,

							ui.user_ref2_age,

							ui.user_ref2_length,

							ui.user_available_mon_start,

							ui.user_available_tue_start,

							ui.user_available_wed_start,

							ui.user_available_thu_start,

							ui.user_available_fri_start,

							ui.user_available_sat_start,

							ui.user_available_sun_start,

							ui.user_available_mon_end,

							ui.user_available_tue_end,

							ui.user_available_wed_end,

							ui.user_available_thu_end,

							ui.user_available_fri_end,

							ui.user_available_sat_end,

							ui.user_available_sun_end,

							ui.user_babysitting_exp,

							ui.user_contact_address,

							ui.user_current_address,

							ui.location_code,

							ui.cpr_approve,

							ui.newborn_approve,

							ui.background_approve

						FROM

							user_management AS um

						LEFT JOIN user_information AS ui ON ui.user_id = um.user_id

						WHERE

							um.user_id = ".$user_id;

		$results	= mysql_query($sql);

		$num_rows 	= mysql_num_rows($results);

		if( $num_rows > 0) {

			$row = mysql_fetch_object($results);

			return $row;

		}

		else {

			return false;

		}



	}

	

	public function check_availability_by_job_id($job_id = 0) {

		$user_id	= (int) $this->user_id;

		$job_id		= (string) $job_id;

		

		if(!$user_id || !$job_id) {

			return false;			

		}

		

		$time_slot	= new stdClass();

		$sql 		= "

				SELECT

					jm.job_id,

					jm.set_code,

					jm.family_user_id,

					jm.booking_date,

					jm.booking_placed_date,

					jm.start_time,

					jm.end_time,

					jm.no_of_kids,

					jm.location_code,

					jm.remarks,

					jm.booking_status,

					jm.sitter_approval,

					jm.job_id,

					ui.user_available_mon_start,

					ui.user_available_tue_start,

					ui.user_available_wed_start,

					ui.user_available_thu_start,

					ui.user_available_fri_start,

					ui.user_available_sat_start,

					ui.user_available_sun_start,

					ui.user_available_mon_end,

					ui.user_available_tue_end,

					ui.user_available_wed_end,

					ui.user_available_thu_end,

					ui.user_available_fri_end,

					ui.user_available_sat_end,

					ui.user_available_sun_end

				FROM

					job_management AS jm,

					user_information AS ui

				WHERE

					ui.user_id = $user_id

					AND jm.job_id =  $job_id";

		

		//echo "<!-- sql: $sql -->\n";

		//echo $sql; exit;

		$conn=mysqli_connect(host,user,pass);
    	mysqli_set_charset($conn, "utf8");
    	mysqli_select_db($conn, db);

		$results	= mysqli_query($conn, $sql);

		//$num_rows 	= mysql_num_rows($results);

		

		//echo "<!-- num_rows: $num_rows -->\n";

		

		//if( $num_rows > 0) {
		if(count($results) > 0) {

			$row = mysqli_fetch_object($results);

			
			foreach ($results as $res)
			{
			    //echo $R->start_time;
			    
			//echo "<pre>"; print_r($res); exit;


			//echo "<!-- row: ";

			//print_r($row);

			//echo "-->\n";

			

			$time_slot->reason			=

			$time_slot->sched 			= array();

			

			$time_slot->day_name 		= 

			$day_name					= strtolower(date('D', strtotime($res['booking_date'])));

			//echo "<!-- day_name: $day_name -->\n";



			$start_time 				= trim($res['start_time']);

			$end_time 					= trim($res['end_time']);

			

			if(!$start_time || !$end_time) {

					//echo "<!-- day_start: Not Available -->\n";

					$time_slot->sched[] = 'Not Available';

					return $time_slot;

			}

				
			$dayname = "user_available_".$day_name."_start";
									

			$day_start	= trim($res[$dayname]);

			//echo "<!-- day_start: $day_start -->\n";

			$dayend = "user_available_".$day_name."_end";

			$day_end	= trim($res[$dayend]);

			

			if(strlen($day_start) && strlen($day_end)) {

				$hour_s = explode(',', $day_start);

				$hour_e = explode(',', $day_end);

				

				/*

				echo "<!-- hour_s: ";

				print_r($hour_s);

				echo "-->\n";

				echo "<!-- hour_e: ";

				print_r($hour_e);

				echo "-->\n";

				*/

				//check if any exist in timeslot

				if(in_array($start_time, $hour_s) && in_array($end_time, $hour_e)) {

					return 'available';

				}

				else {

					$possible	= 0;

										

					//check if the time available is within the range

					//echo "<!-- //check if the time available is within the range -->";

					

					for($i=0; $i<= count($hour_s) - 1; $i++) {

						//echo "<!-- //{$hour_s[$i]} <= $start_time -->\n";

						

						if($hour_s[$i] <= $start_time) {

							for($i=0; $i<= count($hour_s) - 1; $i++) {

								if($hour_e[$i] >= $end_time) {

									$possible++;

									

									//echo "<!-- //{$hour_e[$i]} <= $end_time -->\n";

								}

							}

						}

					}

					if($possible >  0) {

						return 'available';

					}

					else {						  

						for($i=0; $i<= count($hour_s) - 1; $i++) {

								$time_slot->sched[] = date("h a",mktime($hour_s[$i],0,0,0,0,0)).' - '.date("h a",mktime($hour_e[$i],0,0,0,0,0));

						}

						$time_slot->reason[]	= 'Conflict schedule.';

						return $time_slot;

					}

				}					

			}


			else {

					//echo "<!-- day_start: Not Available -->\n";

					$time_slot->sched[]		= 'Not Available.';

					$time_slot->reason[]	= 'No configure schedule.';

					

					return $time_slot;

			}

		}

		}

	}



	public function check_availability_by_book_id($book_id = 0) {

	}



	public function check_my_time_availability($user_id =0 , $date = NULL, $time_s = 0, $time_e = 0) {

		$user_id	= (int) $user_id;

		$date		= $date;

		$start_time = (int) $time_s;

		$end_time 	= (int) $time_e;



		if(!$user_id || !$job_id || ($start_time >= $end_time)) {

			return false;			

		}



		$time_slot	= new stdClass();

		$sql 		= "

						SELECT

							user_id,

							user_first_name,

							user_last_name,

							user_available_mon_start,

							user_available_tue_start,

							user_available_wed_start,

							user_available_thu_start,

							user_available_fri_start,

							user_available_sat_start,

							user_available_sun_start,

							user_available_mon_end,

							user_available_tue_end,

							user_available_wed_end,

							user_available_thu_end,

							user_available_fri_end,

							user_available_sat_end,

							user_available_sun_end

						FROM

							user_information

						WHERE

						user_id = $user_id

						";

		

		//echo "<!-- sql: $sql -->\n";

		

		$results	= mysql_query($sql);

		$num_rows 	= mysql_num_rows($results);

		

		//echo "<!-- num_rows: $num_rows -->\n";

		

		if( $num_rows > 0) {

			$row = mysql_fetch_object($results);

			

			//echo "<!-- row: ";

			//print_r($row);

			//echo "-->\n";

			

			$time_slot->reason			=

			$time_slot->sched 			= array();

			

			$time_slot->day_name 		= 

			$day_name					= strtolower(date('D', strtotime($date)));

			//echo "<!-- day_name: $day_name -->\n";



			

			if(!$start_time || !$end_time) {

					//echo "<!-- day_start: Not Available -->\n";

					$time_slot->sched[] = 'Not Available';

					return $time_slot;

			}

				

									

			$day_start					= trim($row->{user_available_.$day_name._start});

			//echo "<!-- day_start: $day_start -->\n";

			

			$day_end					= trim($row->{user_available_.$day_name._end});

			

			if(strlen($day_start) && strlen($day_end)) {

				$hour_s = explode(',', $day_start);

				$hour_e = explode(',', $day_end);

				

				/*

				echo "<!-- hour_s: ";

				print_r($hour_s);

				echo "-->\n";

				echo "<!-- hour_e: ";

				print_r($hour_e);

				echo "-->\n";

				*/

				//check if any exist in timeslot

				if(in_array($start_time, $hour_s) && in_array($end_time, $hour_e)) {

					return true;

				}

				else {

					$possible	= 0;

										

					//check if the time available is within the range

					//echo "<!-- //check if the time available is within the range -->";

					

					for($i=0; $i<= count($hour_s) - 1; $i++) {

						//echo "<!-- //{$hour_s[$i]} <= $start_time -->\n";

						

						if($hour_s[$i] <= $start_time) {

							for($i=0; $i<= count($hour_s) - 1; $i++) {

								if($hour_e[$i] >= $end_time) {

									$possible++;

									

									//echo "<!-- //{$hour_e[$i]} <= $end_time -->\n";

								}

							}

						}

					}

					if($possible >  0) {

						return true;

					}

					else {						  

						for($i=0; $i<= count($hour_s) - 1; $i++) {

								$time_slot->sched[] = date("h a",mktime($hour_s[$i],0,0,0,0,0)).' - '.date("h a",mktime($hour_e[$i],0,0,0,0,0));

						}

						$time_slot->reason[]	= 'Conflict schedule.';

						return $time_slot;

					}

				}					

			}

			else {

					//echo "<!-- day_start: Not Available -->\n";

					$time_slot->sched[]		= 'Not Available.';

					$time_slot->reason[]	= 'No configure schedule.';

					

					return $time_slot;

			}

		}

	}

}

?>