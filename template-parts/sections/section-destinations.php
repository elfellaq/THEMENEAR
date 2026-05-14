<?php
/**
 * Homepage: Destinations section.
 *
 * @package NearTrips
 */

$query = nt_get_featured_destinations( 6 );
if ( ! $query->have_posts() ) { return; }

$posts = $query->posts;
wp_reset_postdata();
?>

<section class="nt-section" id="destinations" aria-labelledby="destinations-title">
    <div class="nt-container">

        <div class="nt-section-head" data-anim="fade-up">
            <span class="nt-eyebrow"><?php esc_html_e( 'Explore the World', 'neartrips' ); ?></span>
            <h2 id="destinations-title"><?php esc_html_e( 'Popular Destinations', 'neartrips' ); ?></h2>
            <p class="nt-lead"><?php esc_html_e( 'Find your perfect escape among our hand-picked destinations around the globe.', 'neartrips' ); ?></p>
        </div>

        <div class="nt-dest-grid" data-anim="stagger">
            <?php foreach ( $posts as $i => $post ) :
                $wide = ( $i === 0 || $i === 5 ); /* First and last card span 2 columns */
            ?>
                <?php get_template_part( 'template-parts/cards/card', 'destination', [ 'post_id' => $post->ID, 'wide' => $wide ] ); ?>
            <?php endforeach; ?>
        </div>

        <div style="text-align:center;margin-top:var(--nt-space-8)">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'nt_destination' ) ?: home_url( '/destinations/' ) ); ?>" class="nt-btn nt-btn--outline">
                <?php esc_html_e( 'See All Destinations', 'neartrips' ); ?>
                <?php echo nt_icon( 'chevron-r', 16 ); // phpcs:ignore ?>
            </a>
        </div>
    </div>
</section>
