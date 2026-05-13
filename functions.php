<?php
/**
 * Travelio theme functions.
 *
 * @package Travelio
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'TRAVELIO_VERSION', '1.0.0' );
define( 'TRAVELIO_DIR', get_template_directory() );
define( 'TRAVELIO_URI', get_template_directory_uri() );

/**
 * Theme setup.
 */
function travelio_setup() {
    load_theme_textdomain( 'travelio', TRAVELIO_DIR . '/languages' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );

    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Menu', 'travelio' ),
        'footer'  => esc_html__( 'Footer Menu', 'travelio' ),
    ) );

    add_image_size( 'travelio-card', 600, 450, true );
    add_image_size( 'travelio-dest', 600, 800, true );
    add_image_size( 'travelio-hero', 1920, 1080, true );
}
add_action( 'after_setup_theme', 'travelio_setup' );

/**
 * Content width.
 */
function travelio_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'travelio_content_width', 1200 );
}
add_action( 'after_setup_theme', 'travelio_content_width', 0 );

/**
 * Enqueue assets.
 */
function travelio_assets() {
    // Google Fonts.
    wp_enqueue_style(
        'travelio-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap',
        array(),
        null
    );

    // Main stylesheet.
    wp_enqueue_style( 'travelio-style', get_stylesheet_uri(), array( 'travelio-fonts' ), TRAVELIO_VERSION );

    // Main script.
    wp_enqueue_script( 'travelio-main', TRAVELIO_URI . '/assets/js/main.js', array(), TRAVELIO_VERSION, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'travelio_assets' );

/**
 * Register sidebars.
 */
function travelio_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Main Sidebar', 'travelio' ),
        'id'            => 'sidebar-main',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    for ( $i = 1; $i <= 4; $i++ ) {
        register_sidebar( array(
            'name'          => sprintf( esc_html__( 'Footer %d', 'travelio' ), $i ),
            'id'            => 'footer-' . $i,
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4>',
            'after_title'   => '</h4>',
        ) );
    }
}
add_action( 'widgets_init', 'travelio_widgets_init' );

/**
 * Pagination markup wrapper.
 */
function travelio_pagination() {
    the_posts_pagination( array(
        'mid_size'  => 2,
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
        'class'     => 'tv-pagination',
    ) );
}

/**
 * Custom excerpt length.
 */
function travelio_excerpt_length( $length ) {
    return is_admin() ? $length : 24;
}
add_filter( 'excerpt_length', 'travelio_excerpt_length' );

function travelio_excerpt_more( $more ) {
    return is_admin() ? $more : '&hellip;';
}
add_filter( 'excerpt_more', 'travelio_excerpt_more' );

/**
 * Body classes.
 */
function travelio_body_classes( $classes ) {
    if ( ! is_singular() ) { $classes[] = 'hfeed'; }
    if ( is_front_page() )  { $classes[] = 'tv-home'; }
    return $classes;
}
add_filter( 'body_class', 'travelio_body_classes' );

/**
 * Custom post types: Tour Packages & Destinations.
 */
require_once TRAVELIO_DIR . '/inc/custom-post-types.php';

/**
 * Customizer settings.
 */
require_once TRAVELIO_DIR . '/inc/customizer.php';

/**
 * Template tags.
 */
require_once TRAVELIO_DIR . '/inc/template-tags.php';

/**
 * WP Travel Engine integration (optional plugin).
 */
require_once TRAVELIO_DIR . '/inc/wte-integration.php';

/**
 * Helper: get hero image URL with fallback.
 */
function travelio_hero_image() {
    $custom = get_theme_mod( 'travelio_hero_image' );
    if ( $custom ) { return esc_url( $custom ); }
    // Fallback: a public-domain Unsplash photo via source.unsplash.com (no auth required).
    return 'https://source.unsplash.com/1920x1080/?travel,landscape';
}

/**
 * Helper: meta value with default.
 */
function travelio_meta( $key, $default = '' ) {
    $v = get_post_meta( get_the_ID(), $key, true );
    return $v ? $v : $default;
}
