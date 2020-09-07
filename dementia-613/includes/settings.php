<?php 

$tabs = ['api'=>'API Keys'];
$tab = isset($_GET['tab']) && array_key_exists($_GET['tab'],$tabs) ? $_GET['tab'] : 'api';
$adminUrl = admin_url('admin.php?page=settings');

?>
<div class="settings">
	<div class="settings-title">
		<h1>Theme Settings</h1>
	</div>
	<div class="settings-tabs">
		<ul>
			<?php foreach($tabs as $key => $value){ ?>
			<li<?php if($tab === $key){ ?> class="active"<?php } ?>><a href="<?php echo $adminUrl; ?>&tab=<?php echo $key; ?>"><?php echo $value ?></a></li>
			<?php } ?>
		</ul>
	</div>
	<div class="settings-content">
		<form method="post" action="options.php"> 
			<div id="api" class="settings-tab-content <?php if($tab === 'api'){ echo 'active'; } ?>">
				<div class="fields-content">
					<div class="field-group">
						<div class="field-column col-12 input">
							<div class="field-legend">
								<span>Google Maps Key</span>
							</div>
							<div class="field">
								<input name="google_map_api" type="text" value="<?php echo get_option('google_map_api'); ?>" autocomplete="off" />
							</div>
						</div>			
					</div>
				</div>
			</div>
			<div class="settings-btn">
				<?php settings_fields('custom-options-settings');?>
    			<?php do_settings_sections('custom-options-settings');?>
	    		<?php submit_button(); ?>
			</div>
		</form>
	</div>
</div>
