<!doctype html>
<html xml:lang="en" lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1" /> 

<?php 

wp_head(); 

$helper = EncoreHelper::instance();
$logo = $helper -> logo();
$background = $helper -> background(); 

?>
</head>
<body <?php body_class(); ?>>

<header <?php if($background){ echo 'style="background:url(\''.$background[0].'\') no-repeat center center/cover;"' ;} ?>>

<div class="container">
	<div class="row">
		<div class="col-12">
			<?php if($logo){ ?><a href="#"><img src="<?php echo $logo[0]; ?>" alt="<?php echo $helper -> option('blogname'); ?>" /></a><?php } ?>
		</div>
	</div>
</div>

<div class="navigation">
	<?php wp_nav_menu(array('menu'=>'main-menu','container'=>false)); ?>
</div>	

</header>	

<main>