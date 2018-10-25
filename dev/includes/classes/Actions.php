<?php
class Actions {
	public 			$do,
					$action,
					$nonce;
						
	public function __construct($config=NULL) {

		if(!isset($config)) return false;

		$this->do 			= $config['do'];
		$this->action 		= $config['action'];
		$this->nonce 		= base64_decode($config['nonce']);
	}
	
    public function __call($name, $arguments)
    {
        return "Calling Invalid Function";
    }	

	public function login()
	{
		$auth	= new Auth();
		$auth->login();
	}

	public function logout()
	{
		$auth	= new Auth();
		$auth->logout();
	}

	public function update_booking_status()
	{
		$value 		= (int) $this->action;
		$nonce 		= $this->nonce;
		$booking	= new Booking();
		
		$booking->update_booking_status($value, $nonce);
		
		return 'Booking status successfully update';
	}

	public function update_booking_approval()
	{
		$value 		= (int) $this->action;
		$nonce 		= $this->nonce;
		$booking	= new Booking();
		
		$response	= $booking->update_booking_approval($value, $nonce);
		
		if(!$response) {
			return 'Booking is on active status and has been approved.';
		}
		else {
			$notification	= new Notification();
			return $notification->send_booking_approval_notification($nonce);
		}
	}

}
?>