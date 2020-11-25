<?php 

class EncoreHelper {

	static $instance;
	private $options;
	private $logo;
	private $footerLogo;
	private $background;

	function __construct(){
		$this -> options = [];
	}

	/*
	
		Get template
		
	*/
	public function template(){
		$id = get_the_ID();
		
		return basename(get_page_template($id));
	}

	/*
	
		Get Logo
		
	*/
	public function logo(){
		$logo = isset($this -> logo) ? $this -> logo : null;

		if(!$logo){
			$siteLogoId = get_option('site_logo');
			$logo = $siteLogoId ? wp_get_attachment_image_src($siteLogoId,'full') : null;

			if($logo){
				$this -> logo = $logo;
			}	
		}

		return $logo;
	}

	/*
	
		Get Footer Logo
		
	*/
	public function footerLogo(){
		$logo = isset($this -> footerLogo) ? $this -> footerLogo : null;

		if(!$logo){
			$siteLogoId = get_option('footer_logo');
			$logo = $siteLogoId ? wp_get_attachment_image_src($siteLogoId,'full') : null;

			if($logo){
				$this -> footerLogo = $logo;
			}	
		}

		return $logo;
	}

	/*
	
		Get Header Background
		
	*/
	public function background(){
		$background = isset($this -> background) ? $this -> background : null;

		if(!$background){
			$backgroundId = get_option('header_image');
			$background = $backgroundId ? wp_get_attachment_image_src($backgroundId,'full') : null;

			if($background){
				$this -> background = $background;
			}	
		}

		return $background;
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