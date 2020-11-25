<?php 

/* Template Name: Contact */

get_header();

while(have_posts()):
    the_post(); 

    $secondaryContent = get_post_meta($post -> ID,'secondary_content',true);
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

<?php if($secondaryContent){ 
	$email = get_field('email');
	$phone = get_field('phone');
	$address = get_field('address');
	$text = get_field('text');
	$apiKey = get_option('google_map_api');
?>
<div class="secondary-content">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-4 col-12">
				<div class="content">
					<strong>Contact Info</strong>
					<ul>
						<?php if($email){ ?><li><i class="fa fa-envelope"></i> <b>Email:</b> <?php echo $email; ?></li><?php } ?>
						<?php if($phone){ ?><li><i class="fa fa-phone"></i> <b>Phone:</b> <?php echo $phone; ?></li><?php } ?>
						<?php if($address){ ?><li><i class="fas fa-map-marker-alt"></i> <b>Address:</b> <?php echo $address['address']; ?></li><?php } ?>
					</ul>
					<?php if($address && $apiKey){ ?><img src="https://maps.googleapis.com/maps/api/staticmap?zoom=13&size=385x190&maptype=roadmap&markers=color:blue%7Clabel:S%7C<?php echo $address['lat'] ?>,<?php echo $address['lng'] ?>&key=<?php echo $apiKey; ?>" alt="" /><?php } ?>
					<?php if($text){ ?><p><?php echo $text; ?></p><?php } ?>
				</div>
			</div>
			<div class="col-lg-8 col-md-8 col-12">
				<div class="content">
					<?php echo apply_filters('the_content',$secondaryContent); ?>
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