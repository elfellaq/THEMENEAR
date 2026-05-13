<?php
/**
 * Front page template (home).
 *
 * @package Travelio
 */

get_header();

$hero_title    = get_theme_mod( 'travelio_hero_title', __( 'Explore the world, one journey at a time', 'travelio' ) );
$hero_accent   = get_theme_mod( 'travelio_hero_accent', __( 'extraordinary', 'travelio' ) );
$hero_subtitle = get_theme_mod( 'travelio_hero_subtitle', __( 'Hand-crafted tour packages, breathtaking destinations, and the kind of memories that stay with you forever.', 'travelio' ) );
$hero_image    = travelio_hero_image();
?>

<section class="tv-hero" style="background-image:linear-gradient(135deg,rgba(11,37,69,.75),rgba(11,37,69,.45)),url('<?php echo esc_url( $hero_image ); ?>')">
    <div class="tv-container tv-hero-inner">
        <span class="tv-eyebrow" style="color:#FFC857"><?php esc_html_e( 'Welcome to Travelio', 'travelio' ); ?></span>
        <h1><?php echo wp_kses_post( $hero_title ); ?> <span class="tv-accent"><?php echo esc_html( $hero_accent ); ?></span></h1>
        <p class="lead"><?php echo esc_html( $hero_subtitle ); ?></p>

        <div class="tv-hero-actions">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'tour_package' ) ?: '#packages' ); ?>" class="tv-btn tv-btn--primary"><?php esc_html_e( 'Browse Tours', 'travelio' ); ?></a>
            <a href="#destinations" class="tv-btn tv-btn--ghost"><?php esc_html_e( 'Discover Places', 'travelio' ); ?></a>
        </div>

        <form class="tv-search" role="search" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'tour_package' ) ?: home_url( '/' ) ); ?>">
            <div class="tv-search-field">
                <label><?php esc_html_e( 'Destination', 'travelio' ); ?></label>
                <input type="text" name="s" placeholder="<?php esc_attr_e( 'Where to?', 'travelio' ); ?>">
            </div>
            <div class="tv-search-field">
                <label><?php esc_html_e( 'Tour Type', 'travelio' ); ?></label>
                <select name="tour_type">
                    <option value=""><?php esc_html_e( 'Any', 'travelio' ); ?></option>
                    <option value="adventure"><?php esc_html_e( 'Adventure', 'travelio' ); ?></option>
                    <option value="cultural"><?php esc_html_e( 'Cultural', 'travelio' ); ?></option>
                    <option value="beach"><?php esc_html_e( 'Beach', 'travelio' ); ?></option>
                    <option value="city"><?php esc_html_e( 'City Break', 'travelio' ); ?></option>
                </select>
            </div>
            <div class="tv-search-field">
                <label><?php esc_html_e( 'Duration', 'travelio' ); ?></label>
                <select name="duration">
                    <option value=""><?php esc_html_e( 'Any', 'travelio' ); ?></option>
                    <option value="1-3">1–3 <?php esc_html_e( 'days', 'travelio' ); ?></option>
                    <option value="4-7">4–7 <?php esc_html_e( 'days', 'travelio' ); ?></option>
                    <option value="8+">8+ <?php esc_html_e( 'days', 'travelio' ); ?></option>
                </select>
            </div>
            <div class="tv-search-field">
                <label><?php esc_html_e( 'Travelers', 'travelio' ); ?></label>
                <input type="number" min="1" name="travelers" value="2">
            </div>
            <button type="submit" class="tv-btn tv-btn--primary"><?php esc_html_e( 'Search', 'travelio' ); ?></button>
        </form>
    </div>
</section>

<!-- Stats -->
<section class="tv-section" style="padding-top:60px;padding-bottom:0">
    <div class="tv-container">
        <div class="tv-stats">
            <div class="tv-stat"><div class="tv-stat-num">120+</div><div class="tv-stat-label"><?php esc_html_e( 'Destinations', 'travelio' ); ?></div></div>
            <div class="tv-stat"><div class="tv-stat-num">450+</div><div class="tv-stat-label"><?php esc_html_e( 'Tour Packages', 'travelio' ); ?></div></div>
            <div class="tv-stat"><div class="tv-stat-num">25k+</div><div class="tv-stat-label"><?php esc_html_e( 'Happy Travelers', 'travelio' ); ?></div></div>
            <div class="tv-stat"><div class="tv-stat-num">15</div><div class="tv-stat-label"><?php esc_html_e( 'Years Experience', 'travelio' ); ?></div></div>
        </div>
    </div>
</section>

