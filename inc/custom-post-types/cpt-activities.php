<?php
/**
 * CPT: Activities
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'init', 'nt_register_cpt_activity' );
function nt_register_cpt_activity() {
    register_post_type( 'nt_activity', [
        'labels' => [
            'name'          => _x( 'Activities', 'post type general name', 'neartrips' ),
            'singular_name' => _x( 'Activity', 'post type singular name', 'neartrips' ),
            'menu_name'     => __( 'Activities', 'neartrips' ),
            'add_new_item'  => __( 'Add New Activity', 'neartrips' ),
            'edit_item'     => __( 'Edit Activity', 'neartrips' ),
            'not_found'     => __( 'No activities found.', 'neartrips' ),
        ],
        'public'        => true,
        'show_in_rest'  => true,
        'rewrite'       => [ 'slug' => 'activities', 'with_front' => false ],
        'has_archive'   => 'activities',
        'menu_icon'     => 'dashicons-star-filled',
        'menu_position' => 7,
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields' ],
    ] );

    register_taxonomy( 'nt_activity_cat', 'nt_activity', [
        'label'        => __( 'Activity Categories', 'neartrips' ),
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'activity-category' ],
    ] );

    $meta_keys = [
        '_nt_price'         => 'number',
        '_nt_duration'      => 'string',
        '_nt_group_size'    => 'integer',
        '_nt_rating'        => 'number',
        '_nt_reviews_count' => 'integer',
        '_nt_difficulty'    => 'string',
        '_nt_min_age'       => 'integer',
        '_nt_includes'      => 'string',
        '_nt_excludes'      => 'string',
    ];
    foreach ( $meta_keys as $key => $type ) {
        register_post_meta( 'nt_activity', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => '__return_true',
        ] );
    }
}
