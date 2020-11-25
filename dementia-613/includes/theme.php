<?php 

class EncoreTheme {
	
	static $instance;

	function __construct(){

		//shortcodes
		add_shortcode('element',array($this,'render_element'));
		add_shortcode('directory-btn',array($this,'render_directory_btn'));

		if(is_admin()){
			add_theme_support('post-thumbnails');

			//filters
			add_filter('acf/settings/save_json',array($this,'acf_json_save'));
			add_filter('acf/settings/load_json',array($this,'acf_json_load'));
			add_filter('acf/fields/google_map/api',array($this,'acf_google_map_api'));
			add_filter('use_block_editor_for_post','__return_false',10);

			//actions
			add_action('admin_init',array($this,'admin_init_functions'));
			add_action('admin_menu',array($this,'custom_admin_menu'));
			add_action('admin_enqueue_scripts',array($this,'custom_admin_enqueue_styles'));
			add_action('add_meta_boxes',array($this,'add_custom_meta_boxes'));
			add_action('save_post',array($this,'custom_save_post_fields'));
		}else{

			//theme support
			add_theme_support('title-tag');

			//actions
			add_action('wp_enqueue_scripts',array($this,'custom_wp_enqueue_styles'));
		}

		add_action('pre_get_posts',array($this,'modify_query'));
		add_action('init',array($this,'encore_theme_init'));
		add_action('wp_ajax_process_resource',array($this,'process_resource'));
		add_action('wp_ajax_nopriv_process_resource',array($this,'process_resource'));
	}

	/*

		Render directory button

	*/
	public function render_directory_btn(){
		$html = '<p><a href="#" class="directory-btn">Explore the Directory</a></p>';

		return $html;
	}

	/*

		Modify Query

	*/
	public function modify_query($query){
		global $wp_query;

		if($query -> is_post_type_archive(array('resource'))){
			$taxQuery = [];
			$catParams = isset($_GET['category']) ? explode(',',$_GET['category']) : null;
			$typeParams = isset($_GET['types']) ? explode(',',$_GET['types']) : null;
			$locationParams = isset($_GET['neighbourhood']) ? $_GET['neighbourhood'] : null;

			if($catParams){
				array_push($taxQuery,array(
		            'taxonomy' => 'category',
		            'field' => 'id',
		            'terms' => $catParams
		        ));
			}

			if($typeParams){
				array_push($taxQuery,array(
		            'taxonomy' => 'type',
		            'field' => 'id',
		            'terms' => $typeParams
		        ));
			}

			if($locationParams){
				array_push($taxQuery,array(
		            'taxonomy' => 'location',
		            'field' => 'name',
		            'terms' => $locationParams
		        ));
			}

			if(count($taxQuery) > 0){
				$query -> set('tax_query',$taxQuery);
			}
		}else if($query -> is_category()){
			$query -> set('post_type',array('resource'));
		}
	}

	/*

		Process Resource

	*/
	public function process_resource(){
		$response = ['success'=>false];

		print(json_encode($response));
	    wp_die();
	}

	/*

		Render element

	*/
	public function render_element($atts){
		$element = isset($atts['name']) ? encore_theme.'/partials/'.$atts['name'].'.php' : null;
		$html = '';
		
		if($element && file_exists($element)){
	        ob_start();

	        include($element);

	        $html = ob_get_clean();
	    }

		return $html;
	}

	/* 

		Save custom post fields

	*/
	public function custom_save_post_fields($id){
		$helper = EncoreHelper::instance();
		$postFields = $postType === 'page' ? $helper -> template() : $postType.'.php';

	    if(!$postFields){
	    	$postFields = 'page.php';
	    }

	    $postInclude = $postFields ? encore_theme.'/includes/custom-fields/post/'.$postFields : null;
	    $postData = isset($_POST) ? $_POST : null;
		
	    if($postData && file_exists($postInclude)){
	        include_once($postInclude);
	    }
	}

	/*

		Custom meta boxes

	*/
	public function add_custom_meta_boxes($type){
		$helper = EncoreHelper::instance();
		$template = $helper -> template(); 
	    $metaBox = $type === 'page' ? encore_theme.'/includes/custom-fields/'.$template : encore_theme.'/includes/custom-fields/'.$type.'.php';
	    
	    if(file_exists($metaBox)){
	        add_meta_box('custom-fields-'.$type,__('Custom Fields'),function($args,$callback){
	            global $post;

	            include_once($callback['args']['file']);
	        },array($type),'normal','low',array('file'=>$metaBox));
	    }
	}

	/*

		ACF Google Map API Key

	*/
	public function acf_google_map_api($api){
		$api['key'] = get_option('google_map_api');
	
		return $api;
	}

	/*

		ACF load JSON

	*/
	public function acf_json_load($paths){
		unset($paths[0]);

		$paths[] = encore_theme.'/acf';

		return $paths;
	}

	/*

		ACF save JSON

	*/
	public function acf_json_save($path){
		$path = encore_theme.'/acf';

		return $path;
	}

