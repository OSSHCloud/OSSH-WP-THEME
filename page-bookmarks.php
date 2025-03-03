<?php
if (is_user_logged_in()) {
    $user_id = get_current_user_id();
    $args = array(
        'post_type' => 'bookmarks',
        'author' => $user_id,
        'posts_per_page' => -1,
    );
    $bookmarks = new WP_Query($args);

    if ($bookmarks->have_posts()) {
        echo '<h2>Your Bookmarks</h2>';
        echo '<ul>';
        while ($bookmarks->have_posts()) {
            $bookmarks->the_post();
            $url = get_post_meta(get_the_ID(), 'bookmark_url', true);
            echo '<li><a href="' . esc_url($url) . '">' . get_the_title() . '</a></li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No bookmarks found.</p>';
    }
    wp_reset_postdata();

    echo '<a href="' . home_url('/add-bookmark') . '">Add a Bookmark</a>';
} else {
    echo '<p>You must be logged in to view your bookmarks.</p>';
}
?>
