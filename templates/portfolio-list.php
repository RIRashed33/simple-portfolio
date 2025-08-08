<?php defined('ABSPATH') || exit; ?>

<div class="simple-portfolio-list">
    <?php while ($query->have_posts()) : $query->the_post(); ?>
        <div class="portfolio-item">
            <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>" class="portfolio-thumb">
                    <?php the_post_thumbnail('medium'); ?>
                </a>
            <?php endif; ?>
            <h3 class="portfolio-title"><?php the_title(); ?></h3>
            <div class="portfolio-excerpt"><?php the_excerpt(); ?></div>
            <div class="btn-group">
                <a href="<?php the_permalink(); ?>" class="solid-btn">Learn More</a>
                <a href="<?php echo get_post_meta( get_the_ID(), '_portfolio_url', true ); ?>" class="transparent-btn" target="_blank">Project URL</a>
            </div>
        </div>
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
</div>
