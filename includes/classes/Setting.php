<?php
class Setting {
	protected static 		$_id			= 0;
	protected static 		$_config 		= array();
	protected static 		$_config_item 	= array();
	
	public function __construct($config = NULL){
		
		if(!isset($config)) return false;
		
		self::get_setting();
		self::$_id = isset($config['id']) ? 		$config['id'] 			: NULL ;
	}	
		
	public static  function get_setting()
	{
		$sql		= "SELECT * FROM setting";
		$results	= mysql_query($sql);
		$num_rows 	= mysql_num_rows($results);
		$data		= array();
		
		if( $num_rows > 0) {
			while ($row = mysql_fetch_object($results)) {
				$data[$row->id] = array ($row->id, $row->updtime, $row->settingName, $row->settingValue);
			}
			
			self::$_config = $data;
		}
		
		return $data;
	}
	
	public static function get_setting_item() {
		$data					= self::$_config;
		self::$_config_item 	= $data[self::$_id];
		
		return self::$_config_item;
	}
	
}
?>