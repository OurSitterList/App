<?php
class Response {
	protected static 		$_id;
	protected static 		$_message;
	protected static 		$_alert;
	
	public function __construct($config = NULL) {
		
		if(!isset($config)) return false;	
		
		$id				= isset($config['id']) ? 		$config['id'] 			: 'info-box' ;
		$message		= isset($config['message']) ? 	$config['message'] 		: NULL ;
		$alert			= isset($config['alert']) ? 	$config['alert'] 		: 'info' ;			
		
		self::$_id 			= $id;
		self::$_message 	= $message;
		self::_alert_valid($alert);
	}
	
	public static function modal() {
		$id			= self::$_id;
		$message	= self::$_message;
		$alert		= self::$_alert;
		
		if($message == NULL) return false;
		
		$modal 		= "<div class='md-modal md-effect-{$id} md-show autohide' id='modal-{$id}'>
					<div class='md-close {$id}_close'></div>
						<div class='md-content' id='md-content'>
						 	<div class='text-{$alert}'>
							{$message}
							</div>
						 </div>
					</div>";
		echo $modal;
	}
	
	private static function _alert_valid($alert) {
		$valid_alert	= array('success', 'info', 'warning', 'danger');
		
		if(in_array($alert, $valid_alert)) {
			self::$_alert = $alert;
		}
		else {
			self::$_alert = 'info';
		}	
	}
}
?>