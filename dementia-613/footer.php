<?php 

$helper = EncoreHelper::instance();
$logo = $helper -> footerLogo();

?></main>

<footer>

<div class="container">
	<div class="row">
		<div class="col-12">
			<?php if($logo){ ?><a href="#"><img src="<?php echo $logo[0]; ?>" alt="<?php echo $helper -> option('blogname'); ?>" /></a><?php } ?>
			<?php wp_nav_menu(array('menu'=>'footer-menu','container'=>false)); ?>
		</div>
	</div>
</div>

</footer>

<?php 

wp_footer();

?>

</body>
</html>