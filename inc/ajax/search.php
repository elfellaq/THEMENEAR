<?php
/**
 * AJAX: Live search handler.
 * Action: nt_live_search
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_ajax_nt_live_search',        'nt_ajax_live_search' );
add_action( 'wp_ajax_nopriv_nt_live_search', 'nt_ajax_live_search' );

function nt_ajax_live_search() {
    check_ajax_referer( 'nt_nonce', 'nonce' );

    $q = sanitize_text_field( wp_unslash( $_POST['q'] ?? '' ) );
    if ( strlen( $q ) < 2 ) {
        wp_send_json_error( [] );
    }

    $post_types = [ 'nt_tour', 'nt_hotel', 'nt_activity', 'nt_destination' ];
    if ( nt_is_wte_active() ) { $post_types[] = 'trip'; }

    $results = new WP_Query( [
        's'              => $q,
        'post_type'      => $post_types,
        'posts_per_page' => 8,
        'post_status'    => 'publish',
    ] );

    $data = [];
    if ( $results->have_posts() ) {
        while ( $results->have_posts() ) {
            $results->the_post();
            $thumb = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
            if ( ! $thumb ) { $thumb = 'https://placehold.co/100x100/0B2545/FFFFFF?text=NT'; }

            $post_type = get_post_type();
            $type_label = [
                'nt_tour'        => __( 'Tour', 'neartrips' ),
                'trip'           => __( 'Tour', 'neartrips' ),
                'nt_hotel'       => __( 'Hotel', 'neartrips' ),
                'nt_activity'    => __( 'Activity', 'neartrips' ),
                'nt_destination' => __( 'Destination', 'neartrips' ),
            ][ $post_type ] ?? ucfirst( $post_type );

            $data[] = [
                'title' => get_the_title(),
                'url'   => get_permalink(),
                'thumb' => $thumb,
                'type'  => $type_label,
                'price' => (float) get_post_meta( get_the_ID(), '_nt_price', true ),
            ];
        }
        wp_reset_postdata();
    }

    wp_send_json_success( $data );
}
