<?php
/**
 * Archive: Hotels.
 *
 * @package NearTrips
 */

get_header();
?>

<div class="nt-page-hero">
    <div class="nt-container">
        <h1><?php esc_html_e( 'All Hotels', 'neartrips' ); ?></h1>
        <p class="nt-text-muted"><?php printf( __( '%d hotels available', 'neartrips' ), (int) $wp_query->found_posts ); ?></p>
    </div>
</div>

<div class="nt-section nt-section--sm" style="padding-top:var(--nt-space-8)">
    <div class="nt-container">
        <div class="nt-archive-layout">

            <aside class="nt-archive-sidebar">
                <div class="nt-filter-box">
                    <div class="nt-filter-box__title"><?php esc_html_e( 'Hotel Type', 'neartrips' ); ?></div>
                    <?php $types = get_terms( [ 'taxonomy' => 'nt_hotel_type', 'hide_empty' => true ] );
                    if ( ! is_wp_error( $types ) ) : foreach ( $types as $t ) : ?>
                        <label class="nt-filter-option"><input type="checkbox" name="hotel_type[]" value="<?php echo esc_attr( $t->slug ); ?>"><?php echo esc_html( $t->name ); ?></label>
                    <?php endforeach; endif; ?>
                </div>
                <div class="nt-filter-box">
                    <div class="nt-filter-box__title"><?php esc_html_e( 'Star Rating', 'neartrips' ); ?></div>
                    <?php for ( $s = 5; $s >= 2; $s-- ) : ?>
                        <label class="nt-filter-option"><input type="radio" name="hotel_stars" value="<?php echo esc_attr( $s ); ?>"><?php echo str_repeat( '★', $s ); ?></label>
                    <?php endfor; ?>
                </div>
            </aside>

            <div>
                <?php if ( have_posts() ) : ?>
                    <div class="nt-grid-3" data-anim="stagger">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php get_template_part( 'template-parts/cards/card', 'hotel', [ 'post_id' => get_the_ID() ] ); ?>
                        <?php endwhile; ?>
                    </div>
                    <?php nt_pagination(); ?>
                <?php else : ?>
                    <div class="nt-notice nt-notice--info"><?php esc_html_e( 'No hotels found.', 'neartrips' ); ?></div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); ?>
