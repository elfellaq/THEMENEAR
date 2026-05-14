<?php
/**
 * Advanced search widget — tabbed: Tours / Hotels / Activities / Car Rental.
 *
 * @package NearTrips
 */
?>

<div class="nt-search-widget" id="nt-search-widget" role="search">
    <!-- Tab buttons -->
    <div class="nt-search-tabs" role="tablist">
        <button class="nt-search-tab" data-search-tab="tours" role="tab" aria-selected="true">
            <?php echo nt_icon( 'map-pin', 16 ); // phpcs:ignore ?>
            <?php esc_html_e( 'Tours', 'neartrips' ); ?>
        </button>
        <button class="nt-search-tab" data-search-tab="hotels" role="tab" aria-selected="false">
            <?php echo nt_icon( 'map-pin', 16 ); // phpcs:ignore ?>
            <?php esc_html_e( 'Hotels', 'neartrips' ); ?>
        </button>
        <button class="nt-search-tab" data-search-tab="activities" role="tab" aria-selected="false">
            <?php echo nt_icon( 'star', 16 ); // phpcs:ignore ?>
            <?php esc_html_e( 'Activities', 'neartrips' ); ?>
        </button>
        <button class="nt-search-tab" data-search-tab="cars" role="tab" aria-selected="false">
            <?php echo nt_icon( 'car', 16 ); // phpcs:ignore ?>
            <?php esc_html_e( 'Car Rental', 'neartrips' ); ?>
        </button>
    </div>

    <form method="GET" action="<?php echo esc_url( home_url( '/' ) ); ?>" id="nt-search-form">
        <input type="hidden" name="post_type" value="nt_tour">

        <!-- Tours pane -->
        <div class="nt-search-pane" data-search-pane="tours" data-post-type="<?php echo esc_attr( nt_get_tour_post_type() ); ?>" role="tabpanel">
            <div class="nt-search-fields">
                <div class="nt-search-field">
                    <label class="nt-label" for="nt-tour-dest"><?php esc_html_e( 'Where to?', 'neartrips' ); ?></label>
                    <div style="position:relative">
                        <span class="nt-search-field-icon" style="position:absolute;top:50%;left:12px;transform:translateY(-50%);color:var(--nt-text-muted)">
                            <?php echo nt_icon( 'map-pin', 16 ); // phpcs:ignore ?>
                        </span>
                        <input
                            id="nt-tour-dest"
                            type="text"
                            name="destination"
                            class="nt-input"
                            placeholder="<?php esc_attr_e( 'City, region, country…', 'neartrips' ); ?>"
                            style="padding-left:38px"
                            autocomplete="off"
                        >
                    </div>
                </div>
                <div class="nt-search-field">
                    <label class="nt-label" for="nt-tour-date"><?php esc_html_e( 'Date', 'neartrips' ); ?></label>
                    <div style="position:relative">
                        <span style="position:absolute;top:50%;left:12px;transform:translateY(-50%);color:var(--nt-text-muted)">
                            <?php echo nt_icon( 'calendar', 16 ); // phpcs:ignore ?>
                        </span>
                        <input
                            id="nt-tour-date"
                            type="text"
                            name="date"
                            class="nt-input nt-datepicker"
                            placeholder="<?php esc_attr_e( 'Pick a date', 'neartrips' ); ?>"
                            style="padding-left:38px"
                            readonly
                        >
                    </div>
                </div>
                <div class="nt-search-field">
                    <label class="nt-label" for="nt-tour-guests"><?php esc_html_e( 'Guests', 'neartrips' ); ?></label>
                    <div style="position:relative">
                        <span style="position:absolute;top:50%;left:12px;transform:translateY(-50%);color:var(--nt-text-muted)">
                            <?php echo nt_icon( 'users', 16 ); // phpcs:ignore ?>
                        </span>
                        <select id="nt-tour-guests" name="guests" class="nt-select" style="padding-left:38px">
                            <?php for ( $i = 1; $i <= 20; $i++ ) : ?>
                                <option value="<?php echo esc_attr( $i ); ?>"><?php printf( _n( '%d Guest', '%d Guests', $i, 'neartrips' ), $i ); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="nt-btn nt-btn--primary nt-btn--lg">
                    <?php echo nt_icon( 'search', 18 ); // phpcs:ignore ?>
                    <?php esc_html_e( 'Search', 'neartrips' ); ?>
                </button>
            </div>
        </div>

        <!-- Hotels pane -->
        <div class="nt-search-pane" data-search-pane="hotels" data-post-type="nt_hotel" role="tabpanel" style="display:none">
            <div class="nt-search-fields">
                <div class="nt-search-field">
                    <label class="nt-label" for="nt-hotel-dest"><?php esc_html_e( 'Destination', 'neartrips' ); ?></label>
                    <div style="position:relative">
                        <span style="position:absolute;top:50%;left:12px;transform:translateY(-50%);color:var(--nt-text-muted)"><?php echo nt_icon( 'map-pin', 16 ); // phpcs:ignore ?></span>
                        <input id="nt-hotel-dest" type="text" name="destination" class="nt-input" placeholder="<?php esc_attr_e( 'City or hotel name', 'neartrips' ); ?>" style="padding-left:38px">
                    </div>
                </div>
                <div class="nt-search-field">
                    <label class="nt-label"><?php esc_html_e( 'Check In / Out', 'neartrips' ); ?></label>
                    <div style="position:relative">
                        <span style="position:absolute;top:50%;left:12px;transform:translateY(-50%);color:var(--nt-text-muted)"><?php echo nt_icon( 'calendar', 16 ); // phpcs:ignore ?></span>
                        <input type="text" name="dates" class="nt-input nt-datepicker-range" placeholder="<?php esc_attr_e( 'Check In → Check Out', 'neartrips' ); ?>" style="padding-left:38px" readonly>
                    </div>
                </div>
                <div class="nt-search-field">
                    <label class="nt-label" for="nt-hotel-rooms"><?php esc_html_e( 'Rooms', 'neartrips' ); ?></label>
                    <select id="nt-hotel-rooms" name="rooms" class="nt-select">
                        <?php for ( $i = 1; $i <= 10; $i++ ) : ?>
                            <option value="<?php echo esc_attr( $i ); ?>"><?php printf( _n( '%d Room', '%d Rooms', $i, 'neartrips' ), $i ); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <button type="submit" class="nt-btn nt-btn--primary nt-btn--lg">
                    <?php echo nt_icon( 'search', 18 ); // phpcs:ignore ?>
                    <?php esc_html_e( 'Search', 'neartrips' ); ?>
                </button>
            </div>
        </div>

        <!-- Activities pane -->
        <div class="nt-search-pane" data-search-pane="activities" data-post-type="nt_activity" role="tabpanel" style="display:none">
            <div class="nt-search-fields">
                <div class="nt-search-field">
                    <label class="nt-label" for="nt-act-dest"><?php esc_html_e( 'Location', 'neartrips' ); ?></label>
                    <div style="position:relative">
                        <span style="position:absolute;top:50%;left:12px;transform:translateY(-50%);color:var(--nt-text-muted)"><?php echo nt_icon( 'map-pin', 16 ); // phpcs:ignore ?></span>
                        <input id="nt-act-dest" type="text" name="destination" class="nt-input" placeholder="<?php esc_attr_e( 'Where?', 'neartrips' ); ?>" style="padding-left:38px">
                    </div>
                </div>
                <div class="nt-search-field">
                    <label class="nt-label" for="nt-act-date"><?php esc_html_e( 'Date', 'neartrips' ); ?></label>
                    <div style="position:relative">
                        <span style="position:absolute;top:50%;left:12px;transform:translateY(-50%);color:var(--nt-text-muted)"><?php echo nt_icon( 'calendar', 16 ); // phpcs:ignore ?></span>
                        <input id="nt-act-date" type="text" name="date" class="nt-input nt-datepicker" placeholder="<?php esc_attr_e( 'Select date', 'neartrips' ); ?>" style="padding-left:38px" readonly>
                    </div>
                </div>
                <div class="nt-search-field">
                    <label class="nt-label" for="nt-act-cat"><?php esc_html_e( 'Category', 'neartrips' ); ?></label>
                    <?php
                    $act_cats = get_terms( [ 'taxonomy' => 'nt_activity_cat', 'hide_empty' => false ] );
                    ?>
                    <select id="nt-act-cat" name="activity_category" class="nt-select">
                        <option value=""><?php esc_html_e( 'All Categories', 'neartrips' ); ?></option>
                        <?php if ( ! is_wp_error( $act_cats ) ) : foreach ( $act_cats as $cat ) : ?>
                            <option value="<?php echo esc_attr( $cat->slug ); ?>"><?php echo esc_html( $cat->name ); ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <button type="submit" class="nt-btn nt-btn--primary nt-btn--lg">
                    <?php echo nt_icon( 'search', 18 ); // phpcs:ignore ?>
                    <?php esc_html_e( 'Search', 'neartrips' ); ?>
                </button>
            </div>
        </div>

        <!-- Cars pane -->
        <div class="nt-search-pane" data-search-pane="cars" data-post-type="nt_car" role="tabpanel" style="display:none">
            <div class="nt-search-fields">
                <div class="nt-search-field">
                    <label class="nt-label" for="nt-car-pickup"><?php esc_html_e( 'Pickup Location', 'neartrips' ); ?></label>
                    <div style="position:relative">
                        <span style="position:absolute;top:50%;left:12px;transform:translateY(-50%);color:var(--nt-text-muted)"><?php echo nt_icon( 'map-pin', 16 ); // phpcs:ignore ?></span>
                        <input id="nt-car-pickup" type="text" name="pickup" class="nt-input" placeholder="<?php esc_attr_e( 'Airport, city…', 'neartrips' ); ?>" style="padding-left:38px">
                    </div>
                </div>
                <div class="nt-search-field">
                    <label class="nt-label"><?php esc_html_e( 'Pick Up / Drop Off', 'neartrips' ); ?></label>
                    <div style="position:relative">
                        <span style="position:absolute;top:50%;left:12px;transform:translateY(-50%);color:var(--nt-text-muted)"><?php echo nt_icon( 'calendar', 16 ); // phpcs:ignore ?></span>
                        <input type="text" name="dates" class="nt-input nt-datepicker-range" placeholder="<?php esc_attr_e( 'Pick Up → Drop Off', 'neartrips' ); ?>" style="padding-left:38px" readonly>
                    </div>
                </div>
                <div class="nt-search-field">
                    <label class="nt-label" for="nt-car-type"><?php esc_html_e( 'Car Type', 'neartrips' ); ?></label>
                    <?php $car_types = get_terms( [ 'taxonomy' => 'nt_car_type', 'hide_empty' => false ] ); ?>
                    <select id="nt-car-type" name="car_type" class="nt-select">
                        <option value=""><?php esc_html_e( 'Any Type', 'neartrips' ); ?></option>
                        <?php if ( ! is_wp_error( $car_types ) ) : foreach ( $car_types as $ct ) : ?>
                            <option value="<?php echo esc_attr( $ct->slug ); ?>"><?php echo esc_html( $ct->name ); ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <button type="submit" class="nt-btn nt-btn--primary nt-btn--lg">
                    <?php echo nt_icon( 'search', 18 ); // phpcs:ignore ?>
                    <?php esc_html_e( 'Search', 'neartrips' ); ?>
                </button>
            </div>
        </div>
    </form>
</div>
