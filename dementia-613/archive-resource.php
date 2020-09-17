<?php 

get_header();

$categories = get_terms('resource-category',array('hide_empty'=>false));
$types = get_terms('resource-type',array('hide_empty'=>false));

?>

<div class="container content">
	<div class="row">
		<div class="col-lg-8 col-12">
			<h1>Dementia-friendly Resources</h1>
			<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live </p>
		</div>
		<div class="col-12">
			<ul>
				<li>Viewing 1 to 10 of 52 Resources</li>
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
				<?php if(count($categories) > 0){ ?>
				<strong>Categories</strong>
				<ul>
					<?php foreach($categories as $category){ ?>
					<li><input id="category-<?php echo $category -> term_id; ?>" name="resource-category[]" type="checkbox" value="<?php echo $category -> term_id; ?>" /><label for="category-<?php echo $category -> term_id; ?>"><?php echo $category -> name; ?></label></li>
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
			</div>
			<div class="col-lg-9 col-md-8 col-12">
				<?php 

				while(have_posts()):
    				the_post(); 

    				$categories = wp_get_post_terms($post -> ID,'resource-category');

    			?>
    			<div class="resource-item">
    				<?php if(count($categories) > 0){ 
    					$color = get_field('color',$categories[0] -> taxonomy.'_'.$categories[0] -> term_id);
    				?>
					<ul>
						<li><span <?php if($color){ ?>style="background:<?php echo $color; ?>;"<?php } ?>><?php echo $categories[0] -> name ?></span></li>
					</ul>
					<?php } ?>
    				<h2><?php the_title(); ?></h2>
    				<p><?php the_field('excerpt'); ?></p>
    			</div>
    			<?php endwhile; ?>
			</div>
		</div>
	</div>
</div>

<?php 

get_footer();

?>