<?php
/**
 * Elementor Support for NearTrips Theme
 * 
 * @package NearTrips
 * @version 2.0.0
 */

if (!defined('ABSPATH')) exit;

/**
 * Register Elementor locations
 */
function neartrips_register_elementor_locations($elementor_theme_manager) {
    $elementor_theme_manager->register_all_core_location();
}
add_action('elementor/theme/register_locations', 'neartrips_register_elementor_locations');

/**
 * Add Elementor support
 */
function neartrips_add_elementor_support() {
    add_theme_support('elementor', array(
        'locations' => array(
            'header' => array(
                'priority' => 1,
            ),
            'footer' => array(
                'priority' => 999,
            ),
        ),
    ));
    
    // Disable Elementor's default colors and fonts
    update_option('elementor_disable_color_schemes', 'yes');
    update_option('elementor_disable_typography_schemes', 'yes');
    update_option('elementor_default_generic_fonts', 'Poppins');
}
add_action('after_switch_theme', 'neartrips_add_elementor_support');

/**
 * Register custom Elementor widgets for travel
 */
function neartrips_register_elementor_widgets($widgets_registry) {
    // This would register custom widgets
    // For now, we ensure compatibility with existing widgets
}
add_action('elementor/widgets/register', 'neartrips_register_elementor_widgets');

/**
 * Add custom Elementor controls
 */
function neartrips_add_elementor_controls($controls_manager) {
    // Add travel-specific controls if needed
}
add_action('elementor/controls/register', 'neartrips_add_elementor_controls');

/**
 * Make theme compatible with Elementor Pro
 */
function neartrips_elementor_pro_support() {
    // Enable Header & Footer builder
    add_theme_support('elementor-pro-header-footer');
    
    // Enable Mega Menu support
    add_theme_support('elementor-pro-mega-menu');
}

/**
 * Shortcode for Home page content
 */
function neartrips_home_shortcode() {
    ob_start();
    get_template_part('template-parts/home', 'hero');
    get_template_part('template-parts/tours', 'grid');
    get_template_part('template-parts/destinations', 'grid');
    get_template_part('template-parts/features', 'section');
    get_template_part('template-parts/cta', 'section');
    return ob_get_clean();
}
add_shortcode('neartrips_home', 'neartrips_home_shortcode');

/**
 * Shortcode for Tours Grid
 */
function neartrips_tours_grid_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 6,
        'columns' => 3,
        'order' => 'DESC',
        'orderby' => 'date',
    ), $atts);
    
    ob_start();
    
    $tour_post_type = neartrips_get_tour_post_type();
    
    $args = array(
        'post_type' => $tour_post_type,
        'posts_per_page' => intval($atts['count']),
        'order' => $atts['order'],
        'orderby' => $atts['orderby'],
        'post_status' => 'publish',
    );
    
    $tours = new WP_Query($args);
    
    if ($tours->have_posts()) : ?>
        <div class="tours-grid" style="grid-template-columns: repeat(<?php echo esc_attr($atts['columns']); ?>, 1fr);">
            <?php while ($tours->have_posts()) : $tours->the_post(); ?>
                <?php get_template_part('template-parts/tour', 'card'); ?>
            <?php endwhile; ?>
        </div>
        <?php wp_reset_postdata();
    else : ?>
        <p><?php _e('No tours found.', 'neartrips'); ?></p>
    <?php endif;
    
    return ob_get_clean();
}
add_shortcode('neartrips_tours', 'neartrips_tours_grid_shortcode');

/**
 * Shortcode for Destinations
 */
function neartrips_destinations_shortcode($atts) {
    $atts = shortcode_atts(array(
        'count' => 6,
        'columns' => 3,
    ), $atts);
    
    ob_start();
    
    $taxonomy = neartrips_is_wte_active() ? 'wpte-destination' : 'destination';
    
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'number' => intval($atts['count']),
        'hide_empty' => true,
    ));
    
    if (!empty($terms) && !is_wp_error($terms)) : ?>
        <div class="destinations-grid" style="grid-template-columns: repeat(<?php echo esc_attr($atts['columns']); ?>, 1fr);">
            <?php foreach ($terms as $term) : ?>
                <div class="destination-card">
                    <?php
                    $image_id = neartrips_is_wte_active() ? get_term_meta($term->term_id, 'destination_thumbnail_id', true) : false;
                    $image_url = $image_id ? wp_get_attachment_url($image_id) : 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=800';
                    ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($term->name); ?>">
                    <div class="destination-overlay">
                        <h3 class="destination-name"><?php echo esc_html($term->name); ?></h3>
                        <p class="destination-count"><?php printf(_n('%d Tour', '%d Tours', $term->count, 'neartrips'), $term->count); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p><?php _e('No destinations found.', 'neartrips'); ?></p>
    <?php endif;
    
    return ob_get_clean();
}
add_shortcode('neartrips_destinations', 'neartrips_destinations_shortcode');

/**
 * Shortcode for Features Section
 */
function neartrips_features_shortcode() {
    ob_start();
    get_template_part('template-parts/features', 'section');
    return ob_get_clean();
}
add_shortcode('neartrips_features', 'neartrips_features_shortcode');

/**
 * Shortcode for CTA Section
 */
function neartrips_cta_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => __('Ready to Start Your Adventure?', 'neartrips'),
        'description' => __('Book your dream vacation today and create memories that last a lifetime.', 'neartrips'),
    ), $atts);
    
    ob_start();
    ?>
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title"><?php echo esc_html($atts['title']); ?></h2>
            <p class="cta-desc"><?php echo esc_html($atts['description']); ?></p>
            <div class="cta-buttons">
                <a href="<?php echo home_url('/' . neartrips_get_tour_post_type()); ?>" class="cta-btn cta-btn-primary">
                    <?php _e('Browse Tours', 'neartrips'); ?>
                </a>
                <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo wc_get_checkout_url(); ?>" class="cta-btn cta-btn-secondary">
                        <?php _e('Checkout My Trips', 'neartrips'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('neartrips_cta', 'neartrips_cta_shortcode');

/**
 * Check if Elementor is active
 */
function neartrips_is_elementor_active() {
    return did_action('elementor/loaded');
}

/**
 * Add Elementor template for single tour
 */
function neartrips_elementor_single_tour_template($template) {
    if (is_singular(neartrips_get_tour_post_type())) {
        $elementor_template = locate_template('elementor/single-tour.php');
        if ($elementor_template) {
            return $elementor_template;
        }
    }
    return $template;
}
add_filter('single_template', 'neartrips_elementor_single_tour_template');
