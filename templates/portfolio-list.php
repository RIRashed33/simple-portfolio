<?php defined('ABSPATH') || exit; ?>
<div class="portfolio-list-container">
    <div class="simple-portfolio-list">
        <?php while ($query->have_posts()) : $query->the_post(); ?>
            <div class="portfolio-item">
                <?php if (has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" class="portfolio-thumb">
                        <?php the_post_thumbnail('medium'); ?>
                    </a>
                <?php endif; ?>
                <h2><?php the_title(); ?></h2>
				<h5><?php echo get_post_meta( get_the_ID(), '_portfolio_client', true ); ?></h5>
                <div class="portfolio-excerpt"><?php the_excerpt(); ?></div>
                <div class="btn-group">
                    <a href="<?php the_permalink(); ?>" class="solid-btn">Learn More</a>
                    <a href="<?php echo get_post_meta( get_the_ID(), '_portfolio_url', true ); ?>" class="transparent-btn" target="_blank">Project URL</a>
                </div>
            </div>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </div>

    <?php
        $total_pages = $query->max_num_pages;
        if ( $total_pages > 1 ) {
            echo '<div class="portfolio-pagination">';
            echo paginate_links( array(
                'total'   => $total_pages,
                'current' => max( 1, get_query_var('paged') ),
                'prev_text' => '&laquo; Prev',
                'next_text' => 'Next &raquo;',
            ) );
            echo '</div>';
        }
    ?>
</div>
