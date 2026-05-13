<?php
/**
 * Demo Content Importer for NearTrips Theme
 * Imports 10 Tours, 10 Destinations, and Essential Pages
 * 
 * @package NearTrips
 * @version 2.0.0
 */

if (!defined('ABSPATH')) exit;

/**
 * Main demo import function
 */
function neartrips_import_demo_content() {
    // Verify nonce
    if (!isset($_POST['neartrips_demo_nonce']) || !wp_verify_nonce($_POST['neartrips_demo_nonce'], 'neartrips_import_demo')) {
        return __('Security check failed!', 'neartrips');
    }
    
    // Check permissions
    if (!current_user_can('manage_options')) {
        return __('You do not have permission to import content.', 'neartrips');
    }
    
    $imported = array(
        'tours' => 0,
        'destinations' => 0,
        'pages' => 0,
        'menu' => false,
    );
    
    // Determine post type based on active plugins
    $tour_post_type = neartrips_is_wte_active() ? 'trip' : 'tour_package';
    $destination_taxonomy = neartrips_is_wte_active() ? 'wpte-destination' : 'destination';
    
    // Import Tours (10 packages)
    $tours_data = neartrips_get_demo_tours();
    foreach ($tours_data as $tour) {
        if (!get_page_by_path($tour['slug'], OBJECT, $tour_post_type)) {
            $tour_id = neartrips_create_tour($tour, $tour_post_type);
            if ($tour_id && !is_wp_error($tour_id)) {
                $imported['tours']++;
            }
        }
    }
    
    // Import Destinations (10 destinations)
    $destinations_data = neartrips_get_demo_destinations();
    foreach ($destinations_data as $destination) {
        if (!term_exists($destination['slug'], $destination_taxonomy)) {
            $dest_id = neartrips_create_destination($destination, $destination_taxonomy);
            if ($dest_id && !is_wp_error($dest_id)) {
                $imported['destinations']++;
            }
        }
    }
    
    // Create essential pages
    $pages_created = neartrips_create_essential_pages();
    $imported['pages'] = count($pages_created);
    
    // Setup menu
    if (neartrips_setup_menu($pages_created)) {
        $imported['menu'] = true;
    }
    
    // Set homepage
    $home_page = get_page_by_path('home');
    if (!$home_page) {
        $home_page_id = wp_insert_post(array(
            'post_title' => __('Home', 'neartrips'),
            'post_name' => 'home',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_content' => '[neartrips_home]',
        ));
        
        if ($home_page_id && !is_wp_error($home_page_id)) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $home_page_id);
        }
    }
    
    // Return summary
    $message = sprintf(
        __('✅ Demo content imported successfully!<br><br>
        🌍 Tours: %d<br>
        🏝️ Destinations: %d<br>
        📄 Pages: %d<br>
        📋 Menu: %s<br><br>
        <strong>Next Steps:</strong><br>
        1. Go to Settings → Reading and set "Home" as your homepage<br>
        2. Visit your site to see the demo content!<br>
        3. Customize tours and destinations as needed.', 'neartrips'),
        $imported['tours'],
        $imported['destinations'],
        $imported['pages'],
        $imported['menu'] ? __('Created', 'neartrips') : __('Already exists', 'neartrips')
    );
    
    return $message;
}

/**
 * Create a tour/trip
 */
function neartrips_create_tour($tour_data, $post_type) {
    $post_id = wp_insert_post(array(
        'post_title' => $tour_data['title'],
        'post_content' => $tour_data['content'],
        'post_name' => $tour_data['slug'],
        'post_status' => 'publish',
        'post_type' => $post_type,
    ));
    
    if ($post_id && !is_wp_error($post_id)) {
        // Set featured image from URL
        if (!empty($tour_data['image'])) {
            neartrips_set_featured_image_from_url($post_id, $tour_data['image']);
        }
        
        // Add meta data for WP Travel Engine
        if ($post_type === 'trip' && !empty($tour_data['meta'])) {
            foreach ($tour_data['meta'] as $key => $value) {
                update_post_meta($post_id, $key, $value);
            }
        }
        
        // Assign destination taxonomy if exists
        if (!empty($tour_data['destination'])) {
            $taxonomy = neartrips_is_wte_active() ? 'wpte-destination' : 'destination';
            if (term_exists($tour_data['destination'], $taxonomy)) {
                wp_set_object_terms($post_id, $tour_data['destination'], $taxonomy);
            }
        }
    }
    
    return $post_id;
}

/**
 * Create destination
 */
