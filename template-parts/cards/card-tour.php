<?php
/**
 * Tour card template part.
 * Usage: get_template_part( 'template-parts/cards/card', 'tour', [ 'post_id' => $id ] )
 *
 * @package NearTrips
 */

$post_id = $args['post_id'] ?? get_the_ID();
$title   = get_the_title( $post_id );
$link    = get_permalink( $post_id );
$price   = nt_meta( '_nt_price', 0, $post_id ?? 0 ) ?: get_post_meta( $post_id, '_nt_price', true );
$duration= get_post_meta( $post_id, '_nt_duration', true ) ?: __( '1 Day', 'neartrips' );
$guests  = get_post_meta( $post_id, '_nt_group_size', true ) ?: 10;
$rating  = (float) ( get_post_meta( $post_id, '_nt_rating', true ) ?: 5.0 );
$reviews = (int) ( get_post_meta( $post_id, '_nt_reviews_count', true ) ?: 0 );

/* WTE compatibility */
if ( nt_is_wte_active() ) {
    $price    = $price ?: get_post_meta( $post_id, 'wp_travel_engine_setting', true )['trip_price'] ?? 0;
    $duration = $duration ?: get_post_meta( $post_id, 'wp_travel_engine_setting', true )['trip_duration'] ?? $duration;
}

$cats   = wp_get_post_terms( $post_id, nt_is_wte_active() ? 'trip_types' : 'nt_tour_cat', [ 'fields' => 'names' ] );
$cat    = ! is_wp_error( $cats ) && ! empty( $cats ) ? $cats[0] : '';
$price  = (float) $price;
$symbol = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '$';

/* Unique post ID for aria attributes */
static $card_count = 0;
$card_count++;
$card_id = 'nt-tour-card-' . $card_count;
?>

<article class="nt-card" data-anim-child id="<?php echo esc_attr( $card_id ); ?>">

    <!-- Image -->
    <div class="nt-card__img nt-img-zoom">
        <a href="<?php echo esc_url( $link ); ?>" tabindex="-1" aria-hidden="true">
            <?php echo nt_thumbnail( $post_id, 'nt-card', $title ); ?>
        </a>

        <?php if ( $cat ) : ?>
            <div class="nt-card__badge">
                <span class="nt-badge nt-badge--primary"><?php echo esc_html( $cat ); ?></span>
            </div>
        <?php endif; ?>

        <!-- Wishlist -->
        <button
            class="nt-single-action-btn"
            data-wishlist-toggle
            aria-label="<?php esc_attr_e( 'Add to wishlist', 'neartrips' ); ?>"
            style="position:absolute;top:12px;right:12px"
        >
            <?php echo nt_icon( 'heart', 16 ); // phpcs:ignore ?>
        </button>
    </div>

    <!-- Body -->
    <div class="nt-card__body">
        <!-- Rating -->
        <div class="nt-stars-bar" style="margin-bottom:8px">
            <?php nt_stars( $rating ); ?>
            <span class="nt-rating-text"><?php echo esc_html( number_format( $rating, 1 ) ); ?>
                <?php if ( $reviews ) : ?>
                    (<?php printf( _n( '%d review', '%d reviews', $reviews, 'neartrips' ), $reviews ); ?>)
                <?php endif; ?>
            </span>
        </div>

        <h3 class="nt-card__title">
            <a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a>
        </h3>

        <div class="nt-card__meta">
            <span class="nt-card__meta-item">
                <?php echo nt_icon( 'clock', 14 ); // phpcs:ignore ?>
                <?php echo esc_html( $duration ); ?>
            </span>
            <span class="nt-card__meta-item">
                <?php echo nt_icon( 'users', 14 ); // phpcs:ignore ?>
                <?php printf( _n( '%d Guest', '%d Guests', $guests, 'neartrips' ), $guests ); ?>
            </span>
        </div>
    </div>

    <!-- Footer -->
    <div class="nt-card__footer">
        <div class="nt-card__price">
            <span class="nt-card__price-label"><?php esc_html_e( 'From', 'neartrips' ); ?></span>
            <span class="nt-card__price-value">
                <?php echo $price > 0 ? esc_html( $symbol . number_format( $price, 0 ) ) : esc_html__( 'Free', 'neartrips' ); ?>
            </span>
        </div>
        <a href="<?php echo esc_url( $link ); ?>" class="nt-btn nt-btn--primary nt-btn--sm">
            <?php esc_html_e( 'Book Now', 'neartrips' ); ?>
        </a>
    </div>
</article>
