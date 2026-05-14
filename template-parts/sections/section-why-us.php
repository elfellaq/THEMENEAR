<?php
/**
 * Homepage: Why Choose Us / Features strip.
 *
 * @package NearTrips
 */

$features = [
    [
        'icon'  => 'map-pin',
        'stat'  => '4500+',
        'count' => '4500',
        'title' => __( 'World Destinations', 'neartrips' ),
        'desc'  => __( 'Explore thousands of destinations across all seven continents with local expert guidance.', 'neartrips' ),
    ],
    [
        'icon'  => 'calendar',
        'stat'  => '24h',
        'title' => __( 'Fast Booking', 'neartrips' ),
        'desc'  => __( 'Book your trip in seconds with our instant confirmation and secure checkout system.', 'neartrips' ),
    ],
    [
        'icon'  => 'users',
        'stat'  => '98K+',
        'count' => '98000',
        'title' => __( '24/7 Support', 'neartrips' ),
        'desc'  => __( 'Our dedicated travel experts are available around the clock to assist you anywhere.', 'neartrips' ),
    ],
    [
        'icon'  => 'star',
        'stat'  => '100%',
        'title' => __( 'Best Price Match', 'neartrips' ),
        'desc'  => __( 'Found a better price? We\'ll match it — guaranteed lowest rates on every booking.', 'neartrips' ),
    ],
];
?>

<section class="nt-section" id="why-us" aria-labelledby="why-us-title">
    <div class="nt-container">

        <div class="nt-section-head" data-anim="fade-up">
            <span class="nt-eyebrow"><?php esc_html_e( 'Why NearTrips', 'neartrips' ); ?></span>
            <h2 id="why-us-title"><?php esc_html_e( 'Travel Smarter with Us', 'neartrips' ); ?></h2>
            <p class="nt-lead"><?php esc_html_e( 'We bring you the world\'s best travel experiences with trust, transparency, and the lowest prices.', 'neartrips' ); ?></p>
        </div>

        <div class="nt-features-grid" data-anim="stagger">
            <?php foreach ( $features as $f ) : ?>
                <div class="nt-feature-card" data-anim-child data-anim="scale-in">
                    <div class="nt-feature-icon">
                        <?php echo nt_icon( $f['icon'], 32 ); // phpcs:ignore ?>
                    </div>
                    <?php if ( ! empty( $f['count'] ) ) : ?>
                        <div style="font-family:var(--nt-font-head);font-size:var(--nt-fs-2xl);font-weight:800;color:var(--nt-primary);margin-bottom:4px">
                            <span data-count="<?php echo esc_attr( $f['count'] ); ?>" data-count-suffix="+"><?php echo esc_html( $f['stat'] ); ?></span>
                        </div>
                    <?php else : ?>
                        <div style="font-family:var(--nt-font-head);font-size:var(--nt-fs-2xl);font-weight:800;color:var(--nt-primary);margin-bottom:4px"><?php echo esc_html( $f['stat'] ); ?></div>
                    <?php endif; ?>
                    <h3><?php echo esc_html( $f['title'] ); ?></h3>
                    <p><?php echo esc_html( $f['desc'] ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
