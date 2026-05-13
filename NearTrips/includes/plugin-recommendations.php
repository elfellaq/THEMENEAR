<?php
/**
 * Plugin Recommendations for NearTrips Theme
 * Detects and recommends required plugins
 * 
 * @package NearTrips
 * @version 2.0.0
 */

if (!defined('ABSPATH')) exit;

/**
 * Get recommended plugins
 */
function neartrips_get_recommended_plugins() {
    return array(
        'wpte' => array(
            'name' => 'WP Travel Engine',
            'slug' => 'wp-travel-engine',
            'description' => __('Complete travel booking solution with itinerary management, booking system, and payment integration.', 'neartrips'),
            'required' => true,
            'free' => true,
            'url' => 'https://wordpress.org/plugins/wp-travel-engine/',
        ),
        'woocommerce' => array(
            'name' => 'WooCommerce',
            'slug' => 'woocommerce',
            'description' => __('E-commerce platform for selling tour packages, merchandise, and processing payments.', 'neartrips'),
            'required' => false,
            'free' => true,
            'url' => 'https://wordpress.org/plugins/woocommerce/',
        ),
        'elementor' => array(
            'name' => 'Elementor',
            'slug' => 'elementor',
            'description' => __('Drag & drop page builder to customize your travel website without coding.', 'neartrips'),
            'required' => false,
            'free' => true,
            'url' => 'https://wordpress.org/plugins/elementor/',
        ),
        'contact-form-7' => array(
            'name' => 'Contact Form 7',
            'slug' => 'contact-form-7',
            'description' => __('Create contact forms for inquiries and bookings.', 'neartrips'),
            'required' => false,
            'free' => true,
            'url' => 'https://wordpress.org/plugins/contact-form-7/',
        ),
        'yoast-seo' => array(
            'name' => 'Yoast SEO',
            'slug' => 'wordpress-seo',
            'description' => __('Optimize your travel content for search engines.', 'neartrips'),
            'required' => false,
            'free' => true,
            'url' => 'https://wordpress.org/plugins/wordpress-seo/',
        ),
    );
}

/**
 * Check plugin installation status
 */
function neartrips_check_plugin_status($slug) {
    if (file_exists(WP_PLUGIN_DIR . '/' . $slug . '/' . $slug . '.php')) {
        return 'installed';
    }
    
    $plugins = get_plugins('/' . $slug);
    if (!empty($plugins)) {
        return 'installed';
    }
    
    return 'not-installed';
}

/**
 * Check if plugin is active
 */
function neartrips_is_plugin_active($slug) {
    return in_array($slug . '/' . $slug . '.php', get_option('active_plugins', array())) ||
           is_plugin_active_for_network($slug . '/' . $slug . '.php');
}

/**
 * Display plugin recommendation notice
 */
function neartrips_plugin_recommendation_notice() {
    $screen = get_current_screen();
    
    // Only show on theme pages or plugins page
    if ($screen->id !== 'appearance_page_neartrips-demo-import' && 
        $screen->id !== 'plugins' && 
        $screen->id !== 'themes') {
        return;
    }
    
    $recommended = neartrips_get_recommended_plugins();
    $missing_required = array();
    
    foreach ($recommended as $plugin) {
        if ($plugin['required'] && !neartrips_is_plugin_active($plugin['slug'])) {
            $missing_required[] = $plugin;
        }
    }
    
    if (!empty($missing_required)) {
        ?>
        <div class="notice notice-warning">
            <p><strong><?php _e('NearTrips Theme:', 'neartrips'); ?></strong> 
            <?php _e('The following recommended plugin is missing:', 'neartrips'); ?></p>
            <ul style="list-style: disc; margin-left: 20px;">
                <?php foreach ($missing_required as $plugin) : ?>
                    <li>
                        <strong><?php echo esc_html($plugin['name']); ?></strong> - 
                        <?php echo esc_html($plugin['description']); ?>
                        <?php if (!neartrips_is_plugin_active($plugin['slug'])) : ?>
                            <a href="<?php echo admin_url('plugin-install.php?s=' . urlencode($plugin['name']) . '&tab=search&type=term'); ?>" 
                               class="button button-primary" style="margin-left: 10px;">
                                <?php _e('Install Now', 'neartrips'); ?>
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php
    }
}
add_action('admin_notices', 'neartrips_plugin_recommendation_notice');

/**
 * Add plugins page with recommendations
 */
