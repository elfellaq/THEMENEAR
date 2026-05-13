<?php
/**
 * Single Destination.
 *
 * @package Travelio
 */
get_header();
while ( have_posts() ) : the_post(); ?>

<section class="tv-tour-hero">
    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'travelio-hero' ); }
    else { echo '<img src="https://source.unsplash.com/1920x900/?'. esc_attr( sanitize_title( get_the_title() ) ) .',travel" alt="">'; } ?>
    <div class="tv-tour-hero-overlay">
        <div class="tv-container">
            <h1><?php the_title(); ?></h1>
            <div class="meta"><span>&#x1F4CD; <?php esc_html_e( 'Destination', 'travelio' ); ?></span></div>
        </div>
    </div>
</section>

<section class="tv-content">
    <div class="tv-container">
        <article class="entry-content" style="max-width:820px;margin:0 auto 50px">
            <?php the_content(); ?>
        </article>

        <h2 style="text-align:center"><?php esc_html_e( 'Tours in this destination', 'travelio' ); ?></h2>

        <?php
        $related = new WP_Query( array(
            'post_type'      => 'tour_package',
            'posts_per_page' => 6,
            'meta_query'     => array(
                array(
                    'key'     => '_tv_tour_location',
                    'value'   => get_the_title(),
                    'compare' => 'LIKE',
                ),
            ),
        ) );

        if ( $related->have_posts() ) : ?>
            <div class="tv-grid tv-grid--3" style="margin-top:30px">
                <?php while ( $related->have_posts() ) : $related->the_post(); get_template_part( 'template-parts/content', 'tour' ); endwhile; ?>
            </div>
        <?php wp_reset_postdata(); else : ?>
            <p style="text-align:center;margin-top:30px"><?php esc_html_e( 'No tours yet for this destination — check back soon.', 'travelio' ); ?></p>
        <?php endif; ?>
    </div>
</section>

<?php endwhile;
get_footer();
