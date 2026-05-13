<?php
/**
 * Theme Customizer.
 *
 * @package Travelio
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function travelio_customize_register( $wp_customize ) {

    $wp_customize->add_section( 'travelio_hero', array(
        'title'    => __( 'Hero Section', 'travelio' ),
        'priority' => 30,
    ) );

    $controls = array(
        'travelio_hero_title'    => array( 'label' => __( 'Hero Title', 'travelio' ),    'default' => __( 'Explore the world, one journey at a time', 'travelio' ) ),
        'travelio_hero_accent'   => array( 'label' => __( 'Accent Word', 'travelio' ),   'default' => __( 'extraordinary', 'travelio' ) ),
        'travelio_hero_subtitle' => array( 'label' => __( 'Hero Subtitle', 'travelio' ), 'default' => __( 'Hand-crafted tour packages, breathtaking destinations.', 'travelio' ) ),
    );
    foreach ( $controls as $id => $opts ) {
        $wp_customize->add_setting( $id, array( 'default' => $opts['default'], 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( $id, array( 'section' => 'travelio_hero', 'label' => $opts['label'], 'type' => 'text' ) );
    }

    $wp_customize->add_setting( 'travelio_hero_image', array( 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'travelio_hero_image', array(
        'label'   => __( 'Hero Background Image', 'travelio' ),
        'section' => 'travelio_hero',
    ) ) );

    // Contact info.
    $wp_customize->add_section( 'travelio_contact', array(
        'title'    => __( 'Contact & Footer', 'travelio' ),
        'priority' => 40,
    ) );

    $contact_fields = array(
        'travelio_phone'    => array( 'label' => __( 'Phone', 'travelio' ),    'default' => '+1 (555) 123-4567' ),
        'travelio_email'    => array( 'label' => __( 'Email', 'travelio' ),    'default' => 'hello@example.com' ),
        'travelio_address'  => array( 'label' => __( 'Address', 'travelio' ),  'default' => '123 Wanderlust Ave, Lisbon' ),
        'travelio_facebook' => array( 'label' => __( 'Facebook URL', 'travelio' ),  'default' => '#' ),
        'travelio_twitter'  => array( 'label' => __( 'Twitter URL', 'travelio' ),   'default' => '#' ),
        'travelio_instagram'=> array( 'label' => __( 'Instagram URL', 'travelio' ), 'default' => '#' ),
        'travelio_youtube'  => array( 'label' => __( 'YouTube URL', 'travelio' ),   'default' => '#' ),
        'travelio_cta_url'  => array( 'label' => __( 'Header "Book Now" link', 'travelio' ), 'default' => '#contact' ),
    );
    foreach ( $contact_fields as $id => $opts ) {
        $wp_customize->add_setting( $id, array( 'default' => $opts['default'], 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( $id, array( 'section' => 'travelio_contact', 'label' => $opts['label'], 'type' => 'text' ) );
    }

    $wp_customize->add_setting( 'travelio_footer_about', array(
        'default'           => __( 'We craft unforgettable journeys to the world\'s most inspiring destinations.', 'travelio' ),
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'travelio_footer_about', array(
        'section' => 'travelio_contact',
        'label'   => __( 'Footer About Text', 'travelio' ),
        'type'    => 'textarea',
    ) );
}
add_action( 'customize_register', 'travelio_customize_register' );
