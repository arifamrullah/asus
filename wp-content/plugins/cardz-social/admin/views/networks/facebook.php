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
                    <input type="radio" id="feed-type-page" name="feed-type" value="page" />
                    <label for="feed-type-page"><?php _e('Page timeline', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-user" name="feed-type" value="user" />
                    <label for="feed-type-user"><?php _e('User timeline', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-group" name="feed-type" value="group" />
                    <label for="feed-type-group"><?php _e('Public group', 'cardz-social'); ?></label>
                </p>
            </td>
        </tr>
        <tr>
            <td><label><?php _e('Network ID', 'cardz-social'); ?></label></td>
            <td>
                <input type="text" class="regular-text" name="network-id" />
            </td>
        </tr>
        <tr>
            <td><label><?php _e('Hashtag', 'cardz-social'); ?></label></td>
            <td>
                <input type="text" class="regular-text" name="hashtag" />
                <p class="description">Filter posts by hashtag.</p>
            </td>
        </tr>
    </table>
</form>