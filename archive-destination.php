<?php
/**
 * Destinations archive.
 *
 * @package Travelio
 */
get_header(); ?>

<section class="tv-page-header">
    <div class="tv-container">
        <h1><?php esc_html_e( 'Destinations', 'travelio' ); ?></h1>
        <div class="tv-breadcrumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'travelio' ); ?></a> &rsaquo; <?php esc_html_e( 'Destinations', 'travelio' ); ?></div>
    </div>
</section>

<section class="tv-content">
    <div class="tv-container">
        <?php if ( have_posts() ) : ?>
            <div class="tv-grid tv-grid--4">
                <?php while ( have_posts() ) : the_post(); ?>
                    <a class="tv-dest" href="<?php the_permalink(); ?>">
                        <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'travelio-dest' ); }
                        else { echo '<img src="https://source.unsplash.com/600x800/?'. esc_attr( sanitize_title( get_the_title() ) ) .',travel" alt="">'; } ?>
                        <div class="tv-dest-body">
                            <h3><?php the_title(); ?></h3>
                            <span><?php esc_html_e( 'Explore tours &rarr;', 'travelio' ); ?></span>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
            <?php travelio_pagination(); ?>
        <?php else : ?>
            <p style="text-align:center"><?php esc_html_e( 'No destinations published yet.', 'travelio' ); ?></p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer();
