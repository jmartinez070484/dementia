<?php 

$helper = EncoreHelper::instance();
$logo = $helper -> footerLogo();
$categories = get_terms('category',array('hide_empty'=>true));


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

<div class="directory-bar">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<span>Explore the directory</span>
			</div>
		</div>
	</div>
</div>

</footer>

<div class="directory">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="title">
					<strong>Explore the Directory</strong>
					<a href="">Close</a>
				</div>
				<?php foreach($categories as $category){ 
					$color = get_field('color',$category -> taxonomy.'_'.$category -> term_id);
				?>
				<div class="category">
					<b <?php if($color){ ?>style="background:<?php echo $color; ?>;"<?php } ?>><?php echo $category -> name ?></b>
					<p><?php echo $category -> description ?></p>
					<a href="<?php echo get_category_link($category); ?>"><i class="fas fa-arrow-right"></i></a>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php 

wp_footer();

?>

</body>
</html>