<!-- Destinations -->
<section class="tv-section" id="destinations">
    <div class="tv-container">
        <div class="tv-section-head">
            <span class="tv-eyebrow"><?php esc_html_e( 'Top Destinations', 'travelio' ); ?></span>
            <h2><?php esc_html_e( 'Places that take your breath away', 'travelio' ); ?></h2>
            <p><?php esc_html_e( 'From sun-drenched coastlines to misty mountain villages — these are the destinations our travelers love most.', 'travelio' ); ?></p>
        </div>

        <div class="tv-grid tv-grid--4">
            <?php
            $dests = new WP_Query( array(
                'post_type'      => 'destination',
                'posts_per_page' => 4,
                'no_found_rows'  => true,
            ) );

            if ( $dests->have_posts() ) :
                while ( $dests->have_posts() ) : $dests->the_post();
                    $tour_count = wp_count_posts( 'tour_package' );
                    ?>
                    <a class="tv-dest" href="<?php the_permalink(); ?>">
                        <?php if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'travelio-dest' );
                        } else { ?>
                            <img src="https://source.unsplash.com/600x800/?<?php echo esc_attr( sanitize_title( get_the_title() ) ); ?>,travel" alt="<?php the_title_attribute(); ?>">
                        <?php } ?>
                        <div class="tv-dest-body">
                            <h3><?php the_title(); ?></h3>
                            <span><?php echo esc_html( travelio_meta( '_tv_dest_tours_count', __( 'Explore tours', 'travelio' ) ) ); ?></span>
                        </div>
                    </a>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Placeholder destinations when no real data exists yet.
                $placeholders = array(
                    array( 'Bali, Indonesia', 'bali,beach' ),
                    array( 'Kyoto, Japan',    'kyoto,temple' ),
                    array( 'Santorini, Greece','santorini' ),
                    array( 'Marrakech, Morocco','marrakech' ),
                );
                foreach ( $placeholders as $p ) : ?>
                    <a class="tv-dest" href="#">
                        <img src="https://source.unsplash.com/600x800/?<?php echo esc_attr( $p[1] ); ?>" alt="<?php echo esc_attr( $p[0] ); ?>">
                        <div class="tv-dest-body">
                            <h3><?php echo esc_html( $p[0] ); ?></h3>
                            <span><?php esc_html_e( 'Explore tours', 'travelio' ); ?></span>
                        </div>
                    </a>
                <?php endforeach;
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Tour Packages -->
<section class="tv-section tv-section--soft" id="packages">
    <div class="tv-container">
        <div class="tv-section-head">
            <span class="tv-eyebrow"><?php esc_html_e( 'Featured Packages', 'travelio' ); ?></span>
            <h2><?php esc_html_e( 'Tours travelers can\'t stop talking about', 'travelio' ); ?></h2>
            <p><?php esc_html_e( 'Curated experiences with trusted local guides, comfortable stays, and zero hidden fees.', 'travelio' ); ?></p>
        </div>

        <div class="tv-grid tv-grid--3">
            <?php
            $tours = new WP_Query( array(
                'post_type'      => 'tour_package',
                'posts_per_page' => 6,
                'no_found_rows'  => true,
            ) );

            if ( $tours->have_posts() ) :
                while ( $tours->have_posts() ) : $tours->the_post();
                    get_template_part( 'template-parts/content', 'tour' );
                endwhile;
                wp_reset_postdata();
            else :
                // Placeholder packages.
                $placeholders = array(
                    array( 'Bali Island Hopper',      '7 Days, 6 Nights', '$899',  '4.9', 'bali' ),
                    array( 'Kyoto Cultural Escape',   '5 Days, 4 Nights', '$1,150','4.8', 'kyoto' ),
                    array( 'Santorini Sunset Cruise', '4 Days, 3 Nights', '$780',  '4.9', 'santorini' ),
                    array( 'Sahara Desert Trek',      '6 Days, 5 Nights', '$1,050','4.7', 'sahara' ),
                    array( 'Iceland Northern Lights', '8 Days, 7 Nights', '$1,890','5.0', 'iceland' ),
                    array( 'Machu Picchu Adventure',  '9 Days, 8 Nights', '$1,650','4.8', 'machu-picchu' ),
                );
                foreach ( $placeholders as $p ) : ?>
                    <article class="tv-card">
                        <div class="tv-card-media">
                            <img src="https://source.unsplash.com/600x450/?<?php echo esc_attr( $p[4] ); ?>" alt="<?php echo esc_attr( $p[0] ); ?>">
                            <span class="tv-card-badge"><?php esc_html_e( 'Featured', 'travelio' ); ?></span>
                        </div>
                        <div class="tv-card-body">
                            <div class="tv-card-meta"><span>&#9201; <?php echo esc_html( $p[1] ); ?></span></div>
                            <h3 class="tv-card-title"><a href="#"><?php echo esc_html( $p[0] ); ?></a></h3>
                            <p style="color:var(--tv-muted);font-size:.92rem;margin:0"><?php esc_html_e( 'A curated journey featuring iconic sights, local cuisine, and time to wander.', 'travelio' ); ?></p>
                            <div class="tv-card-foot">
                                <span class="tv-price"><?php echo esc_html( $p[2] ); ?><small><?php esc_html_e( ' / person', 'travelio' ); ?></small></span>
                                <span class="tv-rating">&#9733; <span class="num"><?php echo esc_html( $p[3] ); ?></span></span>
                            </div>
                        </div>
                    </article>
                <?php endforeach;
            endif;
            ?>
        </div>

        <div style="text-align:center;margin-top:50px">
            <a href="<?php echo esc_url( get_post_type_archive_link( 'tour_package' ) ?: '#' ); ?>" class="tv-btn tv-btn--dark"><?php esc_html_e( 'View all packages', 'travelio' ); ?></a>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="tv-section">
    <div class="tv-container">
        <div class="tv-section-head">
            <span class="tv-eyebrow"><?php esc_html_e( 'Why Choose Us', 'travelio' ); ?></span>
            <h2><?php esc_html_e( 'Travel made effortless', 'travelio' ); ?></h2>
        </div>
        <div class="tv-features">
            <div class="tv-feature">
                <div class="tv-feature-icon">&#9992;</div>
                <h3><?php esc_html_e( 'Hand-picked tours', 'travelio' ); ?></h3>
                <p><?php esc_html_e( 'Every itinerary is designed by travel experts who\'ve been there.', 'travelio' ); ?></p>
            </div>
            <div class="tv-feature">
                <div class="tv-feature-icon">&#10004;</div>
                <h3><?php esc_html_e( 'Best price guarantee', 'travelio' ); ?></h3>
                <p><?php esc_html_e( 'Find it cheaper elsewhere? We\'ll match the price — no questions.', 'travelio' ); ?></p>
            </div>
            <div class="tv-feature">
                <div class="tv-feature-icon">&#9733;</div>
                <h3><?php esc_html_e( '24/7 local support', 'travelio' ); ?></h3>
                <p><?php esc_html_e( 'A real human on call wherever you are in the world.', 'travelio' ); ?></p>
            </div>
            <div class="tv-feature">
                <div class="tv-feature-icon">&#9786;</div>
                <h3><?php esc_html_e( 'No hidden fees', 'travelio' ); ?></h3>
                <p><?php esc_html_e( 'What you see is what you pay. Always transparent pricing.', 'travelio' ); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Banner -->
