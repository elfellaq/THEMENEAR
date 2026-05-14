<?php
/**
 * Site header.
 *
 * @package NearTrips
 */
?>
<!doctype html>
<html <?php language_attributes(); ?> data-theme="light">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="nt-visually-hidden" href="#nt-main"><?php esc_html_e( 'Skip to content', 'neartrips' ); ?></a>

<!-- Overlay for mobile menu -->
<div class="nt-overlay" id="nt-overlay" aria-hidden="true"></div>

<!-- ── Site Header ── -->
<header class="nt-site-header" id="nt-site-header" role="banner">
    <div class="nt-container nt-header-inner">

        <!-- Logo -->
        <div class="nt-logo">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <span class="nt-logo__icon">
                        <?php echo nt_icon( 'map-pin', 20 ); // phpcs:ignore ?>
                    </span>
                    <?php bloginfo( 'name' ); ?>
                </a>
            <?php endif; ?>
        </div>

        <!-- Primary Navigation -->
        <nav class="nt-nav" id="nt-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'neartrips' ); ?>">
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'container'      => false,
                'fallback_cb'    => 'nt_fallback_nav',
                'depth'          => 3,
            ] );
            ?>
        </nav>

        <!-- Header CTA Group -->
        <div class="nt-header-cta">

            <!-- Dark mode toggle -->
            <button
                class="nt-dark-toggle"
                id="nt-dark-toggle"
                aria-label="<?php esc_attr_e( 'Toggle dark mode', 'neartrips' ); ?>"
                title="<?php esc_attr_e( 'Toggle dark mode', 'neartrips' ); ?>"
            >
                <span class="nt-icon-sun"><?php echo nt_icon( 'sun', 18 ); // phpcs:ignore ?></span>
                <span class="nt-icon-moon" style="display:none"><?php echo nt_icon( 'moon', 18 ); // phpcs:ignore ?></span>
            </button>

            <!-- Sign in -->
            <?php if ( is_user_logged_in() ) : ?>
                <a href="<?php echo esc_url( get_dashboard_url() ); ?>" class="nt-header-user">
                    <?php echo nt_icon( 'users', 18 ); // phpcs:ignore ?>
                    <?php esc_html_e( 'My Account', 'neartrips' ); ?>
                </a>
            <?php else : ?>
                <a href="<?php echo esc_url( wp_login_url() ); ?>" class="nt-header-user">
                    <?php echo nt_icon( 'users', 18 ); // phpcs:ignore ?>
                    <?php esc_html_e( 'Sign In', 'neartrips' ); ?>
                </a>
            <?php endif; ?>

            <!-- Book Now CTA -->
            <a
                href="<?php echo esc_url( get_post_type_archive_link( nt_get_tour_post_type() ) ?: home_url( '/tours/' ) ); ?>"
                class="nt-btn nt-btn--primary"
            ><?php esc_html_e( 'Book Now', 'neartrips' ); ?></a>

            <!-- Mobile toggle -->
            <button
                class="nt-menu-toggle"
                id="nt-menu-toggle"
                aria-controls="nt-offcanvas"
                aria-expanded="false"
                aria-label="<?php esc_attr_e( 'Open menu', 'neartrips' ); ?>"
            ><?php echo nt_icon( 'menu', 22 ); // phpcs:ignore ?></button>

        </div>
    </div>
</header>

<!-- ── Mobile Offcanvas Menu ── -->
<div class="nt-offcanvas" id="nt-offcanvas" role="dialog" aria-label="<?php esc_attr_e( 'Mobile menu', 'neartrips' ); ?>" aria-hidden="true">
    <div class="nt-offcanvas-head">
        <div class="nt-logo">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:var(--nt-navy)">
                    <span class="nt-logo__icon"><?php echo nt_icon( 'map-pin', 18 ); // phpcs:ignore ?></span>
                    <?php bloginfo( 'name' ); ?>
                </a>
            <?php endif; ?>
        </div>
        <button
            class="nt-offcanvas-close"
            id="nt-offcanvas-close"
            aria-label="<?php esc_attr_e( 'Close menu', 'neartrips' ); ?>"
        ><?php echo nt_icon( 'x', 18 ); // phpcs:ignore ?></button>
    </div>

    <nav class="nt-offcanvas-nav" aria-label="<?php esc_attr_e( 'Mobile navigation', 'neartrips' ); ?>">
        <?php
        wp_nav_menu( [
            'theme_location' => 'primary',
            'container'      => false,
            'fallback_cb'    => 'nt_fallback_nav',
            'depth'          => 2,
        ] );
        ?>
    </nav>

    <div class="nt-offcanvas-foot">
        <?php if ( ! is_user_logged_in() ) : ?>
            <a href="<?php echo esc_url( wp_login_url() ); ?>" class="nt-btn nt-btn--outline" style="width:100%;justify-content:center">
                <?php esc_html_e( 'Sign In', 'neartrips' ); ?>
            </a>
        <?php endif; ?>
        <a
            href="<?php echo esc_url( get_post_type_archive_link( nt_get_tour_post_type() ) ?: home_url( '/tours/' ) ); ?>"
            class="nt-btn nt-btn--primary"
            style="width:100%;justify-content:center"
        ><?php esc_html_e( 'Book Now', 'neartrips' ); ?></a>
    </div>
</div>

<main id="nt-main" class="nt-main">
