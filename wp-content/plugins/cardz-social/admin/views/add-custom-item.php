<?php
/**
 *	Add custom feed item view.
 *
 *	Available variables:
 *      $post_id        The ID of the post being edited.
 */
?>
<form class="add-custom-item-form">
    <input type="hidden" name="action" value="ss-add-new-feed" />
    <input type="hidden" name="id_post" value="<?php echo $post_id; ?>" />
    
    <p class="hide-if-no-js ss-upload ss-align-center">
		<a href="#" class="ss-upload-file" id="ss_attachment" data-title="<?php _e('Select post image'); ?>" data-button="<?php _e('Set featured image'); ?>">
			<?php if (!empty($value)) : ?><br />
				<img src="<?php echo $value; ?>" width="266" height="177" />
			<?php else : ?>
				<?php _e('Set post image'); ?>
			<?php endif; ?>
		</a><br />
		<a href="#" class="ss-upload-remove-file"<?php echo (empty($value)) ? ' style="display: none"' : ''; ?>><?php _e('Remove post image'); ?></a>
		<input type="hidden" name="attachment" id="attachment" class="ss-upload-file-input" value="<?php echo $value; ?>" />
	</p>
    <p>
        <label for="message"><?php _e('Message', 'cardz-social'); ?></label>
        <textarea name="message" placeholder="<?php _e('Post content', 'cardz-social'); ?>">
        </textarea>
    </p>
    <p>
        <label><?php _e('Link', 'cardz-social'); ?></label>
        <input type="text" class="regular-text" name="link" placeholder="<?php _e('Post link (optional)', 'cardz-social'); ?>" />
    </p>
<!--    <p>
        <label><?php _e('Video URL', 'cardz-social'); ?></label>
        <input type="text" class="regular-text" name="video_source" />
    </p>-->
    <p>
        <label><?php _e('Author Name', 'cardz-social'); ?></label>
        <input type="text" class="regular-text" name="author_name" placeholder="<?php _e('Author Name (optional)', 'cardz-social'); ?>" />
    </p>
    <!--<p>
        <label><?php _e('Author Picture URL', 'cardz-social'); ?></label>
        <input type="text" class="regular-text" name="author_picture" placeholder="<?php _e('Author image URL (optional)', 'cardz-social'); ?>" />
    </p>-->
    <p class="hide-if-no-js ss-upload ss-align-center author-picture">
		<a href="#" class="ss-upload-file" id="ss_author_picture" data-title="<?php _e('Select post image'); ?>" data-button="<?php _e('Set featured image'); ?>">
			<?php if (!empty($value)) : ?><br />
				<img src="<?php echo $value; ?>" width="80" height="80" />
			<?php else : ?>
				<?php _e('Set post image'); ?>
			<?php endif; ?>
		</a><br />
		<a href="#" class="ss-upload-remove-file"<?php echo (empty($value)) ? ' style="display: none"' : ''; ?>><?php _e('Remove post image'); ?></a>
		<input type="hidden" name="author_picture" id="author-picture" class="ss-upload-file-input" value="<?php echo $value; ?>" />
	</p>
<!--    <p>
        <label><?php _e('Author Link', 'cardz-social'); ?></label>
        <input type="text" class="regular-text" name="author_link" />
    </p>-->
    <p>
        <label><?php _e('Iteration', 'cardz-social'); ?></label>
        <input type="text" class="regular-text" name="iteration" placeholder="<?php _e('Number of repetitions (optional)', 'cardz-social'); ?>" />
    </p>
    <p>
        <label><?php _e('Position', 'cardz-social'); ?></label>
        <input type="text" class="regular-text" name="position" placeholder="<?php _e('Position of the post (optional)', 'cardz-social'); ?>" />
    </p>
</form>
<div class="bottom-bar">
	<div class="buttons">
		<a href="#" class="ss-button ss-cancel"><?php _e('Cancel', 'cardz-social'); ?></a>
		<a href="#" class="ss-button ss-submit" data-form="add-custom-item-form"><?php _e('Add', 'cardz-social'); ?></a>
	</div>
</div>