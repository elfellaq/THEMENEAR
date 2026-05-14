<?php
/**
 * WP Travel Engine integration — compatibility layer.
 * Maps WTE 'trip' post type to NearTrips templates and meta.
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ── Register destination taxonomy on WTE trips ── */
add_action( 'init', 'nt_wte_register_taxonomy', 20 );
function nt_wte_register_taxonomy() {
    if ( ! nt_is_wte_active() ) { return; }
    if ( ! taxonomy_exists( 'nt_destination' ) ) { return; }
    register_taxonomy_for_object_type( 'nt_destination', 'trip' );
}

/* ── Map WTE trip price to NearTrips meta key ── */
add_filter( 'nt_tour_price', 'nt_wte_price', 10, 2 );
function nt_wte_price( $price, $post_id ) {
    if ( ! nt_is_wte_active() ) { return $price; }
    $settings = get_post_meta( $post_id, 'wp_travel_engine_setting', true );
    if ( isset( $settings['trip_price'] ) && (float) $settings['trip_price'] > 0 ) {
        return (float) $settings['trip_price'];
    }
    return $price;
}

/* ── Use NearTrips single template for 'trip' post type ── */
add_filter( 'single_template', 'nt_wte_single_template' );
function nt_wte_single_template( $template ) {
    if ( is_singular( 'trip' ) ) {
        $custom = NT_DIR . '/single-nt_tour.php';
        if ( file_exists( $custom ) ) { return $custom; }
    }
    return $template;
}

/* ── Use NearTrips archive for 'trip' archive ── */
add_filter( 'archive_template', 'nt_wte_archive_template' );
function nt_wte_archive_template( $template ) {
    if ( is_post_type_archive( 'trip' ) ) {
        $custom = NT_DIR . '/archive-nt_tour.php';
        if ( file_exists( $custom ) ) { return $custom; }
    }
    return $template;
}

/* ── Body class helper ── */
add_filter( 'body_class', 'nt_wte_body_class' );
function nt_wte_body_class( $classes ) {
    if ( is_singular( 'trip' ) || is_post_type_archive( 'trip' ) ) {
        $classes[] = 'nt-is-wte';
    }
    return $classes;
}

/* ── Expose WTE meta to REST ── */
add_action( 'rest_api_init', 'nt_wte_rest_meta' );
function nt_wte_rest_meta() {
    if ( ! nt_is_wte_active() ) { return; }
    $keys = [ 'wp_travel_engine_setting', 'wp_travel_engine_itinerary_setting', 'wp_travel_engine_faq_setting' ];
    foreach ( $keys as $key ) {
        register_post_meta( 'trip', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'object',
            'auth_callback' => '__return_true',
        ] );
    }
}
