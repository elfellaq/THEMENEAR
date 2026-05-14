<?php
/**
 * Site footer.
 *
 * @package NearTrips
 */
?>

</main><!-- #nt-main -->

<footer class="nt-footer" role="contentinfo">
    <div class="nt-container">

        <!-- Top grid -->
        <div class="nt-footer-top">

            <!-- Brand -->
            <div class="nt-footer-brand">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nt-footer-logo">
                    <span style="background:var(--nt-primary);width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                        <?php echo nt_icon( 'map-pin', 16 ); // phpcs:ignore ?>
                    </span>
                    <?php bloginfo( 'name' ); ?>
                </a>
                <p class="nt-footer-desc">
                    <?php echo esc_html( get_bloginfo( 'description' ) ?: __( 'NearTrips is your gateway to extraordinary travel experiences worldwide. Discover, book, and explore with confidence.', 'neartrips' ) ); ?>
                </p>
                <div class="nt-footer-contact">
                    <?php $phone = get_theme_mod( 'nt_phone', '' ); if ( $phone ) : ?>
                        <div class="nt-footer-contact-item">
                            <?php echo nt_icon( 'map-pin', 14 ); // phpcs:ignore ?>
                            <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
                        </div>
                    <?php endif; ?>
                    <?php $email = get_theme_mod( 'nt_email', get_option( 'admin_email' ) ); if ( $email ) : ?>
                        <div class="nt-footer-contact-item">
                            <?php echo nt_icon( 'users', 14 ); // phpcs:ignore ?>
                            <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                        </div>
                    <?php endif; ?>
                    <?php $address = get_theme_mod( 'nt_address', '' ); if ( $address ) : ?>
                        <div class="nt-footer-contact-item">
                            <?php echo nt_icon( 'map-pin', 14 ); // phpcs:ignore ?>
                            <span><?php echo esc_html( $address ); ?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Social -->
                <div class="nt-social-icons">
                    <?php
                    $socials = [
                        'facebook'  => get_theme_mod( 'nt_social_facebook', '#' ),
                        'twitter'   => get_theme_mod( 'nt_social_twitter', '#' ),
                        'instagram' => get_theme_mod( 'nt_social_instagram', '#' ),
                        'youtube'   => get_theme_mod( 'nt_social_youtube', '#' ),
                        'linkedin'  => get_theme_mod( 'nt_social_linkedin', '#' ),
                    ];
                    foreach ( $socials as $name => $url ) :
                        if ( ! $url || $url === '#' ) continue;
                    ?>
                        <a href="<?php echo esc_url( $url ); ?>" class="nt-social-icon" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $name ) ); ?>">
                            <?php echo nt_icon( 'share', 14 ); // phpcs:ignore ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="nt-footer-col-title"><?php esc_html_e( 'Quick Links', 'neartrips' ); ?></h4>
                <?php if ( has_nav_menu( 'footer-1' ) ) : ?>
                    <?php wp_nav_menu( [ 'theme_location' => 'footer-1', 'container' => false, 'menu_class' => 'nt-footer-links' ] ); ?>
                <?php else : ?>
                    <ul class="nt-footer-links">
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'neartrips' ); ?></a></li>
                        <li><a href="<?php echo esc_url( get_post_type_archive_link( nt_get_tour_post_type() ) ?: home_url( '/tours/' ) ); ?>"><?php esc_html_e( 'Tours', 'neartrips' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/destinations/' ) ); ?>"><?php esc_html_e( 'Destinations', 'neartrips' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/hotels/' ) ); ?>"><?php esc_html_e( 'Hotels', 'neartrips' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/activities/' ) ); ?>"><?php esc_html_e( 'Activities', 'neartrips' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'neartrips' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'neartrips' ); ?></a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Tours -->
            <div>
                <h4 class="nt-footer-col-title"><?php esc_html_e( 'Tour Types', 'neartrips' ); ?></h4>
                <?php if ( has_nav_menu( 'footer-2' ) ) : ?>
                    <?php wp_nav_menu( [ 'theme_location' => 'footer-2', 'container' => false, 'menu_class' => 'nt-footer-links' ] ); ?>
                <?php else :
                    $tour_cats = get_terms( [ 'taxonomy' => nt_is_wte_active() ? 'trip_types' : 'nt_tour_cat', 'hide_empty' => false, 'number' => 6 ] );
                    ?>
                    <ul class="nt-footer-links">
                        <?php if ( ! is_wp_error( $tour_cats ) ) : foreach ( $tour_cats as $tc ) : ?>
                            <li><a href="<?php echo esc_url( get_term_link( $tc ) ); ?>"><?php echo esc_html( $tc->name ); ?></a></li>
                        <?php endforeach; endif; ?>
                        <li><a href="<?php echo esc_url( get_post_type_archive_link( nt_get_tour_post_type() ) ?: home_url( '/tours/' ) ); ?>"><?php esc_html_e( 'All Tours', 'neartrips' ); ?></a></li>
                    </ul>
                <?php endif; ?>
            </div>

            <!-- Newsletter -->
            <div>
                <h4 class="nt-footer-col-title"><?php esc_html_e( 'Newsletter', 'neartrips' ); ?></h4>
                <p style="font-size:var(--nt-fs-sm);color:rgba(255,255,255,.55);margin-bottom:var(--nt-space-4)">
                    <?php esc_html_e( 'Get travel inspiration and exclusive deals delivered to your inbox.', 'neartrips' ); ?>
                </p>
                <div class="nt-footer-newsletter">
                    <form class="nt-newsletter-input-wrap" method="POST" action="#" novalidate>
                        <?php wp_nonce_field( 'nt_newsletter', 'nt_newsletter_nonce' ); ?>
                        <input type="email" name="email" class="nt-newsletter-input" placeholder="<?php esc_attr_e( 'Your email address', 'neartrips' ); ?>" required>
                        <button type="submit" class="nt-newsletter-btn"><?php esc_html_e( 'Subscribe', 'neartrips' ); ?></button>
                    </form>
                </div>
                <div class="nt-payment-icons" style="margin-top:var(--nt-space-4)">
                    <span class="nt-payment-icon">VISA</span>
                    <span class="nt-payment-icon">MC</span>
                    <span class="nt-payment-icon">PayPal</span>
                    <span class="nt-payment-icon">Stripe</span>
                </div>
            </div>

        </div><!-- .nt-footer-top -->

        <!-- Bottom bar -->
        <div class="nt-footer-bottom">
            <p class="nt-footer-copy">
                &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
                &mdash; <?php esc_html_e( 'All rights reserved.', 'neartrips' ); ?>
            </p>
            <div class="nt-footer-bottom-links">
                <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'neartrips' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/terms/' ) ); ?>"><?php esc_html_e( 'Terms', 'neartrips' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/sitemap.xml' ) ); ?>"><?php esc_html_e( 'Sitemap', 'neartrips' ); ?></a>
            </div>
        </div>

    </div><!-- .nt-container -->
</footer>

<!-- Back to top -->
<button id="nt-back-top" hidden aria-label="<?php esc_attr_e( 'Back to top', 'neartrips' ); ?>">
    <?php echo nt_icon( 'chevron-d', 20 ); // phpcs:ignore — chevron-d rotated 180 via CSS ?>
    <svg style="transform:rotate(180deg)" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6,9 12,15 18,9"/></svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
