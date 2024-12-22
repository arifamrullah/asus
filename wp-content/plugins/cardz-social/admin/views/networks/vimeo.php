<form class="edit-network-form">
    <table>
        <tr>
            <td><label for="feed-type"><?php _e('Feed Type', 'cardz-social'); ?></label></td>
            <td>
                <p>
                    <input type="radio" id="feed-type-own" name="feed-type" value="own" checked="checked" />
                    <label for="feed-type-own"><?php _e('Own videos', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-channel" name="feed-type" value="channel" />
                    <label for="feed-type-channel"><?php _e('Channel videos', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-group" name="feed-type" value="group" />
                    <label for="feed-type-group"><?php _e('Group videos', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-likes" name="feed-type" value="likes" />
                    <label for="feed-type-likes"><?php _e('Liked videos', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-album" name="feed-type" value="album" />
                    <label for="feed-type-album"><?php _e('Album videos', 'cardz-social'); ?></label>
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