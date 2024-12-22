<div class="acf_postbox">

	<label>Region</label>
	
	<p class="field">
		<?php $selected = ' selected="selected"'; ?>
		<?php $metabox->the_field('region'); ?>
		<select name="<?php $metabox->the_name(); ?>" class="select">
			<option value=""></option>
			<?php
				global $q_config;

				$enabled_languages = $q_config['enabled_languages'];
				$language_name = $q_config['language_name'];
				
				foreach($enabled_languages as $el){
					echo '<option value="'.$el.'" '.(($metabox->get_the_value()==$el)? "selected": "").'>'.$language_name[$el].'</option>';
				}
			?>
		</select>
	</p>
	
	<label>Address</label>
	
	<p class="field">
		<?php $metabox->the_field('map_address'); ?>
		<textarea name="<?php $metabox->the_name(); ?>"><?php $metabox->the_value(); ?></textarea>
	</p>
	
	<label>LongLat</label>
	 
	<p class="field">
		<div class="acf-google-map" data-id="acf-field-test" data-lat="-37.81411" data-lng="144.96328" data-zoom="14">
		<?php $metabox->the_field('map_address'); ?>
		<input type="hidden" class="input-address" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>">
		<?php $metabox->the_field('map_lng'); ?>
		<input type="hidden" class="input-lng" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>">
		<?php $metabox->the_field('map_lat'); ?>
		<input type="hidden" class="input-lat" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>">
			<div class="title">
				<div class="has-value">
					<a href="#" class="acf-sprite-remove ir" title="Clear location">Remove</a>
					<h4><?php $metabox->the_value('map_address'); ?></h4>
				</div>
				<div class="no-value">
					<a href="#" class="acf-sprite-locate ir" title="Find current location">Locate</a>
					<input type="text" placeholder="Search for address..." class="search" autocomplete="off"/>
				</div>
				<div class="canvas"></div>
			</div>
		</div>
	</p>
	
	<label>Status</label>
	
	<p class="field">
		<?php $metabox->the_field('status'); ?>
		<input type="radio" name="<?php $metabox->the_name(); ?>" value="Active"<?php echo $mb->is_value('Active')?' checked="checked"':''; ?>/> Active
		&nbsp;
		<input type="radio" name="<?php $metabox->the_name(); ?>" value="Inactive"<?php echo $mb->is_value('Inactive')?' checked="checked"':''; ?>/> Inactive
	</p>

</div>