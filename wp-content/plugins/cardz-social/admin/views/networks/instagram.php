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
                    <label for="feed-type-user"><?php _e('User', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-popular" name="feed-type" value="popular" />
                    <label for="feed-type-popular"><?php _e('Popular', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-likes" name="feed-type" value="likes" />
                    <label for="feed-type-likes"><?php _e('Likes timeline', 'cardz-social'); ?></label>
                </p>
                <p>
                    <input type="radio" id="feed-type-hashtag" name="feed-type" value="search" />
                    <label for="feed-type-hashtag"><?php _e('Search by hashtag', 'cardz-social'); ?></label>
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