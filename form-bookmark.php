<?php
if (is_user_logged_in()) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_bookmark'])) {
        $url = esc_url_raw($_POST['bookmark_url']);
        $title = sanitize_text_field($_POST['bookmark_title']);
        $tags = sanitize_text_field($_POST['bookmark_tags']);
        $categories = sanitize_text_field($_POST['bookmark_categories']);

        // Check if the URL already exists
        $existing_bookmark = get_posts(array(
            'post_type' => 'bookmarks',
            'meta_key' => 'bookmark_url',
            'meta_value' => $url,
            'author' => get_current_user_id(), // Ensure it's the same user
        ));

        if (empty($existing_bookmark)) {
            // URL does not exist, proceed to add the bookmark
            $post_id = wp_insert_post(array(
                'post_title' => $title,
                'post_type' => 'bookmarks',
                'post_status' => 'publish',
                'post_author' => get_current_user_id(),
            ));

            if ($post_id) {
                update_post_meta($post_id, 'bookmark_url', $url);
                wp_set_post_tags($post_id, $tags);
                wp_set_post_categories($post_id, array($categories));
                echo '<p>Bookmark added successfully!</p>';
            }
        } else {
            // URL already exists
            echo '<p>This URL has already been bookmarked.</p>';
        }
    }
    ?>
    <form method="post" action="">
        <label for="bookmark_title">Title:</label>
        <input type="text" name="bookmark_title" required><br>

        <label for="bookmark_url">URL:</label>
        <input type="url" name="bookmark_url" required><br>

        <label for="bookmark_tags">Tags:</label>
        <input type="text" name="bookmark_tags"><br>

        <label for="bookmark_categories">Category:</label>
        <input type="text" name="bookmark_categories"><br>

        <input type="submit" name="submit_bookmark" value="Add Bookmark">
    </form>
    <?php
} else {
    echo '<p>You must be logged in to add a bookmark.</p>';
}
?>
