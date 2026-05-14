<?php
/**
 * NearTrips — Theme functions.
 *
 * @package NearTrips
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'NT_VERSION',  '2.0.0' );
define( 'NT_DIR',      get_template_directory() );
define( 'NT_URI',      get_template_directory_uri() );
define( 'NT_INC',      NT_DIR . '/inc' );
define( 'NT_ASSETS',   NT_URI . '/assets' );

/* ── Autoload includes ── */
$nt_includes = [
    NT_INC . '/setup/theme-support.php',
    NT_INC . '/setup/image-sizes.php',
    NT_INC . '/setup/menus.php',
    NT_INC . '/custom-post-types/cpt-tours.php',
    NT_INC . '/custom-post-types/cpt-hotels.php',
    NT_INC . '/custom-post-types/cpt-activities.php',
    NT_INC . '/custom-post-types/cpt-destinations.php',
    NT_INC . '/custom-post-types/cpt-cars.php',
    NT_INC . '/custom-post-types/cpt-testimonials.php',
    NT_INC . '/helpers/template-functions.php',
    NT_INC . '/performance/asset-loader.php',
    NT_INC . '/seo/meta-tags.php',
    NT_INC . '/ajax/search.php',
    NT_INC . '/ajax/booking.php',
    NT_INC . '/wte-integration.php',
];

foreach ( $nt_includes as $file ) {
    if ( file_exists( $file ) ) {
        require_once $file;
    }
}

if ( is_admin() ) {
    $admin_includes = [
        NT_INC . '/acf/field-groups.php',
        NT_DIR . '/includes/demo-importer.php',
    ];
    foreach ( $admin_includes as $file ) {
        if ( file_exists( $file ) ) {
            require_once $file;
        }
    }
}