function neartrips_create_destination($destination_data, $taxonomy) {
    $term = wp_insert_term($destination_data['name'], $taxonomy, array(
        'slug' => $destination_data['slug'],
        'description' => $destination_data['description'],
    ));
    
    if (!is_wp_error($term) && !empty($term['term_id'])) {
        // Set featured image for destination if WTE is active
        if (neartrips_is_wte_active() && !empty($destination_data['image'])) {
            $image_id = neartrips_upload_image_from_url($destination_data['image'], $destination_data['name']);
            if ($image_id) {
                update_term_meta($term['term_id'], 'destination_thumbnail_id', $image_id);
            }
        }
    }
    
    return $term;
}

/**
 * Setup navigation menu
 */
function neartrips_setup_menu($pages) {
    $menu_name = 'Primary Menu';
    $location = 'primary';
    
    // Get existing menu or create new one
    $menus = wp_get_nav_menus();
    $menu_id = null;
    
    foreach ($menus as $menu) {
        if ($menu->name === $menu_name) {
            $menu_id = $menu->term_id;
            break;
        }
    }
    
    if (!$menu_id) {
        $menu_id = wp_create_nav_menu($menu_name);
        if (is_wp_error($menu_id)) {
            return false;
        }
    }
    
    // Add menu items
    $menu_items = array(
        array('title' => __('Home', 'neartrips'), 'url' => home_url('/')),
        array('title' => __('About Us', 'neartrips'), 'url' => home_url('/about-us')),
        array('title' => __('Tours', 'neartrips'), 'url' => home_url('/' . neartrips_get_tour_post_type())),
        array('title' => __('Destinations', 'neartrips'), 'url' => neartrips_is_wte_active() ? home_url('/wpte-destination') : home_url('/destination')),
        array('title' => __('Contact', 'neartrips'), 'url' => home_url('/contact')),
    );
    
    foreach ($menu_items as $item) {
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => $item['title'],
            'menu-item-url' => $item['url'],
            'menu-item-status' => 'publish',
        ));
    }
    
    // Assign menu to location
    $locations = get_theme_mod('nav_menu_locations');
    $locations[$location] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
    
    return true;
}

/**
 * Upload image from URL
 */
function neartrips_upload_image_from_url($image_url, $filename = null) {
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    
    if (!$image_data) {
        return false;
    }
    
    if (!$filename) {
        $filename = basename($image_url);
    }
    
    $file_path = $upload_dir['path'] . '/' . $filename;
    file_put_contents($file_path, $image_data);
    
    $file_array = array(
        'name' => $filename,
        'tmp_name' => $file_path,
    );
    
    $attachment_id = media_handle_sideload($file_array, 0);
    
    if (is_wp_error($attachment_id)) {
        @unlink($file_path);
        return false;
    }
    
    return $attachment_id;
}

/**
 * Set featured image from URL
 */
function neartrips_set_featured_image_from_url($post_id, $image_url) {
    $attachment_id = neartrips_upload_image_from_url($image_url);
    if ($attachment_id) {
        set_post_thumbnail($post_id, $attachment_id);
        return true;
    }
    return false;
}

/**
 * Get demo tours data (10 tours)
 */
