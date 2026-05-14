<?php
/**
 * CPT: Destinations
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'init', 'nt_register_cpt_destination' );
function nt_register_cpt_destination() {
    register_post_type( 'nt_destination', [
        'labels' => [
            'name'          => _x( 'Destinations', 'post type general name', 'neartrips' ),
            'singular_name' => _x( 'Destination', 'post type singular name', 'neartrips' ),
            'menu_name'     => __( 'Destinations', 'neartrips' ),
            'add_new_item'  => __( 'Add New Destination', 'neartrips' ),
            'edit_item'     => __( 'Edit Destination', 'neartrips' ),
            'not_found'     => __( 'No destinations found.', 'neartrips' ),
        ],
        'public'        => true,
        'show_in_rest'  => true,
        'rewrite'       => [ 'slug' => 'destinations', 'with_front' => false ],
        'has_archive'   => 'destinations',
        'menu_icon'     => 'dashicons-location-alt',
        'menu_position' => 8,
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
    ] );

    register_taxonomy( 'nt_dest_region', 'nt_destination', [
        'label'        => __( 'Regions', 'neartrips' ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'region' ],
    ] );

    $meta_keys = [
        '_nt_country'        => 'string',
        '_nt_continent'      => 'string',
        '_nt_tours_count'    => 'integer',
        '_nt_map_lat'        => 'number',
        '_nt_map_lng'        => 'number',
        '_nt_best_time'      => 'string',
        '_nt_currency'       => 'string',
        '_nt_language'       => 'string',
        '_nt_timezone'       => 'string',
    ];
    foreach ( $meta_keys as $key => $type ) {
        register_post_meta( 'nt_destination', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => '__return_true',
        ] );
    }
}
