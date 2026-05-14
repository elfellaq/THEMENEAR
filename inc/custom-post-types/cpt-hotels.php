<?php
/**
 * CPT: Hotels
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'init', 'nt_register_cpt_hotel' );
function nt_register_cpt_hotel() {
    register_post_type( 'nt_hotel', [
        'labels' => [
            'name'          => _x( 'Hotels', 'post type general name', 'neartrips' ),
            'singular_name' => _x( 'Hotel', 'post type singular name', 'neartrips' ),
            'menu_name'     => __( 'Hotels', 'neartrips' ),
            'add_new_item'  => __( 'Add New Hotel', 'neartrips' ),
            'edit_item'     => __( 'Edit Hotel', 'neartrips' ),
            'not_found'     => __( 'No hotels found.', 'neartrips' ),
        ],
        'public'          => true,
        'show_in_rest'    => true,
        'rewrite'         => [ 'slug' => 'hotels', 'with_front' => false ],
        'has_archive'     => 'hotels',
        'menu_icon'       => 'dashicons-building',
        'menu_position'   => 6,
        'supports'        => [ 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ],
    ] );

    register_taxonomy( 'nt_hotel_type', 'nt_hotel', [
        'label'        => __( 'Hotel Types', 'neartrips' ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'hotel-type' ],
    ] );

    register_taxonomy( 'nt_hotel_amenity', 'nt_hotel', [
        'label'        => __( 'Amenities', 'neartrips' ),
        'hierarchical' => false,
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'amenity' ],
    ] );

    $meta_keys = [
        '_nt_price_night'   => 'number',
        '_nt_stars'         => 'integer',
        '_nt_rating'        => 'number',
        '_nt_reviews_count' => 'integer',
        '_nt_rooms'         => 'integer',
        '_nt_address'       => 'string',
        '_nt_map_lat'       => 'number',
        '_nt_map_lng'       => 'number',
        '_nt_check_in'      => 'string',
        '_nt_check_out'     => 'string',
        '_nt_phone'         => 'string',
        '_nt_email'         => 'string',
    ];
    foreach ( $meta_keys as $key => $type ) {
        register_post_meta( 'nt_hotel', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => '__return_true',
        ] );
    }
}
