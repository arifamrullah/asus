<form class="edit-network-form">
    <table>
        <tr>
            <td><label for="feed-type"><?php _e('Feed Type', 'cardz-social'); ?></label></td>
            <td>
                <p>
                    <input type="radio" id="feed-type-home" name="feed-type" value="home" checked="checked" />
                    <label for="feed-type-home"><?php _e('Home timeline', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-user" name="feed-type" value="user" />
                    <label for="feed-type-user"><?php _e('User timeline', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-user-list" name="feed-type" value="user-list" />
                    <label for="feed-type-user-list"><?php _e('User list', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-user-fav" name="feed-type" value="user-fav" />
                    <label for="feed-type-user-fav"><?php _e('User favorites', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-hashtag" name="feed-type" value="search" />
                    <label for="feed-type-hashtag"><?php _e('Search by keyword or hashtag', 'cardz-social'); ?></label>
                </p>
            </td>
        </tr>
        <tr>
            <td><label><?php _e('Network ID', 'cardz-social'); ?></label></td>
            <td>
                <input type="text" class="regular-text" name="network-id" />
            </td>
        </tr>
        <tr class="ss-list-name">
            <td><label><?php _e('List Name', 'cardz-social'); ?></label></td>
            <td>
                <input type="text" class="regular-text" name="list-name" />
            </td>
        </tr>
        <tr>
            <td><label><?php _e('Ignore Tweets', 'cardz-social'); ?></label></td>
            <td>
                <p>
                    <input type="checkbox" id="ignore-retweets" name="ignore-retweets" value="1" />
                    <label for="ignore-retweets"><?php _e('Ignore Retweets', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="checkbox" id="ignore-replies" name="ignore-replies" value="1" checked="checked" />
                    <label for="ignore-replies"><?php _e('Ignore Replies', 'cardz-social'); ?></label>
                </p>
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