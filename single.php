<?php
/**
 * Single post template.
 *
 * @package Travelio
 */
get_header();
while ( have_posts() ) : the_post(); ?>

<section class="tv-page-header">
    <div class="tv-container">
        <h1><?php the_title(); ?></h1>
        <div class="tv-breadcrumbs">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'travelio' ); ?></a> &rsaquo;
            <?php echo esc_html( get_the_date() ); ?>
        </div>
    </div>
</section>

<section class="tv-content tv-section--soft">
    <div class="tv-container">
        <div class="tv-layout">
            <article <?php post_class(); ?>>
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="tv-post-media" style="border-radius:var(--tv-radius);overflow:hidden;margin-bottom:24px">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </div>
                <?php endif; ?>

                <div class="tv-post-meta" style="margin-bottom:16px">
                    <?php echo esc_html( get_the_author() ); ?> &middot; <?php echo esc_html( get_the_date() ); ?> &middot; <?php the_category( ', ' ); ?>
                </div>

                <div class="entry-content">
                    <?php the_content(); ?>
                    <?php wp_link_pages(); ?>
                </div>

                <?php if ( has_tag() ) : ?>
                    <div style="margin-top:30px"><?php the_tags( '<strong>' . esc_html__( 'Tags:', 'travelio' ) . '</strong> ', ', ' ); ?></div>
                <?php endif; ?>

                <?php if ( comments_open() || get_comments_number() ) : ?>
                    <div class="tv-comments"><?php comments_template(); ?></div>
                <?php endif; ?>
            </article>

            <aside class="tv-sidebar">
                <?php get_sidebar(); ?>
            </aside>
        </div>
    </div>
</section>

<?php endwhile;
get_footer();
