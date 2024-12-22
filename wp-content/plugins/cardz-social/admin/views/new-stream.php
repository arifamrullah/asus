<?php
/**
 *	New stream window content.
 *
 *	Available variables:
 *		$skins	An array with the available skins.
 */
 ?>
<form class="new-popup-form">
	<input type="hidden" name="action" value="ss-new-stream" />
	
	<div class="inputs">
		<div class="left-input">
			<label for="stream-name"><?php _e('Stream Name *', 'cardz-social'); ?></label>
			<input type="text" id="stream-name" name="stream-name" required="required" />
		</div>
		<div class="right-input">
			<label for="stream-caption"><?php _e('Stream Caption', 'cardz-social'); ?></label>
			<input type="text" id="stream-caption" name="stream-caption" />
		</div>
	</div>
	<div class="theme-holder">
		<div class="theme-list">
			<ul style="width: <?php echo (count($skins) * 170); ?>px;">
				<?php foreach ($skins as $skin) : ?>
					<li data-name="<?php echo $skin->name; ?>"<?php echo ($skin->name == 'flat') ? ' class="selected"' : ''; ?>><?php echo (isset($skin->thumb)) ? $skin->thumb : $skin->name; ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
		<input type="hidden" name="skin-name" id="skin-name" value="flat" required="required" />
	</div>
</form>
<div class="bottom-bar">
	<div class="buttons">
		<a href="#" class="ss-button ss-cancel"><?php _e('Cancel', 'cardz-social'); ?></a>
		<a href="#" class="ss-button ss-submit" data-form="new-popup-form"><?php _e('Create', 'cardz-social'); ?></a>
	</div>
</div>