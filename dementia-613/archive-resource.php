<?php 

get_header();

global $wp_query;

$categories = get_terms('category',array('hide_empty'=>true));
$types = get_terms('type',array('hide_empty'=>false));
$perPage = $wp_query -> query_vars['posts_per_page'];
$total = $wp_query -> found_posts;
$page = $wp_query -> query_vars['paged'] ? $wp_query -> query_vars['paged'] : 0;
$from = $page ? ($page * $perPage) - ($perPage - 1) : 1;
$to = ($from + $perPage) - $perPage < $total ? ($from + $perPage) - ($perPage -1) : $total;

//params
$catParams = isset($_GET['category']) ? explode(',',$_GET['category']) : null;
$typeParams = isset($_GET['types']) ? explode(',',$_GET['types']) : null;
$locationParams = isset($_GET['neighbourhood']) ? $_GET['neighbourhood'] : null;

?>

<div class="container content">
	<div class="row">
		<div class="col-lg-8 col-12">
			<h1>Dementia-friendly Resources</h1>
			<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live </p>
		</div>
		<div class="col-12">
			<ul>
				<li>Viewing <?php echo $from ?> to <?php echo $to ?> of <?php echo $total; ?> Resources</li>
				<li></li>
			</ul>
			<strong>Filter Results</strong>
		</div>
	</div>
</div>

<div class="results">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-12 col-12">
				<form action="<?php echo get_post_type_archive_link('resource'); ?>" method="GET" onsubmit="return resourcePage(this)" novalidate>
					<?php if(count($categories) > 0){ ?>
					<strong>Categories</strong>
					<ul>
						<?php foreach($categories as $category){ ?>
						<li><input id="category-<?php echo $category -> term_id; ?>" name="category" type="checkbox" value="<?php echo $category -> term_id; ?>" <?php if($catParams && in_array($category -> term_id,$catParams) || !$catParams){ echo 'checked'; } ?> /><label for="category-<?php echo $category -> term_id; ?>"><?php echo $category -> name; ?></label></li>
						<?php } ?>
					</ul>
					<?php 

					}

					if(count($types) > 0){ ?>
					<strong>Resource Types</strong>
					<ul>
						<?php foreach($types as $type){ ?>
						<li><input id="type-<?php echo $type -> term_id; ?>" name="types" type="checkbox" value="<?php echo $type -> term_id; ?>" <?php if($typeParams && in_array($type -> term_id,$typeParams) || !$typeParams){ echo 'checked'; } ?> /><label for="type-<?php echo $type -> term_id; ?>"><?php echo $type -> name; ?></label></li>
						<?php } ?>
					</ul>
					<?php } ?>
					<strong>Neighbourhood</strong>
					<input name="neighbourhood" type="text" placeholder="eg. Kanata" autocomplete="off" />
					<button>Submit</button>
				</form>
			</div>
			<div class="col-lg-9 col-md-12 col-12">
				<?php 

				while(have_posts()):
    				the_post(); 

    				$categories = wp_get_post_terms($post -> ID,'category');
    				$location = wp_get_post_terms($post -> ID,'location');
    				$cost = wp_get_post_terms($post -> ID,'cost');
    				$files = wp_get_post_terms($post -> ID,'files');
    				$address = get_field('address');

    			?>
    			<div class="resource-item" <?php if(isset($address['lat']) && $address['lng']){ ?>data-lat="<?php echo $address['lat'] ?>" data-lng="<?php echo $address['lng'] ?>"<?php } ?>>
    				<?php if(is_array($categories) && count($categories) > 0){ 
    					$color = get_field('color',$categories[0] -> taxonomy.'_'.$categories[0] -> term_id);

    					if(!$color){
    						$color = '#000';
    					}
    				?>
					<ul>
						<li><span style="background:<?php echo $color; ?>;"><?php echo $categories[0] -> name ?></span></li>
					</ul>
					<?php } ?>
    				<h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
    				<p><?php if(count($location) > 0){ ?><span><i class="fas fa-map-marker-alt"></i> <?php echo $location[0] -> name; ?></span><?php } ?><?php if(count($cost) > 0){ ?><span><?php echo $cost[0] -> name; ?></span><?php } ?></p>
    				<p><?php the_field('excerpt'); ?></p>
    				<a href="<?php echo get_permalink(); ?>"></a>
    				<?php if(is_array($files) && count($files) > 0){ ?><small><?php echo $files[0] -> name; ?></small><?php  } ?>
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