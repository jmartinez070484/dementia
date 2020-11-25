<?php 

$categories = get_terms('resource-category',array('hide_empty'=>false));

?><form name="add-resource" action="<?php echo admin_url('admin-ajax.php') ?>" onsubmit="return submitForm(this)" autocomplete="off" method="POST" novalidate>
	<fieldset>
		<strong>Your Contact Information</strong>
	</fieldset>
	<fieldset>
		<label for="name">Your Name*</label>
		<input id="name" name="name" type="text" value="" required />
	</fieldset>
	<fieldset>
		<label for="email">Your Email Address*</label>
		<input id="email" name="email" type="email" value="" required />
	</fieldset>
	<fieldset>
		<label for="phone">Your Phone</label>
		<input id="phone" name="phone" type="text" value="" />
	</fieldset>
	<hr />
	<fieldset>
		<strong>Resource Category</strong>
		<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live</p>
	</fieldset>
	<fieldset>
		<span>Category *</span>
		<?php foreach($categories as $category){ ?>
		<input id="category-<?php echo $category -> term_id ?>" type="radio" name="category[]" value="<?php echo $category -> term_id ?>" required />
		<label for="category-<?php echo $category -> term_id ?>"><?php echo $category -> name ?></label>
		<?php } ?>
	</fieldset>
	<hr />
	<fieldset>
		<strong>Resource Details</strong>
	</fieldset>
	<fieldset>
		<label for="resource">Name of your resource *</label>
		<input id="resource" name="name" type="text" value="" placeholder="E.g., Meals on Wheels, Seniors Craft Workshop etc." required />
	</fieldset>
	<fieldset>
		<label for="description">Description*</label>
		<small>Provide a brief description of your resource and its benefits in 240 characters or less. Include your hours of operation.</small>
		<textarea id="description" name="description" required></textarea>
	</fieldset>
	<hr />
	<fieldset>
		<strong>Resource Location</strong>
	</fieldset>
	<fieldset>
		<label for="resource">Name of your resource *</label>
		<input id="resource" name="name" type="text" value="" placeholder="E.g., Meals on Wheels, Seniors Craft Workshop etc." required />
	</fieldset>
	<fieldset>
		<span>Resource in online only *</span>
		<input id="online-yes" type="radio" name="online" value="1" required />
		<label for="online-yes">Yes</label>
		<input id="online-no" type="radio" name="online" value="0" required />
		<label for="online-no">No</label>
	</fieldset>
	<fieldset>
		<label for="org_name">Name of Company / Organization *</label>
		<input id="org_name" name="org_name" type="text" value="" required />
	</fieldset>
	<fieldset>
		<label for="street_1">Street Address 1 *</label>
		<input id="street_1" name="street_1" type="text" value="" required />
	</fieldset>
	<fieldset>
		<label for="street_2">Street Address 2 *</label>
		<input id="street_2" name="street_2" type="text" value="" required />
	</fieldset>
	<fieldset>
		<label for="neighbourhood">Neighbourhood *</label>
		<input id="neighbourhood" name="neighbourhood" type="text" value="" required />
	</fieldset>
	<fieldset>
		<label for="postal_code">Postal Code *</label>
		<input id="postal_code" name="postal_code" type="text" value="" required />
	</fieldset>
	<fieldset>
		<label for="website_url">Website URL</label>
		<input id="website_url" name="website_url" type="text" value="" placeholder="e.g., https:yourwebsite.com" />
	</fieldset>
	<fieldset>
		<input name="action" type="hidden" value="process_resource" />
		<button>Submit</button>
	</fieldset>
</form>	