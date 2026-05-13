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
            ),
            array(
                'title' => 'Marrakech',
                'slug' => 'marrakech',
                'description' => 'The Red City of Morocco, a magical blend of ancient traditions and vibrant souks.',
                'image' => 'https://images.unsplash.com/photo-1539020140153-e479b8c22e70?w=800&q=80'
            ),
            array(
                'title' => 'Merzouga',
                'slug' => 'merzouga',
                'description' => 'Gateway to the Sahara Desert, famous for its towering golden dunes.',
                'image' => 'https://images.unsplash.com/photo-1542401886-65d6c61db217?w=800&q=80'
            ),
            array(
                'title' => 'Fes',
                'slug' => 'fes',
                'description' => 'Morocco\'s spiritual and cultural capital, home to the world\'s oldest university.',
                'image' => 'https://images.unsplash.com/photo-1577147443647-8185bbc09f5d?w=800&q=80'
            ),
            array(
                'title' => 'Chefchaouen',
                'slug' => 'chefchaouen',
                'description' => 'The Blue Pearl of Morocco, a picturesque mountain town painted in shades of blue.',
                'image' => 'https://images.unsplash.com/photo-1560706248-9c24d73e6531?w=800&q=80'
            )
        );
        
        // Sample Tours
        $this->sample_tours = array(
            array(
                'title' => '3 Jours dans le Désert de Merzouga au Départ de Marrakech',
                'slug' => '3-jours-desert-merzouga-marrakech',
                'destination' => 'merzouga',
                'duration' => '3 Jours',
                'price' => 299,
                'sale_price' => 249,
                'rating' => 4.9,
                'reviews' => 342,
                'image' => 'https://images.unsplash.com/photo-1542401886-65d6c61db217?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1542401886-65d6c61db217?w=800&q=80',
                    'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?w=800&q=80',
                    'https://images.unsplash.com/photo-1534234828563-02511c750b8e?w=800&q=80'
                ),
                'description' => 'Découvrez la magie du Sahara marocain lors de cette excursion inoubliable de 3 jours au départ de Marrakech. Traversez les montagnes de l\'Atlas, visitez les kasbahs anciennes et passez une nuit sous les étoiles dans un campement berbère luxueux.',
                'highlights' => array(
                    'Traversée spectaculaire des montagnes du Haut Atlas',
                    'Visite de la Kasbah Ait Ben Haddou, site UNESCO',
                    'Balade à dos de chameau au coucher du soleil',
                    'Nuit en bivouac de luxe avec dîner traditionnel',
                    'Spectacle de musique gnawa autour du feu de camp'
                ),
                'includes' => array(
                    'Transport en 4x4 climatisé avec chauffeur',
                    '2 nuits en hôtel et bivouac de luxe',
                    'Petit-déjeuner, déjeuner et dîner inclus',
                    'Balade à chameau incluse',
                    'Guide francophone expérimenté'
                ),
                'difficulty' => 'Facile',
                'category' => 'Désert & Aventure'
            ),
            array(
                'title' => 'Excursion d\'une Journée à Ouzoud depuis Marrakech',
                'slug' => 'excursion-ouzoud-journee-marrakech',
                'destination' => 'marrakech',
                'duration' => '1 Jour',
                'price' => 89,
                'sale_price' => 69,
                'rating' => 4.7,
                'reviews' => 218,
                'image' => 'https://images.unsplash.com/photo-1588668214407-6ea9f6d7a9fe?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1588668214407-6ea9f6d7a9fe?w=800&q=80',
                    'https://images.unsplash.com/photo-1570535384209-4d3cd127faa9?w=800&q=80',
                    'https://images.unsplash.com/photo-1534438097545-a2c22c57f01b?w=800&q=80'
                ),
                'description' => 'Évadez-vous de l\'agitation de Marrakech pour découvrir les magnifiques cascades d\'Ouzoud, les plus hautes d\'Afrique du Nord. Une journée rafraîchissante au cœur de la nature avec possibilité de baignade et d\'observation des singes macaques.',
                'highlights' => array(
                    'Admiration des cascades de 110 mètres de hauteur',
                    'Promenade en barque au pied des chutes',
                    'Observation des macaques de Barbarie en liberté',
                    'Déjeuner traditionnel dans un restaurant panoramique',
                    'Arrêt photo à la vallée de l\'Atlas'
                ),
                'includes' => array(
                    'Transport aller-retour en minibus climatisé',
                    'Guide accompagnateur francophone',
                    'Temps libre pour explorer les cascades',
                    'Assurance voyage incluse',
                    'Prise en charge à votre hôtel'
                ),
                'difficulty' => 'Facile',
                'category' => 'Nature & Découverte'
            ),
            array(
                'title' => 'Circuit Impériale: Marrakech, Fès, Rabat et Casablanca',
                'slug' => 'circuit-imperiale-maroc-7-jours',
                'destination' => 'fes',
                'duration' => '7 Jours',
                'price' => 899,
                'sale_price' => 749,
                'rating' => 4.8,
                'reviews' => 156,
                'image' => 'https://images.unsplash.com/photo-1577147443647-8185bbc09f5d?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1577147443647-8185bbc09f5d?w=800&q=80',
                    'https://images.unsplash.com/photo-1539020140153-e479b8c22e70?w=800&q=80',
                    'https://images.unsplash.com/photo-1560706248-9c24d73e6531?w=800&q=80'
                ),
                'description' => 'Explorez les quatre villes impériales du Maroc en un circuit complet de 7 jours. De l\'effervescence de Marrakech à la spiritualité de Fès, en passant par Rabat la capitale et Casablanca la moderne, découvrez mille ans d\'histoire marocaine.',
                'highlights' => array(
                    'Visite guidée de la médina de Fès, la plus grande zone piétonne au monde',
                    'Exploration du Palais Royal et des jardins de la Kasbah des Oudayas à Rabat',
                    'Découverte de la majestueuse mosquée Hassan II à Casablanca',
                    'Promenade dans les souks colorés de Marrakech et place Jemaa el-Fna',
                    'Rencontre avec des artisans locaux et démonstrations de savoir-faire traditionnel'
                ),
                'includes' => array(
                    '6 nuits en hôtels 4 étoiles avec petit-déjeuner',
                    'Transport privé en véhicule climatisé',
                    'Guides locaux certifiés dans chaque ville',
                    'Tous les transferts et péages',
                    'Dîners traditionnels inclus (3 repas)'
                ),
                'difficulty' => 'Moyen',
                'category' => 'Culture & Patrimoine'
            ),
            array(
                'title' => 'Aventure 4x4 dans le Désert d\'Agafay',
                'slug' => 'aventure-4x4-desert-agafay',
                'destination' => 'marrakech',
                'duration' => 'Demi-journée',
                'price' => 129,
                'sale_price' => 99,
                'rating' => 4.6,
                'reviews' => 189,
                'image' => 'https://images.unsplash.com/photo-1533587851505-d119e13fa0d7?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1533587851505-d119e13fa0d7?w=800&q=80',
                    'https://images.unsplash.com/photo-1534234828563-02511c750b8e?w=800&q=80',
                    'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?w=800&q=80'
                ),
                'description' => 'Vivez des sensations fortes lors de cette excursion en 4x4 dans le désert pierreux d\'Agafay, à seulement 30 minutes de Marrakech. Un paysage lunaire unique au monde vous attend pour une aventure mémorable.',
                'highlights' => array(
                    'Conduite sportive dans les pistes du désert d\'Agafay',
                    'Arrêt dans un village berbère authentique',
                    'Thé à la menthe chez l\'habitant',
                    'Photos panoramiques avec l\'Atlas en toile de fond',
                    'Option quad ou buggy disponible en supplément'
                ),
                'includes' => array(
                    'Location de 4x4 avec chauffeur professionnel',
                    'Assurance tous risques',
                    'Thé berbère traditionnel',
                    'Transfert depuis votre hôtel',
                    'Casque et équipement de sécurité'
                ),
                'difficulty' => 'Moyen',
                'category' => 'Aventure & Sensations'
            ),
            array(
                'title' => 'Escapade Romantique dans les Jardins de Majorelle',
                'slug' => 'escapade-jardins-majorelle-marrakech',
                'destination' => 'marrakech',
                'duration' => 'Demi-journée',
                'price' => 79,
                'sale_price' => 59,
                'rating' => 4.9,
                'reviews' => 267,
                'image' => 'https://images.unsplash.com/photo-1597316747660-178b94a3b87a?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1597316747660-178b94a3b87a?w=800&q=80',
                    'https://images.unsplash.com/photo-1539020140153-e479b8c22e70?w=800&q=80',
                    'https://images.unsplash.com/photo-1560706248-9c24d73e6531?w=800&q=80'
                ),
                'description' => 'Laissez-vous envoûter par la beauté des célèbres Jardins Majorelle, chef-d\'œuvre botanique créé par Jacques Majorelle et restauré par Yves Saint Laurent. Une expérience sensorielle unique au cœur de Marrakech.',
                'highlights' => array(
                    'Visite prioritaire sans file d\'attente des jardins',
                    'Découverte du Musée Berbère adjacent',
                    'Photo devant la villa bleue iconique',
                    'Collection exceptionnelle de cactus du monde entier',
                    'Pause café dans le café du jardin'
                ),
                'includes' => array(
                    'Billets d\'entrée coupe-file inclus',
                    'Guide conférencier francophone',
                    'Transport depuis et vers votre hôtel',
                    'Boisson de bienvenue offerte',
                    'Album photo souvenir numérique'
                ),
                'difficulty' => 'Facile',
                'category' => 'Culture & Détente'
            ),
            array(
                'title' => 'Randonnée dans l\'Atlas et Rencontre Berbère',
                'slug' => 'randonnee-atlas-rencontre-berbere',
                'destination' => 'marrakech',
                'duration' => '1 Jour',
                'price' => 119,
                'sale_price' => 89,
                'rating' => 4.8,
                'reviews' => 134,
                'image' => 'https://images.unsplash.com/photo-1518182170546-0766ce6fec56?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1518182170546-0766ce6fec56?w=800&q=80',
                    'https://images.unsplash.com/photo-1534234828563-02511c750b8e?w=800&q=80',
                    'https://images.unsplash.com/photo-1542401886-65d6c61db217?w=800&q=80'
                ),
                'description' => 'Échappez-vous dans les montagnes du Haut Atlas pour une journée de randonnée authentique. Découvrez les villages perchés, les vallées verdoyantes et partagez un moment convivial avec une famille berbère locale.',
                'highlights' => array(
                    'Randonnée guidée de niveau accessible (3-4 heures)',
                    'Déjeuner traditionnel tagine préparé chez l\'habitant',
                    'Cérémonie du thé à la menthe avec une famille berbère',
                    'Visite d\'un grenier collectif (agadir) traditionnel',
                    'Points de vue panoramiques sur les sommets enneigés'
                ),
                'includes' => array(
                    'Guide de montagne certifié francophone',
                    'Transport en minibus 4x4',
                    'Déjeuner complet chez l\'habitant',
                    'Eau et collations pendant la randonnée',
                    'Assurance rapatriement incluse'
                ),
                'difficulty' => 'Moyen',
                'category' => 'Randonnée & Nature'
            ),
            array(
                'title' => 'Tour des Oasis et Vallée du Dadès',
                'slug' => 'tour-oasis-vallee-dades',
                'destination' => 'merzouga',
                'duration' => '2 Jours',
                'price' => 259,
                'sale_price' => 219,
                'rating' => 4.7,
                'reviews' => 98,
                'image' => 'https://images.unsplash.com/photo-1534234828563-02511c750b8e?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1534234828563-02511c750b8e?w=800&q=80',
                    'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?w=800&q=80',
                    'https://images.unsplash.com/photo-1542401886-65d6c61db217?w=800&q=80'
                ),
                'description' => 'Explorez la route des mille kasbahs à travers la vallée du Dadès et ses gorges spectaculaires. Un voyage au cœur des oasis millénaires et des villages fortifiés du sud marocain.',
                'highlights' => array(
                    'Traversée des gorges du Dadès et du Todra',
                    'Visite de la vallée des roses à Kelaat M\'Gouna',
                    'Arrêt dans les oasis de Skoura et son palmier millénaire',
                    'Nuit en kasbah-hôtel de charme avec piscine',
                    'Dégustation de produits locaux (huile d\'argan, miel, amandes)'
                ),
                'includes' => array(
                    'Transport en 4x4 tout confort',
                    '1 nuit en kasbah-hôtel 3 étoiles avec demi-pension',
                    'Guide accompagnateur spécialisé',
                    'Entrées aux sites touristiques',
                    'Assistance 24h/24 pendant le séjour'
                ),
                'difficulty' => 'Facile',
                'category' => 'Découverte & Patrimoine'
            ),
            array(
                'title' => 'Chefchaouen la Perle Bleue - Excursion de 3 Jours',
                'slug' => 'chefchaouen-perle-bleue-3-jours',
                'destination' => 'chefchaouen',
                'duration' => '3 Jours',
                'price' => 349,
                'sale_price' => 299,
                'rating' => 4.9,
                'reviews' => 221,
                'image' => 'https://images.unsplash.com/photo-1560706248-9c24d73e6531?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1560706248-9c24d73e6531?w=800&q=80',
                    'https://images.unsplash.com/photo-1577147443647-8185bbc09f5d?w=800&q=80',
                    'https://images.unsplash.com/photo-1539020140153-e479b8c22e70?w=800&q=80'
                ),
                'description' => 'Partez à la découverte de Chefchaouen, la célèbre ville bleue nichée dans les montagnes du Rif. Trois jours pour s\'imprégner de l\'atmosphère unique de cette perle andalouse aux ruelles peintes en bleu azur.',
                'highlights' => array(
                    'Promenade photographique dans les ruelles bleues de la médina',
                    'Randonnée jusqu\'à la kasbah pour vue panoramique',
                    'Visite de la Grande Mosquée et de la place Outa el Hammam',
                    'Shopping d\'artisanat local (tissus, cuir, poteries)',
                    'Dégustation de spécialités rifaines (fromage de chèvre, miel)'
                ),
                'includes' => array(
                    '2 nuits en riad traditionnel avec petit-déjeuner',
                    'Transport climatique aller-retour depuis Marrakech',
                    'Guide local francophone à Chefchaouen',
                    'Atelier de teinture traditionnelle (optionnel)',
                    'Carte postale souvenir personnalisée'
                ),
                'difficulty' => 'Facile',
                'category' => 'Culture & Photographie'
            ),
            array(
                'title' => 'Surf et Plage à Essaouira - Week-end Détente',
                'slug' => 'surf-plage-essaouira-weekend',
                'destination' => 'marrakech',
                'duration' => '2 Jours',
                'price' => 199,
                'sale_price' => 169,
                'rating' => 4.6,
                'reviews' => 175,
                'image' => 'https://images.unsplash.com/photo-1560508195-9a963d6bb9a6?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1560508195-9a963d6bb9a6?w=800&q=80',
                    'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=800&q=80',
                    'https://images.unsplash.com/photo-1534438097545-a2c22c57f01b?w=800&q=80'
                ),
                'description' => 'Évadez-vous vers la cité des alizés, Essaouira, pour un week-end détente entre surf, plage et découverte culturelle. Une ambiance relaxante garantie dans cette ville portuaire classée UNESCO.',
                'highlights' => array(
                    'Cours de surf débutant ou intermédiaire inclus',
                    'Promenade sur les remparts portugais du XVIIIe siècle',
                    'Visite du port de pêche et criée aux poissons',
                    'Soirée musicale gnawa dans un café de la médina',
                    'Temps libre pour shopping et farniente'
                ),
                'includes' => array(
                    '1 nuit en hôtel face à la mer avec petit-déjeuner',
                    'Transport depuis Marrakech en bus touristique',
                    'Cours de surf de 2 heures avec matériel',
                    'Guide accompagnateur bilingue',
                    'Kit de plage offert (serviette, crème solaire)'
                ),
                'difficulty' => 'Facile',
                'category' => 'Plage & Sports Nautiques'
            ),
            array(
                'title' => 'Expérience Luxe: Dîner Privé sous les Étoiles dans le Désert',
                'slug' => 'experience-luxe-diner-prive-desert',
                'destination' => 'merzouga',
                'duration' => 'Soirée',
                'price' => 399,
                'sale_price' => 349,
                'rating' => 5.0,
                'reviews' => 87,
                'image' => 'https://images.unsplash.com/photo-1518182170546-0766ce6fec56?w=800&q=80',
                'gallery' => array(
                    'https://images.unsplash.com/photo-1518182170546-0766ce6fec56?w=800&q=80',
                    'https://images.unsplash.com/photo-1542401886-65d6c61db217?w=800&q=80',
                    'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?w=800&q=80'
                ),
                'description' => 'Vivez une expérience exclusive et romantique avec un dîner gastronomique privé au cœur des dunes de sable doré. Un service haut de gamme pour une soirée inoubliable sous le ciel étoilé du Sahara.',
                'highlights' => array(
                    'Installation privée dans un salon berbère de luxe',
                    'Menu gastronomique 5 services par chef privé',
                    'Musique live traditionnelle (violon ou oud)',
                    'Observation astronomique avec télescope professionnel',
                    'Service de voiturier et transfert VIP'
                ),
                'includes' => array(
                    'Transfert en véhicule de luxe (Mercedes V-Class)',
                    'Dîner gastronomique avec accords mets-vins',
                    'Décoration florale et ambiance personnalisée',
                    'Photographe professionnel (30 minutes)',
                    'Cadeau souvenir personnalisé'
                ),
                'difficulty' => 'Facile',
                'category' => 'Luxe & Romantisme'
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
            $imported_data = isset($_GET['imported']) ? stripslashes($_GET['imported']) : '';
            $imported = !empty($imported_data) ? json_decode($imported_data, true) : null;
            
            echo '<div class="notice notice-success"><p><strong>Demo content imported successfully!</strong></p>';
            
            if ($imported && is_array($imported)) {
                $tours = isset($imported['tours']) ? intval($imported['tours']) : 0;
                $destinations = isset($imported['destinations']) ? intval($imported['destinations']) : 0;
                $pages = isset($imported['pages']) ? intval($imported['pages']) : 0;
                echo '<p>Tours: ' . $tours . ' | Destinations: ' . $destinations . ' | Pages: ' . $pages . '</p>';
            } else {
                echo '<p>Import completed. Please check your content in Trips or Tour Packages.</p>';
            }
            
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
        $wte_active = class_exists('WPTrip_Summary') || class_exists('Wp_Travel_Engine');
        
        // Import Destinations
        if (post_type_exists('destination')) {
            $imported['destinations'] = $this->import_destinations();
        }
        
        // Import Tours - try multiple post types
        if ($wte_active && post_type_exists('trip')) {
            $imported['tours'] = $this->import_tours_wte();
        } elseif (post_type_exists('tour_package')) {
            $imported['tours'] = $this->import_tours_custom();
        } else {
            // Fallback: create with custom post type registration
            if ($wte_active) {
                // WTE is active but trip post type not registered yet - force it
                $imported['tours'] = $this->import_tours_wte();
            }
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
            // Check if already exists - check both trip and tour_package
            $exists = get_page_by_path($tour['slug'], OBJECT, 'trip');
            if (!$exists) {
                $exists = get_page_by_path($tour['slug'], OBJECT, 'tour_package');
            }
            if ($exists) {
                continue;
            }
            
            // Determine post type to use
            $post_type = post_type_exists('trip') ? 'trip' : 'tour_package';
            
            $post_id = wp_insert_post(array(
                'post_title' => $tour['title'],
                'post_name' => $tour['slug'],
                'post_content' => $this->format_tour_content($tour),
                'post_status' => 'publish',
                'post_type' => $post_type
            ));
            
            if ($post_id && !is_wp_error($post_id)) {
                // Set featured image
                $this->set_featured_image($post_id, $tour['image']);
                
                // Set WTE meta fields (use wpte_ prefix for WP Travel Engine)
                update_post_meta($post_id, 'wpte_trip_duration', $tour['duration']);
                update_post_meta($post_id, 'wpte_trip_price', $tour['sale_price']);
                update_post_meta($post_id, 'wpte_trip_original_price', $tour['price']);
                update_post_meta($post_id, 'wpte_trip_availability', 'available');
                
                // Also set alternative meta keys for compatibility
                update_post_meta($post_id, 'trip_duration', $tour['duration']);
                update_post_meta($post_id, 'trip_price', $tour['sale_price']);
                update_post_meta($post_id, 'original_price', $tour['price']);
                
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
                        update_post_meta($post_id, 'trip_gallery', $gallery_ids);
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
            // Check if already exists - check both tour_package and trip
            $exists = get_page_by_path($tour['slug'], OBJECT, 'tour_package');
            if (!$exists) {
                $exists = get_page_by_path($tour['slug'], OBJECT, 'trip');
            }
            if ($exists) {
                continue;
            }
            
            // Determine post type to use
            $post_type = post_type_exists('tour_package') ? 'tour_package' : 'trip';
            
            $post_id = wp_insert_post(array(
                'post_title' => $tour['title'],
                'post_name' => $tour['slug'],
                'post_content' => $this->format_tour_content($tour),
                'post_status' => 'publish',
                'post_type' => $post_type
            ));
            
            if ($post_id && !is_wp_error($post_id)) {
                // Set featured image
                $this->set_featured_image($post_id, $tour['image']);
                
                // Set custom meta fields for both systems
                update_post_meta($post_id, '_tour_duration', $tour['duration']);
                update_post_meta($post_id, '_tour_price', $tour['sale_price']);
                update_post_meta($post_id, '_tour_original_price', $tour['price']);
                update_post_meta($post_id, '_tour_rating', $tour['rating']);
                update_post_meta($post_id, '_tour_difficulty', $tour['difficulty']);
                
                // Also set WTE meta fields for compatibility
                update_post_meta($post_id, 'wpte_trip_duration', $tour['duration']);
                update_post_meta($post_id, 'wpte_trip_price', $tour['sale_price']);
                update_post_meta($post_id, 'wpte_trip_original_price', $tour['price']);
                update_post_meta($post_id, 'wpte_trip_availability', 'available');
                
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
        
        // Determine trips URL based on post type
        $trips_url = post_type_exists('trip') ? home_url('/trips/') : home_url('/tour-packages/');
        $destinations_url = post_type_exists('destination') ? home_url('/destinations/') : home_url('/');
        
        // Add menu items
        $items = array(
            array('title' => 'Home', 'url' => home_url('/')),
            array('title' => 'Tours', 'url' => $trips_url),
            array('title' => 'Destinations', 'url' => $destinations_url),
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
