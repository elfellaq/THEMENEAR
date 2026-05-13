<?php
/**
 * Tour Packages archive.
 *
 * @package Travelio
 */
get_header(); ?>

<section class="tv-page-header">
    <div class="tv-container">
        <h1><?php esc_html_e( 'All Tour Packages', 'travelio' ); ?></h1>
        <div class="tv-breadcrumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'travelio' ); ?></a> &rsaquo; <?php esc_html_e( 'Tours', 'travelio' ); ?></div>
    </div>
</section>

<section class="tv-content tv-section--soft">
    <div class="tv-container">
        <?php if ( have_posts() ) : ?>
            <div class="tv-grid tv-grid--3">
                <?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content', 'tour' ); endwhile; ?>
            </div>
            <?php travelio_pagination(); ?>
        <?php else : ?>
            <p style="text-align:center"><?php esc_html_e( 'No tour packages published yet. Add some from Tours &rarr; Add New.', 'travelio' ); ?></p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer();
