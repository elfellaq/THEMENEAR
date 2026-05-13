<?php
/**
 * Default page template.
 *
 * @package Travelio
 */
get_header();
while ( have_posts() ) : the_post(); ?>

<section class="tv-page-header">
    <div class="tv-container">
        <h1><?php the_title(); ?></h1>
        <div class="tv-breadcrumbs"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'travelio' ); ?></a> &rsaquo; <?php the_title(); ?></div>
    </div>
</section>

<section class="tv-content">
    <div class="tv-container">
        <article <?php post_class( 'tv-page-article' ); ?>>
            <div class="entry-content">
                <?php the_content(); ?>
                <?php wp_link_pages(); ?>
            </div>
        </article>
        <?php if ( comments_open() || get_comments_number() ) { comments_template(); } ?>
    </div>
</section>

<?php endwhile;
get_footer();
