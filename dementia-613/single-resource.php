<?php 

get_header();

while(have_posts()):
    the_post(); 

    $categories = wp_get_post_terms($post -> ID,'resource-category');
    $excerpt = get_field('excerpt');
?>

<div class="details">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-12">
				<?php if(count($categories) > 0){ ?>
				<ul>
					<?php foreach($categories as $category){ 
						$color = get_field('color',$category -> taxonomy.'_'.$category -> term_id);
					?>
					<li><span <?php if($color){ ?>style="background:<?php echo $color; ?>;"<?php } ?>><?php echo $category -> name ?></span></li>
					<?php } ?>
				</ul>
				<?php } ?>
				<h1><?php the_title(); ?></h1>
				<?php if($excerpt){ ?><p><?php echo $excerpt ?></p><?php } ?>
			</div>
		</div>
	</div>
</div>

<div class="features">
	<div class="container">
		<div class="row justify-content-end">
			<div class="col-lg-8 col-md-8 col-12">
				<h2>Verified Dementia-Friendly Features</h2>
				<ul>
					<li><span>Atmosphere</span><br />Quiet Mornings, busier afternoons</li>
					<li><span>Accesibility</span><br />Wheelchair accessible, clear signage</li>
					<li><span>Staff</span><br />Dementia-friendly trained</li>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php 

$email = get_field('email_address');
$phone = get_field('phone');
$website = get_field('website');
$address = get_field('address');
$contactInfo = get_field('contact_info');
$apiKey = get_option('google_map_api');

?>
<div class="description">
	<div class="container">
		<div class="row justify-content-end">
			<div class="col-lg-4 col-md-4 col-12">
				<div class="contact-info">
					<strong>Contact Info</strong>
					<ul>
						<?php if($email){ ?><li><i class="fa fa-envelope"></i> <b>Email:</b> <?php echo $email; ?></li><?php } ?>
						<?php if($phone){ ?><li><i class="fa fa-phone"></i> <b>Phone:</b> <?php echo $email; ?></li><?php } ?>
						<?php if($website){ ?><li><i class="fas fa-globe-americas"></i> <b>Website:</b> <?php echo $website; ?></li><?php } ?>
						<?php if($address){ ?><li><i class="fas fa-map-marker-alt"></i> <b>Address:</b> <?php echo $address['address']; ?></li><?php } ?>
					</ul>
					<?php if($address && $apiKey){ ?><img src="https://maps.googleapis.com/maps/api/staticmap?zoom=13&size=385x190&maptype=roadmap&markers=color:blue%7Clabel:S%7C<?php echo $address['lat'] ?>,<?php echo $address['lng'] ?>&key=<?php echo $apiKey; ?>" alt="" /><?php } ?>
					<?php if($contactInfo){ ?><p><?php echo $contactInfo; ?></p><?php } ?>
				</div>
			</div>
			<div class="col-lg-8 col-md-8 col-12">
				<h3>Description</h3>
				<?php the_field('description'); ?>
			</div>
		</div>
	</div>
</div>

<?php 

endwhile;

get_footer();

?>