<?php defined('ABSPATH') || exit; ?>

<div class="simple-portfolio-list">
    <?php while ($query->have_posts()) : $query->the_post(); ?>
        <div class="portfolio-item">
            <?php if (has_post_thumbnail()) : ?>
                <div class="portfolio-thumb">
                    <?php the_post_thumbnail('medium'); ?>
                </div>
            <?php endif; ?>
            <h3 class="portfolio-title"><?php the_title(); ?></h3>
            <div class="portfolio-excerpt"><?php the_excerpt(); ?></div>
        </div>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
</div>
