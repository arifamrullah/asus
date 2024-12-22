<?php
/**
 *	Editor properties panel.
 *
 *	Available variables:
 *      $post_id        The ID of the post being edited.
 *		$menu_id		The ID of the menu being edited.
 *		$post			The custom post.
 */
 
$frame_link = admin_url('admin-ajax.php?action=ss-load-view&view=canvas&menu_id=' . $menu_id)
?>

<div class="ss-editor-holder" data-post-id="<?php echo $post_id; ?>">
	<div class="ss-editor-left-panel" data-menu-id="<?php echo $menu_id; ?>">
		<div class="ss-editor-properties">
			<div class="ss-toolbar">
				<!--<a href="#" class="preview-bs ss-button"><?php _e('Preview', 'bubble-share'); ?></a>-->
				<a href="#" class="save-ss save-bs ss-button"><?php _e('Save Stream', 'bubble-share'); ?></a>
			</div>
			<div class="sp-editor-groups-holder">
				<?php CardZStream()->admin->editor->display($post); ?>
			</div>
		</div>
		<div class="ss-editor-elements">
			<a href="#" class="ss-editor-element apply-content"></a>
			<a href="#" class="ss-editor-element"></a>
			<a href="#" class="ss-editor-element"></a>
		</div>

	</div>
	<div class="ss-editor-right-panel">
		<iframe id="ss-preview" src="<?php echo $frame_link; ?>"></iframe>
		<div class="ss-editor-content-editor">
            <span class="ss-editor-highlight">
                <span class="ss-editor-highlight-info"></span>
            </span>
            <span class="ss-editor-selection">
                <span class="ss-editor-selection-toolbar">Edit Properties</span>
                <span class="ss-editor-selection-padding"></span>
            </span>
        </div>
	</div>
</div>