<?php
/**
 * Homepage: Featured Tours section (Swiper slider).
 *
 * @package NearTrips
 */

$query = nt_get_featured_tours( 8 );
if ( ! $query->have_posts() ) { return; }
?>

<section class="nt-section nt-section--soft" id="featured-tours" aria-labelledby="featured-tours-title">
    <div class="nt-container">

        <div class="nt-flex-between" style="margin-bottom:var(--nt-space-8)" data-anim="fade-up">
            <div>
                <span class="nt-eyebrow"><?php esc_html_e( 'Hand-picked', 'neartrips' ); ?></span>
                <h2 id="featured-tours-title"><?php esc_html_e( 'Featured Tours', 'neartrips' ); ?></h2>
            </div>
            <div class="nt-flex" style="gap:var(--nt-space-8);align-items:center">
                <a href="<?php echo esc_url( get_post_type_archive_link( nt_get_tour_post_type() ) ?: home_url( '/tours/' ) ); ?>" class="nt-btn nt-btn--outline nt-btn--sm">
                    <?php esc_html_e( 'View All', 'neartrips' ); ?>
                    <?php echo nt_icon( 'chevron-r', 16 ); // phpcs:ignore ?>
                </a>
                <div class="nt-swiper-nav">
                    <button class="nt-swiper-btn nt-tours-prev" aria-label="<?php esc_attr_e( 'Previous', 'neartrips' ); ?>">
                        <?php echo nt_icon( 'chevron-l', 18 ); // phpcs:ignore ?>
                    </button>
                    <button class="nt-swiper-btn nt-tours-next" aria-label="<?php esc_attr_e( 'Next', 'neartrips' ); ?>">
                        <?php echo nt_icon( 'chevron-r', 18 ); // phpcs:ignore ?>
                    </button>
                </div>
            </div>
        </div>

        <div class="swiper nt-tours-swiper">
            <div class="swiper-wrapper">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <div class="swiper-slide">
                        <?php get_template_part( 'template-parts/cards/card', 'tour', [ 'post_id' => get_the_ID() ] ); ?>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <div class="swiper-pagination nt-tours-pagination" style="position:static;margin-top:var(--nt-space-6)"></div>
        </div>

    </div>
</section>
