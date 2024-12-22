<?php global $wpalchemy_media_access; ?>
<div class="acf_postbox">
	<?php
	global $q_config;
	$enabled_languages = $q_config['enabled_languages'];
	if ( $enabled_languages ) { ?>
			<label>Select Region</label>
			<p class="field">
					<?php
						$language_name = $q_config['language_name'];
						foreach ( $enabled_languages as $key => $value ) {
							$mb->the_field( 'lang', WPALCHEMY_FIELD_HINT_CHECKBOX_MULTI ); ?>
							<input type="checkbox" name="<?php $mb->the_name(); ?>" value="<?php echo $value ?>" <?php $mb->the_checkbox_state( $value ); ?>/>
							<?php echo $language_name[$enabled_languages[$key]]; ?> <br/>
					<?php } ?>
			</p>
	<?php } ?>

	<label>Store Locator</label>

	<p class="field">
		<?php
			$args = array(
				'post_type'				=> array( 'store-locator' ),
				'posts_per_page'	=> -1
			);
			$the_query = new WP_Query( $args );
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$mb->the_field( 'loc', WPALCHEMY_FIELD_HINT_CHECKBOX_MULTI ); ?>
				<input type="checkbox" name="<?php $mb->the_name(); ?>" value="<?php echo get_the_title(); ?>"
					<?php
						if ( $metabox->get_the_value() ) {
							$mb->the_checkbox_state( get_the_title() );
						} elseif ( is_null( $metabox->get_the_value() ) ) {
							echo 'checked';
						} else {
							$mb->the_checkbox_state( get_the_title() );
						}
					?>
				/>
				<?php the_title(); ?><br /><?php
			endwhile;
			wp_reset_postdata();
		?>
	</p>

	<label>Product Selector</label><br><br>
	<em>Primary</em>
	<p class="field">
		<?php
			$args= array(
				'post_type'				=> array( 'product-selector' ),
				'posts_per_page'	=> -1,
				'orderby'					=> 'title',
				'order'						=> 'asc'
			) ;
			$the_query = new WP_Query( $args );
			 while ( $the_query->have_posts() ) : $the_query->the_post();
					$mb->the_field( 'product_selector', WPALCHEMY_FIELD_HINT_CHECKBOX_MULTI ); ?>
					<div style="width: 10%;float: left;">
						<input type="checkbox" name="<?php $mb->the_name(); ?>" value="<?php echo get_the_ID(); ?>" <?php $mb->the_checkbox_state( get_the_ID() ); ?>/>
						<?php the_title(); ?><br />
					</div>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	</p>
	<div style="clear:both"></div><br>
	<em>Optional</em>
			<p class="field">
			<?php
			$args = array(
			'type'                     => 'post',
			'child_of'                 => 8,
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 0,
			'hierarchical'             => 1,
			'taxonomy'                 => 'product-categories',
			'pad_counts'               => false
			);
			$categories = get_categories($args);
				foreach ($categories as $cat) {
					if($cat->parent!=8){
						$mb->the_field( '_product_selector_optional', WPALCHEMY_FIELD_HINT_CHECKBOX_MULTI );
						?>
						<input type="checkbox" name="<?php $mb->the_name(); ?>" value="<?php echo $cat->term_id; ?>" <?php $mb->the_checkbox_state( $cat->term_id ); ?> >
						<?php
					}
					echo $cat->cat_name; ?> <br>
					<?php
			}
			?>
		</p>


	<label>Short Description</label>

	<p class="field">
		<?php $metabox->the_field('short_description'); ?>
		<textarea name="<?php $metabox->the_name(); ?>"><?php $metabox->the_value(); ?></textarea>
	</p>

	<label>Operating System</label>

	<p class="field">
		<?php $metabox->the_field('os'); ?>
		<select name="<?php $metabox->the_name(); ?>">
			<option value=""></option>
			<?php
				$operating_system = zenpad_get_option('os');
				$os_array = explode(', ', $operating_system);
				foreach ($os_array as $os) { ?>
					<option value="<?php echo $os; ?>" <?php echo ($metabox->get_the_value() == $os)?' selected="selected"':'' ?> >
						<?php echo $os; ?>
					</option>
			<?php }	?>
		</select>
	</p>

	<label>Memory</label>

	<p class="field">
		<?php $metabox->the_field('ram'); ?>
		<select name="<?php $metabox->the_name(); ?>">
			<option value=""></option>
			<?php
				$memory = zenpad_get_option('ram');
				$ram_array = explode(', ', $memory);
				foreach ($ram_array as $ram) { ?>
					<option value="<?php echo $ram; ?>" <?php echo ($metabox->get_the_value() == $ram)?' selected="selected"':'' ?> >
						<?php echo $ram; ?>
					</option>
			<?php }	?>
		</select>
	</p>

	<label>Storage</label>

	<p class="field">
		<?php $metabox->the_field('storage'); ?>
		<select name="<?php $metabox->the_name(); ?>">
			<option value=""></option>
			<?php
				$storage = zenpad_get_option('storage');
				$sg_array = explode(', ', $storage);
				foreach ($sg_array as $sg) { ?>
					<option value="<?php echo $sg; ?>" <?php echo ($metabox->get_the_value() == $sg)?' selected="selected"':'' ?> >
						<?php echo $sg; ?>
					</option>
			<?php }	?>
		</select>
	</p>

	<label>Screen Size</label>

	<p class="field">
		<?php $metabox->the_field('screen_size'); ?>
		<select name="<?php $metabox->the_name(); ?>">
			<option value=""></option>
			<?php
				$screen_size = zenpad_get_option('screen-size');
				$ss_array = explode(', ', $screen_size);
				foreach ($ss_array as $ss) { ?>
					<option value="<?php echo $ss; ?>" <?php echo ($metabox->get_the_value() == $ss)?' selected="selected"':'' ?> >
						<?php echo $ss; ?>
					</option>
			<?php }	?>
		</select>
	</p>

	<label>Connectivity</label>

	<p class="field">
		<?php $metabox->the_field('connectivity'); ?>
		<select name="<?php $metabox->the_name(); ?>">
			<option value=""></option>
			<?php
				$connectivity = zenpad_get_option('connectivity');
				$cn_array = explode(', ', $connectivity);
				foreach ($cn_array as $cn) { ?>
					<option value="<?php echo $cn; ?>" <?php echo ($metabox->get_the_value() == $cn)?' selected="selected"':'' ?> >
						<?php echo $cn; ?>
					</option>
			<?php }	?>
		</select>
	</p>

	<label>Customization</label>

	<p class="field">

		<?php $metabox->the_field('customization'); ?>
		<select name="<?php $metabox->the_name(); ?>">
			<option value=""></option>
			<?php
				$customization = zenpad_get_option('customization');
				$cz_array = explode(', ', $customization);
				foreach ($cz_array as $cz) { ?>
					<option value="<?php echo $cz; ?>" <?php echo ($metabox->get_the_value() == $cz)?' selected="selected"':'' ?> >
						<?php echo $cz; ?>
					</option>
			<?php }	?>
		</select>
	</p>

	<label>Performance</label>

	<p class="field">

		<?php $metabox->the_field('performance'); ?>
		<select name="<?php $metabox->the_name(); ?>">
			<option value=""></option>
			<?php
				$performance = zenpad_get_option('performance');
				$pf_array = explode(', ', $performance);
				foreach ($pf_array as $pf) { ?>
					<option value="<?php echo html_entity_decode($pf, ENT_NOQUOTES, 'UTF-8'); ?>" <?php echo ( html_entity_decode($metabox->get_the_value(), ENT_NOQUOTES, 'UTF-8') == html_entity_decode($pf, ENT_NOQUOTES, 'UTF-8') )?' selected="selected"':'' ?> >
						<?php echo $pf; ?>
					</option>
			<?php }	?>
		</select>
	</p>

	<label>Content Consumption</label>

	<p class="field">

		<?php $metabox->the_field('content_consumption'); ?>
		<select name="<?php $metabox->the_name(); ?>">
			<option value=""></option>
			<?php
				$content_consumption = zenpad_get_option('content-consumption');
				$cc_array = explode(', ', $content_consumption);
				foreach ($cc_array as $cc) { ?>
					<option value="<?php echo $cc; ?>" <?php echo ($metabox->get_the_value() == $cc)?' selected="selected"':'' ?> >
						<?php echo $cc; ?>
					</option>
			<?php }	?>
		</select>
	</p>

	<label>Mobility</label>

	<p class="field">

		<?php $metabox->the_field('mobility'); ?>
		<select name="<?php $metabox->the_name(); ?>">
			<option value=""></option>
			<?php
				$mobility = zenpad_get_option('mobility');
				$mb_array = explode(', ', $mobility);
				foreach ($mb_array as $mob) { ?>
					<option value="<?php echo $mob; ?>" <?php echo ($metabox->get_the_value() == $mob)?' selected="selected"':'' ?> >
						<?php echo $mob; ?>
					</option>
			<?php }	?>
		</select>
	</p>

	<label>Battery</label>

	<p class="field">

		<?php $metabox->the_field('battery'); ?>
		<select name="<?php $metabox->the_name(); ?>">
			<option value=""></option>
			<?php
				$battery = zenpad_get_option('battery');
				$bt_array = explode(', ', $battery);
				foreach ($bt_array as $bt) { ?>
					<option value="<?php echo $bt; ?>" <?php echo ($metabox->get_the_value() == $bt)?' selected="selected"':'' ?> >
						<?php echo $bt; ?>
					</option>
			<?php }	?>
		</select>
	</p>

	<label>Weight</label>

	<p class="field">

		<?php $metabox->the_field('weight'); ?>
		<select name="<?php $metabox->the_name(); ?>">
			<option value=""></option>
			<?php
				$weight = zenpad_get_option('weight');
				$we_array = explode(', ', $weight);
				foreach ($we_array as $we) { ?>
					<option value="<?php echo $we; ?>" <?php echo ($metabox->get_the_value() == $we)?' selected="selected"':'' ?> >
						<?php echo $we; ?>
					</option>
			<?php }	?>
		</select>
	</p>

	<label>Dimensions</label>

	<p class="field">

		<?php $metabox->the_field('dimensions'); ?>
		<select name="<?php $metabox->the_name(); ?>">
			<option value=""></option>
			<?php
				$dimensions = zenpad_get_option('dimensions');
				$dim_array = explode(', ', $dimensions);
				foreach ($dim_array as $dim) { ?>
					<option value="<?php echo $dim; ?>" <?php echo ($metabox->get_the_value() == $dim)?' selected="selected"':'' ?> >
						<?php echo $dim; ?>
					</option>
			<?php }	?>
		</select>
	</p>

	<label>Colour</label>

	<p class="field">

		<?php $metabox->the_field('colour'); ?>
		<select name="<?php $metabox->the_name(); ?>">
			<option value=""></option>
			<?php
				$colour = zenpad_get_option('colour');
				$cl_array = explode(', ', $colour);
				foreach ($cl_array as $cl) { ?>
					<option value="<?php echo $cl; ?>" <?php echo ($metabox->get_the_value() == $cl)?' selected="selected"':'' ?> >
						<?php echo $cl; ?>
					</option>
			<?php }	?>
		</select>
	</p>

	<label>Product Detail URL</label>

	<p class="field">
		<?php $metabox->the_field('product_url'); ?>
		<input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
	</p>

	<label>Buy Now URL</label>

	<p class="field">
		<?php $metabox->the_field('buy_url'); ?>
		<input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
	</p>

	<label>Product Video</label>

	<?php $metabox->the_field('product_video'); ?>
  <?php $wpalchemy_media_access->setGroupName('pv')->setInsertButtonLabel('Add Video')->setTab('gallery'); ?>

  <p class="field">
      <?php echo $wpalchemy_media_access->getField(array('name' => $metabox->get_the_name(), 'value' => $metabox->get_the_value())); ?>
      <?php echo $wpalchemy_media_access->getButton( array( 'label' => 'Add Video' )); ?>
  </p>

	<label>Product List</label>

	<p class="field">
		<?php $metabox->the_field( 'product_list' ); ?>
		<input type="checkbox" name="<?php $metabox->the_name(); ?>" value="yes" <?php $metabox->the_checkbox_state('yes') ?> />Show on Product List
	</p>

	<label>Product Result</label>

	<p class="field">
		<?php $metabox->the_field( 'product_result' ); ?>
		<input type="checkbox" name="<?php $metabox->the_name(); ?>" value="yes" <?php $metabox->the_checkbox_state('yes') ?> />Don't Show on Product Result
	</p>

</div>
