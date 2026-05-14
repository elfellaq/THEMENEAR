<?php
/**
 * Booking widget for single tour/activity/hotel.
 * Expects: $args['post_id'], $args['price'], $args['unit']
 *
 * @package NearTrips
 */

$post_id   = $args['post_id'] ?? get_the_ID();
$price     = (float) ( $args['price'] ?? get_post_meta( $post_id, '_nt_price', true ) ?: 0 );
$unit      = $args['unit'] ?? __( 'per person', 'neartrips' );
$symbol    = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '$';
$post_type = get_post_type( $post_id );
?>

<div class="nt-booking-sidebar" id="nt-booking-widget">

    <!-- Price header -->
    <div class="nt-booking-head">
        <span class="nt-booking-price-label"><?php esc_html_e( 'Price from', 'neartrips' ); ?></span>
        <div class="nt-booking-price-val" data-unit-price="<?php echo esc_attr( $price ); ?>">
            <?php echo $price > 0 ? esc_html( $symbol . number_format( $price, 0 ) ) : esc_html__( 'Free', 'neartrips' ); ?>
        </div>
        <span class="nt-booking-price-per"><?php echo esc_html( $unit ); ?></span>
    </div>

    <!-- Form -->
    <form class="nt-booking-body" method="POST" action="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
        <?php wp_nonce_field( 'nt_booking_' . $post_id, 'nt_booking_nonce' ); ?>
        <input type="hidden" name="booking_post_id" value="<?php echo esc_attr( $post_id ); ?>">
        <input type="hidden" name="booking_date" value="">

        <!-- Date -->
        <div class="nt-form-group">
            <label class="nt-label" for="nt-bk-date"><?php esc_html_e( 'Date', 'neartrips' ); ?></label>
            <div style="position:relative">
                <span style="position:absolute;top:50%;left:12px;transform:translateY(-50%);color:var(--nt-text-muted)"><?php echo nt_icon( 'calendar', 16 ); // phpcs:ignore ?></span>
                <input id="nt-bk-date" class="nt-input nt-booking-date" type="text" name="display_date" placeholder="<?php esc_attr_e( 'Select date', 'neartrips' ); ?>" style="padding-left:38px" readonly>
            </div>
        </div>

        <?php if ( $post_type !== 'nt_hotel' ) : ?>
        <!-- Time -->
        <div class="nt-form-group">
            <label class="nt-label" for="nt-bk-time"><?php esc_html_e( 'Time', 'neartrips' ); ?></label>
            <select id="nt-bk-time" name="booking_time" class="nt-select">
                <?php
                $times = [ '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00' ];
                foreach ( $times as $t ) {
                    printf( '<option value="%s">%s</option>', esc_attr( $t ), esc_html( $t ) );
                }
                ?>
            </select>
        </div>
        <?php endif; ?>

        <!-- Ticket types -->
        <div class="nt-form-group">
            <label class="nt-label"><?php esc_html_e( 'Tickets', 'neartrips' ); ?></label>
            <?php
            $ticket_types = [
                [ 'name' => 'adults',   'label' => __( 'Adults', 'neartrips' ),   'note' => __( 'Age 12+', 'neartrips' ),  'min' => 1 ],
                [ 'name' => 'children', 'label' => __( 'Children', 'neartrips' ), 'note' => __( 'Age 2-11', 'neartrips' ), 'min' => 0 ],
                [ 'name' => 'infants',  'label' => __( 'Infants', 'neartrips' ),  'note' => __( 'Under 2', 'neartrips' ),  'min' => 0 ],
            ];
            foreach ( $ticket_types as $tt ) : ?>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:var(--nt-space-3) 0;border-bottom:1px solid var(--nt-border)">
                    <div>
                        <div style="font-size:var(--nt-fs-sm);font-weight:600;color:var(--nt-text-heading)"><?php echo esc_html( $tt['label'] ); ?></div>
                        <div style="font-size:var(--nt-fs-xs);color:var(--nt-text-muted)"><?php echo esc_html( $tt['note'] ); ?></div>
                    </div>
                    <div class="nt-qty-wrap" style="width:110px">
                        <button type="button" class="nt-qty-btn" aria-label="<?php esc_attr_e( 'Decrease', 'neartrips' ); ?>">−</button>
                        <input
                            class="nt-qty-input"
                            type="number"
                            name="<?php echo esc_attr( 'qty_' . $tt['name'] ); ?>"
                            value="<?php echo esc_attr( $tt['min'] ); ?>"
                            min="<?php echo esc_attr( $tt['min'] ); ?>"
                            max="20"
                            aria-label="<?php echo esc_attr( $tt['label'] ); ?>"
                        >
                        <button type="button" class="nt-qty-btn" aria-label="<?php esc_attr_e( 'Increase', 'neartrips' ); ?>">+</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Total -->
        <div class="nt-booking-total">
            <span class="nt-booking-total-label"><?php esc_html_e( 'Total', 'neartrips' ); ?></span>
            <span class="nt-booking-total-value"><?php echo esc_html( $symbol . '0' ); ?></span>
        </div>

        <!-- CTA -->
        <button type="button" class="nt-btn nt-btn--primary nt-btn--lg nt-book-submit" style="width:100%;justify-content:center">
            <?php echo nt_icon( 'calendar', 18 ); // phpcs:ignore ?>
            <?php esc_html_e( 'Book Now', 'neartrips' ); ?>
        </button>

        <p style="font-size:var(--nt-fs-xs);color:var(--nt-text-muted);text-align:center;margin:0">
            <?php esc_html_e( 'No payment charged yet. Free cancellation.', 'neartrips' ); ?>
        </p>
    </form>

    <!-- Quick info list -->
    <div style="padding:var(--nt-space-4) var(--nt-space-5);border-top:1px solid var(--nt-border)">
        <div class="nt-booking-meta-list">
            <?php
            $duration    = get_post_meta( $post_id, '_nt_duration',   true );
            $group_size  = get_post_meta( $post_id, '_nt_group_size', true );
            $tour_type   = get_post_meta( $post_id, '_nt_tour_type',  true );
            if ( $duration )   echo '<div class="nt-booking-meta-item">' . nt_icon( 'clock', 16 ) . '<span>' . esc_html( $duration ) . '</span></div>'; // phpcs:ignore
            if ( $group_size ) echo '<div class="nt-booking-meta-item">' . nt_icon( 'users', 16 ) . '<span>' . sprintf( _n( 'Max %d guest', 'Max %d guests', (int) $group_size, 'neartrips' ), (int) $group_size ) . '</span></div>'; // phpcs:ignore
            if ( $tour_type )  echo '<div class="nt-booking-meta-item">' . nt_icon( 'map-pin', 16 ) . '<span>' . esc_html( $tour_type ) . '</span></div>'; // phpcs:ignore
            ?>
        </div>
    </div>
</div>
