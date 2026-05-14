<?php
/**
 * Activity card template part.
 *
 * @package NearTrips
 */

$post_id  = $args['post_id'] ?? get_the_ID();
$title    = get_the_title( $post_id );
$link     = get_permalink( $post_id );
$price    = (float) get_post_meta( $post_id, '_nt_price', true );
$duration = get_post_meta( $post_id, '_nt_duration', true ) ?: __( '2 Hours', 'neartrips' );
$guests   = (int) ( get_post_meta( $post_id, '_nt_group_size', true ) ?: 10 );
$rating   = (float) ( get_post_meta( $post_id, '_nt_rating', true ) ?: 5.0 );
$reviews  = (int) get_post_meta( $post_id, '_nt_reviews_count', true );
$symbol   = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '$';

$cats   = wp_get_post_terms( $post_id, 'nt_activity_cat', [ 'fields' => 'names' ] );
$cat    = ! is_wp_error( $cats ) && ! empty( $cats ) ? $cats[0] : '';
?>

<article class="nt-card" data-anim-child>
    <div class="nt-card__img nt-img-zoom">
        <a href="<?php echo esc_url( $link ); ?>" tabindex="-1" aria-hidden="true">
            <?php echo nt_thumbnail( $post_id, 'nt-card', $title ); ?>
        </a>
        <?php if ( $cat ) : ?>
            <div class="nt-card__badge"><span class="nt-badge nt-badge--yellow"><?php echo esc_html( $cat ); ?></span></div>
        <?php endif; ?>
        <button class="nt-single-action-btn" data-wishlist-toggle aria-label="<?php esc_attr_e( 'Save', 'neartrips' ); ?>" style="position:absolute;top:12px;right:12px">
            <?php echo nt_icon( 'heart', 16 ); // phpcs:ignore ?>
        </button>
    </div>

    <div class="nt-card__body">
        <div class="nt-stars-bar" style="margin-bottom:6px">
            <?php nt_stars( $rating ); ?>
            <span class="nt-rating-text"><?php echo esc_html( number_format( $rating, 1 ) ); ?>
                <?php if ( $reviews ) : echo '(' . esc_html( $reviews ) . ')'; endif; ?>
            </span>
        </div>
        <h3 class="nt-card__title"><a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a></h3>
        <div class="nt-card__meta">
            <span class="nt-card__meta-item"><?php echo nt_icon( 'clock', 13 ); // phpcs:ignore ?><?php echo esc_html( $duration ); ?></span>
            <span class="nt-card__meta-item"><?php echo nt_icon( 'users', 13 ); // phpcs:ignore ?><?php printf( _n( '%d Guest', '%d Guests', $guests, 'neartrips' ), $guests ); ?></span>
        </div>
    </div>

    <div class="nt-card__footer">
        <div class="nt-card__price">
            <span class="nt-card__price-label"><?php esc_html_e( 'Per person', 'neartrips' ); ?></span>
            <span class="nt-card__price-value"><?php echo $price > 0 ? esc_html( $symbol . number_format( $price, 0 ) ) : esc_html__( 'Free', 'neartrips' ); ?></span>
        </div>
        <a href="<?php echo esc_url( $link ); ?>" class="nt-btn nt-btn--primary nt-btn--sm"><?php esc_html_e( 'Book Now', 'neartrips' ); ?></a>
    </div>
</article>
