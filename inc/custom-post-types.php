<?php
/**
 * Custom post types & meta boxes.
 *
 * @package Travelio
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Register Tour Package & Destination CPTs.
 */
function travelio_register_cpts() {

    register_post_type( 'tour_package', array(
        'labels' => array(
            'name'               => __( 'Tour Packages', 'travelio' ),
            'singular_name'      => __( 'Tour Package', 'travelio' ),
            'add_new_item'       => __( 'Add new tour', 'travelio' ),
            'edit_item'          => __( 'Edit tour', 'travelio' ),
            'menu_name'          => __( 'Tours', 'travelio' ),
        ),
        'public'        => true,
        'has_archive'   => 'tours',
        'rewrite'       => array( 'slug' => 'tour' ),
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-palmtree',
        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    ) );

    register_post_type( 'destination', array(
        'labels' => array(
            'name'               => __( 'Destinations', 'travelio' ),
            'singular_name'      => __( 'Destination', 'travelio' ),
            'add_new_item'       => __( 'Add new destination', 'travelio' ),
            'edit_item'          => __( 'Edit destination', 'travelio' ),
            'menu_name'          => __( 'Destinations', 'travelio' ),
        ),
        'public'        => true,
        'has_archive'   => 'destinations',
        'rewrite'       => array( 'slug' => 'destination' ),
        'show_in_rest'  => true,
        'menu_icon'     => 'dashicons-location-alt',
        'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
    ) );

    // Taxonomies.
    register_taxonomy( 'tour_type', 'tour_package', array(
        'label'        => __( 'Tour Types', 'travelio' ),
        'public'       => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'rewrite'      => array( 'slug' => 'tour-type' ),
    ) );
}
add_action( 'init', 'travelio_register_cpts' );

/**
 * Meta boxes for Tour Package details.
 */
function travelio_meta_boxes() {
    add_meta_box( 'tv_tour_details', __( 'Tour Details', 'travelio' ), 'travelio_tour_meta_cb', 'tour_package', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'travelio_meta_boxes' );

function travelio_tour_meta_cb( $post ) {
    wp_nonce_field( 'tv_tour_save', 'tv_tour_nonce' );

    $fields = array(
        '_tv_tour_price'      => __( 'Price (e.g. $899)', 'travelio' ),
        '_tv_tour_duration'   => __( 'Duration (e.g. 7 Days, 6 Nights)', 'travelio' ),
        '_tv_tour_group_size' => __( 'Group Size (e.g. Max 12)', 'travelio' ),
        '_tv_tour_location'   => __( 'Location / Destination', 'travelio' ),
        '_tv_tour_rating'     => __( 'Rating (e.g. 4.8)', 'travelio' ),
    );

    echo '<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:14px">';
    foreach ( $fields as $key => $label ) {
        $val = get_post_meta( $post->ID, $key, true );
        printf(
            '<p><label style="display:block;font-weight:600;margin-bottom:4px">%s</label><input type="text" name="%s" value="%s" class="widefat"></p>',
            esc_html( $label ),
            esc_attr( $key ),
            esc_attr( $val )
        );
    }
    echo '</div>';

    $featured = get_post_meta( $post->ID, '_tv_tour_featured', true );
    printf(
        '<p><label><input type="checkbox" name="_tv_tour_featured" value="1" %s> %s</label></p>',
        checked( $featured, '1', false ),
        esc_html__( 'Show "Featured" badge on this tour', 'travelio' )
    );

    $included = get_post_meta( $post->ID, '_tv_tour_included', true );
    $excluded = get_post_meta( $post->ID, '_tv_tour_excluded', true );

    echo '<p><label style="display:block;font-weight:600;margin-bottom:4px">' . esc_html__( 'What\'s included (HTML list allowed)', 'travelio' ) . '</label>';
    echo '<textarea name="_tv_tour_included" rows="4" class="widefat">' . esc_textarea( $included ) . '</textarea></p>';

    echo '<p><label style="display:block;font-weight:600;margin-bottom:4px">' . esc_html__( 'What\'s NOT included (HTML list allowed)', 'travelio' ) . '</label>';
    echo '<textarea name="_tv_tour_excluded" rows="4" class="widefat">' . esc_textarea( $excluded ) . '</textarea></p>';
}

function travelio_save_tour_meta( $post_id ) {
    if ( ! isset( $_POST['tv_tour_nonce'] ) || ! wp_verify_nonce( $_POST['tv_tour_nonce'], 'tv_tour_save' ) ) { return; }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
    if ( ! current_user_can( 'edit_post', $post_id ) ) { return; }

    $text_keys = array( '_tv_tour_price', '_tv_tour_duration', '_tv_tour_group_size', '_tv_tour_location', '_tv_tour_rating' );
    foreach ( $text_keys as $k ) {
        if ( isset( $_POST[ $k ] ) ) {
            update_post_meta( $post_id, $k, sanitize_text_field( wp_unslash( $_POST[ $k ] ) ) );
        }
    }

    $html_keys = array( '_tv_tour_included', '_tv_tour_excluded' );
    foreach ( $html_keys as $k ) {
        if ( isset( $_POST[ $k ] ) ) {
            update_post_meta( $post_id, $k, wp_kses_post( wp_unslash( $_POST[ $k ] ) ) );
        }
    }

    update_post_meta( $post_id, '_tv_tour_featured', isset( $_POST['_tv_tour_featured'] ) ? '1' : '' );
}
add_action( 'save_post_tour_package', 'travelio_save_tour_meta' );
