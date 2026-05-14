<?php
/**
 * CPT: Car Rentals
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'init', 'nt_register_cpt_car' );
function nt_register_cpt_car() {
    register_post_type( 'nt_car', [
        'labels' => [
            'name'          => _x( 'Car Rentals', 'post type general name', 'neartrips' ),
            'singular_name' => _x( 'Car Rental', 'post type singular name', 'neartrips' ),
            'menu_name'     => __( 'Car Rentals', 'neartrips' ),
            'add_new_item'  => __( 'Add New Car', 'neartrips' ),
            'edit_item'     => __( 'Edit Car', 'neartrips' ),
            'not_found'     => __( 'No cars found.', 'neartrips' ),
        ],
        'public'        => true,
        'show_in_rest'  => true,
        'rewrite'       => [ 'slug' => 'car-rental', 'with_front' => false ],
        'has_archive'   => 'car-rental',
        'menu_icon'     => 'dashicons-car',
        'menu_position' => 9,
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
    ] );

    register_taxonomy( 'nt_car_type', 'nt_car', [
        'label'        => __( 'Car Types', 'neartrips' ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'car-type' ],
    ] );

    $meta_keys = [
        '_nt_price_day'     => 'number',
        '_nt_seats'         => 'integer',
        '_nt_doors'         => 'integer',
        '_nt_transmission'  => 'string',
        '_nt_fuel_type'     => 'string',
        '_nt_ac'            => 'boolean',
        '_nt_mileage'       => 'string',
        '_nt_rating'        => 'number',
        '_nt_pickup_loc'    => 'string',
    ];
    foreach ( $meta_keys as $key => $type ) {
        register_post_meta( 'nt_car', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => '__return_true',
        ] );
    }
}
