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

        $con = new DBConnection(host,user,pass,db);
        $results = $con->get('SELECT * FROM setting');
        $data = [];

        if(count($results) > 0) {
            foreach($results as $result) {
                $data[$result->id] = [
                    $result->id,
                    $result->updtime,
                    $result->settingName,
                    $result->settingValue
                ];
            }
        }

        self::$_config = $data;

        return $data;
	}
	
	public static function get_setting_item() {
		$data					= self::$_config;
		self::$_config_item 	= $data[self::$_id];
		
		return self::$_config_item;
	}
	
}
?>