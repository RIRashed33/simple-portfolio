<?php
defined('ABSPATH') || exit;

get_header();

if (have_posts()) :
    while (have_posts()) : the_post();
        // Get meta fields
        $client_name = get_post_meta(get_the_ID(), '_portfolio_client', true);
        $project_url = get_post_meta(get_the_ID(), '_portfolio_url', true);

        // Get project types (taxonomy terms)
        $project_types = get_the_terms(get_the_ID(), 'project_type');
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('single-portfolio'); ?>>

            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="portfolio-thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="portfolio-meta">
                <?php if ($client_name) : ?>
                    <p><strong>Client:</strong> <?php echo esc_html($client_name); ?></p>
                <?php endif; ?>

                <?php if ($project_types && !is_wp_error($project_types)) : ?>
                    <p><strong>Project Type:</strong>
                        <?php
                        $types = wp_list_pluck($project_types, 'name');
                        echo esc_html(implode(', ', $types));
                        ?>
                    </p>
                <?php endif; ?>

                <?php if ($project_url) : ?>
                    <p><strong>Project URL:</strong> <a href="<?php echo esc_url($project_url); ?>" target="_blank" rel="nofollow noopener"><?php echo esc_html($project_url); ?></a></p>
                <?php endif; ?>
            </div>

            <div class="portfolio-content entry-content">
                <?php the_content(); ?>
            </div>

        </article>

    <?php endwhile;
else :
    echo '<p>No portfolio found.</p>';
endif;

get_footer();
