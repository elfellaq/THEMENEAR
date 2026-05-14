<?php
/**
 * Homepage: Latest Blog Posts section.
 *
 * @package NearTrips
 */

$query = new WP_Query( [
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
] );
if ( ! $query->have_posts() ) { return; }
?>

<section class="nt-section nt-section--soft" id="blog" aria-labelledby="blog-title">
    <div class="nt-container">

        <div class="nt-flex-between" style="margin-bottom:var(--nt-space-8)" data-anim="fade-up">
            <div>
                <span class="nt-eyebrow"><?php esc_html_e( 'Travel Tips', 'neartrips' ); ?></span>
                <h2 id="blog-title"><?php esc_html_e( 'From Our Blog', 'neartrips' ); ?></h2>
            </div>
            <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog/' ) ); ?>" class="nt-btn nt-btn--outline nt-btn--sm">
                <?php esc_html_e( 'All Articles', 'neartrips' ); ?>
                <?php echo nt_icon( 'chevron-r', 16 ); // phpcs:ignore ?>
            </a>
        </div>

        <div class="nt-grid-3" data-anim="stagger">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <article class="nt-card" data-anim-child>
                    <div class="nt-card__img nt-img-zoom">
                        <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'nt-blog', [ 'loading' => 'lazy' ] ); ?>
                            <?php else : ?>
                                <img src="https://placehold.co/800x500/0B2545/FFFFFF?text=NearTrips+Blog" alt="<?php the_title_attribute(); ?>" loading="lazy" width="800" height="500">
                            <?php endif; ?>
                        </a>
                        <?php $cats = get_the_category(); if ( $cats ) : ?>
                            <div class="nt-card__badge">
                                <span class="nt-badge nt-badge--soft"><?php echo esc_html( $cats[0]->name ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="nt-card__body">
                        <div class="nt-card__meta" style="margin-bottom:var(--nt-space-3)">
                            <span class="nt-card__meta-item">
                                <?php echo nt_icon( 'calendar', 13 ); // phpcs:ignore ?>
                                <?php echo esc_html( get_the_date() ); ?>
                            </span>
                            <span class="nt-card__meta-item">
                                <?php echo nt_icon( 'users', 13 ); // phpcs:ignore ?>
                                <?php the_author(); ?>
                            </span>
                        </div>
                        <h3 class="nt-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p style="font-size:var(--nt-fs-sm);color:var(--nt-text-muted);margin:0;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                            <?php the_excerpt(); ?>
                        </p>
                    </div>

                    <div class="nt-card__footer">
                        <a href="<?php the_permalink(); ?>" class="nt-btn nt-btn--sm nt-btn--outline">
                            <?php esc_html_e( 'Read More', 'neartrips' ); ?>
                            <?php echo nt_icon( 'chevron-r', 14 ); // phpcs:ignore ?>
                        </a>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

    </div>
</section>
