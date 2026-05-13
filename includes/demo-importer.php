<?php
/**
 * Travelio Demo Content Importer
 * 
 * This file creates a simple demo importer that populates the site with sample tours,
 * destinations, and pages when WP Travel Engine is active.
 * 
 * Usage: Visit /wp-admin/admin.php?page=travelio-demo-import
 */

if (!defined('ABSPATH')) {
    exit;
}

class Travelio_Demo_Importer {
    
    private $sample_tours = array();
    private $sample_destinations = array();
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_page'));
        add_action('admin_post_travelio_import_demo', array($this, 'handle_import'));
        
        $this->setup_sample_data();
    }
    
    private function setup_sample_data() {
        // Sample Destinations
        $this->sample_destinations = array(
            array(
                'title' => 'Paris',
                'slug' => 'paris',
                'description' => 'The City of Light awaits you with its iconic landmarks, world-class museums, and romantic atmosphere.',
                'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=800&q=80'
            ),
            array(
                'title' => 'Tokyo',
                'slug' => 'tokyo',
                'description' => 'Experience the perfect blend of traditional culture and cutting-edge technology in Japan\'s vibrant capital.',
                'image' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=800&q=80'
            ),
            array(
                'title' => 'New York',
                'slug' => 'new-york',
                'description' => 'The city that never sleeps offers endless entertainment, dining, and cultural experiences.',
                'image' => 'https://images.unsplash.com/photo-1496442226666-8d4a0e62e6e9?w=800&q=80'
            ),
            array(
                'title' => 'Bali',
                'slug' => 'bali',
                'description' => 'Tropical paradise with stunning beaches, ancient temples, and lush rice terraces.',
                'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800&q=80'
            ),
            array(
                'title' => 'Rome',
                'slug' => 'rome',
                'description' => 'Walk through history in the Eternal City with its ancient ruins and Renaissance art.',
                'image' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=800&q=80'
            ),
            array(
                'title' => 'Dubai',
                'slug' => 'dubai',
                'description' => 'A futuristic metropolis in the desert offering luxury shopping and ultramodern architecture.',
                'image' => 'https://images.unsplash.com/photo-1512453979798-5ea904ac6605?w=800&q=80'
            )
        );
        
        // Sample Tours
        $this->sample_tours = array(
            array(
                'title' => 'Paris Romantic Getaway',
                'slug' => 'paris-romantic-getaway',
                'destination' => 'paris',
                'duration' => '5 Days',
                'price' => 1299,
                'sale_price' => 999,
                'rating' => 4.9,
                'reviews' => 127,
                'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=800&q=80',
                    'https://images.unsplash.com/photo-1520939817895-060bdaf4de1e?w=800&q=80',
                    'https://images.unsplash.com/photo-1509248961158-e54f6934749c?w=800&q=80'
                ),
                'description' => 'Experience the romance of Paris with this carefully curated 5-day tour. Visit the Eiffel Tower, cruise along the Seine, explore the Louvre Museum, and enjoy authentic French cuisine in charming bistros.',
                'highlights' => array(
                    'Skip-the-line access to Eiffel Tower',
                    'Seine River sunset cruise with champagne',
                    'Guided tour of Louvre Museum',
                    'Traditional French cooking class',
                    'Visit to Palace of Versailles'
                ),
                'includes' => array(
                    '4 nights accommodation in 4-star hotel',
                    'Daily breakfast',
                    'Airport transfers',
                    'Professional English-speaking guide',
                    'All entrance fees'
                ),
                'difficulty' => 'Easy',
                'category' => 'Romantic'
            ),
            array(
                'title' => 'Tokyo Adventure Explorer',
                'slug' => 'tokyo-adventure-explorer',
                'destination' => 'tokyo',
                'duration' => '7 Days',
                'price' => 1899,
                'sale_price' => 1599,
                'rating' => 4.8,
                'reviews' => 94,
                'image' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1542051841857-5f90071e7989?w=800&q=80',
                    'https://images.unsplash.com/photo-1536098561742-ca998e48cbcc?w=800&q=80',
                    'https://images.unsplash.com/photo-1528164344705-47542687000d?w=800&q=80'
                ),
                'description' => 'Discover the wonders of Tokyo from ancient temples to modern skyscrapers. Experience traditional tea ceremonies, explore bustling markets, and witness the famous cherry blossoms.',
                'highlights' => array(
                    'Visit Senso-ji Temple in Asakusa',
                    'Traditional tea ceremony experience',
                    'Shibuya Crossing and Meiji Shrine',
                    'Day trip to Mount Fuji',
                    'Tsukiji Fish Market food tour'
                ),
                'includes' => array(
                    '6 nights accommodation in ryokan and hotel',
                    'All meals included',
                    'JR Pass for unlimited train travel',
                    'English-speaking guide',
                    'Cultural activities and workshops'
                ),
                'difficulty' => 'Moderate',
                'category' => 'Adventure'
            ),
            array(
                'title' => 'New York City Highlights',
                'slug' => 'nyc-highlights',
                'destination' => 'new-york',
                'duration' => '4 Days',
                'price' => 899,
                'sale_price' => 749,
                'rating' => 4.7,
                'reviews' => 203,
                'image' => 'https://images.unsplash.com/photo-1496442226666-8d4a0e62e6e9?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1534438097545-a2c22c57f01b?w=800&q=80',
                    'https://images.unsplash.com/photo-1497366811353-6870744d04b2?w=800&q=80',
                    'https://images.unsplash.com/photo-1518391846015-55a9cc003b25?w=800&q=80'
                ),
                'description' => 'Explore the Big Apple with our comprehensive city tour. From Central Park to Times Square, Statue of Liberty to Broadway shows, experience everything NYC has to offer.',
                'highlights' => array(
                    'Statue of Liberty and Ellis Island ferry',
                    'Central Park bike tour',
                    'Metropolitan Museum of Art',
                    'Broadway show tickets included',
                    'Empire State Building observation deck'
                ),
                'includes' => array(
                    '3 nights in Midtown Manhattan hotel',
                    'Daily continental breakfast',
                    'CityPASS attraction tickets',
                    'Hop-on hop-off bus tour pass',
                    'Welcome dinner cruise'
                ),
                'difficulty' => 'Easy',
                'category' => 'City Tour'
            ),
            array(
                'title' => 'Bali Beach & Culture',
                'slug' => 'bali-beach-culture',
                'destination' => 'bali',
                'duration' => '6 Days',
                'price' => 1199,
                'sale_price' => 899,
                'rating' => 4.9,
                'reviews' => 156,
                'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=800&q=80',
                    'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=800&q=80',
                    'https://images.unsplash.com/photo-1538485399081-7191377e8241?w=800&q=80'
                ),
                'description' => 'Relax on pristine beaches while immersing yourself in Balinese culture. Visit ancient temples, watch traditional dances, and rejuvenate with spa treatments.',
                'highlights' => array(
                    'Sunrise at Borobudur Temple',
                    'Traditional Kecak dance performance',
                    'Ubud Monkey Forest and rice terraces',
                    'Snorkeling in Nusa Penida',
                    'Balinese massage and spa day'
                ),
                'includes' => array(
                    '5 nights in beachfront resort',
                    'Daily breakfast and 2 dinners',
                    'Private airport transfers',
                    'Temple entrance fees',
                    'Spa treatment voucher'
                ),
                'difficulty' => 'Easy',
                'category' => 'Beach & Relaxation'
            ),
            array(
                'title' => 'Ancient Rome Discovery',
                'slug' => 'ancient-rome-discovery',
                'destination' => 'rome',
                'duration' => '5 Days',
                'price' => 1399,
                'sale_price' => 1149,
                'rating' => 4.8,
                'reviews' => 89,
                'image' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1555992336-b8b5c6b7e9b9?w=800&q=80',
                    'https://images.unsplash.com/photo-1515542706656-8e6ef1763e3b?w=800&q=80',
                    'https://images.unsplash.com/photo-1513829596327-2bb8fcc59851?w=800&q=80'
                ),
                'description' => 'Step back in time and explore the glory of Ancient Rome. Visit the Colosseum, Roman Forum, Vatican City, and toss a coin in the Trevi Fountain.',
                'highlights' => array(
                    'Skip-the-line Colosseum and Forum tour',
                    'Vatican Museums and Sistine Chapel',
                    'St. Peter\'s Basilica guided visit',
                    'Trevi Fountain and Spanish Steps',
                    'Authentic Roman food tour in Trastevere'
                ),
                'includes' => array(
                    '4 nights in historic center hotel',
                    'Daily Italian breakfast',
                    'All museum and attraction entries',
                    'Professional archaeologist guide',
                    'Traditional pizza-making class'
                ),
                'difficulty' => 'Moderate',
                'category' => 'Historical'
            ),
            array(
                'title' => 'Dubai Luxury Experience',
                'slug' => 'dubai-luxury-experience',
                'destination' => 'dubai',
                'duration' => '4 Days',
                'price' => 1699,
                'sale_price' => 1399,
                'rating' => 4.9,
                'reviews' => 112,
                'image' => 'https://images.unsplash.com/photo-1512453979798-5ea904ac6605?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1582672060674-bc2bd808a8b5?w=800&q=80',
                    'https://images.unsplash.com/photo-1597659840241-37e2b9c2f55f?w=800&q=80',
                    'https://images.unsplash.com/photo-1546412414-e1885259563a?w=800&q=80'
                ),
                'description' => 'Indulge in ultimate luxury in Dubai. Stay in 5-star hotels, dine at Michelin-starred restaurants, and experience thrilling desert safaris.',
                'highlights' => array(
                    'Burj Khalifa At The Top experience',
                    'Private desert safari with BBQ dinner',
                    'Dubai Mall and Fountain show',
                    'Luxury yacht cruise in Dubai Marina',
                    'Gold and Spice Souk guided tour'
                ),
                'includes' => array(
                    '3 nights in 5-star luxury hotel',
                    'Daily gourmet breakfast',
                    'VIP airport fast-track service',
                    'Desert safari with premium seating',
                    'Yacht cruise with refreshments'
                ),
                'difficulty' => 'Easy',
                'category' => 'Luxury'
            )
        );
    }
    
    public function add_admin_page() {
        add_submenu_page(
            'themes.php',
            'Import Demo',
            'Import Demo Content',
            'manage_options',
            'travelio-demo-import',
            array($this, 'render_admin_page')
        );
    }
    
    public function render_admin_page() {
        if (isset($_GET['imported'])) {
            $imported = json_decode(stripslashes($_GET['imported']), true);
            echo '<div class="notice notice-success"><p><strong>Demo content imported successfully!</strong></p>';
            echo '<p>Tours: ' . intval($imported['tours']) . ' | Destinations: ' . intval($imported['destinations']) . ' | Pages: ' . intval($imported['pages']) . '</p>';
            echo '<p><a href="' . home_url() . '" target="_blank" class="button button-primary">View Your Site</a></p></div>';
        }
        ?>
        <div class="wrap">
            <h1>Travelio Demo Content Importer</h1>
            <div style="max-width: 800px; margin-top: 20px;">
                <div class="notice notice-info" style="padding: 20px;">
                    <h2>Populate Your Site with Demo Content</h2>
                    <p>This tool will create sample tours, destinations, and pages to help you visualize your travel website.</p>
                    
                    <h3>What will be imported:</h3>
                    <ul style="list-style: disc; margin-left: 20px;">
                        <li><strong>6 Sample Tours</strong> - Complete with images, descriptions, pricing, and itineraries</li>
                        <li><strong>6 Destinations</strong> - Popular travel destinations with descriptions</li>
                        <li><strong>Essential Pages</strong> - Home, About Us, Contact, FAQ</li>
                        <li><strong>Menu Setup</strong> - Navigation menu configured automatically</li>
                    </ul>
                    
                    <p><strong>Note:</strong> This requires <em>WP Travel Engine</em> plugin to be installed and activated.</p>
                    
                    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" style="margin-top: 20px;">
                        <?php wp_nonce_field('travelio_import_demo', 'travelio_demo_nonce'); ?>
                        <input type="hidden" name="action" value="travelio_import_demo">
                        <button type="submit" class="button button-primary button-hero" onclick="return confirm('This will create demo content. Continue?');">
                            🚀 Import Demo Content Now
                        </button>
                    </form>
                    
                    <p style="margin-top: 15px; font-size: 12px; color: #666;">
                        ⚠️ Warning: This will create new content. Existing content with the same slugs may be skipped.
                    </p>
                </div>
                
                <div style="margin-top: 30px;">
                    <h3>Sample Tours Preview:</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                        <?php foreach ($this->sample_tours as $tour): ?>
                            <div style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #fff;">
                                <img src="<?php echo esc_url($tour['image']); ?>" alt="<?php echo esc_attr($tour['title']); ?>" style="width: 100%; height: 120px; object-fit: cover;">
                                <div style="padding: 10px;">
                                    <h4 style="margin: 0 0 5px 0; font-size: 14px;"><?php echo esc_html($tour['title']); ?></h4>
                                    <p style="margin: 0; font-size: 12px; color: #666;">
                                        <?php echo esc_html($tour['duration']); ?> • $<?php echo esc_html($tour['sale_price']); ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    public function handle_import() {
        // Verify nonce
        if (!isset($_POST['travelio_demo_nonce']) || !wp_verify_nonce($_POST['travelio_demo_nonce'], 'travelio_import_demo')) {
            wp_die('Security check failed');
        }
        
        // Check permissions
        if (!current_user_can('manage_options')) {
            wp_die('Insufficient permissions');
        }
        
        $imported = array(
            'tours' => 0,
            'destinations' => 0,
            'pages' => 0
        );
        
        // Check if WP Travel Engine is active
        $wte_active = class_exists('WPTrip_Summary');
        
        // Import Destinations
        if (post_type_exists('destination')) {
            $imported['destinations'] = $this->import_destinations();
        }
        
        // Import Tours
        if ($wte_active && post_type_exists('trip')) {
            $imported['tours'] = $this->import_tours_wte();
        } elseif (post_type_exists('tour_package')) {
            $imported['tours'] = $this->import_tours_custom();
        }
        
        // Import Pages
        $imported['pages'] = $this->import_pages();
        
        // Set up menu
        $this->setup_menu();
        
        // Redirect back with success message
        wp_redirect(admin_url('themes.php?page=travelio-demo-import&imported=' . json_encode($imported)));
        exit;
    }
    
    private function import_destinations() {
        $count = 0;
        
        foreach ($this->sample_destinations as $dest) {
            // Check if already exists
            $exists = get_page_by_path($dest['slug'], OBJECT, 'destination');
            if ($exists) {
                continue;
            }
            
            $post_id = wp_insert_post(array(
                'post_title' => $dest['title'],
                'post_name' => $dest['slug'],
                'post_content' => $dest['description'],
                'post_status' => 'publish',
                'post_type' => 'destination'
            ));
            
            if ($post_id && !is_wp_error($post_id)) {
                // Set featured image
                $this->set_featured_image($post_id, $dest['image']);
                $count++;
            }
        }
        
        return $count;
    }
    
    private function import_tours_wte() {
        $count = 0;
        
        foreach ($this->sample_tours as $tour) {
            // Check if already exists
            $exists = get_page_by_path($tour['slug'], OBJECT, 'trip');
            if ($exists) {
                continue;
            }
            
            $post_id = wp_insert_post(array(
                'post_title' => $tour['title'],
                'post_name' => $tour['slug'],
                'post_content' => $this->format_tour_content($tour),
                'post_status' => 'publish',
                'post_type' => 'trip'
            ));
            
            if ($post_id && !is_wp_error($post_id)) {
                // Set featured image
                $this->set_featured_image($post_id, $tour['image']);
                
                // Set WTE meta fields
                update_post_meta($post_id, 'wpte_trip_duration', $tour['duration']);
                update_post_meta($post_id, 'wpte_trip_price', $tour['sale_price']);
                update_post_meta($post_id, 'wpte_trip_original_price', $tour['price']);
                update_post_meta($post_id, 'wpte_trip_availability', 'available');
                
                // Add gallery
                if (!empty($tour['gallery'])) {
                    $gallery_ids = array();
                    foreach ($tour['gallery'] as $img_url) {
                        $img_id = $this->upload_image_from_url($img_url);
                        if ($img_id) {
                            $gallery_ids[] = $img_id;
                        }
                    }
                    if (!empty($gallery_ids)) {
                        update_post_meta($post_id, 'wpte_trip_gallery', $gallery_ids);
                    }
                }
                
                $count++;
            }
        }
        
        return $count;
    }
    
    private function import_tours_custom() {
        $count = 0;
        
        foreach ($this->sample_tours as $tour) {
            // Check if already exists
            $exists = get_page_by_path($tour['slug'], OBJECT, 'tour_package');
            if ($exists) {
                continue;
            }
            
            $post_id = wp_insert_post(array(
                'post_title' => $tour['title'],
                'post_name' => $tour['slug'],
                'post_content' => $this->format_tour_content($tour),
                'post_status' => 'publish',
                'post_type' => 'tour_package'
            ));
            
            if ($post_id && !is_wp_error($post_id)) {
                // Set featured image
                $this->set_featured_image($post_id, $tour['image']);
                
                // Set custom meta fields
                update_post_meta($post_id, '_tour_duration', $tour['duration']);
                update_post_meta($post_id, '_tour_price', $tour['sale_price']);
                update_post_meta($post_id, '_tour_original_price', $tour['price']);
                update_post_meta($post_id, '_tour_rating', $tour['rating']);
                update_post_meta($post_id, '_tour_difficulty', $tour['difficulty']);
                
                $count++;
            }
        }
        
        return $count;
    }
    
    private function import_pages() {
        $count = 0;
        $pages = array(
            array(
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => '<h1>Welcome to Travelio</h1><p>We are your trusted partner in creating unforgettable travel experiences. With years of expertise in the travel industry, we curate exceptional tours and destinations around the globe.</p><h2>Our Mission</h2><p>To inspire wanderlust and make travel accessible, sustainable, and transformative for everyone.</p><h2>Why Choose Us?</h2><ul><li>Expert local guides</li><li>Handpicked accommodations</li><li>24/7 customer support</li><li>Sustainable travel practices</li></ul>'
            ),
            array(
                'title' => 'Contact Us',
                'slug' => 'contact',
                'content' => '<h1>Get in Touch</h1><p>Have questions about our tours? We\'d love to hear from you!</p><p><strong>Email:</strong> hello@travelio.com</p><p><strong>Phone:</strong> +1 (555) 123-4567</p><p><strong>Address:</strong> 123 Travel Street, Adventure City, AC 12345</p>'
            ),
            array(
                'title' => 'FAQ',
                'slug' => 'faq',
                'content' => '<h1>Frequently Asked Questions</h1><h2>How do I book a tour?</h2><p>Simply browse our tours, select your preferred dates, and complete the booking form. You\'ll receive instant confirmation.</p><h2>What payment methods do you accept?</h2><p>We accept all major credit cards, PayPal, and bank transfers.</p><h2>Can I cancel my booking?</h2><p>Yes! Most tours offer free cancellation up to 48 hours before departure.</p>'
            )
        );
        
        foreach ($pages as $page) {
            $exists = get_page_by_path($page['slug']);
            if ($exists) {
                continue;
            }
            
            $post_id = wp_insert_post(array(
                'post_title' => $page['title'],
                'post_name' => $page['slug'],
                'post_content' => $page['content'],
                'post_status' => 'publish',
                'post_type' => 'page'
            ));
            
            if ($post_id && !is_wp_error($post_id)) {
                $count++;
            }
        }
        
        return $count;
    }
    
    private function setup_menu() {
        // Create or update primary menu
        $menu_name = 'Primary Menu';
        $location = 'primary';
        
        // Get the menu
        $menu = wp_get_nav_menu_object($menu_name);
        
        if (!$menu) {
            // Create menu
            $menu_id = wp_create_nav_menu($menu_name);
        } else {
            $menu_id = $menu->term_id;
        }
        
        // Add menu items
        $items = array(
            array('title' => 'Home', 'url' => home_url('/')),
            array('title' => 'Tours', 'url' => home_url('/trips/')),
            array('title' => 'Destinations', 'url' => home_url('/destinations/')),
            array('title' => 'About', 'url' => home_url('/about-us/')),
            array('title' => 'Contact', 'url' => home_url('/contact/'))
        );
        
        foreach ($items as $item) {
            wp_update_nav_menu_item($menu_id, 0, array(
                'menu-item-title' => $item['title'],
                'menu-item-url' => $item['url'],
                'menu-item-status' => 'publish'
            ));
        }
        
        // Assign menu to location
        $locations = get_theme_mod('nav_menu_locations');
        $locations[$location] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
    
    private function format_tour_content($tour) {
        $content = '<div class="tour-description">';
        $content .= '<p>' . esc_html($tour['description']) . '</p>';
        
        $content .= '<h3>Tour Highlights</h3><ul>';
        foreach ($tour['highlights'] as $highlight) {
            $content .= '<li>' . esc_html($highlight) . '</li>';
        }
        $content .= '</ul>';
        
        $content .= '<h3>What\'s Included</h3><ul>';
        foreach ($tour['includes'] as $include) {
            $content .= '<li>✓ ' . esc_html($include) . '</li>';
        }
        $content .= '</ul>';
        
        $content .= '<p><strong>Duration:</strong> ' . esc_html($tour['duration']) . '</p>';
        $content .= '<p><strong>Difficulty:</strong> ' . esc_html($tour['difficulty']) . '</p>';
        $content .= '<p><strong>Category:</strong> ' . esc_html($tour['category']) . '</p>';
        
        $content .= '</div>';
        
        return $content;
    }
    
    private function set_featured_image($post_id, $image_url) {
        $attachment_id = $this->upload_image_from_url($image_url);
        if ($attachment_id) {
            set_post_thumbnail($post_id, $attachment_id);
        }
    }
    
    private function upload_image_from_url($url) {
        // Check if image already exists
        $args = array(
            'post_type' => 'attachment',
            'meta_query' => array(
                array(
                    'key' => '_source_url',
                    'value' => $url,
                    'compare' => '='
                )
            )
        );
        
        $existing = get_posts($args);
        if (!empty($existing)) {
            return $existing[0]->ID;
        }
        
        // Download image
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        
        $file_array = array();
        $file_array['name'] = basename($url);
        
        $download = download_url($url);
        
        if (is_wp_error($download)) {
            return false;
        }
        
        $file_array['tmp_name'] = $download;
        
        $id = media_handle_sideload($file_array, 0);
        
        if (is_wp_error($id)) {
            @unlink($download);
            return false;
        }
        
        // Store source URL
        update_post_meta($id, '_source_url', $url);
        
        return $id;
    }
}

// Initialize importer
new Travelio_Demo_Importer();
