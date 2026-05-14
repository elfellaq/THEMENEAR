<?php
/**
 * Hotel card template part.
 *
 * @package NearTrips
 */

$post_id   = $args['post_id'] ?? get_the_ID();
$title     = get_the_title( $post_id );
$link      = get_permalink( $post_id );
$price     = (float) get_post_meta( $post_id, '_nt_price_night', true );
$stars_num = (int) get_post_meta( $post_id, '_nt_stars', true ) ?: 4;
$rating    = (float) ( get_post_meta( $post_id, '_nt_rating', true ) ?: 4.5 );
$reviews   = (int) get_post_meta( $post_id, '_nt_reviews_count', true );
$address   = get_post_meta( $post_id, '_nt_address', true );
$symbol    = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '$';

$types  = wp_get_post_terms( $post_id, 'nt_hotel_type', [ 'fields' => 'names' ] );
$type   = ! is_wp_error( $types ) && ! empty( $types ) ? $types[0] : '';
?>

<article class="nt-card" data-anim-child>

    <div class="nt-card__img nt-img-zoom">
        <a href="<?php echo esc_url( $link ); ?>" tabindex="-1" aria-hidden="true">
            <?php echo nt_thumbnail( $post_id, 'nt-card', $title ); ?>
        </a>
        <?php if ( $type ) : ?>
            <div class="nt-card__badge">
                <span class="nt-badge nt-badge--navy"><?php echo esc_html( $type ); ?></span>
            </div>
        <?php endif; ?>
        <button class="nt-single-action-btn" data-wishlist-toggle aria-label="<?php esc_attr_e( 'Add to wishlist', 'neartrips' ); ?>" style="position:absolute;top:12px;right:12px">
            <?php echo nt_icon( 'heart', 16 ); // phpcs:ignore ?>
        </button>
    </div>

    <div class="nt-card__body">
        <!-- Hotel star class -->
        <div style="display:flex;align-items:center;gap:6px;margin-bottom:6px">
            <?php for ( $i = 0; $i < 5; $i++ ) : ?>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="<?php echo $i < $stars_num ? 'var(--nt-yellow)' : 'var(--nt-border)'; ?>" stroke="none" xmlns="http://www.w3.org/2000/svg"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/></svg>
            <?php endfor; ?>
            <span style="font-size:.75rem;color:var(--nt-text-muted)"><?php printf( _n( '%d Star', '%d Stars', $stars_num, 'neartrips' ), $stars_num ); ?></span>
        </div>

        <h3 class="nt-card__title">
            <a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a>
        </h3>

        <div class="nt-card__meta">
            <?php if ( $address ) : ?>
                <span class="nt-card__meta-item">
                    <?php echo nt_icon( 'map-pin', 13 ); // phpcs:ignore ?>
                    <?php echo esc_html( $address ); ?>
                </span>
            <?php endif; ?>
            <?php if ( $rating ) : ?>
                <span class="nt-card__meta-item">
                    <?php echo nt_icon( 'star', 13 ); // phpcs:ignore ?>
                    <?php echo esc_html( number_format( $rating, 1 ) ); ?>
                    <?php if ( $reviews ) : echo '(' . esc_html( $reviews ) . ')'; endif; ?>
                </span>
            <?php endif; ?>
        </div>
    </div>

    <div class="nt-card__footer">
        <div class="nt-card__price">
            <span class="nt-card__price-label"><?php esc_html_e( 'Per night from', 'neartrips' ); ?></span>
            <span class="nt-card__price-value">
                <?php echo $price > 0 ? esc_html( $symbol . number_format( $price, 0 ) ) : esc_html__( 'Ask', 'neartrips' ); ?>
            </span>
        </div>
        <a href="<?php echo esc_url( $link ); ?>" class="nt-btn nt-btn--primary nt-btn--sm">
            <?php esc_html_e( 'Book', 'neartrips' ); ?>
        </a>
    </div>
</article>
