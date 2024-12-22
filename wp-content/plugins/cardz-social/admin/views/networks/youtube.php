<form class="edit-network-form">
    <table>
        <tr>
            <td><label for="feed-type"><?php _e('Feed Type', 'cardz-social'); ?></label></td>
            <td>
                <p>
                    <input type="radio" id="feed-type-home" name="feed-type" value="channel" checked="checked" />
                    <label for="feed-type-home"><?php _e('Channel', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-page" name="feed-type" value="playlist" />
                    <label for="feed-type-page"><?php _e('Playlist', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-user" name="feed-type" value="search" />
                    <label for="feed-type-user"><?php _e('Search', 'cardz-social'); ?></label>
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