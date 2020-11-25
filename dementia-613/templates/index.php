<?php 

/* Template Name: Index */

get_header();

$resources = get_field('featured_resources');

?>

<div id="featured" class="featured">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<p><strong>Featured</strong> dementia-friendly resources <a href="<?php echo get_post_type_archive_link('resource'); ?>">View All</a></p>
			</div>	
			<?php foreach($resources as $key => $value){ 
				$categories = wp_get_post_terms($value -> ID,'category');
    			$location = wp_get_post_terms($value -> ID,'location');
    			$cost = wp_get_post_terms($value -> ID,'cost');
    			$files = wp_get_post_terms($value -> ID,'files');
			?>
			<div class="<?php if($key === 0){ ?>main col-12<?php }else{ ?>col-lg-6 col-12<?php } ?>">
				<div class="resource-item">
					<?php if(count($categories) > 0){ 
						$color = get_field('color',$categories[0] -> taxonomy.'_'.$categories[0] -> term_id);

						if(!$color){
							$color = '#000';
						}
					?>
					<ul>
						<li><span style="background:<?php echo $color; ?>;"><?php echo $categories[0] -> name ?></span></li>
					</ul>
					<?php } ?>
					<h2><a href="<?php echo get_permalink($value -> ID); ?>"><?php echo $value -> post_title; ?></a></h2>
					<p><?php if(count($location) > 0){ ?><span><i class="fas fa-map-marker-alt"></i> <?php echo $location[0] -> name; ?></span><?php } ?><?php if(count($cost) > 0){ ?><span><?php echo $cost[0] -> name; ?></span><?php } ?></p>
					<p><?php the_field('excerpt',$value -> ID); ?></p>
	    			<a href="<?php echo get_permalink($value -> ID); ?>"></a>
	    			<?php if(is_array($files) && count($files) > 0){ ?><small><?php echo $files[0] -> name; ?></small><?php  } ?>
	    		</div>
			</div>
			<?php } ?>
			<div class="col-12">
				<p><a href="<?php echo get_post_type_archive_link('resource'); ?>">View All</a></p>
			</div>
		</div>
	</div>
</div>

<?php 

$bgImage = get_field('subcontent_image');
$leftContent = get_field('subcontent_left');
$rightContent = get_field('subcontent_right');

?>

<div class="subcontent" <?php if($bgImage){ ?>style="background:url('<?php echo $bgImage; ?>') no-repeat center center/cover;"<?php } ?>>
	<div class="container">
		<div class="row align-items-cente">
			<div class="col-lg-6 col-12">
				<?php echo $leftContent ?>
			</div>
			<div class="col-lg-6 col-12">
				<?php echo $rightContent ?>
			</div>
		</div>
	</div>
</div>

<?php 

get_footer();

?>