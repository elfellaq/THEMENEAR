<?php
/**
 * Front page (Homepage) template.
 *
 * @package NearTrips
 */

get_header();
?>

<!-- ── Hero with Search Widget ── -->
<div style="position:relative">
    <?php get_template_part( 'template-parts/hero/hero-slider' ); ?>

    <!-- Search widget overlaps hero bottom -->
    <div class="nt-container" style="position:relative;z-index:4;margin-top:-70px;padding-bottom:var(--nt-space-12)">
        <?php get_template_part( 'template-parts/search/search-widget' ); ?>
    </div>
</div>

<?php
/* ── Homepage Sections ── */
get_template_part( 'template-parts/sections/section', 'featured' );
get_template_part( 'template-parts/sections/section', 'destinations' );
get_template_part( 'template-parts/sections/section', 'hotels' );
get_template_part( 'template-parts/sections/section', 'why-us' );
get_template_part( 'template-parts/sections/section', 'testimonials' );
get_template_part( 'template-parts/sections/section', 'blog' );
?>

<!-- ── CTA Banner ── -->
<section class="nt-section">
    <div class="nt-container">
        <div class="nt-cta-banner">
            <img
                class="nt-cta-banner__bg"
                src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600&q=80"
                alt=""
                loading="lazy"
                aria-hidden="true"
            >
            <div class="nt-cta-banner__overlay"></div>
            <div class="nt-cta-banner__content">
                <span class="nt-eyebrow" style="color:rgba(255,255,255,.7)"><?php esc_html_e( 'Ready to Explore?', 'neartrips' ); ?></span>
                <h2><?php esc_html_e( 'Start Your Next Adventure Today', 'neartrips' ); ?></h2>
                <p><?php esc_html_e( 'Join millions of travellers who book with NearTrips every year. Get the best prices, hand-picked experiences, and 24/7 support.', 'neartrips' ); ?></p>
                <div style="display:flex;gap:var(--nt-space-3);justify-content:center;flex-wrap:wrap">
                    <a href="<?php echo esc_url( get_post_type_archive_link( nt_get_tour_post_type() ) ?: home_url( '/tours/' ) ); ?>" class="nt-btn nt-btn--primary nt-btn--lg">
                        <?php esc_html_e( 'Browse Tours', 'neartrips' ); ?>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="nt-btn nt-btn--ghost nt-btn--lg">
                        <?php esc_html_e( 'Contact Us', 'neartrips' ); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
