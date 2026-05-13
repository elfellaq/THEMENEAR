<?php
/**
 * Single Tour Package.
 *
 * @package Travelio
 */
get_header();
while ( have_posts() ) : the_post();
    $price    = travelio_meta( '_tv_tour_price' );
    $duration = travelio_meta( '_tv_tour_duration' );
    $group    = travelio_meta( '_tv_tour_group_size' );
    $location = travelio_meta( '_tv_tour_location' );
    $included = travelio_meta( '_tv_tour_included' );
    $excluded = travelio_meta( '_tv_tour_excluded' );
    $itin     = get_post_meta( get_the_ID(), '_tv_tour_itinerary', true );
?>

<section class="tv-tour-hero">
    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'travelio-hero' ); }
    else { echo '<img src="https://source.unsplash.com/1920x900/?travel,'. esc_attr( sanitize_title( get_the_title() ) ) .'" alt="">'; } ?>
    <div class="tv-tour-hero-overlay">
        <div class="tv-container">
            <h1><?php the_title(); ?></h1>
            <div class="meta">
                <?php if ( $location ) : ?><span>&#x1F4CD; <?php echo esc_html( $location ); ?></span><?php endif; ?>
                <?php if ( $duration ) : ?><span>&#9201; <?php echo esc_html( $duration ); ?></span><?php endif; ?>
                <?php if ( $group ) : ?><span>&#x1F465; <?php echo esc_html( $group ); ?></span><?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="tv-content">
    <div class="tv-container">
        <div class="tv-tour-grid">
            <article class="tv-tour-main">
                <div class="tv-tour-tabs" role="tablist">
                    <button class="is-active" data-tab="overview"><?php esc_html_e( 'Overview', 'travelio' ); ?></button>
                    <button data-tab="itinerary"><?php esc_html_e( 'Itinerary', 'travelio' ); ?></button>
                    <button data-tab="included"><?php esc_html_e( 'Included', 'travelio' ); ?></button>
                    <button data-tab="reviews"><?php esc_html_e( 'Reviews', 'travelio' ); ?></button>
                </div>

                <div class="tv-tour-panel is-active" data-panel="overview">
                    <?php the_content(); ?>
                </div>

                <div class="tv-tour-panel" data-panel="itinerary">
                    <?php if ( is_array( $itin ) && ! empty( $itin ) ) : ?>
                        <ol class="tv-itinerary">
                            <?php foreach ( $itin as $day ) : ?>
                                <li>
                                    <strong><?php echo esc_html( $day['title'] ?? '' ); ?></strong>
                                    <?php echo wp_kses_post( $day['desc'] ?? '' ); ?>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php else : ?>
                        <ol class="tv-itinerary">
                            <li><strong><?php esc_html_e( 'Arrival & welcome dinner', 'travelio' ); ?></strong><?php esc_html_e( 'Check in to your hotel and meet your guide over a local meal.', 'travelio' ); ?></li>
                            <li><strong><?php esc_html_e( 'City highlights tour', 'travelio' ); ?></strong><?php esc_html_e( 'Explore the must-see sights with a private expert.', 'travelio' ); ?></li>
                            <li><strong><?php esc_html_e( 'Day trip & free time', 'travelio' ); ?></strong><?php esc_html_e( 'Excursion to nearby landmark, afternoon at leisure.', 'travelio' ); ?></li>
                            <li><strong><?php esc_html_e( 'Departure', 'travelio' ); ?></strong><?php esc_html_e( 'Transfer to airport after breakfast.', 'travelio' ); ?></li>
                        </ol>
                    <?php endif; ?>
                </div>

                <div class="tv-tour-panel" data-panel="included">
                    <h3><?php esc_html_e( 'What\'s included', 'travelio' ); ?></h3>
                    <div><?php echo wp_kses_post( $included ?: '<ul><li>Accommodation</li><li>Daily breakfast</li><li>Local guide</li><li>Airport transfers</li></ul>' ); ?></div>
                    <h3 style="margin-top:24px"><?php esc_html_e( 'Not included', 'travelio' ); ?></h3>
                    <div><?php echo wp_kses_post( $excluded ?: '<ul><li>International flights</li><li>Travel insurance</li><li>Personal expenses</li></ul>' ); ?></div>
                </div>

                <div class="tv-tour-panel" data-panel="reviews">
                    <?php if ( comments_open() || get_comments_number() ) { comments_template(); }
                    else { esc_html_e( 'Be the first to review this tour.', 'travelio' ); } ?>
                </div>
            </article>

            <aside class="tv-tour-side">
                <div class="tv-booking-card">
                    <div class="price"><?php echo esc_html( $price ?: '$899' ); ?><small><?php esc_html_e( ' / person', 'travelio' ); ?></small></div>
                    <hr>
                    <?php
                    /**
                     * If WP Travel Engine is active and provides a booking form, render it.
                     * Otherwise fall back to a simple inquiry button.
                     */
                    if ( function_exists( 'wte_booking_form' ) ) {
                        wte_booking_form();
                    } else { ?>
                        <form class="tv-form" method="post" action="">
                            <div>
                                <label><?php esc_html_e( 'Travel Date', 'travelio' ); ?></label>
                                <input type="date" name="travel_date" required>
                            </div>
                            <div class="row">
                                <div>
                                    <label><?php esc_html_e( 'Adults', 'travelio' ); ?></label>
                                    <input type="number" min="1" value="2" name="adults">
                                </div>
                                <div>
                                    <label><?php esc_html_e( 'Children', 'travelio' ); ?></label>
                                    <input type="number" min="0" value="0" name="children">
                                </div>
                            </div>
                            <button type="submit" class="tv-btn tv-btn--primary"><?php esc_html_e( 'Book this tour', 'travelio' ); ?></button>
                            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="tv-btn tv-btn--dark"><?php esc_html_e( 'Send an inquiry', 'travelio' ); ?></a>
                        </form>
                    <?php } ?>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php endwhile;
get_footer();
