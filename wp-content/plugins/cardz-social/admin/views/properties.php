<?php
/**
 *	Editor properties panel.
 *
 *	$groups	An associative array with the available groups. Each group contains the __title property
 *			which contains the title of the group, it may also contain a __stats property which specifies
 *			if the group panel should be open or not. Each group contains the elements that should be added
 *			to the panel.
 */

foreach ($this->groups as $key => $group)
{
	$stats = (isset($group['__stats']) && $group['__stats'] == 'open') ? '' : ' style="display: none;"';
	
	// Go through all fields of the current group and render them to HTML.
	foreach ($group as $field_key => $field)
	{
		// If the key starts with '__' this is a variable and not an element.
		if (strpos($field_key, '__') === 0)
		{
			continue ;
		}
		
		$value = get_post_meta($post->ID, $field_key, true);
		
		$group[$field_key] = $this->options->get_field($value, $field_key);
	}
?>
	<div class="ss-group">
		<h4 class="ss-group-header"><?php echo $group['__title']; ?></h4>
		<div class="ss-group-content"<?php echo $stats; ?>>
			<?php // Note. We use basename so we make sure we don't allow the acces to other directory. ?>
			<?php include_once(SS_PROOT . '/admin/views/properties/' . basename($key) . '.php'); ?>
		</div>
	</div>
<?php
}