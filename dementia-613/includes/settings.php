<?php 

$tabs = ['general'=>'General','api'=>'API Keys'];
$tab = isset($_GET['tab']) && array_key_exists($_GET['tab'],$tabs) ? $_GET['tab'] : 'general';
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
			<div id="general" class="settings-tab-content <?php if($tab === 'general'){ echo 'active'; } ?>">
				<div class="fields-content">
					<div class="field-group">
						<div class="field-column col-12 input">
							<div class="field-legend">
								<span>Site Title</span>
							</div>
							<div class="field">
								<input name="blogname" type="text" value="<?php echo get_option('blogname'); ?>" autocomplete="off">
							</div>
						</div>
						<div class="field-column col-12 input">
							<div class="field-legend">
								<span>Site Tagline</span>
							</div>
							<div class="field">
								<input name="blogdescription" type="text" value="<?php echo get_option('blogdescription'); ?>" />
							</div>
						</div>				
					</div>
					<div class="field-group">
						<div class="field-column col-2 image">
							<div class="field-legend">
								<span>Logo</span>
							</div>
							<?php 

							$siteLogoId = get_option('site_logo');
							$siteLogo = $siteLogoId ? wp_get_attachment_image_src($siteLogoId,'full') : null;

							?>
							<div class="field">
								<div class="placeholder <?php if($siteLogo){ ?>has-image<?php } ?>">
									<i class="fa fa-times" onclick="removeImage(this)"></i>
									<span <?php if($siteLogo){ ?>style="background:url('<?php echo $siteLogo[0]; ?>') no-repeat center center/contain;"<?php } ?> onclick="return selectImage(this)"></span>
									<input name="site_logo" type="hidden" value="<?php echo $siteLogoId; ?>">
								</div>
							</div>
						</div>
						<div class="field-column col-2 image">
							<div class="field-legend">
								<span>Footer Logo</span>
							</div>
							<?php 

							$footerLogoId = get_option('footer_logo');
							$footerLogo = $footerLogoId ? wp_get_attachment_image_src($footerLogoId,'full') : null;

							?>
							<div class="field">
								<div class="placeholder <?php if($footerLogo){ ?>has-image<?php } ?>">
									<i class="fa fa-times" onclick="removeImage(this)"></i>
									<span <?php if($footerLogo){ ?>style="background:url('<?php echo $footerLogo[0]; ?>') no-repeat center center/contain;"<?php } ?> onclick="return selectImage(this)"></span>
									<input name="footer_logo" type="hidden" value="<?php echo $footerLogoId; ?>">
								</div>
							</div>
						</div>
						<div class="field-column col-2 image">
							<div class="field-legend">
								<span>Header Image</span>
							</div>
							<?php 

							$headerImageId = get_option('header_image');
							$headerImage = $headerImageId ? wp_get_attachment_image_src($headerImageId,'full') : null;

							?>
							<div class="field">
								<div class="placeholder <?php if($headerImage){ ?>has-image<?php } ?>">
									<i class="fa fa-times" onclick="removeImage(this)"></i>
									<span <?php if($headerImage){ ?>style="background:url('<?php echo $headerImage[0]; ?>') no-repeat center center/contain;"<?php } ?> onclick="return selectImage(this)"></span>
									<input name="header_image" type="hidden" value="<?php echo $headerImageId; ?>">
								</div>
							</div>
						</div>					
					</div>
				</div>
			</div>
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

<?php wp_enqueue_media(); ?>