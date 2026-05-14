<?php
/**
 * Single Tour template.
 *
 * @package NearTrips
 */

get_header();

while ( have_posts() ) : the_post();
    $post_id   = get_the_ID();
    $price     = (float) get_post_meta( $post_id, '_nt_price', true );
    $duration  = get_post_meta( $post_id, '_nt_duration',    true ) ?: '1 Day';
    $group     = (int) get_post_meta( $post_id, '_nt_group_size', true );
    $rating    = (float) ( get_post_meta( $post_id, '_nt_rating', true ) ?: 5 );
    $reviews_n = (int) get_post_meta( $post_id, '_nt_reviews_count', true );
    $tour_type = get_post_meta( $post_id, '_nt_tour_type', true );
    $languages = get_post_meta( $post_id, '_nt_languages',  true );
    $includes  = get_post_meta( $post_id, '_nt_includes',   true );
    $excludes  = get_post_meta( $post_id, '_nt_excludes',   true );
    $min_age   = (int) get_post_meta( $post_id, '_nt_min_age', true );
    $symbol    = function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '$';
?>

<!-- Breadcrumb -->
<div class="nt-page-hero">
    <div class="nt-container">
        <nav class="nt-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'neartrips' ); ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'neartrips' ); ?></a>
            <span class="nt-breadcrumb-sep" aria-hidden="true"><?php echo nt_icon( 'chevron-r', 12 ); // phpcs:ignore ?></span>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'nt_tour' ) ?: home_url( '/tours/' ) ); ?>"><?php esc_html_e( 'Tours', 'neartrips' ); ?></a>
            <span class="nt-breadcrumb-sep" aria-hidden="true"><?php echo nt_icon( 'chevron-r', 12 ); // phpcs:ignore ?></span>
            <span><?php the_title(); ?></span>
        </nav>

        <!-- Single Header -->
        <div class="nt-single-header">
            <div class="nt-single-header__meta">
                <?php $cats = wp_get_post_terms( $post_id, 'nt_tour_cat', [ 'fields' => 'names' ] );
                if ( ! is_wp_error( $cats ) && ! empty( $cats ) ) : ?>
                    <span class="nt-badge nt-badge--soft"><?php echo esc_html( $cats[0] ); ?></span>
                <?php endif; ?>
                <div class="nt-stars-bar">
                    <?php nt_stars( $rating ); ?>
                    <span class="nt-rating-text"><?php echo esc_html( number_format( $rating, 1 ) ); ?>
                        <?php if ( $reviews_n ) : echo '(' . esc_html( $reviews_n ) . ' ' . esc_html__( 'reviews', 'neartrips' ) . ')'; endif; ?>
                    </span>
                </div>
            </div>
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:var(--nt-space-4);flex-wrap:wrap">
                <h1 class="nt-single-header__title" style="margin:0;flex:1"><?php the_title(); ?></h1>
                <div class="nt-single-header__actions">
                    <button class="nt-single-action-btn" data-wishlist-toggle aria-label="<?php esc_attr_e( 'Save', 'neartrips' ); ?>"><?php echo nt_icon( 'heart', 18 ); // phpcs:ignore ?></button>
                    <button class="nt-single-action-btn" aria-label="<?php esc_attr_e( 'Share', 'neartrips' ); ?>"><?php echo nt_icon( 'share', 18 ); // phpcs:ignore ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="nt-section nt-section--sm">
    <div class="nt-container">

        <!-- Gallery -->
        <div class="nt-gallery-wrap" data-anim="fade-up">
            <div class="swiper nt-gallery-main">
                <div class="swiper-wrapper">
                    <?php
                    $gallery_ids = get_post_meta( $post_id, '_nt_gallery', true );
                    if ( $gallery_ids ) :
                        foreach ( (array) $gallery_ids as $img_id ) :
                    ?>
                        <div class="swiper-slide">
                            <?php echo wp_get_attachment_image( $img_id, 'nt-card-lg', false, [ 'style' => 'width:100%;aspect-ratio:16/9;object-fit:cover' ] ); ?>
                        </div>
                    <?php endforeach; else : ?>
                        <div class="swiper-slide">
                            <?php echo nt_thumbnail( $post_id, 'nt-card-lg', get_the_title() ); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <button class="nt-swiper-btn nt-gallery-prev" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);z-index:2"><?php echo nt_icon( 'chevron-l', 20 ); // phpcs:ignore ?></button>
                <button class="nt-swiper-btn nt-gallery-next" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);z-index:2"><?php echo nt_icon( 'chevron-r', 20 ); // phpcs:ignore ?></button>
            </div>
        </div>

        <!-- Key info strip -->
        <div class="nt-tour-info-strip" data-anim="fade-up">
            <?php if ( $duration ) : ?>
                <div class="nt-info-item"><span class="nt-info-label"><?php esc_html_e( 'Duration', 'neartrips' ); ?></span><span class="nt-info-value"><?php echo nt_icon( 'clock', 14 ); echo esc_html( $duration ); ?></span></div>
            <?php endif; ?>
            <?php if ( $group ) : ?>
                <div class="nt-info-item"><span class="nt-info-label"><?php esc_html_e( 'Group Size', 'neartrips' ); ?></span><span class="nt-info-value"><?php echo nt_icon( 'users', 14 ); printf( _n( 'Max %d', 'Max %d', $group, 'neartrips' ), $group ); ?></span></div>
            <?php endif; ?>
            <?php if ( $tour_type ) : ?>
                <div class="nt-info-item"><span class="nt-info-label"><?php esc_html_e( 'Type', 'neartrips' ); ?></span><span class="nt-info-value"><?php echo nt_icon( 'map-pin', 14 ); echo esc_html( $tour_type ); ?></span></div>
            <?php endif; ?>
            <?php if ( $languages ) : ?>
                <div class="nt-info-item"><span class="nt-info-label"><?php esc_html_e( 'Languages', 'neartrips' ); ?></span><span class="nt-info-value"><?php echo esc_html( $languages ); ?></span></div>
            <?php endif; ?>
            <?php if ( $min_age ) : ?>
                <div class="nt-info-item"><span class="nt-info-label"><?php esc_html_e( 'Min Age', 'neartrips' ); ?></span><span class="nt-info-value"><?php echo esc_html( $min_age ) . '+'; ?></span></div>
            <?php endif; ?>
            <?php if ( $price ) : ?>
                <div class="nt-info-item"><span class="nt-info-label"><?php esc_html_e( 'Price', 'neartrips' ); ?></span><span class="nt-info-value" style="color:var(--nt-primary)"><?php echo esc_html( $symbol . number_format( $price, 0 ) ); ?></span></div>
            <?php endif; ?>
        </div>

        <!-- Two-column layout -->
        <div class="nt-single-layout">

            <!-- Content column -->
            <div class="nt-single-content">

                <!-- Tabs -->
                <div class="nt-tabs" role="tablist">
                    <div class="nt-tabs-nav">
                        <?php
                        $tabs = [
                            'overview'  => __( 'Overview', 'neartrips' ),
                            'highlights'=> __( 'Highlights', 'neartrips' ),
                            'itinerary' => __( 'Itinerary', 'neartrips' ),
                            'inc-exc'   => __( 'Included / Excluded', 'neartrips' ),
                            'faq'       => __( 'FAQ', 'neartrips' ),
                            'reviews'   => __( 'Reviews', 'neartrips' ),
                        ];
                        foreach ( $tabs as $key => $label ) :
                        ?>
                            <button class="nt-tab-btn" role="tab" data-tab="<?php echo esc_attr( $key ); ?>" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
                                <?php echo esc_html( $label ); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <!-- Overview -->
                    <div id="tab-overview" class="nt-tab-panel" role="tabpanel">
                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>
                    </div>

                    <!-- Highlights -->
                    <div id="tab-highlights" class="nt-tab-panel" role="tabpanel" hidden>
                        <?php
                        $highlights = get_post_meta( $post_id, '_nt_highlights', true );
                        if ( $highlights ) {
                            $items = array_filter( array_map( 'trim', explode( "\n", $highlights ) ) );
                            echo '<ul style="display:flex;flex-direction:column;gap:var(--nt-space-3);list-style:none;padding:0;margin:0">';
                            foreach ( $items as $item ) {
                                echo '<li style="display:flex;align-items:flex-start;gap:var(--nt-space-2);font-size:var(--nt-fs-sm)">'
                                   . nt_icon( 'check', 16 ) . '<span>' . esc_html( $item ) . '</span></li>';
                            }
                            echo '</ul>';
                        } else {
                            echo '<p class="nt-text-muted">' . esc_html__( 'Highlights coming soon.', 'neartrips' ) . '</p>';
                        }
                        ?>
                    </div>

                    <!-- Itinerary -->
                    <div id="tab-itinerary" class="nt-tab-panel" role="tabpanel" hidden>
                        <?php
                        $itinerary = get_post_meta( $post_id, '_nt_itinerary', true );
                        if ( $itinerary && is_array( $itinerary ) ) :
                        ?>
                            <div class="nt-itinerary">
                                <?php foreach ( $itinerary as $step ) : ?>
                                    <div class="nt-itinerary-item">
                                        <div class="nt-itinerary-dot">
                                            <svg width="10" height="10" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="6"/></svg>
                                        </div>
                                        <div class="nt-itinerary-content">
                                            <div class="nt-itinerary-title"><?php echo esc_html( $step['title'] ?? '' ); ?></div>
                                            <?php if ( ! empty( $step['time'] ) ) : ?>
                                                <div class="nt-itinerary-time"><?php echo esc_html( $step['time'] ); ?></div>
                                            <?php endif; ?>
                                            <?php if ( ! empty( $step['desc'] ) ) : ?>
                                                <div class="nt-itinerary-desc"><?php echo esc_html( $step['desc'] ); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <p class="nt-text-muted"><?php esc_html_e( 'Itinerary coming soon.', 'neartrips' ); ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Included / Excluded -->
                    <div id="tab-inc-exc" class="nt-tab-panel" role="tabpanel" hidden>
                        <div class="nt-inc-exc">
                            <div>
                                <h4 style="margin-bottom:var(--nt-space-4)"><?php esc_html_e( 'What\'s Included', 'neartrips' ); ?></h4>
                                <ul class="nt-inc-list">
                                    <?php if ( $includes ) : foreach ( array_filter( array_map( 'trim', explode( "\n", $includes ) ) ) as $item ) : ?>
                                        <li><?php echo nt_icon( 'check', 16 ); // phpcs:ignore ?><span><?php echo esc_html( $item ); ?></span></li>
                                    <?php endforeach; else : ?>
                                        <li style="color:var(--nt-text-muted)"><?php esc_html_e( 'No info yet.', 'neartrips' ); ?></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            <div>
                                <h4 style="margin-bottom:var(--nt-space-4)"><?php esc_html_e( 'What\'s Excluded', 'neartrips' ); ?></h4>
                                <ul class="nt-exc-list">
                                    <?php if ( $excludes ) : foreach ( array_filter( array_map( 'trim', explode( "\n", $excludes ) ) ) as $item ) : ?>
                                        <li><?php echo nt_icon( 'x', 16 ); // phpcs:ignore ?><span><?php echo esc_html( $item ); ?></span></li>
                                    <?php endforeach; else : ?>
                                        <li style="color:var(--nt-text-muted)"><?php esc_html_e( 'No info yet.', 'neartrips' ); ?></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ -->
                    <div id="tab-faq" class="nt-tab-panel" role="tabpanel" hidden>
                        <?php
                        $faqs = get_post_meta( $post_id, '_nt_faqs', true );
                        if ( $faqs && is_array( $faqs ) ) :
                        ?>
                            <div class="nt-accordion">
                                <?php foreach ( $faqs as $faq ) : ?>
                                    <div class="nt-accordion-item">
                                        <button class="nt-accordion-toggle" aria-expanded="false">
                                            <?php echo esc_html( $faq['question'] ?? '' ); ?>
                                            <?php echo nt_icon( 'chevron-d', 18 ); // phpcs:ignore ?>
                                        </button>
                                        <div class="nt-accordion-content">
                                            <div class="nt-accordion-inner"><?php echo wp_kses_post( $faq['answer'] ?? '' ); ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else : ?>
                            <p class="nt-text-muted"><?php esc_html_e( 'No FAQs yet.', 'neartrips' ); ?></p>
                        <?php endif; ?>
                    </div>

                    <!-- Reviews -->
                    <div id="tab-reviews" class="nt-tab-panel" role="tabpanel" hidden>
                        <!-- Reviews summary -->
                        <div class="nt-reviews-summary">
                            <div class="nt-reviews-big">
                                <span class="nt-reviews-big-num"><?php echo esc_html( number_format( $rating, 1 ) ); ?></span>
                                <?php nt_stars( $rating ); ?>
                                <span style="font-size:var(--nt-fs-xs);color:var(--nt-text-muted)"><?php printf( _n( '%d review', '%d reviews', $reviews_n, 'neartrips' ), $reviews_n ); ?></span>
                            </div>
                            <div class="nt-reviews-breakdown">
                                <?php
                                $breakdown = [
                                    __( 'Excellent', 'neartrips' ) => 85,
                                    __( 'Good', 'neartrips' )      => 10,
                                    __( 'Average', 'neartrips' )   => 3,
                                    __( 'Poor', 'neartrips' )      => 2,
                                ];
                                foreach ( $breakdown as $label => $pct ) :
                                ?>
                                    <div class="nt-review-bar">
                                        <span><?php echo esc_html( $label ); ?></span>
                                        <div class="nt-review-bar-track"><div class="nt-review-bar-fill" style="width:<?php echo esc_attr( $pct ); ?>%"></div></div>
                                        <span><?php echo esc_html( $pct ); ?>%</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- WordPress comments as reviews -->
                        <?php comments_template(); ?>
                    </div>
                </div>

            </div><!-- .nt-single-content -->

            <!-- Booking sidebar -->
            <div class="nt-single-sidebar">
                <?php get_template_part( 'template-parts/booking/booking-widget', null, [ 'post_id' => $post_id, 'price' => $price, 'unit' => __( 'per person', 'neartrips' ) ] ); ?>
            </div>

        </div><!-- .nt-single-layout -->

        <!-- Related Tours -->
        <?php
        $related = new WP_Query( [
            'post_type'      => get_post_type(),
            'posts_per_page' => 4,
            'post__not_in'   => [ $post_id ],
            'post_status'    => 'publish',
            'orderby'        => 'rand',
        ] );
        if ( $related->have_posts() ) :
        ?>
            <hr class="nt-divider" style="margin:var(--nt-space-12) 0">
            <div data-anim="fade-up">
                <h2 style="margin-bottom:var(--nt-space-6)"><?php esc_html_e( 'You Might Also Like', 'neartrips' ); ?></h2>
                <div class="nt-grid-4">
                    <?php while ( $related->have_posts() ) : $related->the_post(); ?>
                        <?php get_template_part( 'template-parts/cards/card', 'tour', [ 'post_id' => get_the_ID() ] ); ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        <?php endif; ?>

    </div><!-- .nt-container -->
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
