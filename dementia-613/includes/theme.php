<?php 

class EncoreTheme {
	
	static $instance;

	function __construct(){

		if(is_admin()){
			add_theme_support('post-thumbnails');

			//filters
			add_filter('acf/settings/save_json',array($this,'acf_json_save'));
			add_filter('acf/settings/load_json',array($this,'acf_json_load'));
			add_filter('acf/fields/google_map/api',array($this,'acf_google_map_api'));


			//actions
			add_action('admin_init',array($this,'admin_init_functions'));
			add_action('admin_menu',array($this,'custom_admin_menu'));
			add_action('admin_enqueue_scripts',array($this,'custom_admin_enqueue_styles'));
		}else{

			//theme support
			add_theme_support('title-tag');

			//actions
			add_action('wp_enqueue_scripts',array($this,'custom_wp_enqueue_styles'));
		}

		add_action('init',array($this,'encore_theme_init'));
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
		register_setting('custom-options-settings','google_map_api');
	}

	/*

		Custom enqueue styles

	*/
	public function custom_wp_enqueue_styles(){
		$styles = '/css/style.min.css';
	    $scripts = '/js/scripts.js';

	    wp_enqueue_style('theme-bootstrap','//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',array(),null,'all');
	    wp_enqueue_style('theme-open-sans','//fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap',array(),null,'all');
	    wp_enqueue_style('theme-font-awesome','//use.fontawesome.com/releases/v5.2.0/css/all.css',array(),null,'all');

	    if(file_exists(encore_theme.$styles)){
	        wp_enqueue_style('theme-admin-styles',encore_theme_url.$styles.'?v='.filemtime(encore_theme.$styles),array(),null,'all');
	    }

	    if(file_exists(encore_theme.$scripts)){
	        wp_enqueue_script('theme-admin-scripts',encore_theme_url.$scripts.'?v='.filemtime(encore_theme.$scripts), array(),null,true);
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
		/* Taxonomy */
		register_taxonomy('resource-category',array('resource'),array('label'=>__('Categories'),'hierarchical'=>true,'with_front'=>false,'show_admin_column'=>true));
		register_taxonomy('type',array('resource'),array('label'=>__('Types'),'hierarchical'=>true,'with_front'=>false,'show_admin_column'=>true));

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
	        'rewrite' =>  array('slug'=>'resource','with_front'=>true),
	        'query_var' => true,
	        'can_export' => true,
	        'show_in_nav_menus' => false,
	        'menu_icon' => 'dashicons-book-alt'
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