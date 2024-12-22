<?php
/**
 *	Available variables:
 *		$network	An array with the available skins.
 */
 ?>
<?php // Note. We use basename so we make sure we don't allow the acces to other directory. ?>
<?php include_once(SS_PROOT . '/admin/views/networks/' . basename($network) . '.php'); ?>
<div class="bottom-bar">
	<div class="buttons">
		<a href="#" class="ss-button ss-cancel"><?php _e('Cancel', 'cardz-social'); ?></a>
		<a href="#" class="ss-button ss-submit" data-form="edit-network-form"><?php _e('Save', 'cardz-social'); ?></a>
	</div>
</div>