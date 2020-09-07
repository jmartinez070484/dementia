<?php 

//constants
define('encore_theme',__DIR__);
define('encore_theme_url',get_template_directory_uri());

//includes
require_once(encore_theme.'/includes/helper.php');
require_once(encore_theme.'/includes/theme.php');

$encoreTheme = EncoreTheme::instance();

?>