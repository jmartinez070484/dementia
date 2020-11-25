<?php 

get_header();

while(have_posts()):
    the_post(); 

    $secondaryContent = get_post_meta($post -> ID,'secondary_content',true);
    $sidebarContent = get_post_meta($post -> ID,'sidebar_content',true);
?>

<div class="main-content">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-12">
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</div>

<?php if($secondaryContent || $sidebarContent){ ?>
<div class="secondary-content">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-12">
				<div class="content">
					<?php echo apply_filters('the_content',$secondaryContent); ?>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-12">
				<div class="content">
					<?php echo apply_filters('the_content',$sidebarContent); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<?php 

endwhile;

get_footer();

?>