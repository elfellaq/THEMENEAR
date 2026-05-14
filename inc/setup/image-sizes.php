<?php
/**
 * Custom image sizes.
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'after_setup_theme', function () {
    add_image_size( 'nt-card',     600,  450, true );
    add_image_size( 'nt-card-lg',  900,  600, true );
    add_image_size( 'nt-dest',     500,  700, true );
    add_image_size( 'nt-hero',    1920, 1080, true );
    add_image_size( 'nt-thumb',    400,  300, true );
    add_image_size( 'nt-blog',     800,  500, true );
    add_image_size( 'nt-square',   400,  400, true );
} );

/* Expose custom sizes in media library */
add_filter( 'image_size_names_choose', function ( $sizes ) {
    return array_merge( $sizes, [
        'nt-card'    => __( 'NT Card (600×450)', 'neartrips' ),
        'nt-card-lg' => __( 'NT Card Large (900×600)', 'neartrips' ),
        'nt-dest'    => __( 'NT Destination (500×700)', 'neartrips' ),
        'nt-hero'    => __( 'NT Hero (1920×1080)', 'neartrips' ),
        'nt-blog'    => __( 'NT Blog (800×500)', 'neartrips' ),
    ] );
} );
