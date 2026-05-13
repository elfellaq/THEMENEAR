<?php
/**
 * Generic archive template.
 *
 * @package Travelio
 */
get_header(); ?>

<section class="tv-page-header">
    <div class="tv-container">
        <h1><?php the_archive_title(); ?></h1>
        <div class="tv-breadcrumbs"><?php the_archive_description(); ?></div>
    </div>
</section>

<section class="tv-content tv-section--soft">
    <div class="tv-container">
        <?php if ( have_posts() ) : ?>
            <div class="tv-grid tv-grid--3">
                <?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content' ); endwhile; ?>
            </div>
            <?php travelio_pagination(); ?>
        <?php else : ?>
            <p><?php esc_html_e( 'Nothing found.', 'travelio' ); ?></p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer();
