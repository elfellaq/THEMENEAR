<?php
/**
 * SEO: Open Graph, Twitter Card, and JSON-LD Schema.
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Only add if Yoast / RankMath are NOT active */
if ( defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) ) { return; }

/* ── Open Graph + Twitter Card ── */
add_action( 'wp_head', 'nt_meta_tags' );
function nt_meta_tags() {
    if ( is_feed() || is_admin() ) { return; }

    global $post;

    $title       = is_singular() ? get_the_title() : get_bloginfo( 'name' );
    $description = is_singular() ? ( get_the_excerpt() ?: get_bloginfo( 'description' ) ) : get_bloginfo( 'description' );
    $description = wp_strip_all_tags( $description );
    $url         = is_singular() ? get_permalink() : home_url( '/' );
    $image       = is_singular() ? get_the_post_thumbnail_url( null, 'nt-hero' ) : get_site_icon_url( 512 );
    $site_name   = get_bloginfo( 'name' );

    $description = esc_attr( wp_trim_words( $description, 25 ) );
    $title       = esc_attr( $title );
    $url         = esc_url( $url );
    $image       = $image ? esc_url( $image ) : '';

    echo "\n<!-- NearTrips SEO -->\n";
    echo '<meta property="og:type" content="' . ( is_singular() ? 'article' : 'website' ) . '">' . "\n";
    echo '<meta property="og:title" content="' . $title . '">' . "\n";
    echo '<meta property="og:description" content="' . $description . '">' . "\n";
    echo '<meta property="og:url" content="' . $url . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr( $site_name ) . '">' . "\n";
    if ( $image ) echo '<meta property="og:image" content="' . $image . '">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . $title . '">' . "\n";
    echo '<meta name="twitter:description" content="' . $description . '">' . "\n";
    if ( $image ) echo '<meta name="twitter:image" content="' . $image . '">' . "\n";
}

/* ── JSON-LD Schema ── */
add_action( 'wp_head', 'nt_schema_jsonld' );
function nt_schema_jsonld() {
    if ( ! is_singular() ) { return; }

    $post_type = get_post_type();
    $schema    = null;

    if ( in_array( $post_type, [ 'nt_tour', 'trip' ], true ) ) {
        $price    = (float) get_post_meta( get_the_ID(), '_nt_price', true );
        $rating   = (float) ( get_post_meta( get_the_ID(), '_nt_rating', true ) ?: 5 );
        $reviews  = (int) get_post_meta( get_the_ID(), '_nt_reviews_count', true );
        $currency = function_exists( 'get_woocommerce_currency' ) ? get_woocommerce_currency() : 'USD';
        $schema   = [
            '@context'    => 'https://schema.org',
            '@type'       => 'TouristTrip',
            'name'        => get_the_title(),
            'description' => wp_strip_all_tags( get_the_excerpt() ),
            'url'         => get_permalink(),
            'image'       => get_the_post_thumbnail_url( null, 'nt-hero' ) ?: '',
            'touristType' => 'Traveller',
        ];
        if ( $price > 0 ) {
            $schema['offers'] = [
                '@type'         => 'Offer',
                'price'         => $price,
                'priceCurrency' => $currency,
                'availability'  => 'https://schema.org/InStock',
                'url'           => get_permalink(),
            ];
        }
        if ( $rating && $reviews ) {
            $schema['aggregateRating'] = [
                '@type'       => 'AggregateRating',
                'ratingValue' => $rating,
                'reviewCount' => $reviews,
                'bestRating'  => '5',
                'worstRating' => '1',
            ];
        }
    }

    if ( $post_type === 'nt_hotel' ) {
        $stars  = (int) get_post_meta( get_the_ID(), '_nt_stars', true );
        $rating = (float) ( get_post_meta( get_the_ID(), '_nt_rating', true ) ?: 4.5 );
        $addr   = get_post_meta( get_the_ID(), '_nt_address', true );
        $schema = [
            '@context'   => 'https://schema.org',
            '@type'      => 'Hotel',
            'name'       => get_the_title(),
            'description'=> wp_strip_all_tags( get_the_excerpt() ),
            'url'        => get_permalink(),
            'image'      => get_the_post_thumbnail_url( null, 'nt-hero' ) ?: '',
        ];
        if ( $stars )  { $schema['starRating'] = [ '@type' => 'Rating', 'ratingValue' => $stars ]; }
        if ( $addr )   { $schema['address']    = $addr; }
        if ( $rating ) { $schema['aggregateRating'] = [ '@type' => 'AggregateRating', 'ratingValue' => $rating, 'bestRating' => '5' ]; }
    }

    if ( ! $schema ) { return; }

    echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
