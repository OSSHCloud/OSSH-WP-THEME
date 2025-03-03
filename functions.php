function create_bookmarks_post_type() {
    register_post_type('bookmarks',
        array(
            'labels' => array(
                'name' => __('Bookmarks'),
                'singular_name' => __('Bookmark'),
                'add_new_item' => __('Add New Bookmark'),
                'edit_item' => __('Edit Bookmark'),
                'view_item' => __('View Bookmark'),
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'author', 'custom-fields'),
            'capability_type' => 'post',
            'show_in_rest' => true, // Enable Gutenberg editor if needed
        )
    );
}
add_action('init', 'create_bookmarks_post_type');

function add_bookmark_meta_boxes() {
    add_meta_box(
        'bookmark_url',
        __('Bookmark URL'),
        'render_bookmark_url_meta_box',
        'bookmarks',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_bookmark_meta_boxes');

function render_bookmark_url_meta_box($post) {
    $url = get_post_meta($post->ID, 'bookmark_url', true);
    ?>
    <label for="bookmark_url">URL:</label>
    <input type="text" id="bookmark_url" name="bookmark_url" value="<?php echo esc_url($url); ?>" style="width: 100%;">
    <?php
}

function save_bookmark_meta($post_id) {
    if (array_key_exists('bookmark_url', $_POST)) {
        update_post_meta(
            $post_id,
            'bookmark_url',
            esc_url_raw($_POST['bookmark_url'])
        );
    }
}
add_action('save_post', 'save_bookmark_meta');
