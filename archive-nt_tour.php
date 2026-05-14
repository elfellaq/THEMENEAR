<?php
/**
 * Archive: Tours.
 *
 * @package NearTrips
 */

get_header();
?>

<div class="nt-page-hero">
    <div class="nt-container">
        <h1 style="margin-bottom:var(--nt-space-2)"><?php esc_html_e( 'All Tours', 'neartrips' ); ?></h1>
        <p class="nt-text-muted"><?php printf( __( '%d tours available', 'neartrips' ), (int) $wp_query->found_posts ); ?></p>
    </div>
</div>

<div class="nt-section nt-section--sm">
    <div class="nt-container">
        <?php get_template_part( 'template-parts/search/search-widget' ); ?>
    </div>
</div>

<div class="nt-section nt-section--sm" style="padding-top:0">
    <div class="nt-container">
        <div class="nt-archive-layout">

            <!-- Sidebar filters -->
            <aside class="nt-archive-sidebar" aria-label="<?php esc_attr_e( 'Filters', 'neartrips' ); ?>">

                <div class="nt-filter-box">
                    <div class="nt-filter-box__title"><?php esc_html_e( 'Tour Category', 'neartrips' ); ?></div>
                    <?php
                    $cats = get_terms( [ 'taxonomy' => nt_is_wte_active() ? 'trip_types' : 'nt_tour_cat', 'hide_empty' => true ] );
                    if ( ! is_wp_error( $cats ) ) : foreach ( $cats as $cat ) :
                        $active = isset( $_GET['tour_category'] ) && sanitize_text_field( $_GET['tour_category'] ) === $cat->slug;
                    ?>
                        <label class="nt-filter-option">
                            <input type="checkbox" name="tour_category[]" value="<?php echo esc_attr( $cat->slug ); ?>" <?php checked( $active ); ?>>
                            <?php echo esc_html( $cat->name ); ?>
                            <span style="margin-left:auto;font-size:.75rem;color:var(--nt-text-muted)">(<?php echo esc_html( $cat->count ); ?>)</span>
                        </label>
                    <?php endforeach; endif; ?>
                </div>

                <div class="nt-filter-box">
                    <div class="nt-filter-box__title"><?php esc_html_e( 'Destination', 'neartrips' ); ?></div>
                    <?php
                    $dests = get_terms( [ 'taxonomy' => 'nt_destination', 'hide_empty' => true, 'number' => 10 ] );
                    if ( ! is_wp_error( $dests ) ) : foreach ( $dests as $dest ) : ?>
                        <label class="nt-filter-option">
                            <input type="checkbox" name="destination[]" value="<?php echo esc_attr( $dest->slug ); ?>">
                            <?php echo esc_html( $dest->name ); ?>
                        </label>
                    <?php endforeach; endif; ?>
                </div>

                <div class="nt-filter-box">
                    <div class="nt-filter-box__title"><?php esc_html_e( 'Duration', 'neartrips' ); ?></div>
                    <?php
                    $durations = [ '1 Day' => '1-day', '2-3 Days' => '2-3-days', '4-7 Days' => '4-7-days', '8+ Days' => '8-plus-days' ];
                    foreach ( $durations as $label => $val ) : ?>
                        <label class="nt-filter-option">
                            <input type="checkbox" name="duration[]" value="<?php echo esc_attr( $val ); ?>">
                            <?php echo esc_html( $label ); ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <div class="nt-filter-box">
                    <div class="nt-filter-box__title"><?php esc_html_e( 'Rating', 'neartrips' ); ?></div>
                    <?php for ( $r = 5; $r >= 3; $r-- ) : ?>
                        <label class="nt-filter-option">
                            <input type="radio" name="min_rating" value="<?php echo esc_attr( $r ); ?>">
                            <?php nt_stars( $r ); ?>
                            <?php echo esc_html( $r . '+' ); ?>
                        </label>
                    <?php endfor; ?>
                </div>

            </aside>

            <!-- Main content -->
            <div>
                <div class="nt-archive-toolbar">
                    <span class="nt-archive-count">
                        <?php printf( __( 'Showing %d tours', 'neartrips' ), (int) $wp_query->found_posts ); ?>
                    </span>
                    <div class="nt-archive-sort">
                        <label class="nt-label" for="nt-sort"><?php esc_html_e( 'Sort by:', 'neartrips' ); ?></label>
                        <select id="nt-sort" name="orderby" class="nt-select" style="width:auto">
                            <option value="popular"><?php esc_html_e( 'Most Popular', 'neartrips' ); ?></option>
                            <option value="price_low"><?php esc_html_e( 'Price: Low → High', 'neartrips' ); ?></option>
                            <option value="price_high"><?php esc_html_e( 'Price: High → Low', 'neartrips' ); ?></option>
                            <option value="newest"><?php esc_html_e( 'Newest', 'neartrips' ); ?></option>
                            <option value="rating"><?php esc_html_e( 'Top Rated', 'neartrips' ); ?></option>
                        </select>
                    </div>
                </div>

                <?php if ( have_posts() ) : ?>
                    <div class="nt-grid-3" id="nt-tours-grid" data-anim="stagger">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php get_template_part( 'template-parts/cards/card', 'tour', [ 'post_id' => get_the_ID() ] ); ?>
                        <?php endwhile; ?>
                    </div>
                    <?php nt_pagination(); ?>
                <?php else : ?>
                    <div class="nt-notice nt-notice--info">
                        <?php esc_html_e( 'No tours found. Try adjusting your filters.', 'neartrips' ); ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); ?>
