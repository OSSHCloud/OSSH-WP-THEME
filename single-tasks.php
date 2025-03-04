<?php
while (have_posts()) : the_post();
    $website_url = get_post_meta(get_the_ID(), 'website_url', true);
    $website_name = get_post_meta(get_the_ID(), 'website_name', true);
    $description = get_post_meta(get_the_ID(), 'description', true);
    $subtasks = get_post_meta(get_the_ID(), 'subtasks', true);
    ?>
    <h1><?php the_title(); ?></h1>
    <p><strong>Website URL:</strong> <a href="<?php echo esc_url($website_url); ?>"><?php echo esc_html($website_name); ?></a></p>
    <p><strong>Description:</strong> <?php echo esc_html($description); ?></p>

    <h2>Subtasks</h2>
    <?php if (is_array($subtasks)) : ?>
        <ul>
            <?php foreach ($subtasks as $subtask) : ?>
                <li>
                    <strong><?php echo esc_html($subtask['name']); ?></strong>
                    <ul>
                        <?php foreach ($subtask['solutions'] as $solution) : ?>
                            <li>
                                <p><strong>File Path:</strong> <?php echo esc_html($solution['file_path']); ?></p>
                                <p><strong>Code Snippet:</strong></p>
                                <pre><?php echo esc_html($solution['code_snippet']); ?></pre>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php endwhile; ?>
