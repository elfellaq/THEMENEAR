<?php
/**
 * CPT: Tours
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'init', 'nt_register_cpt_tour' );
function nt_register_cpt_tour() {
    /* Skip if WP Travel Engine is active — it registers 'trip' */
    if ( post_type_exists( 'trip' ) ) { return; }

    $labels = [
        'name'                  => _x( 'Tours', 'post type general name', 'neartrips' ),
        'singular_name'         => _x( 'Tour', 'post type singular name', 'neartrips' ),
        'menu_name'             => _x( 'Tours', 'admin menu', 'neartrips' ),
        'add_new'               => __( 'Add New', 'neartrips' ),
        'add_new_item'          => __( 'Add New Tour', 'neartrips' ),
        'edit_item'             => __( 'Edit Tour', 'neartrips' ),
        'new_item'              => __( 'New Tour', 'neartrips' ),
        'view_item'             => __( 'View Tour', 'neartrips' ),
        'search_items'          => __( 'Search Tours', 'neartrips' ),
        'not_found'             => __( 'No tours found.', 'neartrips' ),
        'not_found_in_trash'    => __( 'No tours found in Trash.', 'neartrips' ),
        'all_items'             => __( 'All Tours', 'neartrips' ),
    ];

    register_post_type( 'nt_tour', [
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => [ 'slug' => 'tours', 'with_front' => false ],
        'capability_type'    => 'post',
        'has_archive'        => 'tours',
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-airplane',
        'supports'           => [ 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ],
    ] );

    /* Taxonomies */
    register_taxonomy( 'nt_tour_cat', 'nt_tour', [
        'label'        => __( 'Tour Categories', 'neartrips' ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'tour-category' ],
    ] );

    register_taxonomy( 'nt_destination', [ 'nt_tour', 'nt_hotel', 'nt_activity' ], [
        'label'        => __( 'Destinations', 'neartrips' ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'destination' ],
    ] );

    register_taxonomy( 'nt_tour_tag', 'nt_tour', [
        'label'        => __( 'Tour Tags', 'neartrips' ),
        'hierarchical' => false,
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'tour-tag' ],
    ] );
}

/* REST API — expose meta fields */
add_action( 'rest_api_init', 'nt_tour_rest_meta' );
function nt_tour_rest_meta() {
    $meta_keys = [
        '_nt_price'        => 'number',
        '_nt_price_old'    => 'number',
        '_nt_duration'     => 'string',
        '_nt_group_size'   => 'integer',
        '_nt_rating'       => 'number',
        '_nt_reviews_count'=> 'integer',
        '_nt_languages'    => 'string',
        '_nt_tour_type'    => 'string',
        '_nt_difficulty'   => 'string',
        '_nt_min_age'      => 'integer',
    ];
    foreach ( $meta_keys as $key => $type ) {
        register_post_meta( 'nt_tour', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => '__return_true',
        ] );
    }
}
