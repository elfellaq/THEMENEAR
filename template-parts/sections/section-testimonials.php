<?php
/**
 * Homepage: Testimonials section (Swiper).
 *
 * @package NearTrips
 */

$query = nt_get_testimonials( 9 );
if ( ! $query->have_posts() ) { return; }
?>

<section class="nt-section nt-section--dark" id="testimonials" aria-labelledby="testimonials-title">
    <div class="nt-container">

        <div class="nt-flex-between" style="margin-bottom:var(--nt-space-8)" data-anim="fade-up">
            <div>
                <span class="nt-eyebrow" style="color:rgba(255,255,255,.6)"><?php esc_html_e( 'Traveller Stories', 'neartrips' ); ?></span>
                <h2 id="testimonials-title" style="color:#fff"><?php esc_html_e( 'What Our Travellers Say', 'neartrips' ); ?></h2>
            </div>
            <div class="nt-swiper-nav">
                <button class="nt-swiper-btn nt-testimonials-prev" aria-label="<?php esc_attr_e( 'Previous', 'neartrips' ); ?>">
                    <?php echo nt_icon( 'chevron-l', 18 ); // phpcs:ignore ?>
                </button>
                <button class="nt-swiper-btn nt-testimonials-next" aria-label="<?php esc_attr_e( 'Next', 'neartrips' ); ?>">
                    <?php echo nt_icon( 'chevron-r', 18 ); // phpcs:ignore ?>
                </button>
            </div>
        </div>

        <div class="swiper nt-testimonials-swiper">
            <div class="swiper-wrapper">
                <?php while ( $query->have_posts() ) : $query->the_post();
                    $name    = get_post_meta( get_the_ID(), '_nt_reviewer_name', true ) ?: get_the_title();
                    $role    = get_post_meta( get_the_ID(), '_nt_reviewer_role', true );
                    $country = get_post_meta( get_the_ID(), '_nt_reviewer_country', true );
                    $rating  = (float) ( get_post_meta( get_the_ID(), '_nt_rating', true ) ?: 5 );
                    $content = get_the_content();
                ?>
                <div class="swiper-slide">
                    <div class="nt-testi-card" style="background:rgba(255,255,255,.07);border-color:rgba(255,255,255,.1);color:#fff">
                        <div><?php nt_stars( $rating ); ?></div>
                        <p class="nt-testi-card__quote" style="color:rgba(255,255,255,.85)">
                            "<?php echo wp_kses_post( $content ); ?>"
                        </p>
                        <div class="nt-testi-card__author">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'thumbnail', [ 'class' => 'nt-testi-card__avatar', 'alt' => esc_attr( $name ) ] ); ?>
                            <?php else : ?>
                                <div class="nt-testi-card__avatar" style="background:var(--nt-primary);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.9rem">
                                    <?php echo esc_html( mb_strtoupper( mb_substr( $name, 0, 2 ) ) ); ?>
                                </div>
                            <?php endif; ?>
                            <div>
                                <div class="nt-testi-card__name" style="color:#fff"><?php echo esc_html( $name ); ?></div>
                                <?php if ( $role ) : ?>
                                    <div class="nt-testi-card__role" style="color:rgba(255,255,255,.6)"><?php echo esc_html( $role ); ?></div>
                                <?php endif; ?>
                                <?php if ( $country ) : ?>
                                    <div class="nt-testi-card__tour" style="color:var(--nt-primary)"><?php echo esc_html( $country ); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
            <div class="swiper-pagination nt-testimonials-pagination" style="position:static;margin-top:var(--nt-space-6)"></div>
        </div>

    </div>
</section>
