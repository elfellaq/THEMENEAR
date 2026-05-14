<?php
/**
 * AJAX: Booking handler — adds to WooCommerce cart or redirects to WTE booking.
 * Action: nt_add_booking
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_ajax_nt_add_booking',        'nt_ajax_add_booking' );
add_action( 'wp_ajax_nopriv_nt_add_booking', 'nt_ajax_add_booking' );

function nt_ajax_add_booking() {
    check_ajax_referer( 'nt_nonce', 'nonce' );

    $post_id = (int) ( $_POST['booking_post_id'] ?? 0 );
    if ( ! $post_id || get_post_status( $post_id ) !== 'publish' ) {
        wp_send_json_error( [ 'message' => __( 'Invalid booking.', 'neartrips' ) ] );
    }

    $date = sanitize_text_field( wp_unslash( $_POST['booking_date'] ?? '' ) );
    $time = sanitize_text_field( wp_unslash( $_POST['booking_time'] ?? '' ) );
    $qty_adults   = max( 1, (int) ( $_POST['qty_adults']   ?? 1 ) );
    $qty_children = max( 0, (int) ( $_POST['qty_children'] ?? 0 ) );
    $qty_infants  = max( 0, (int) ( $_POST['qty_infants']  ?? 0 ) );
    $qty_total    = $qty_adults + $qty_children + $qty_infants;

    /* WP Travel Engine integration */
    if ( nt_is_wte_active() && class_exists( 'Wp_Travel_Engine' ) ) {
        $redirect = get_permalink( $post_id );
        wp_send_json_success( [ 'redirect' => $redirect ] );
    }

    /* WooCommerce cart integration */
    if ( function_exists( 'WC' ) && function_exists( 'wc_get_product' ) ) {
        $product_id = (int) get_post_meta( $post_id, '_nt_wc_product_id', true );
        if ( $product_id && wc_get_product( $product_id ) ) {
            $added = WC()->cart->add_to_cart( $product_id, $qty_total, 0, [], [
                'booking_post_id'   => $post_id,
                'booking_date'      => $date,
                'booking_time'      => $time,
                'qty_adults'        => $qty_adults,
                'qty_children'      => $qty_children,
                'qty_infants'       => $qty_infants,
            ] );
            if ( $added ) {
                wp_send_json_success( [ 'redirect' => wc_get_cart_url() ] );
            }
        }
    }

    /* Fallback: redirect to single post for manual booking */
    wp_send_json_success( [
        'redirect' => add_query_arg( [
            'booking_date' => rawurlencode( $date ),
            'adults'       => $qty_adults,
        ], get_permalink( $post_id ) ),
    ] );
}
