<?php
/**
 * Navigation menu registrations.
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'after_setup_theme', function () {
    register_nav_menus( [
        'primary'    => __( 'Primary Menu', 'neartrips' ),
        'mobile'     => __( 'Mobile Menu', 'neartrips' ),
        'footer-1'   => __( 'Footer Column 1', 'neartrips' ),
        'footer-2'   => __( 'Footer Column 2', 'neartrips' ),
        'footer-3'   => __( 'Footer Column 3', 'neartrips' ),
        'footer-4'   => __( 'Footer Column 4', 'neartrips' ),
    ] );
} );
