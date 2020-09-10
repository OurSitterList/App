<?php

include($_SERVER["DOCUMENT_ROOT"] . '/includes/connection.php');

  /**
   * POST
   * 
   * #user_id
   * $job_calender_val
   * $job_no_of_kids
   * $job_location_code
   * $job_remarks
   */

	$data = json_decode(file_get_contents('php://input'), true);

	if(!isset($data['user_id']) || !isset($data['location_id'])) {
        echo json_encode([
            'code' => 201,
            'message' => 'Please post from a valid account'
        ]);
        exit;
    }

	$code =  time().rand(0,100);
	$calender_val_arr = explode(',',$data['job_calender_val']);
	$insertedId = null;
	$postingTimeout = strtotime('-1 Minute');
	$throttlePostings = $db->get('
	    SELECT job_id,booking_placed_date FROM job_management 
	    WHERE family_user_id=:user_id
	    AND booking_placed_date >= '.$postingTimeout,[
	        'user_id' => $data['user_id']
        ]
    );
	if(count($throttlePostings) > 0) {
	    $maxTime = 0;
	    foreach($throttlePostings as $posting) {
	        if($posting->booking_placed_date > $maxTime) {
	            $maxTime = $posting->booking_placed_date;
            }
        }
	    $msg = 'Oops! You\'re trying that too often.';
	    if($maxTime > 0) {
	        $timeout = time() - $maxTime;
	        if($timeout > 0) {
                $timeout = 5 - ceil($timeout / 60);
                //$msg .= ' Please try again in '.$timeout.' minute'.($timeout == 1 ? '' : 's');
                $msg .= ' Please try again in a bit';
            }
        }
        $response = array('code' => 201, 'message' => $msg);
        echo json_encode($response); exit;
    } else {
        foreach ($calender_val_arr as $CV) {
            $make_id = str_replace('/', '', trim($CV));

            $insertedId = $db->insert("into job_management set 
            set_code=:code,
            family_user_id=:user_id,
            booking_date=:cv,
            booking_placed_date=:place_time,
            booking_status='1',
            start_time=:start_time,
            end_time=:end_time,
            no_of_kids=:job_no_of_kids,
            location_code=:job_location_code,
            remarks=:job_remarks, 
            location_id =:location_id", [
                'code' => $code,
                'user_id' => $data['user_id'],
                'cv' => trim($CV),
                'place_time' => time(),
                'start_time' => $data['job_start_time' . $make_id],
                'end_time' => $data['job_end_time' . $make_id],
                'job_no_of_kids' => $data['job_no_of_kids'],
                'job_location_code' => $data['job_location_code'],
                'job_remarks' => $data['job_remarks'],
                'location_id' => $data['location_id']
            ]);

        }

        // send notification
        $notification = new Notification();
        $notification->send_family_notification($_REQUEST, $insertedId);
        $response = array('code' => 200, 'message' => 'Your job posting has been created.');
        echo json_encode($response);
        exit;
    }

