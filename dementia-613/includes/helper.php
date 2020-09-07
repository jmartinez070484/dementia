<?php 

class EncoreHelper {

	static $instance;
	private $options;

	function __construct(){
		$this -> options = [];
	}

	/*
	
		Get Option
		
	*/
	public function option($key = null){
		$option = $key && isset($this -> options[$key]) ? $this -> options[$key] : null;

		if(!$option && $key){
			$option = get_option($key);

			if($option){
				$this -> options[$key] = $option;
			}
		}

		return $option;
	}

	/*

		Class Instance
	
	*/
	public static function instance(){
        if(!(self::$instance instanceof self)){
            self::$instance = new self;
        }

        return self::$instance;
    }
}

?>