<?php
/**
 * Asset enqueuing — CSS + JS pipeline.
 * CDN-sourced libraries; local built files for theme CSS/JS.
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ── Frontend assets ── */
add_action( 'wp_enqueue_scripts', 'nt_enqueue_assets' );
function nt_enqueue_assets() {

    /* Google Fonts — preconnect first */
    wp_enqueue_style( 'nt-fonts-preconnect', 'https://fonts.googleapis.com', [], null );

    wp_enqueue_style(
        'nt-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&family=Cairo:wght@400;500;600;700&display=swap',
        [ 'nt-fonts-preconnect' ],
        null
    );

    /* Theme CSS modules — order matters */
    $styles = [
        'nt-tokens'     => 'assets/css/tokens.css',
        'nt-typography' => 'assets/css/typography.css',
        'nt-layout'     => 'assets/css/layout.css',
        'nt-components' => 'assets/css/components.css',
        'nt-animations' => 'assets/css/animations.css',
        'nt-header'     => 'assets/css/header.css',
        'nt-sections'   => 'assets/css/sections.css',
        'nt-booking'    => 'assets/css/booking.css',
        'nt-search'     => 'assets/css/search.css',
        'nt-single'     => 'assets/css/single.css',
        'nt-footer'     => 'assets/css/footer.css',
    ];

    $base_dep = [ 'nt-fonts' ];
    foreach ( $styles as $handle => $path ) {
        $file = NT_DIR . '/' . $path;
        if ( file_exists( $file ) ) {
            wp_enqueue_style( $handle, NT_URI . '/' . $path, $base_dep, NT_VERSION );
            $base_dep = [ $handle ];
        }
    }

    /* RTL override */
    if ( is_rtl() ) {
        wp_enqueue_style( 'nt-rtl', NT_URI . '/assets/css/rtl.css', [ 'nt-footer' ], NT_VERSION );
    }

    /* WordPress theme stylesheet (required for theme recognition) */
    wp_enqueue_style( 'neartrips-style', get_stylesheet_uri(), [], NT_VERSION );

    /* ── Third-party JS (CDN, deferred) ── */

    /* Alpine.js — reactive UI state */
    wp_enqueue_script(
        'alpinejs',
        'https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js',
        [],
        '3.14.1',
        [ 'strategy' => 'defer', 'in_footer' => true ]
    );

    /* Swiper.js — sliders */
    wp_enqueue_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', [], '11' );
    wp_enqueue_script(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        '11',
        true
    );

    /* GSAP + ScrollTrigger */
    wp_enqueue_script( 'gsap', 'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js', [], '3.12.5', true );
    wp_enqueue_script(
        'gsap-scrolltrigger',
        'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js',
        [ 'gsap' ],
        '3.12.5',
        true
    );

    /* flatpickr — date pickers */
    wp_enqueue_style( 'flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', [], null );
    wp_enqueue_script( 'flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr', [], null, true );

    /* ── Theme JS modules ── */
    $scripts = [
        'nt-dark-mode' => [ 'file' => 'assets/js/dark-mode.js',  'deps' => [] ],
        'nt-header'    => [ 'file' => 'assets/js/header.js',     'deps' => [] ],
        'nt-sliders'   => [ 'file' => 'assets/js/sliders.js',    'deps' => [ 'swiper' ] ],
        'nt-search'    => [ 'file' => 'assets/js/search.js',     'deps' => [ 'flatpickr' ] ],
        'nt-booking'   => [ 'file' => 'assets/js/booking.js',    'deps' => [ 'flatpickr' ] ],
        'nt-animations'=> [ 'file' => 'assets/js/animations.js', 'deps' => [ 'gsap-scrolltrigger' ] ],
        'nt-main'      => [ 'file' => 'assets/js/main.js',       'deps' => [ 'nt-header', 'nt-sliders', 'nt-animations' ] ],
    ];

    foreach ( $scripts as $handle => $cfg ) {
        $file = NT_DIR . '/' . $cfg['file'];
        if ( file_exists( $file ) ) {
            wp_enqueue_script( $handle, NT_URI . '/' . $cfg['file'], $cfg['deps'], NT_VERSION, true );
        }
    }

    /* Inline JS config object for AJAX/nonce */
    wp_localize_script( 'nt-main', 'ntConfig', [
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'nonce'     => wp_create_nonce( 'nt_nonce' ),
        'siteUrl'   => home_url(),
        'currency'  => get_woocommerce_currency_symbol(),
        'isRtl'     => is_rtl() ? 'true' : 'false',
        'i18n'      => [
            'loading'    => __( 'Loading…', 'neartrips' ),
            'noResults'  => __( 'No results found.', 'neartrips' ),
            'bookNow'    => __( 'Book Now', 'neartrips' ),
            'addToCart'  => __( 'Add to Cart', 'neartrips' ),
        ],
    ] );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

/* ── Critical CSS inlined for above-the-fold ── */
add_action( 'wp_head', 'nt_critical_css', 5 );
function nt_critical_css() {
    $critical = NT_DIR . '/assets/css/critical.css';
    if ( ! file_exists( $critical ) ) { return; }
    echo '<style id="nt-critical">';
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    echo file_get_contents( $critical );
    echo '</style>';
}

/* ── Preload key fonts ── */
add_action( 'wp_head', 'nt_preload_assets', 1 );
function nt_preload_assets() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <?php
}

/* ── Admin assets ── */
add_action( 'admin_enqueue_scripts', 'nt_admin_assets' );
function nt_admin_assets() {
    wp_enqueue_style( 'nt-admin', NT_URI . '/assets/css/admin.css', [], NT_VERSION );
}
