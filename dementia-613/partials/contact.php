<form name="contact" action="<?php echo admin_url('admin-ajax.php') ?>" onsubmit="return submitForm(this)" autocomplete="off" method="POST" novalidate>
	<fieldset>
		<label for="name">Your Name*</label>
		<input id="name" name="name" type="text" value="" required />
	</fieldset>
	<fieldset>
		<label for="email">Your Email Address*</label>
		<input id="email" name="email" type="email" value="" required />
	</fieldset>
	<fieldset>
		<label for="message">Your Message</label>
		<textarea id="message" name="message" required></textarea>
	</fieldset>
	<fieldset>
		<input name="action" type="hidden" value="process_resource" />
		<button>Submit</button>
	</fieldset>
</form>	