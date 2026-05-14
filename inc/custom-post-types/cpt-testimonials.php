<?php
/**
 * CPT: Testimonials
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'init', 'nt_register_cpt_testimonial' );
function nt_register_cpt_testimonial() {
    register_post_type( 'nt_testimonial', [
        'labels' => [
            'name'          => _x( 'Testimonials', 'post type general name', 'neartrips' ),
            'singular_name' => _x( 'Testimonial', 'post type singular name', 'neartrips' ),
            'menu_name'     => __( 'Testimonials', 'neartrips' ),
            'add_new_item'  => __( 'Add New Testimonial', 'neartrips' ),
            'edit_item'     => __( 'Edit Testimonial', 'neartrips' ),
        ],
        'public'          => false,
        'show_ui'         => true,
        'show_in_menu'    => true,
        'show_in_rest'    => true,
        'menu_icon'       => 'dashicons-format-quote',
        'menu_position'   => 20,
        'supports'        => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
    ] );

    $meta_keys = [
        '_nt_reviewer_name'   => 'string',
        '_nt_reviewer_role'   => 'string',
        '_nt_reviewer_country'=> 'string',
        '_nt_rating'          => 'number',
        '_nt_tour_ref'        => 'integer',
        '_nt_date'            => 'string',
    ];
    foreach ( $meta_keys as $key => $type ) {
        register_post_meta( 'nt_testimonial', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => $type,
            'auth_callback' => '__return_true',
        ] );
    }
}
