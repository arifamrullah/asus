<form class="edit-network-form">
    <table>
        <tr>
            <td><label for="feed-type"><?php _e('Feed Type', 'cardz-social'); ?></label></td>
            <td>
                <p>
                    <input type="radio" id="feed-type-tips" name="feed-type" value="tips" checked="checked" />
                    <label for="feed-type-tips"><?php _e('Tips', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-photos" name="feed-type" value="photos" />
                    <label for="feed-type-photos"><?php _e('Photos', 'cardz-social'); ?></label>
                </p>
            </td>
        </tr>
        <tr>
            <td><label><?php _e('Network ID', 'cardz-social'); ?></label></td>
            <td>
                <input type="text" class="regular-text" name="network-id" />
            </td>
        </tr>
    </table>
</form>
<script>
    jQuery('[name="feed-type"]').change(function ()
    {
        var list_name = jQuery('.ss-list-name');
        var container = list_name.closest('.ss-container-window');
    
        if (jQuery(this).val() === 'user-list')
        {
            container.css('max-height', 395);
            list_name.show();
        }
        else
        {
            container.css('max-height', 350);
            list_name.hide();
        }
    });
</script>
<style type="text/css">
    .ss-list-name{display:none}
</style>