<?php
/**
 * Site footer.
 *
 * @package Travelio
 */
?>
</main><!-- #tv-main -->

<footer class="tv-site-footer">
    <div class="tv-container">
        <div class="tv-footer-grid">
            <div class="tv-footer-brand">
                <h4><?php bloginfo( 'name' ); ?></h4>
                <p><?php echo esc_html( get_theme_mod( 'travelio_footer_about', __( 'We craft unforgettable journeys to the world\'s most inspiring destinations. Travel with confidence, comfort, and a touch of wonder.', 'travelio' ) ) ); ?></p>
                <div class="tv-social">
                    <a href="<?php echo esc_url( get_theme_mod( 'travelio_facebook', '#' ) ); ?>" aria-label="Facebook">f</a>
                    <a href="<?php echo esc_url( get_theme_mod( 'travelio_twitter', '#' ) ); ?>" aria-label="Twitter">t</a>
                    <a href="<?php echo esc_url( get_theme_mod( 'travelio_instagram', '#' ) ); ?>" aria-label="Instagram">i</a>
                    <a href="<?php echo esc_url( get_theme_mod( 'travelio_youtube', '#' ) ); ?>" aria-label="YouTube">y</a>
                </div>
            </div>

            <div>
                <h4><?php esc_html_e( 'Explore', 'travelio' ); ?></h4>
                <?php
                if ( has_nav_menu( 'footer' ) ) {
                    wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'depth' => 1 ) );
                } else { ?>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About Us', 'travelio' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/tour-package/' ) ); ?>"><?php esc_html_e( 'Tour Packages', 'travelio' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/destination/' ) ); ?>"><?php esc_html_e( 'Destinations', 'travelio' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'travelio' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'travelio' ); ?></a></li>
                    </ul>
                <?php } ?>
            </div>

            <div>
                <h4><?php esc_html_e( 'Contact', 'travelio' ); ?></h4>
                <ul>
                    <li><?php echo esc_html( get_theme_mod( 'travelio_address', __( '123 Wanderlust Ave, Lisbon', 'travelio' ) ) ); ?></li>
                    <li><?php echo esc_html( get_theme_mod( 'travelio_phone', '+1 (555) 123-4567' ) ); ?></li>
                    <li><?php echo esc_html( get_theme_mod( 'travelio_email', 'hello@example.com' ) ); ?></li>
                </ul>
            </div>

            <div class="tv-newsletter">
                <h4><?php esc_html_e( 'Newsletter', 'travelio' ); ?></h4>
                <p style="margin-bottom:14px;opacity:.85"><?php esc_html_e( 'Get travel tips and exclusive deals to your inbox.', 'travelio' ); ?></p>
                <form action="#" method="post" onsubmit="event.preventDefault();this.querySelector('button').innerText='Thanks!';">
                    <input type="email" required placeholder="<?php esc_attr_e( 'Your email address', 'travelio' ); ?>">
                    <button type="submit" class="tv-btn tv-btn--primary"><?php esc_html_e( 'Subscribe', 'travelio' ); ?></button>
                </form>
            </div>
        </div>

        <div class="tv-footer-bottom">
            &copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'travelio' ); ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