	/*

		Admin init functions

	*/
	public function admin_init_functions(){
		//general
		register_setting('custom-options-settings','blogname');
		register_setting('custom-options-settings','blogdescription');
		register_setting('custom-options-settings','site_logo');
		register_setting('custom-options-settings','footer_logo');
		register_setting('custom-options-settings','header_image');

		//contact
		register_setting('custom-options-settings','contact_email');

		//api
		register_setting('custom-options-settings','google_map_api');
	}

	/*

		Custom enqueue styles

	*/
	public function custom_wp_enqueue_styles(){
		$styles = '/css/style.min.css';
	    $scripts = '/js/scripts.js';

	    wp_enqueue_style('theme-bootstrap','//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',array(),null,'all');
	    wp_enqueue_style('theme-font-lato','//fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap',array(),null,'all');
	    wp_enqueue_style('theme-font-awesome','//use.fontawesome.com/releases/v5.2.0/css/all.css',array(),null,'all');

	    if(file_exists(encore_theme.$styles)){
	        wp_enqueue_style('theme-styles',encore_theme_url.$styles.'?v='.filemtime(encore_theme.$styles),array(),null,'all');
	    }

	    if(file_exists(encore_theme.$scripts)){
	    	$apiKey = get_option('google_map_api');;

	    	if($apiKey){
	    		wp_enqueue_script('theme-google-maps','//maps.googleapis.com/maps/api/js?key='.$apiKey, array(),null,true);
	    	}
	    	
	        wp_enqueue_script('theme-scripts',encore_theme_url.$scripts.'?v='.filemtime(encore_theme.$scripts), array(),null,true);
	    }
	}

	/*

		Custom admin enqueue styles

	*/
	public function custom_admin_enqueue_styles(){
		$styles = '/css/admin.css';
	    $scripts = '/js/admin.js';

	    wp_enqueue_style('theme-font-awesome','//use.fontawesome.com/releases/v5.2.0/css/all.css',array(),null,'all');

	    if(file_exists(encore_theme.$styles)){
	        wp_enqueue_style('theme-admin-styles',encore_theme_url.$styles.'?v='.filemtime(encore_theme.$styles),array(),null,'all');
	    }

	    if(file_exists(encore_theme.$scripts)){
	        wp_enqueue_script('theme-admin-scripts',encore_theme_url.$scripts.'?v='.filemtime(encore_theme.$scripts), array(),null,false);
	    }
	}

	/*

		Class Instance
	
	*/
	public function custom_admin_menu(){
		add_menu_page(__('Theme Settings','settings'), __('Theme Settings','settings'),'manage_options','settings',function(){
			include_once(encore_theme.'/includes/settings.php');
		},'dashicons-welcome-widgets-menus',30);
	}

	/*

		Theme Init

	*/
	public function encore_theme_init(){
		/* Menus */
		register_nav_menus(array('main-menu'=>__('Main Menu')));
		register_nav_menus(array('footer-menu'=>__('Footer Menu')));

		/* Taxonomy */
		register_taxonomy('type',array('resource'),array('label'=>__('Types'),'hierarchical'=>true,'with_front'=>false,'show_admin_column'=>true));
		register_taxonomy('features',array('resource'),array('label'=>__('Features'),'hierarchical'=>true,'with_front'=>false,'show_admin_column'=>false));
		register_taxonomy('location',array('resource'),array('label'=>__('Locations'),'hierarchical'=>true,'with_front'=>false,'show_admin_column'=>false));
		register_taxonomy('cost',array('resource'),array('label'=>__('Costs'),'hierarchical'=>true,'with_front'=>false,'show_admin_column'=>false));
		register_taxonomy('files',array('resource'),array('label'=>__('Files'),'hierarchical'=>true,'with_front'=>false,'show_admin_column'=>false));

		/* Resources */
		$customPostArgs = array(
	        'labels' => array('name' => __('Resources'),'singular_name' => __('Resource'),'add_new' => __('Add Resource'),'add_new_item' => __('Add New Resource'),'edit_item' => __('Edit Resource'),'new_item' => __('New Resource'),'view_item' => __('View Resource'),'search_items' => __('Search Resource'),'not_found' => __('No Resource found'),'not_found_in_trash' => __('No Resource found in Trash'),'parent_item_colon' => '','menu_name' => __('Resources')),
	        'public' => true,
	        'publicly_queryable' => true,
	        'exclude_from_search' => true,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'capability_type' => 'post',
	        'capabilities' => array('edit_post' => 'edit_post','edit_posts' => 'edit_posts','edit_others_posts' => 'edit_others_posts','publish_posts' => 'publish_posts','read_post' => 'read_post','read_private_posts' => 'read_private_posts','delete_post' => 'delete_post'),
	        'map_meta_cap' => true,
	        'hierarchical' => false,
	        'supports' => array('title'),
	        'has_archive' => true,
	        'rewrite' =>  array('slug'=>'resources','with_front'=>true),
	        'query_var' => true,
	        'can_export' => true,
	        'show_in_nav_menus' => false,
	        'menu_icon' => 'dashicons-book-alt',
	        'taxonomies'=> array('category','type','features','cost')
	    );

	    register_post_type('resource',$customPostArgs);
	    flush_rewrite_rules();
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