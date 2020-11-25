<?php 

get_header();

global $wp_query;

$categories = get_terms('resource-category',array('hide_empty'=>false));
$types = get_terms('resource-type',array('hide_empty'=>false));
$perPage = $wp_query -> query_vars['posts_per_page'];
$total = $wp_query -> found_posts;
$page = $wp_query -> query_vars['paged'] ? $wp_query -> query_vars['paged'] : 0;
$from = $page ? ($page * $perPage) - ($perPage - 1) : 1;
$to = ($from + $perPage) - $perPage < $total ? ($from + $perPage) - ($perPage -1) : $total;

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
				<li>See Map View</li>
			</ul>
			<strong>Filter Results</strong>
		</div>
	</div>
</div>

<div class="results">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-4 col-12">
				<form action="<?php echo get_post_type_archive_link('resource'); ?>" method="GET" novalidate>
					<?php if(count($categories) > 0){ ?>
					<strong>Categories</strong>
					<ul>
						<?php foreach($categories as $category){ ?>
						<li><input id="category-<?php echo $category -> term_id; ?>" name="resource-category" type="checkbox" value="<?php echo $category -> term_id; ?>" /><label for="category-<?php echo $category -> term_id; ?>"><?php echo $category -> name; ?></label></li>
						<?php } ?>
					</ul>
					<?php 

					}

					if(count($types) > 0){ ?>
					<strong>Resource Types</strong>
					<ul>
						<?php foreach($types as $type){ ?>
						<li><input id="type-<?php echo $type -> term_id; ?>" name="resource-type[]" type="checkbox" value="<?php echo $type -> term_id; ?>" /><label for="type-<?php echo $type -> term_id; ?>"><?php echo $type -> name; ?></label></li>
						<?php } ?>
					</ul>
					<?php } ?>
					<strong>Neighbourhood</strong>
					<input name="location" type="text" placeholder="eg. Kanata" autocomplete="off" />
					<button>Submit</button>
				</form>
			</div>
			<div class="col-lg-9 col-md-8 col-12">
				<?php 

				while(have_posts()):
    				the_post(); 

    				$categories = wp_get_post_terms($post -> ID,'resource-category');
    				$location = wp_get_post_terms($post -> ID,'location');
    				$cost = wp_get_post_terms($post -> ID,'cost');

    			?>
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
    				<h2><?php the_title(); ?></h2>
    				<p><?php if(count($location) > 0){ ?><span><i class="fas fa-map-marker-alt"></i> <?php echo $location[0] -> name; ?></span><?php } ?><?php if(count($cost) > 0){ ?><span><?php echo $cost[0] -> name; ?></span><?php } ?></p>
    				<p><?php the_field('excerpt'); ?></p>
    				<a href="<?php echo get_permalink(); ?>"><i class="fas fa-arrow-right"></i></a>
    			</div>
    			<?php endwhile; ?>
    			<div class="pagination">
    				<?php the_posts_pagination(array('screen_reader_text'=>'','mid_size'=>2,'prev_text'=>'','next_text'=>'')); ?>
    			</div>
			</div>
		</div>
	</div>
</div>

<?php 

get_footer();

?>