<section class="tv-cta-banner">
    <div class="tv-container">
        <h2><?php esc_html_e( 'Ready to start your next adventure?', 'travelio' ); ?></h2>
        <p><?php esc_html_e( 'Talk to one of our travel designers and get a tailor-made itinerary in 24 hours.', 'travelio' ); ?></p>
        <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="tv-btn tv-btn--primary"><?php esc_html_e( 'Plan my trip', 'travelio' ); ?></a>
    </div>
</section>

<!-- Testimonials -->
<section class="tv-section tv-section--soft">
    <div class="tv-container">
        <div class="tv-section-head">
            <span class="tv-eyebrow"><?php esc_html_e( 'Travelers Say', 'travelio' ); ?></span>
            <h2><?php esc_html_e( 'Stories from the road', 'travelio' ); ?></h2>
        </div>
        <div class="tv-grid tv-grid--3">
            <?php
            $reviews = array(
                array( 'The Bali trip was flawless. Every detail thought through, every guide warm and knowledgeable. We can\'t wait to book the next one.', 'Sofia M.', 'Lisbon, Portugal' ),
                array( 'I\'m a nervous traveler — Travelio made me feel safe and looked-after at every step. Worth every penny.', 'James K.', 'Toronto, Canada' ),
                array( 'Iceland in winter was a dream. The northern lights tour delivered exactly what was promised, plus a sky we\'ll never forget.', 'Aiko T.', 'Osaka, Japan' ),
            );
            foreach ( $reviews as $i => $r ) : ?>
                <div class="tv-testimonial">
                    <p><?php echo esc_html( $r[0] ); ?></p>
                    <div class="who">
                        <img src="https://i.pravatar.cc/108?img=<?php echo (int) ( $i + 12 ); ?>" alt="">
                        <div>
                            <strong><?php echo esc_html( $r[1] ); ?></strong>
                            <span><?php echo esc_html( $r[2] ); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Blog teasers -->
<?php
$posts_q = new WP_Query( array( 'posts_per_page' => 3, 'no_found_rows' => true ) );
if ( $posts_q->have_posts() ) : ?>
<section class="tv-section">
    <div class="tv-container">
        <div class="tv-section-head">
            <span class="tv-eyebrow"><?php esc_html_e( 'From the Blog', 'travelio' ); ?></span>
            <h2><?php esc_html_e( 'Travel tips & inspiration', 'travelio' ); ?></h2>
        </div>
        <div class="tv-grid tv-grid--3">
            <?php while ( $posts_q->have_posts() ) : $posts_q->the_post(); ?>
                <article class="tv-post">
                    <a href="<?php the_permalink(); ?>" class="tv-post-media">
                        <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'travelio-card' ); }
                        else { ?><img src="https://source.unsplash.com/600x400/?travel,blog,<?php echo esc_attr( get_the_ID() ); ?>" alt=""><?php } ?>
                    </a>
                    <div class="tv-post-body">
                        <div class="tv-post-meta"><?php echo esc_html( get_the_date() ); ?> &middot; <?php the_category( ', ' ); ?></div>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
                        <a href="<?php the_permalink(); ?>" class="tv-readmore"><?php esc_html_e( 'Read article &rarr;', 'travelio' ); ?></a>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php get_footer();
