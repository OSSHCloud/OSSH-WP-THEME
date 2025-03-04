<?php get_header(); ?>

<main id="main-content">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                <h1><?php the_title(); ?></h1>

                <?php 
                // Get the Website URL custom field
                $website_url = get_field('website_url'); 
                if ($website_url): ?>
                    <p><strong>Website URL:</strong> <a href="<?php echo esc_url($website_url); ?>" target="_blank"><?php echo esc_url($website_url); ?></a></p>
                <?php endif; ?>

                <h2>Sub Tasks</h2>

                <?php 
                // Get related Sub Tasks (Post Object field)
                $sub_tasks = get_field('sub_tasks'); 
                if ($sub_tasks): ?>
                    <ul>
                        <?php foreach ($sub_tasks as $sub_task): 
                            $sub_task_id = $sub_task->ID;
                            $s_no = get_field('s_no', $sub_task_id);
                            $issue = get_field('issue', $sub_task_id);
                            $solution_path = get_field('solution_path', $sub_task_id);
                            $solution = get_field('solution', $sub_task_id);
                        ?>
                            <li>
                                <h3><?php echo get_the_title($sub_task_id); ?></h3>
                                <p><strong>S. No:</strong> <?php echo esc_html($s_no); ?></p>
                                <p><strong>Issue:</strong> <?php echo esc_html($issue); ?></p>
                                <p><strong>Solution Path:</strong> <?php echo esc_html($solution_path); ?></p>
                                <p><strong>Solution:</strong> <?php echo esc_html($solution); ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No sub-tasks available.</p>
                <?php endif; ?>

            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
