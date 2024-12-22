<?php
/**
 *	Support page view.
 *
 *  Available variables:
 *      $options    - An associative array with the available values.
 */
?>
<div class="wrap">
    <h2><?php _e('Request Support', 'cardz-social'); ?></h2>
    <?php if (!empty($ss_response)) : ?>
        <div class="ss-info-nag"><?php _e('Message sent successfully.', 'cardz-social'); ?></div>
    <?php endif; ?>
    <form action="" method="post">
        <input type="hidden" name="ss-page-name" value="<?php echo SS_Pg_Support::PAGE_NAME; ?>" />
        <table class="ss-settings-table wp-list-table widefat fixed" cellspacing="0">
            <thead>
                <tr>
                    <th class="manage-column column-cb" width="200"><?php _e('Caption', 'cardz-social'); ?></th>
                    <th class="manage-column column-cb"><?php _e('Value', 'cardz-social'); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2"><h3><?php _e('Ask for support', 'cardz-social'); ?></h3></td>
                </tr>
                <tr>
                    <td><label for="ss-support-type"><?php _e('Request type', 'cardz-social'); ?></label></td>
                    <td>
                        <select name="ss-support-type" id="ss-support-type">
                            <option value="bug-report"><?php _e('Submit a Bug Report', 'cardz-social'); ?></option>
                            <option value="new-feature"><?php _e('Suggest a New Feature', 'cardz-social'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="ss-support-name"><?php _e('Name', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-support-name" id="ss-support-name" value="" /></td>
                </tr>
                <tr>
                    <td><label for="ss-support-email"><?php _e('E-Mail', 'cardz-social'); ?></label></td>
                    <td><input type="email" class="regular-text" required="required" name="ss-support-email" id="ss-support-email" value="<?php echo get_option('admin_email'); ?>" /></td>
                </tr>
                <tr>
                    <td><label for="ss-support-website"><?php _e('Website URL', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" required="required" name="ss-support-website" id="ss-support-website" value="<?php echo home_url(); ?>" /></td>
                </tr>
                <tr>
                    <td><label for="ss-support-title"><?php _e('Title', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-support-title" id="ss-support-title" value="" /></td>
                </tr>
                <tr>
                    <td><label for="ss-support-issue"><?php _e('Issue description', 'cardz-social'); ?></label></td>
                    <td><textarea class="regular-text" required="required" name="ss-support-issue" id="ss-support-issue" style="width: 25em; min-height: 200px"></textarea></td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Submit Request', 'cardz-social'); ?>">
        </p>
    </form>
</div>