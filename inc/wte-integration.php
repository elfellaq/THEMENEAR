<?php
/**
 * WP Travel Engine integration hooks.
 *
 * If the WP Travel Engine plugin is active, Travelio will defer to its
 * `trip` post type for booking-enabled tours. The theme's `tour_package`
 * CPT remains available as a lightweight alternative for sites that don't
 * need full booking/payment functionality.
 *
 * @package Travelio
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Tell WP Travel Engine that this theme provides its own templates so the
 * plugin doesn't load its bundled (often unstyled) markup.
 */
add_filter( 'wte_load_default_template', '__return_false' );

/**
 * Add body class when WTE is active.
 */
add_filter( 'body_class', function( $classes ) {
    if ( class_exists( 'Wp_Travel_Engine' ) || class_exists( 'WPTrip_Summary' ) ) {
        $classes[] = 'has-wte';
    }
    return $classes;
} );

/**
 * Convenience: if a Travelio "tour_package" CPT has a matching WTE trip
 * (by title), redirect single-tour_package to the WTE trip permalink.
 * This lets editors who switch to WTE seamlessly use the same theme.
 */
add_action( 'template_redirect', function() {
    if ( ! is_singular( 'tour_package' ) || ! post_type_exists( 'trip' ) ) { return; }
    $match = get_page_by_title( get_the_title(), OBJECT, 'trip' );
    if ( $match && 'publish' === $match->post_status ) {
        wp_safe_redirect( get_permalink( $match->ID ), 301 );
        exit;
    }
} );

/**
 * Register destination taxonomy for WTE trips
 */
add_action( 'init', function() {
    if ( ! post_type_exists( 'trip' ) ) { return; }
    
    register_taxonomy( 'destination', 'trip', array(
        'label'        => __( 'Destinations', 'travelio' ),
        'public'       => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => array( 'slug' => 'destination' ),
    ) );
} );

/**
 * Add meta fields support for demo importer compatibility
 */
add_action( 'init', function() {
    if ( ! post_type_exists( 'trip' ) ) { return; }
    
    // Register meta fields for WTE trips
    register_meta( 'post', 'wpte_trip_duration', array(
        'type'              => 'string',
        'single'            => true,
        'sanitize_callback' => 'sanitize_text_field',
        'show_in_rest'      => true,
    ) );
    
    register_meta( 'post', 'wpte_trip_price', array(
        'type'              => 'string',
        'single'            => true,
        'sanitize_callback' => 'sanitize_text_field',
        'show_in_rest'      => true,
    ) );
    
    register_meta( 'post', 'wpte_trip_original_price', array(
        'type'              => 'string',
        'single'            => true,
        'sanitize_callback' => 'sanitize_text_field',
        'show_in_rest'      => true,
    ) );
    
    register_meta( 'post', 'wpte_trip_availability', array(
        'type'              => 'string',
        'single'            => true,
        'sanitize_callback' => 'sanitize_text_field',
        'show_in_rest'      => true,
    ) );
    
    register_meta( 'post', 'wpte_trip_gallery', array(
        'type'              => 'array',
        'single'            => true,
        'sanitize_callback' => 'wp_sanitize_array',
        'show_in_rest'      => true,
    ) );
} );
