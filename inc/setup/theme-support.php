<?php
/**
 * Theme support registration.
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function nt_setup() {
    load_theme_textdomain( 'neartrips', NT_DIR . '/languages' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    add_theme_support( 'custom-logo', [
        'height'      => 60,
        'width'       => 220,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => [ 'site-title', 'site-description' ],
    ] );

    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ] );

    add_theme_support( 'custom-background', [
        'default-color' => 'ffffff',
    ] );
}
add_action( 'after_setup_theme', 'nt_setup' );

/* ── Content width ── */
function nt_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'nt_content_width', 1200 );
}
add_action( 'after_setup_theme', 'nt_content_width', 0 );

/* ── Body classes ── */
function nt_body_classes( $classes ) {
    if ( ! is_singular() )   { $classes[] = 'hfeed'; }
    if ( is_front_page() )   { $classes[] = 'nt-home'; }
    if ( is_rtl() )          { $classes[] = 'rtl'; }
    if ( is_single() )       { $classes[] = 'nt-single'; }
    if ( is_archive() )      { $classes[] = 'nt-archive'; }
    return $classes;
}
add_filter( 'body_class', 'nt_body_classes' );

/* ── Sidebars ── */
function nt_widgets_init() {
    $sidebars = [
        [ 'name' => __( 'Main Sidebar', 'neartrips' ), 'id' => 'sidebar-main' ],
        [ 'name' => __( 'Tour Archive Sidebar', 'neartrips' ), 'id' => 'sidebar-tours' ],
        [ 'name' => __( 'Hotel Archive Sidebar', 'neartrips' ), 'id' => 'sidebar-hotels' ],
        [ 'name' => __( 'Blog Sidebar', 'neartrips' ), 'id' => 'sidebar-blog' ],
    ];
    foreach ( $sidebars as $sb ) {
        register_sidebar( array_merge( $sb, [
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ] ) );
    }
    for ( $i = 1; $i <= 4; $i++ ) {
        register_sidebar( [
            'name'          => sprintf( __( 'Footer Column %d', 'neartrips' ), $i ),
            'id'            => 'footer-' . $i,
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ] );
    }
}
add_action( 'widgets_init', 'nt_widgets_init' );

/* ── Pagination ── */
function nt_pagination() {
    the_posts_pagination( [
        'mid_size'  => 2,
        'prev_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15,18 9,12 15,6"/></svg>',
        'next_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9,18 15,12 9,6"/></svg>',
        'class'     => 'nt-pagination',
    ] );
}

/* ── Excerpt ── */
add_filter( 'excerpt_length', fn() => 24 );
add_filter( 'excerpt_more',   fn() => '&hellip;' );
