<?php function create_bookmarks_post_type() {
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

function create_tasks_post_type() {
  register_post_type('tasks',
      array(
          'labels' => array(
              'name' => __('Tasks'),
              'singular_name' => __('Task'),
              'add_new_item' => __('Add New Task'),
              'edit_item' => __('Edit Task'),
              'view_item' => __('View Task'),
          ),
          'public' => true,
          'has_archive' => true,
          'supports' => array('title', 'author', 'editor', 'custom-fields'),
          'show_in_rest' => true, // Enable Gutenberg editor if needed
      )
  );
}
add_action('init', 'create_tasks_post_type');

function add_task_meta_boxes() {
  add_meta_box(
      'task_details',
      __('Task Details'),
      'render_task_details_meta_box',
      'tasks',
      'normal',
      'default'
  );
}
add_action('add_meta_boxes', 'add_task_meta_boxes');

function render_task_details_meta_box($post) {
  $website_url = get_post_meta($post->ID, 'website_url', true);
  $website_name = get_post_meta($post->ID, 'website_name', true);
  $description = get_post_meta($post->ID, 'description', true);
  ?>
  <label for="website_url">Website URL:</label>
  <input type="url" id="website_url" name="website_url" value="<?php echo esc_url($website_url); ?>" style="width: 100%;"><br>

  <label for="website_name">Website Name:</label>
  <input type="text" id="website_name" name="website_name" value="<?php echo esc_attr($website_name); ?>" style="width: 100%;"><br>

  <label for="description">Description:</label>
  <textarea id="description" name="description" style="width: 100%;"><?php echo esc_textarea($description); ?></textarea>
  <?php
}

function save_task_meta($post_id) {
  if (array_key_exists('website_url', $_POST)) {
      update_post_meta(
          $post_id,
          'website_url',
          esc_url_raw($_POST['website_url'])
      );
  }
  if (array_key_exists('website_name', $_POST)) {
      update_post_meta(
          $post_id,
          'website_name',
          sanitize_text_field($_POST['website_name'])
      );
  }
  if (array_key_exists('description', $_POST)) {
      update_post_meta(
          $post_id,
          'description',
          sanitize_textarea_field($_POST['description'])
      );
  }
}
add_action('save_post', 'save_task_meta');

function create_subtasks_taxonomy() {
  register_taxonomy(
      'subtasks',
      'tasks',
      array(
          'labels' => array(
              'name' => __('Subtasks'),
              'singular_name' => __('Subtask'),
          ),
          'hierarchical' => true, // Allows parent-child relationships
          'show_in_rest' => true, // Enable in Gutenberg
      )
  );
}
add_action('init', 'create_subtasks_taxonomy');

function add_subtasks_meta_boxes() {
  add_meta_box(
      'subtasks_solutions',
      __('Subtasks & Solutions'),
      'render_subtasks_solutions_meta_box',
      'tasks',
      'normal',
      'default'
  );
}
add_action('add_meta_boxes', 'add_subtasks_meta_boxes');

function render_subtasks_solutions_meta_box($post) {
  $subtasks = get_post_meta($post->ID, 'subtasks', true);
  ?>
  <div id="subtasks-container">
      <?php if (is_array($subtasks)) : ?>
          <?php foreach ($subtasks as $index => $subtask) : ?>
              <div class="subtask">
                  <label for="subtask_<?php echo $index; ?>">Subtask:</label>
                  <input type="text" name="subtasks[<?php echo $index; ?>][name]" value="<?php echo esc_attr($subtask['name']); ?>"><br>

                  <div class="solutions">
                      <?php if (is_array($subtask['solutions'])) : ?>
                          <?php foreach ($subtask['solutions'] as $solution_index => $solution) : ?>
                              <div class="solution">
                                  <label for="file_path_<?php echo $index; ?>_<?php echo $solution_index; ?>">File Path:</label>
                                  <input type="text" name="subtasks[<?php echo $index; ?>][solutions][<?php echo $solution_index; ?>][file_path]" value="<?php echo esc_attr($solution['file_path']); ?>"><br>

                                  <label for="code_snippet_<?php echo $index; ?>_<?php echo $solution_index; ?>">Code Snippet:</label>
                                  <textarea name="subtasks[<?php echo $index; ?>][solutions][<?php echo $solution_index; ?>][code_snippet]"><?php echo esc_textarea($solution['code_snippet']); ?></textarea><br>
                              </div>
                          <?php endforeach; ?>
                      <?php endif; ?>
                  </div>
              </div>
          <?php endforeach; ?>
      <?php endif; ?>
  </div>
  <button type="button" id="add-subtask">Add Subtask</button>
  <script>
      // JavaScript to dynamically add subtasks and solutions
  </script>
  <?php
}

function save_subtasks_solutions_meta($post_id) {
  if (array_key_exists('subtasks', $_POST)) {
      update_post_meta(
          $post_id,
          'subtasks',
          $_POST['subtasks']
      );
  }
}
add_action('save_post', 'save_subtasks_solutions_meta');
