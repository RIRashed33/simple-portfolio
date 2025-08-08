<?php
defined( 'ABSPATH' ) || exit;

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <div class="portfolio-content">
                <?php the_content(); ?>
            </div>
        </article>

    <?php endwhile;
else :
    echo '<p>No portfolio found.</p>';
endif;

get_footer();
