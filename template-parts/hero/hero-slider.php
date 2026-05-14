<?php
/**
 * Hero slider section.
 *
 * @package NearTrips
 */

$slides = get_theme_mod( 'nt_hero_slides', [] );

/* Fallback single slide if no customizer slides set */
if ( empty( $slides ) ) {
    $slides = [ [
        'image'    => get_theme_mod( 'nt_hero_image', '' ),
        'title'    => get_theme_mod( 'nt_hero_title', __( 'Unlock the Magic of <span>Travel</span>', 'neartrips' ) ),
        'subtitle' => get_theme_mod( 'nt_hero_subtitle', __( 'Discover extraordinary destinations, hand-crafted tours and seamless bookings — all in one place.', 'neartrips' ) ),
        'cta_text' => __( 'Explore Tours', 'neartrips' ),
        'cta_url'  => get_post_type_archive_link( nt_get_tour_post_type() ) ?: home_url( '/tours/' ),
    ] ];
}
?>

<section class="nt-hero swiper nt-hero-swiper" aria-label="<?php esc_attr_e( 'Hero slideshow', 'neartrips' ); ?>">
    <div class="swiper-wrapper">
        <?php foreach ( $slides as $slide ) :
            $img = ! empty( $slide['image'] ) ? esc_url( $slide['image'] ) : 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1920&q=80';
        ?>
        <div class="swiper-slide nt-hero__slide">
            <img
                class="nt-hero__bg"
                src="<?php echo $img; ?>"
                alt="<?php echo esc_attr( wp_strip_all_tags( $slide['title'] ?? '' ) ); ?>"
                loading="eager"
                fetchpriority="high"
            >
            <div class="nt-hero__overlay"></div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Content overlay (same for all slides / or per-slide via JS) -->
    <div class="nt-container" style="position:relative;z-index:3;width:100%">
        <div class="nt-hero__content">
            <div class="nt-hero__eyebrow">
                <?php echo nt_icon( 'star', 14 ); // phpcs:ignore ?>
                <?php esc_html_e( 'World\'s Best Travel Platform', 'neartrips' ); ?>
            </div>

            <h1 class="nt-hero__title">
                <?php echo wp_kses_post( $slides[0]['title'] ?? __( 'Unlock the Magic of <span>Travel</span>', 'neartrips' ) ); ?>
            </h1>

            <p class="nt-hero__subtitle">
                <?php echo wp_kses_post( $slides[0]['subtitle'] ?? '' ); ?>
            </p>

            <div class="nt-hero__cta-group">
                <a
                    href="<?php echo esc_url( $slides[0]['cta_url'] ?? home_url( '/tours/' ) ); ?>"
                    class="nt-btn nt-btn--primary nt-btn--lg"
                >
                    <?php esc_html_e( 'Explore Tours', 'neartrips' ); ?>
                    <?php echo nt_icon( 'chevron-r', 18 ); // phpcs:ignore ?>
                </a>
                <a
                    href="<?php echo esc_url( home_url( '/destinations/' ) ); ?>"
                    class="nt-btn nt-btn--ghost nt-btn--lg"
                ><?php esc_html_e( 'View Destinations', 'neartrips' ); ?></a>
            </div>

            <!-- Stats -->
            <div class="nt-hero__stats">
                <div class="nt-hero__stat-item">
                    <span class="nt-hero__stat-num" data-count="4500" data-count-suffix="+">4500+</span>
                    <span class="nt-hero__stat-label"><?php esc_html_e( 'Destinations', 'neartrips' ); ?></span>
                </div>
                <div class="nt-hero__stat-item">
                    <span class="nt-hero__stat-num" data-count="98000" data-count-suffix="+">98K+</span>
                    <span class="nt-hero__stat-label"><?php esc_html_e( 'Happy Travellers', 'neartrips' ); ?></span>
                </div>
                <div class="nt-hero__stat-item">
                    <span class="nt-hero__stat-num" data-count="4.9">4.9</span>
                    <span class="nt-hero__stat-label"><?php esc_html_e( 'Average Rating', 'neartrips' ); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Slider controls -->
    <div class="nt-hero-nav" style="position:absolute;bottom:32px;right:32px;z-index:3">
        <button class="nt-swiper-btn nt-hero-prev" aria-label="<?php esc_attr_e( 'Previous slide', 'neartrips' ); ?>">
            <?php echo nt_icon( 'chevron-l', 20 ); // phpcs:ignore ?>
        </button>
        <div class="swiper-pagination nt-hero-pagination"></div>
        <button class="nt-swiper-btn nt-hero-next" aria-label="<?php esc_attr_e( 'Next slide', 'neartrips' ); ?>">
            <?php echo nt_icon( 'chevron-r', 20 ); // phpcs:ignore ?>
        </button>
    </div>
</section>
