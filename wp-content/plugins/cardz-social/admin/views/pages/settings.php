<?php
/**
 *	Settings page view.
 *
 *  Available variables:
 *      $options    - An associative array with the available values.
 */
?>
<div class="wrap">
    <h2><?php _e('General Settings', 'cardz-social'); ?></h2>
    
    <form action="" method="post">
        <input type="hidden" name="ss-page-name" value="general-settings" />
        <table class="ss-settings-table wp-list-table widefat fixed" cellspacing="0">
            <thead>
                <tr>
                    <th class="manage-column column-cb" width="200"><?php _e('Caption', 'cardz-social'); ?></th>
                    <th class="manage-column column-cb"><?php _e('Value', 'cardz-social'); ?></th>
                </tr>
            </thead>
            <tbody>
                <!-- Purchase Code -->
                <tr>
                    <td colspan="2"><h3><?php _e('Purchase Code for Automatic Updates', 'cardz-social'); ?></h3></td>
                </tr>
                <tr>
                    <td><label for="ss-purchase-code"><?php _e('Purchase Code', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-purchase-code" id="ss-purchase-code" value="<?php echo $options['ss-purchase-code']; ?>" /></td>
                </tr>
                
                <!-- Facebook auth settings -->
                <tr>
                    <td colspan="2"><h3><?php _e('Facebook auth settings', 'cardz-social'); ?></h3></td>
                </tr>
                <tr>
                    <td><label for="ss-fb-app-id"><?php _e('App ID', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-fb-app-id" id="ss-fb-app-id" value="<?php echo $options['ss-fb-app-id']; ?>" /></td>
                </tr>
                <tr>
                    <td><label for="ss-fb-app-secret"><?php _e('App Secret', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-fb-app-secret" id="ss-fb-app-secret" value="<?php echo $options['ss-fb-app-secret']; ?>" /></td>
                </tr>
                
                <!-- Twitter auth settings -->
                <tr>
                    <td colspan="2"><h3><?php _e('Twitter auth settings', 'cardz-social'); ?></h3></td>
                </tr>
                <tr>
                    <td><label for="ss-tw-api-key"><?php _e('Consumer Key', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-tw-api-key" id="ss-tw-api-key" value="<?php echo $options['ss-tw-api-key']; ?>" /></td>
                </tr>
                <tr>
                    <td><label for="ss-tw-api-secret"><?php _e('Consumer Secret', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-tw-api-secret" id="ss-tw-api-secret" value="<?php echo $options['ss-tw-api-secret']; ?>" /></td>
                </tr>
                <tr>
                    <td><label for="ss-tw-access-token"><?php _e('Access Token', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-tw-access-token" id="ss-tw-access-token" value="<?php echo $options['ss-tw-access-token']; ?>" /></td>
                </tr>
                <tr>
                    <td><label for="ss-tw-access-token-secret"><?php _e('Access Token Secret', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-tw-access-token-secret" id="ss-tw-access-token-secret" value="<?php echo $options['ss-tw-access-token-secret']; ?>" /></td>
                </tr>
                
                <!-- Google+ auth settings -->
                <tr>
                    <td colspan="2"><h3><?php _e('Google+ auth settings', 'cardz-social'); ?></h3></td>
                </tr>
                <tr>
                    <td><label for="ss-gp-api-key"><?php _e('API Key', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-gp-api-key" id="ss-gp-api-key" value="<?php echo $options['ss-gp-api-key']; ?>" /></td>
                </tr>
                
                <!-- YouTube auth settings -->
                <tr>
                    <td colspan="2"><h3><?php _e('YouTube auth settings', 'cardz-social'); ?></h3></td>
                </tr>
                <tr>
                    <td><label for="ss-yb-api-key"><?php _e('API Key', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-yb-api-key" id="ss-yb-api-key" value="<?php echo $options['ss-yb-api-key']; ?>" /></td>
                </tr>
                
                <!-- Instagram auth settings -->
                <tr>
                    <td colspan="2"><h3><?php _e('Instagram auth settings', 'cardz-social'); ?></h3></td>
                </tr>
                <tr>
                    <td><label for="ss-is-access-token"><?php _e('Access Token', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-is-access-token" id="ss-is-access-token" value="<?php echo $options['ss-is-access-token']; ?>" /></td>
                </tr>
                
                <!-- SoundCloud auth settings -->
                <tr>
                    <td colspan="2"><h3><?php _e('SoundCloud auth settings', 'cardz-social'); ?></h3></td>
                </tr>
                <tr>
                    <td><label for="ss-sc-api-key"><?php _e('API Key', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-sc-api-key" id="ss-sc-api-key" value="<?php echo $options['ss-sc-api-key']; ?>" /></td>
                </tr>
                
                <!-- Foursquare auth settings -->
                <tr>
                    <td colspan="2"><h3><?php _e('Foursquare auth settings', 'cardz-social'); ?></h3></td>
                </tr>
                <tr>
                    <td><label for="ss-fq-client-id"><?php _e('Client ID', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-fq-client-id" id="ss-fq-client-id" value="<?php echo $options['ss-fq-client-id']; ?>" /></td>
                </tr>
                <tr>
                    <td><label for="ss-fq-client-secret"><?php _e('Client Secret', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-fq-client-secret" id="ss-fq-client-secret" value="<?php echo $options['ss-fq-client-secret']; ?>" /></td>
                </tr>
                
                <!-- LinkedIn auth settings -->
                <tr>
                    <td colspan="2"><h3><?php _e('LinkedIn auth settings', 'cardz-social'); ?></h3></td>
                </tr>
                <tr>
                    <td><label for="ss-li-access-token"><?php _e('Access Token', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-li-access-token" id="ss-li-access-token" value="<?php echo $options['ss-li-access-token']; ?>" /></td>
                </tr>
                <tr>
                    <td><label for="ss-li-client-id"><?php _e('Client ID', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-li-client-id" id="ss-li-client-id" value="<?php echo $options['ss-li-client-id']; ?>" /></td>
                </tr>
                <tr>
                    <td><label for="ss-li-client-secret"><?php _e('Client Secret', 'cardz-social'); ?></label></td>
                    <td><input type="text" class="regular-text" name="ss-li-client-secret" id="ss-li-client-secret" value="<?php echo $options['ss-li-client-secret']; ?>" /></td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'cardz-social'); ?>">
        </p>
    </form>
</div>