<?php
/**
 * Template helper functions used throughout theme templates.
 *
 * @package NearTrips
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ── Meta value with default ── */
function nt_meta( string $key, $default = '', int $post_id = 0 ) {
    $id = $post_id ?: get_the_ID();
    $v  = get_post_meta( $id, $key, true );
    return ( $v !== '' && $v !== false ) ? $v : $default;
}

/* ── Render star icons ── */
function nt_stars( float $rating = 5.0, bool $echo = true ): string {
    $out  = '<span class="nt-stars-fill" aria-label="' . esc_attr( sprintf( __( '%s out of 5 stars', 'neartrips' ), $rating ) ) . '">';
    for ( $i = 1; $i <= 5; $i++ ) {
        $filled = $i <= $rating ? 'var(--nt-yellow)' : 'none';
        $stroke = $i <= $rating ? 'var(--nt-yellow)'  : 'var(--nt-border)';
        $out .= sprintf(
            '<svg class="nt-star" viewBox="0 0 24 24" fill="%s" stroke="%s" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>',
            esc_attr( $filled ),
            esc_attr( $stroke )
        );
    }
    $out .= '</span>';
    if ( $echo ) {
        echo $out; // phpcs:ignore WordPress.Security.EscapeOutput
    }
    return $out;
}

/* ── Currency-formatted price ── */
function nt_price( $amount, bool $echo = true ): string {
    $symbol    = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '$';
    $formatted = $symbol . number_format( (float) $amount, 0, '.', ',' );
    if ( $echo ) { echo esc_html( $formatted ); }
    return $formatted;
}

/* ── Render a card ── */
function nt_get_card( string $type, int $post_id, array $args = [] ): void {
    get_template_part( 'template-parts/cards/card', $type, array_merge( [ 'post_id' => $post_id ], $args ) );
}

/* ── Featured Tours query ── */
function nt_get_featured_tours( int $count = 6 ): WP_Query {
    $pt = post_type_exists( 'trip' ) ? 'trip' : 'nt_tour';
    return new WP_Query( [
        'post_type'      => $pt,
        'posts_per_page' => $count,
        'meta_key'       => '_nt_rating',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
        'post_status'    => 'publish',
    ] );
}

/* ── Featured Destinations query ── */
function nt_get_featured_destinations( int $count = 6 ): WP_Query {
    return new WP_Query( [
        'post_type'      => 'nt_destination',
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ] );
}

/* ── Testimonials query ── */
function nt_get_testimonials( int $count = 8 ): WP_Query {
    return new WP_Query( [
        'post_type'      => 'nt_testimonial',
        'posts_per_page' => $count,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ] );
}

/* ── Thumbnail with fallback ── */
function nt_thumbnail( int $post_id, string $size = 'nt-card', string $alt = '' ): string {
    if ( has_post_thumbnail( $post_id ) ) {
        return get_the_post_thumbnail( $post_id, $size, [ 'alt' => $alt, 'loading' => 'lazy' ] );
    }
    $dims = [
        'nt-card'    => [ 600, 450 ],
        'nt-card-lg' => [ 900, 600 ],
        'nt-dest'    => [ 500, 700 ],
        'nt-hero'    => [ 1920, 1080 ],
        'nt-blog'    => [ 800, 500 ],
    ];
    [ $w, $h ] = $dims[ $size ] ?? [ 600, 450 ];
    return sprintf(
        '<img src="https://placehold.co/%dx%d/0B2545/FFFFFF?text=NearTrips" alt="%s" loading="lazy" width="%d" height="%d">',
        $w, $h, esc_attr( $alt ), $w, $h
    );
}

/* ── Section head helper ── */
function nt_section_head( string $eyebrow, string $title, string $desc = '', string $align = 'center' ): void {
    $class = 'nt-section-head' . ( $align !== 'center' ? ' nt-section-head--' . esc_attr( $align ) : '' );
    ?>
    <div class="<?php echo esc_attr( $class ); ?>">
        <?php if ( $eyebrow ) : ?>
            <span class="nt-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
        <?php endif; ?>
        <h2><?php echo wp_kses_post( $title ); ?></h2>
        <?php if ( $desc ) : ?>
            <p class="nt-lead"><?php echo wp_kses_post( $desc ); ?></p>
        <?php endif; ?>
    </div>
    <?php
}

/* ── SVG icon helper ── */
function nt_icon( string $name, int $size = 20 ): string {
    $icons = [
        'clock'     => '<path d="M12 2a10 10 0 100 20A10 10 0 0012 2zm0 18a8 8 0 110-16 8 8 0 010 16zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/>',
        'users'     => '<path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>',
        'map-pin'   => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>',
        'star'      => '<polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>',
        'calendar'  => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
        'chevron-r' => '<polyline points="9,18 15,12 9,6"/>',
        'chevron-l' => '<polyline points="15,18 9,12 15,6"/>',
        'chevron-d' => '<polyline points="6,9 12,15 18,9"/>',
        'search'    => '<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
        'menu'      => '<line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>',
        'x'         => '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
        'sun'       => '<circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>',
        'moon'      => '<path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>',
        'heart'     => '<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>',
        'share'     => '<circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>',
        'check'     => '<polyline points="20,6 9,17 4,12"/>',
        'car'       => '<rect x="1" y="3" width="15" height="13"/><polygon points="16,8 20,8 23,11 23,16 16,16 16,8"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/>',
    ];
    $path = $icons[ $name ] ?? $icons['star'];
    return sprintf(
        '<svg xmlns="http://www.w3.org/2000/svg" width="%1$d" height="%1$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">%2$s</svg>',
        $size,
        $path
    );
}

/* ── Fallback nav (when no menu is assigned) ── */
function nt_fallback_nav() {
    echo '<ul class="menu">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'neartrips' ) . '</a></li>';
    echo '<li><a href="' . esc_url( get_post_type_archive_link( nt_get_tour_post_type() ) ?: home_url( '/tours/' ) ) . '">' . esc_html__( 'Tours', 'neartrips' ) . '</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/destinations/' ) ) . '">' . esc_html__( 'Destinations', 'neartrips' ) . '</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/hotels/' ) ) . '">' . esc_html__( 'Hotels', 'neartrips' ) . '</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/blog/' ) ) . '">' . esc_html__( 'Blog', 'neartrips' ) . '</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/contact/' ) ) . '">' . esc_html__( 'Contact', 'neartrips' ) . '</a></li>';
    echo '</ul>';
}

/* ── WTE helpers ── */
function nt_is_wte_active(): bool {
    return class_exists( 'Wp_Travel_Engine' ) || post_type_exists( 'trip' );
}

function nt_get_tour_post_type(): string {
    return nt_is_wte_active() ? 'trip' : 'nt_tour';
}
