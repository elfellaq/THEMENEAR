<?php
/**
 * Homepage: Top Rated Hotels section.
 *
 * @package NearTrips
 */

$query = new WP_Query( [
    'post_type'      => 'nt_hotel',
    'posts_per_page' => 6,
    'meta_key'       => '_nt_rating',
    'orderby'        => 'meta_value_num',
    'order'          => 'DESC',
    'post_status'    => 'publish',
] );
if ( ! $query->have_posts() ) { return; }
?>

<section class="nt-section nt-section--soft" id="hotels" aria-labelledby="hotels-title">
    <div class="nt-container">

        <div class="nt-flex-between" style="margin-bottom:var(--nt-space-8)" data-anim="fade-up">
            <div>
                <span class="nt-eyebrow"><?php esc_html_e( 'Top Picks', 'neartrips' ); ?></span>
                <h2 id="hotels-title"><?php esc_html_e( 'Top Rated Hotels', 'neartrips' ); ?></h2>
            </div>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'nt_hotel' ) ?: home_url( '/hotels/' ) ); ?>" class="nt-btn nt-btn--outline nt-btn--sm">
                <?php esc_html_e( 'All Hotels', 'neartrips' ); ?>
                <?php echo nt_icon( 'chevron-r', 16 ); // phpcs:ignore ?>
            </a>
        </div>

        <div class="nt-grid-3" data-anim="stagger">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <?php get_template_part( 'template-parts/cards/card', 'hotel', [ 'post_id' => get_the_ID() ] ); ?>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

    </div>
</section>