function neartrips_add_plugins_page() {
    add_theme_page(
        __('Required Plugins', 'neartrips'),
        __('Plugins', 'neartrips'),
        'manage_options',
        'neartrips-plugins',
        'neartrips_plugins_page'
    );
}
add_action('admin_menu', 'neartrips_add_plugins_page');

/**
 * Plugins page callback
 */
function neartrips_plugins_page() {
    $plugins = neartrips_get_recommended_plugins();
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <p><?php _e('Install these plugins to unlock all NearTrips theme features.', 'neartrips'); ?></p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(400px, 1fr)); gap: 20px; margin-top: 30px;">
            <?php foreach ($plugins as $key => $plugin) : 
                $status = neartrips_check_plugin_status($plugin['slug']);
                $active = neartrips_is_plugin_active($plugin['slug']);
            ?>
                <div class="card" style="padding: 20px;">
                    <h2 style="margin-bottom: 10px;">
                        <?php echo esc_html($plugin['name']); ?>
                        <?php if ($plugin['required']) : ?>
                            <span style="background: #dc3545; color: white; padding: 3px 8px; border-radius: 3px; font-size: 0.7rem; margin-left: 10px;">
                                <?php _e('Required', 'neartrips'); ?>
                            </span>
                        <?php endif; ?>
                        <?php if ($plugin['free']) : ?>
                            <span style="background: #28a745; color: white; padding: 3px 8px; border-radius: 3px; font-size: 0.7rem; margin-left: 5px;">
                                <?php _e('Free', 'neartrips'); ?>
                            </span>
                        <?php endif; ?>
                    </h2>
                    <p style="color: #666; margin-bottom: 15px;"><?php echo esc_html($plugin['description']); ?></p>
                    
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <?php if ($active) : ?>
                            <span style="color: #28a745; font-weight: 600;">
                                <i class="fas fa-check-circle"></i> <?php _e('Active', 'neartrips'); ?>
                            </span>
                        <?php elseif ($status === 'installed') : ?>
                            <span style="color: #ffc107; font-weight: 600;">
                                <i class="fas fa-exclamation-triangle"></i> <?php _e('Installed but Inactive', 'neartrips'); ?>
                            </span>
                            <a href="<?php echo wp_nonce_url(admin_url('plugins.php?action=activate&plugin=' . $plugin['slug'] . '/' . $plugin['slug'] . '.php'), 'activate-plugin_' . $plugin['slug'] . '/' . $plugin['slug'] . '.php'); ?>" 
                               class="button button-primary">
                                <?php _e('Activate', 'neartrips'); ?>
                            </a>
                        <?php else : ?>
                            <a href="<?php echo admin_url('plugin-install.php?s=' . urlencode($plugin['name']) . '&tab=search&type=term'); ?>" 
                               class="button button-primary">
                                <i class="fas fa-download"></i> <?php _e('Install & Activate', 'neartrips'); ?>
                            </a>
                        <?php endif; ?>
                        
                        <a href="<?php echo esc_url($plugin['url']); ?>" target="_blank" style="color: #0066cc; text-decoration: none;">
                            <?php _e('More Info', 'neartrips'); ?> ↗
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="card" style="margin-top: 30px; padding: 20px; background: #f0f8ff;">
            <h2><?php _e('Quick Installation Guide', 'neartrips'); ?></h2>
            <ol style="line-height: 2;">
                <li><?php _e('Click "Install & Activate" for WP Travel Engine (Required)', 'neartrips'); ?></li>
                <li><?php _e('Install WooCommerce for payment processing (Recommended)', 'neartrips'); ?></li>
                <li><?php _e('Install Elementor for easy page customization (Optional)', 'neartrips'); ?></li>
                <li><?php _e('Go to Appearance → Import Demo to add sample content', 'neartrips'); ?></li>
            </ol>
        </div>
    </div>
    <?php
}

/**
 * TGMPA-like functionality for plugin installation
 */
function neartrips_register_required_plugins() {
    $plugins = array(
        array(
            'name' => 'WP Travel Engine',
            'slug' => 'wp-travel-engine',
            'required' => true,
        ),
        array(
            'name' => 'WooCommerce',
            'slug' => 'woocommerce',
            'required' => false,
        ),
        array(
            'name' => 'Elementor',
            'slug' => 'elementor',
            'required' => false,
        ),
    );
    
    // This would typically use TGMPA library
    // For now, we handle it through the admin page
}
