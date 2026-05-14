<?php
/**
 * Destination card template part.
 *
 * @package NearTrips
 */

$post_id = $args['post_id'] ?? get_the_ID();
$title   = get_the_title( $post_id );
$link    = get_permalink( $post_id );
$count   = (int) get_post_meta( $post_id, '_nt_tours_count', true );
$country = get_post_meta( $post_id, '_nt_country', true );
$wide    = ! empty( $args['wide'] ) ? ' nt-dest-card--wide' : '';
?>

<a href="<?php echo esc_url( $link ); ?>" class="nt-dest-card<?php echo esc_attr( $wide ); ?>" data-anim-child>
    <?php echo nt_thumbnail( $post_id, 'nt-dest', $title ); // outputs <img> with class="nt-dest-card__img" if we wrap ?>
    <div class="nt-dest-card__overlay"></div>
    <div class="nt-dest-card__body">
        <?php if ( $country ) : ?>
            <span style="font-size:.72rem;letter-spacing:.1em;text-transform:uppercase;opacity:.75;display:block;margin-bottom:4px">
                <?php echo nt_icon( 'map-pin', 12 ); // phpcs:ignore ?>
                <?php echo esc_html( $country ); ?>
            </span>
        <?php endif; ?>
        <h3 class="nt-dest-card__name"><?php echo esc_html( $title ); ?></h3>
        <?php if ( $count ) : ?>
            <span class="nt-dest-card__count"><?php printf( _n( '%d Tour', '%d Tours', $count, 'neartrips' ), $count ); ?></span>
        <?php endif; ?>
    </div>
</a>
