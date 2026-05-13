<?php
/**
 * Template tags & menu fallback.
 *
 * @package Travelio
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Fallback navigation when no menu is set.
 */
function travelio_fallback_menu() {
    echo '<ul>';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'travelio' ) . '</a></li>';
    if ( post_type_exists( 'tour_package' ) ) {
        echo '<li><a href="' . esc_url( get_post_type_archive_link( 'tour_package' ) ) . '">' . esc_html__( 'Tours', 'travelio' ) . '</a></li>';
    }
    if ( post_type_exists( 'destination' ) ) {
        echo '<li><a href="' . esc_url( get_post_type_archive_link( 'destination' ) ) . '">' . esc_html__( 'Destinations', 'travelio' ) . '</a></li>';
    }
    $blog = get_permalink( get_option( 'page_for_posts' ) );
    if ( $blog ) {
        echo '<li><a href="' . esc_url( $blog ) . '">' . esc_html__( 'Blog', 'travelio' ) . '</a></li>';
    }
    echo '<li><a href="' . esc_url( home_url( '/about/' ) ) . '">' . esc_html__( 'About', 'travelio' ) . '</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">' . esc_html__( 'Contact', 'travelio' ) . '</a></li>';
    echo '</ul>';
}
