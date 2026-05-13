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
 * Get demo tours data (10 Morocco Desert Tours)
 */
function neartrips_get_demo_tours() {
    return array(
        array(
            'title' => __('3 Days Merzouga Desert Tour from Marrakech', 'neartrips'),
            'slug' => '3-days-merzouga-desert-tour-marrakech',
            'content' => __('Experience the magic of the Sahara Desert on this 3-day adventure from Marrakech. Cross the High Atlas Mountains, visit Ait Ben Haddou Kasbah, explore Dades Valley, and ride camels into the sunset at Erg Chebbi dunes. Spend a night in a luxury desert camp under the stars.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1539650116455-251d93d5c933?w=800',
            'destination' => 'merzouga',
            'meta' => array(
                'wpte_duration' => '3 days',
                'wpte_price' => '250',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('2 Days Zagora Desert Tour from Marrakech', 'neartrips'),
            'slug' => '2-days-zagora-desert-tour-marrakech',
            'content' => __('A perfect weekend getaway to the Zagora Desert. Travel through the Palmeraie, cross the Draa Valley with its ancient kasbahs, and experience camel trekking in the Agafay Desert. Enjoy traditional Berber music and dinner around the campfire.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1542401886-65d6c61db217?w=800',
            'destination' => 'zagora',
            'meta' => array(
                'wpte_duration' => '2 days',
                'wpte_price' => '180',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('4 Days Imperial Cities Tour: Marrakech, Fes, Meknes, Rabat', 'neartrips'),
            'slug' => '4-days-imperial-cities-tour',
            'content' => __('Discover Morocco\'s four imperial cities on this comprehensive tour. Explore the medinas of Marrakech and Fes, visit the Roman ruins of Volubilis, see the Hassan Tower in Rabat, and experience the authentic Moroccan culture and architecture.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1597212618440-806262de4f6b?w=800',
            'destination' => 'fes',
            'meta' => array(
                'wpte_duration' => '4 days',
                'wpte_price' => '350',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('Luxury 5 Days Sahara Desert Experience', 'neartrips'),
            'slug' => 'luxury-5-days-sahara-desert-experience',
            'content' => __('Indulge in the ultimate Sahara experience with luxury accommodations. Visit Ouarzazate (Hollywood of Africa), explore Todra Gorges, enjoy private camel treks, stay in premium desert camps with ensuite bathrooms, and witness breathtaking sunrises over the dunes.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1534008722876-8e5ea9e54f2b?w=800',
            'destination' => 'merzouga',
            'meta' => array(
                'wpte_duration' => '5 days',
                'wpte_price' => '550',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('1 Day Agafay Desert Quad Biking Adventure', 'neartrips'),
            'slug' => '1-day-agafay-desert-quad-biking',
            'content' => __('Adrenaline-pumping quad biking adventure in the Agafay Stone Desert near Marrakech. Ride through rocky landscapes, visit Berber villages, enjoy mint tea with local families, and watch the sunset over the Atlas Mountains.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1563297129-8f37068c7565?w=800',
            'destination' => 'agafay',
            'meta' => array(
                'wpte_duration' => '1 day',
                'wpte_price' => '80',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('7 Days Grand Morocco Desert Circuit', 'neartrips'),
            'slug' => '7-days-grand-morocco-desert-circuit',
            'content' => __('The complete Morocco experience! From Marrakech to the Sahara, through Chefchaouen (Blue City), Fes, and back. Visit cascading waterfalls, cedar forests with Barbary macaques, ancient medinas, and spend two nights in the desert. Perfect for first-time visitors.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1539020140153-e479b8c22e70?w=800',
            'destination' => 'chefchaouen',
            'meta' => array(
                'wpte_duration' => '7 days',
                'wpte_price' => '750',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('Sunset Camel Trek & Desert Dinner', 'neartrips'),
            'slug' => 'sunset-camel-trek-desert-dinner',
            'content' => __('Short but unforgettable experience! Ride camels through the palm groves of Marrakech, watch the sunset over the Atlas Mountains, and enjoy a traditional Moroccan dinner with live Gnawa music in a beautiful riad setting.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1590422749830-6b63265467bd?w=800',
            'destination' => 'marrakech',
            'meta' => array(
                'wpte_duration' => 'Half day',
                'wpte_price' => '60',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('3 Days Fes to Merzouga Desert Tour', 'neartrips'),
            'slug' => '3-days-fes-merzouga-desert-tour',
            'content' => __('Start from Fes and journey to the Sahara. Explore Ifrane (Little Switzerland), Cedar forests of Azrou, Midelt apple orchards, Ziz Valley panoramas, and end with an unforgettable night in Erg Chebbi dunes with camel trekking and stargazing.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1512591290618-9fb59548df33?w=800',
            'destination' => 'merzouga',
            'meta' => array(
                'wpte_duration' => '3 days',
                'wpte_price' => '280',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('Private Atlas Mountains & Ourika Valley Day Trip', 'neartrips'),
            'slug' => 'private-atlas-mountains-ourika-valley',
            'content' => __('Escape the city heat with a refreshing day trip to the Ourika Valley. Drive through scenic Tizi n\'Test pass, visit traditional Berber markets, hike to Setti Fatma waterfalls, and enjoy lunch in a riverside restaurant with mountain views.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1533658286953-7a59a0e64dc4?w=800',
            'destination' => 'ourika',
            'meta' => array(
                'wpte_duration' => '1 day',
                'wpte_price' => '90',
                'wpte_availability' => 'Available',
            ),
        ),
        array(
            'title' => __('Marrakech to Casablanca & Rabat Express Tour', 'neartrips'),
            'slug' => 'marrakech-casablanca-rabat-express',
            'content' => __('Perfect for travelers with limited time. Visit the magnificent Hassan II Mosque in Casablanca (one of the largest in the world), explore Rabat\'s Kasbah of the Udayas, see Mohammed V Mausoleum, and experience modern Moroccan capital life.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1577147443647-8185bbc09e5d?w=800',
            'destination' => 'casablanca',
            'meta' => array(
                'wpte_duration' => '1 day',
                'wpte_price' => '120',
                'wpte_availability' => 'Available',
            ),
        ),
    );
}

/**
 * Get demo destinations data (10 Morocco destinations)
 */
function neartrips_get_demo_destinations() {
    return array(
        array(
            'name' => __('Merzouga', 'neartrips'),
            'slug' => 'merzouga',
            'description' => __('Gateway to the Erg Chebbi dunes and Sahara Desert experience.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1539650116455-251d93d5c933?w=800',
        ),
        array(
            'name' => __('Zagora', 'neartrips'),
            'slug' => 'zagora',
            'description' => __('Historic desert town with ancient kasbahs and palm oases.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1542401886-65d6c61db217?w=800',
        ),
        array(
            'name' => __('Fes', 'neartrips'),
            'slug' => 'fes',
            'description' => __('Morocco\'s cultural and spiritual capital with medieval medina.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1597212618440-806262de4f6b?w=800',
        ),
        array(
            'name' => __('Agafay', 'neartrips'),
            'slug' => 'agafay',
            'description' => __('Stone desert near Marrakech perfect for day trips and quad biking.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1563297129-8f37068c7565?w=800',
        ),
        array(
            'name' => __('Chefchaouen', 'neartrips'),
            'slug' => 'chefchaouen',
            'description' => __('The famous Blue City nestled in the Rif Mountains.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1539020140153-e479b8c22e70?w=800',
        ),
        array(
            'name' => __('Marrakech', 'neartrips'),
            'slug' => 'marrakech',
            'description' => __('The Red City - vibrant souks, palaces, and gardens.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1590422749830-6b63265467bd?w=800',
        ),
        array(
            'name' => __('Ourika Valley', 'neartrips'),
            'slug' => 'ourika',
            'description' => __('Scenic valley in the Atlas Mountains with Berber villages and waterfalls.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1533658286953-7a59a0e64dc4?w=800',
        ),
        array(
            'name' => __('Casablanca', 'neartrips'),
            'slug' => 'casablanca',
            'description' => __('Morocco\'s economic hub with the magnificent Hassan II Mosque.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1577147443647-8185bbc09e5d?w=800',
        ),
        array(
            'name' => __('Rabat', 'neartrips'),
            'slug' => 'rabat',
            'description' => __('The capital city blending modern and historic attractions.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1586724237569-f3d0c1dee8c6?w=800',
        ),
        array(
            'name' => __('Ouarzazate', 'neartrips'),
            'slug' => 'ouarzazate',
            'description' => __('Hollywood of Africa - film studios and gateway to the desert.', 'neartrips'),
            'image' => 'https://images.unsplash.com/photo-1534008722876-8e5ea9e54f2b?w=800',
        ),
    );
}
