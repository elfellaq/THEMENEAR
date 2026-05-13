<?php
/**
 * Site header.
 *
 * @package Travelio
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) { wp_body_open(); } ?>

<a class="screen-reader-text" href="#tv-main"><?php esc_html_e( 'Skip to content', 'travelio' ); ?></a>

<header class="tv-site-header" id="tv-site-header">
    <div class="tv-container tv-header-inner">
        <div class="tv-logo">
            <?php if ( has_custom_logo() ) :
                the_custom_logo();
            else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <span class="tv-logo-dot"></span><?php bloginfo( 'name' ); ?>
                </a>
            <?php endif; ?>
        </div>

        <nav class="tv-nav" id="tv-nav" aria-label="<?php esc_attr_e( 'Primary', 'travelio' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container'      => false,
                'fallback_cb'    => 'travelio_fallback_menu',
                'depth'          => 2,
            ) );
            ?>
        </nav>

        <div class="tv-header-cta">
            <?php $phone = get_theme_mod( 'travelio_phone', '+1 (555) 123-4567' ); ?>
            <?php if ( $phone ) : ?>
                <span class="tv-phone">&#9742; <?php echo esc_html( $phone ); ?></span>
            <?php endif; ?>
            <a href="<?php echo esc_url( get_theme_mod( 'travelio_cta_url', '#contact' ) ); ?>" class="tv-btn tv-btn--primary"><?php esc_html_e( 'Book Now', 'travelio' ); ?></a>
            <button class="tv-menu-toggle" aria-controls="tv-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle menu', 'travelio' ); ?>">&#9776;</button>
        </div>
    </div>
</header>

<main id="tv-main" class="tv-main">
