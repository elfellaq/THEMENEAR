<?php
/**
 * 404 template.
 *
 * @package Travelio
 */
get_header(); ?>

<section class="tv-404">
    <div class="tv-container">
        <div class="big">404</div>
        <h2><?php esc_html_e( 'This page wandered off the map', 'travelio' ); ?></h2>
        <p style="color:var(--tv-muted);max-width:500px;margin:0 auto 26px"><?php esc_html_e( 'The page you\'re looking for may have moved or never existed. Let\'s get you back to base camp.', 'travelio' ); ?></p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tv-btn tv-btn--primary"><?php esc_html_e( 'Back to home', 'travelio' ); ?></a>
    </div>
</section>

<?php get_footer();
