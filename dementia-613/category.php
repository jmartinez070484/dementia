<?php 

get_header();

global $wp_query;

$perPage = $wp_query -> query_vars['posts_per_page'];
$total = $wp_query -> found_posts;
$page = $wp_query -> query_vars['paged'] ? $wp_query -> query_vars['paged'] : 0;
$from = $page ? ($page * $perPage) - ($perPage - 1) : 1;
$to = ($from + $perPage) - $perPage < $total ? ($from + $perPage) - ($perPage -1) : $total;
$category = get_category(get_query_var('cat'),false);

?>

<div class="container content">
	<div class="row">
		<div class="col-lg-8 col-12">
			<h1><?php echo $category -> name; ?></h1>
			<p><?php echo $category -> description; ?></p>
		</div>
		<div class="col-12">
			<ul>
				<li>Viewing <?php echo $from ?> to <?php echo $to ?> of <?php echo $total; ?> Resources</li>
				<li></li>
			</ul>
		</div>
	</div>
</div>

<div class="results">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php 

				while(have_posts()):
    				the_post(); 

    				$location = wp_get_post_terms($post -> ID,'location');
    				$address = get_field('address');

    			?>
    			<div class="resource" <?php if(isset($address['lat']) && $address['lng']){ ?>data-lat="<?php echo $address['lat'] ?>" data-lng="<?php echo $address['lng'] ?>"<?php } ?>>
    				<h2><?php echo $post -> post_title; ?></h2>
					<p><?php if(count($location) > 0){ ?><span><i class="fas fa-map-marker-alt"></i> <?php echo $location[0] -> name; ?></span><?php } ?></p>
					<p><?php the_field('excerpt',$value -> ID); ?></p>
	    			<a href="<?php echo get_permalink($value -> ID); ?>"><i class="fas fa-arrow-right"></i></a>
    			</div>
    			<?php endwhile; ?>
    			<div class="pagination">
    				<?php the_posts_pagination(array('screen_reader_text'=>'','mid_size'=>2,'prev_text'=>'','next_text'=>'')); ?>
    			</div>
			</div>
		</div>
	</div>
</div>

<?php if(have_posts()){ ?>
<div class="map">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="g-map">

				</div>
				<div class="locations">
					<div class="title">
						<strong>Locations</strong>
					</div>
					<?php 

					$count = 0;

					while(have_posts()):
	    				the_post(); 

	    				$address = get_field('address');
	    				$phone = get_field('phone');
	    				$email = get_field('email');
	    				$count++;
	    			?>
	    			<div class="location">
	    				<span><?php echo $count; ?></span>
	    				<h3><?php the_title(); ?></h3>
	    				<p><?php echo $address['address'] ?></p>
	    				<p><a href="tel:<?php echo $phone ?>"><?php echo $phone ?></a><br /><a href="email:<?php echo $email ?>">Visit Website</a></p>
	    			</div>
	    			<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php } ?>

<?php 

get_footer();

?>