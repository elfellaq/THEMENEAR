<?php
/**
 * Default template / blog index.
 *
 * @package Travelio
 */
get_header(); ?>

<section class="tv-page-header">
    <div class="tv-container">
        <h1><?php is_home() ? single_post_title( '', true ) : esc_html_e( 'Latest Articles', 'travelio' ); ?></h1>
        <div class="tv-breadcrumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'travelio' ); ?></a> &rsaquo; <?php esc_html_e( 'Blog', 'travelio' ); ?></div>
    </div>
</section>

<section class="tv-content tv-section--soft">
    <div class="tv-container">
        <div class="tv-layout">
            <div>
                <?php if ( have_posts() ) : ?>
                    <div class="tv-grid tv-grid--2" style="grid-template-columns:repeat(2,1fr);gap:28px;display:grid">
                        <?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content' ); endwhile; ?>
                    </div>
                    <?php travelio_pagination(); ?>
                <?php else : ?>
                    <p><?php esc_html_e( 'No articles found.', 'travelio' ); ?></p>
                <?php endif; ?>
            </div>
            <aside class="tv-sidebar">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    </div>
</section>

<?php get_footer();