function neartrips_get_demo_tours() {
    return array(
        array(
            'title' => __('Paris Romantic Getaway', 'neartrips'),
            'slug' => 'paris-romantic-getaway',
            'content' => __('Experience the city of love with our romantic Paris package. Visit Eiffel Tower, Louvre Museum, Seine River cruise, and enjoy French cuisine in charming cafes.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=800',
            'destination' => 'paris',
            'meta' => array(
                'wpte_duration' => '5 days',
                'wpte_price' => '1299',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('Tokyo Adventure', 'neartrips'),
            'slug' => 'tokyo-adventure',
            'content' => __('Discover modern and traditional Japan in Tokyo. Visit ancient temples, experience bullet train, explore Shibuya crossing, and enjoy authentic sushi.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=800',
            'destination' => 'tokyo',
            'meta' => array(
                'wpte_duration' => '7 days',
                'wpte_price' => '1899',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('New York City Explorer', 'neartrips'),
            'slug' => 'new-york-city-explorer',
            'content' => __('The ultimate NYC experience! Statue of Liberty, Times Square, Central Park, Broadway show, and world-class museums await you.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1496442226666-8d4a0e62e6e9?w=800',
            'destination' => 'new-york',
            'meta' => array(
                'wpte_duration' => '4 days',
                'wpte_price' => '999',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('Bali Paradise Retreat', 'neartrips'),
            'slug' => 'bali-paradise-retreat',
            'content' => __('Relax in tropical Bali with pristine beaches, ancient temples, rice terraces, and luxurious spa treatments. Perfect for honeymooners and families.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800',
            'destination' => 'bali',
            'meta' => array(
                'wpte_duration' => '6 days',
                'wpte_price' => '799',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('Rome Historical Tour', 'neartrips'),
            'slug' => 'rome-historical-tour',
            'content' => __('Walk through ancient history in Rome. Colosseum, Vatican Museums, Roman Forum, Trevi Fountain, and authentic Italian pasta experiences.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=800',
            'destination' => 'rome',
            'meta' => array(
                'wpte_duration' => '5 days',
                'wpte_price' => '1199',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('Dubai Luxury Experience', 'neartrips'),
            'slug' => 'dubai-luxury-experience',
            'content' => __('Experience luxury in Dubai. Burj Khalifa, desert safari, Palm Jumeirah, gold souk, and world-class shopping malls.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1512453979798-5ea904ac22ac?w=800',
            'destination' => 'dubai',
            'meta' => array(
                'wpte_duration' => '4 days',
                'wpte_price' => '1599',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('Santorini Sunset Escape', 'neartrips'),
            'slug' => 'santorini-sunset-escape',
            'content' => __('Witness breathtaking sunsets in Santorini. White-washed buildings, blue domes, volcanic beaches, wine tasting, and Greek cuisine.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?w=800',
            'destination' => 'santorini',
            'meta' => array(
                'wpte_duration' => '5 days',
                'wpte_price' => '1399',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('Swiss Alps Adventure', 'neartrips'),
            'slug' => 'swiss-alps-adventure',
            'content' => __('Adventure in the Swiss Alps! Skiing, hiking, scenic train rides, chocolate tasting, and picturesque mountain villages.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=800',
            'destination' => 'switzerland',
            'meta' => array(
                'wpte_duration' => '6 days',
                'wpte_price' => '1799',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('Maldives Beach Resort', 'neartrips'),
            'slug' => 'maldives-beach-resort',
            'content' => __('Ultimate beach paradise in Maldives. Overwater bungalows, crystal clear waters, snorkeling, diving, and complete relaxation.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=800',
            'destination' => 'maldives',
            'meta' => array(
                'wpte_duration' => '7 days',
                'wpte_price' => '2499',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('Iceland Northern Lights', 'neartrips'),
            'slug' => 'iceland-northern-lights',
            'content' => __('Chase the Northern Lights in Iceland! Geysers, glaciers, waterfalls, black sand beaches, and unique Viking culture.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=800',
            'destination' => 'iceland',
            'meta' => array(
                'wpte_duration' => '6 days',
                'wpte_price' => '1999',
                'wpte_availability' => 'Available',
            ),
        ),
    );
}

/**
 * Get demo destinations data (10 destinations)
 */
function neartrips_get_demo_destinations() {
    return array(
        array(
            'name' => __('Paris', 'neartrips'),
            'slug' => 'paris',
            'description' => __('The City of Light, romance, and art.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=800',
        ),
        array(
            'name' => __('Tokyo', 'neartrips'),
            'slug' => 'tokyo',
            'description' => __('Where tradition meets innovation in Japan.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=800',
        ),
        array(
            'name' => __('New York', 'neartrips'),
            'slug' => 'new-york',
            'description' => __('The city that never sleeps.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1496442226666-8d4a0e62e6e9?w=800',
        ),
        array(
            'name' => __('Bali', 'neartrips'),
            'slug' => 'bali',
            'description' => __('Tropical paradise in Indonesia.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800',
        ),
        array(
            'name' => __('Rome', 'neartrips'),
            'slug' => 'rome',
            'description' => __('The Eternal City of ancient wonders.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1552832230-c0197dd311b5?w=800',
        ),
        array(
            'name' => __('Dubai', 'neartrips'),
            'slug' => 'dubai',
            'description' => __('Luxury and innovation in the desert.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1512453979798-5ea904ac22ac?w=800',
        ),
        array(
            'name' => __('Santorini', 'neartrips'),
            'slug' => 'santorini',
            'description' => __('Greek island paradise with stunning sunsets.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1570077188670-e3a8d69ac5ff?w=800',
        ),
        array(
            'name' => __('Switzerland', 'neartrips'),
            'slug' => 'switzerland',
            'description' => __('Alpine beauty and precision.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=800',
        ),
        array(
            'name' => __('Maldives', 'neartrips'),
            'slug' => 'maldives',
            'description' => __('Ultimate tropical beach destination.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?w=800',
        ),
        array(
            'name' => __('Iceland', 'neartrips'),
            'slug' => 'iceland',
            'description' => __('Land of fire, ice, and Northern Lights.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1476610182048-b716b8518aae?w=800',
        ),
    );
}
