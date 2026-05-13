<?php
/**
 * NearTrips Theme Functions
 * 
 * @package NearTrips
 * @version 2.0.0
 */

if (!defined('ABSPATH')) exit;

// Define theme constants
define('NEARTRIPS_VERSION', '2.0.0');
define('NEARTRIPS_DIR', get_template_directory());
define('NEARTRIPS_URI', get_template_directory_uri());

/**
 * Setup theme features
 */
function neartrips_setup() {
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');
    
    // Let WordPress manage the document title
    add_theme_support('title-tag');
    
    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1920, 1080, true);
    add_image_size('neartrips-tour', 600, 400, true);
    add_image_size('neartrips-destination', 500, 600, true);
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'neartrips'),
        'footer' => __('Footer Menu', 'neartrips'),
    ));
    
    // Switch default core markup for various elements to HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    
    // Add support for custom logo
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 300,
        'flex-height' => true,
        'flex-width' => true,
    ));
    
    // Add support for custom background
    add_theme_support('custom-background');
    
    // Add support for Elementor
    add_theme_support('elementor');
    
    // Add support for WooCommerce
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Load text domain
    load_theme_textdomain('neartrips', NEARTRIPS_DIR . '/languages');
}
add_action('after_setup_theme', 'neartrips_setup');

/**
 * Enqueue scripts and styles
 */
function neartrips_scripts() {
    // Google Fonts
    wp_enqueue_style('neartrips-google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap', array(), null);
    
    // Font Awesome
    wp_enqueue_style('neartrips-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    
    // Main stylesheet
    wp_enqueue_style('neartrips-style', get_stylesheet_uri(), array(), NEARTRIPS_VERSION);
    
    // jQuery
    wp_enqueue_script('jquery');
    
    // Main JS
    wp_enqueue_script('neartrips-main', NEARTRIPS_URI . '/js/main.js', array('jquery'), NEARTRIPS_VERSION, true);
    
    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'neartrips_scripts');

/**
 * Register widget areas
 */
function neartrips_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'neartrips'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'neartrips'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer 1', 'neartrips'),
        'id' => 'footer-1',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer 2', 'neartrips'),
        'id' => 'footer-2',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer 3', 'neartrips'),
        'id' => 'footer-3',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'neartrips_widgets_init');

/**
 * Include required files
 */
require_once NEARTRIPS_DIR . '/includes/demo-importer.php';
require_once NEARTRIPS_DIR . '/includes/plugin-recommendations.php';
require_once NEARTRIPS_DIR . '/includes/elementor-support.php';
require_once NEARTRIPS_DIR . '/includes/woocommerce-support.php';
require_once NEARTRIPS_DIR . '/includes/wte-integration.php';

/**
 * Custom template tags
 */
require_once NEARTRIPS_DIR . '/inc/template-tags.php';

/**
 * Customizer additions
 */
require_once NEARTRIPS_DIR . '/inc/customizer.php';

/**
 * Check if WP Travel Engine is active
 */
function neartrips_is_wte_active() {
    return class_exists('WPTrip_Summary') || class_exists('Wp_Travel_Engine');
}

/**
 * Get tour post type
 */
function neartrips_get_tour_post_type() {
    return neartrips_is_wte_active() ? 'trip' : 'tour_package';
}

/**
 * Add custom admin menu for demo import
 */
function neartrips_add_demo_import_menu() {
    add_theme_page(
        __('Import Demo Content', 'neartrips'),
        __('Import Demo', 'neartrips'),
        'manage_options',
        'neartrips-demo-import',
        'neartrips_demo_import_page'
    );
}
add_action('admin_menu', 'neartrips_add_demo_import_menu');

/**
 * Demo import page callback
 */
function neartrips_demo_import_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
        <div class="notice notice-info">
            <p><?php _e('This will import 10 tours, 10 destinations, and essential pages for NearTrips theme.', 'neartrips'); ?></p>
        </div>
        
        <?php if (neartrips_is_wte_active()) : ?>
            <div class="card" style="max-width: 600px; padding: 20px;">
                <h2><?php _e('Ready to Import!', 'neartrips'); ?></h2>
                <p><?php _e('WP Travel Engine is active. Click the button below to import demo content.', 'neartrips'); ?></p>
                <form method="post" action="">
                    <?php wp_nonce_field('neartrips_import_demo', 'neartrips_demo_nonce'); ?>
                    <input type="submit" name="import_demo" class="button button-primary button-hero" value="<?php _e('🚀 Import Demo Content Now', 'neartrips'); ?>">
                </form>
                
                <?php
                if (isset($_POST['import_demo']) && check_admin_referer('neartrips_import_demo', 'neartrips_demo_nonce')) {
                    $result = neartrips_import_demo_content();
                    echo '<div class="notice notice-success"><p>' . esc_html($result) . '</p></div>';
                }
                ?>
            </div>
        <?php else : ?>
            <div class="card" style="max-width: 600px; padding: 20px;">
                <h2><?php _e('Required Plugin Missing', 'neartrips'); ?></h2>
                <p><?php _e('Please install and activate WP Travel Engine plugin first.', 'neartrips'); ?></p>
                <a href="<?php echo admin_url('plugin-install.php?s=wp+travel+engine&tab=search&type=term'); ?>" class="button button-primary">
                    <?php _e('Install WP Travel Engine', 'neartrips'); ?>
                </a>
            </div>
        <?php endif; ?>
        
        <div class="card" style="max-width: 600px; margin-top: 20px; padding: 20px;">
            <h2><?php _e('What Will Be Imported?', 'neartrips'); ?></h2>
            <ul style="list-style: disc; margin-left: 20px;">
                <li><?php _e('10 Tour Packages with images, prices, and descriptions', 'neartrips'); ?></li>
                <li><?php _e('10 Destinations with featured images', 'neartrips'); ?></li>
                <li><?php _e('Essential Pages (About, Contact, FAQ)', 'neartrips'); ?></li>
                <li><?php _e('Primary Navigation Menu', 'neartrips'); ?></li>
            </ul>
        </div>
    </div>
    <?php
}

/**
 * Create essential pages
 */
function neartrips_create_essential_pages() {
    $pages = array(
        array(
            'title' => __('About Us', 'neartrips'),
            'slug' => 'about-us',
            'content' => __('Welcome to NearTrips! We are your trusted travel companion, offering unforgettable experiences around the globe. Our mission is to make travel accessible, enjoyable, and memorable for everyone.', 'neartrips'),
        ),
        array(
            'title' => __('Contact', 'neartrips'),
            'slug' => 'contact',
            'content' => __('Get in touch with us! We\'d love to hear from you. Email: info@neartrips.com | Phone: +1 234 567 890', 'neartrips'),
        ),
        array(
            'title' => __('FAQ', 'neartrips'),
            'slug' => 'faq',
            'content' => __('Frequently Asked Questions about our tours, booking process, cancellations, and more.', 'neartrips'),
        ),
    );
    
    $created_pages = array();
    
    foreach ($pages as $page) {
        if (!get_page_by_path($page['slug'])) {
            $page_id = wp_insert_post(array(
                'post_title' => $page['title'],
                'post_content' => $page['content'],
                'post_name' => $page['slug'],
                'post_status' => 'publish',
                'post_type' => 'page',
            ));
            
            if ($page_id && !is_wp_error($page_id)) {
                $created_pages[] = $page_id;
            }
        }
    }
    
    return $created_pages;
}
