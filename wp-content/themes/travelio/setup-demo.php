<?php
/**
 * Travelio Demo Content Importer
 * قم بتشغيل هذا الملف مرة واحدة عبر المتصفح: yoursite.com/wp-content/themes/travelio/setup-demo.php
 * ثم احذفه فوراً بعد الانتهاء لأسباب أمنية.
 */

// التحقق من الصلاحيات (يجب أن تكون مسجلاً كمسؤول)
if (!current_user_can('manage_options')) {
    die('يجب أن تكون مسجلاً الدخول كمسؤول (Admin) لتشغيل هذا الملف.');
}

// تحميل بيئة ووردبريس
require_once('../../../wp-load.php');

echo "<h1>جاري تثبيت محتوى Travelio التجريبي...</h1>";
echo "<ul>";

// 1. إنشاء الصفحات الأساسية
$pages = [
    'Home' => '[travelio_home]',
    'About Us' => 'مرحباً بكم في Travelio، وجهتكم الأولى لاستكشاف العالم.',
    'Contact' => 'تواصل معنا لدعمكم على مدار الساعة.',
    'My Bookings' => '[wte_my_bookings]', // صفحة حجوزاتي إذا كانت الإضافة مفعلة
];

$page_ids = [];
foreach ($pages as $title => $content) {
    $page_check = get_page_by_title($title);
    if (!$page_check) {
        $id = wp_insert_post([
            'post_title'   => $title,
            'post_content' => $content,
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ]);
        $page_ids[$title] = $id;
        echo "<li>تم إنشاء صفحة: <strong>$title</strong></li>";
    } else {
        $page_ids[$title] = $page_check->ID;
        echo "<li>صفحة <strong>$title</strong> موجودة مسبقاً.</li>";
    }
}

// تعيين الصفحة الرئيسية
if (isset($page_ids['Home'])) {
    update_option('show_on_front', 'page');
    update_option('page_on_front', $page_ids['Home']);
    echo "<li>تم تعيين صفحة Home كصفحة رئيسية.</li>";
}

// 2. إنشاء جولات تجريبية (Trips)
// نتحقق مما إذا كان نوع المحتوى 'trip' موجوداً (من WP Travel Engine) أو نستخدم 'tour_package'
$post_type = post_type_exists('trip') ? 'trip' : 'tour_package';
$type_label = ($post_type == 'trip') ? 'WP Travel Engine Trip' : 'Custom Tour';

$trips = [
    [
        'title' => 'مغامرة صحراء دبي',
        'price' => '150',
        'duration' => '6 Hours',
        'location' => 'Dubai, UAE',
        'image' => 'https://images.unsplash.com/photo-1512453979798-5ea904ac66de?auto=format&fit=crop&w=800&q=80',
        'desc' => 'استمتع بتجربة السفاري في صحراء دبي مع ركوب الجمال والعشاء تحت النجوم.'
    ],
    [
        'title' => 'جولة تاريخية في الأهرامات',
        'price' => '200',
        'duration' => '8 Hours',
        'location' => 'Cairo, Egypt',
        'image' => 'https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?auto=format&fit=crop&w=800&q=80',
        'desc' => 'اكتشف أسرار الفراعنة في جولة شاملة للأهرامات وأبو الهول والمتحف المصري.'
    ],
    [
        'title' => 'عطلة جزر المالديف الاستوائية',
        'price' => '1200',
        'duration' => '7 Days',
        'location' => 'Maldives',
        'image' => 'https://images.unsplash.com/photo-1514282401047-d79a71a590e8?auto=format&fit=crop&w=800&q=80',
        'desc' => 'إقامة فاخرة في فيلا فوق الماء مع أنشطة غوص/snorkeling وجلسات استرخاء.'
    ],
    [
        'title' => 'رحلة سفاري في غابات الأمازون',
        'price' => '850',
        'duration' => '5 Days',
        'location' => 'Brazil',
        'image' => 'https://images.unsplash.com/photo-1591696205602-2f950c417cb9?auto=format&fit=crop&w=800&q=80',
        'desc' => 'مغامرة لا تنسى في قلب الأمازون لمشاهدة الحياة البرية النادرة.'
    ],
    [
        'title' => 'جولة ثقافية في إسطنبول',
        'price' => '300',
        'duration' => '3 Days',
        'location' => 'Istanbul, Turkey',
        'image' => 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?auto=format&fit=crop&w=800&q=80',
        'desc' => 'جولة بين المساجد والأسواق التاريخية والمضيق البوسفور.'
    ],
    [
        'title' => 'تزلج في جبال الألب السويسرية',
        'price' => '950',
        'duration' => '6 Days',
        'location' => 'Switzerland',
        'image' => 'https://images.unsplash.com/photo-1551524559-8af4e6624178?auto=format&fit=crop&w=800&q=80',
        'desc' => 'تجربة تزلج عالمية المستوى مع إطلالات بانورامية خلابة.'
    ]
];

foreach ($trips as $trip) {
    $check = get_page_by_title($trip['title'], OBJECT, $post_type);
    if (!$check) {
        $post_id = wp_insert_post([
            'post_title'   => $trip['title'],
            'post_content' => $trip['desc'],
            'post_status'  => 'publish',
            'post_type'    => $post_type,
        ]);

        // إضافة الصورة البارزة
        if ($post_id && !is_wp_error($post_id)) {
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            
            $attach_id = media_sideload_image($trip['image'], $post_id, $trip['title'], 'id');
            if (!is_wp_error($attach_id)) {
                set_post_thumbnail($post_id, $attach_id);
            }

            // إضافة بيانات مخصصة (Meta Data) حسب نوع الإضافة
            if ($post_type === 'trip') {
                // حقول WP Travel Engine
                update_post_meta($post_id, 'wte_price', $trip['price']);
                update_post_meta($post_id, 'wte_duration', $trip['duration']);
                update_post_meta($post_id, 'wte_location', $trip['location']);
                update_post_meta($post_id, '_wte_is_bookable', 'yes');
            } else {
                // حقول مخصصة للثيم
                update_post_meta($post_id, '_price', $trip['price']);
                update_post_meta($post_id, '_duration', $trip['duration']);
                update_post_meta($post_id, '_location', $trip['location']);
            }
            
            echo "<li>تم إنشاء الجولة: <strong>{$trip['title']}</strong> ($type_label)</li>";
        }
    } else {
        echo "<li>الجولة <strong>{$trip['title']}</strong> موجودة مسبقاً.</li>";
    }
}

// 3. إنشاء قائمة تنقل (Menu)
$menu_name = 'Primary Menu';
$menu_exists = wp_get_nav_menu_object($menu_name);

if (!$menu_exists) {
    $menu_id = wp_create_nav_menu($menu_name);
    
    // إضافة العناصر للقائمة
    foreach ($page_ids as $title => $id) {
        if ($title !== 'My Bookings') { // لا نضيف صفحة الحجوزات للقائمة الرئيسية إلا إذا أردت
            wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title'     => $title,
                'menu-item-object-id' => $id,
                'menu-item-object'    => 'page',
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
            ]);
        }
    }
    
    // تعيين الموقع للقائمة
    $locations = get_theme_mods();
    $locations['nav_menus'] = [ 'primary' => $menu_id ]; // تأكد من اسم الموقع 'primary' من ملف functions.php
    set_theme_mod('nav_menu_locations', $locations);
    
    echo "<li>تم إنشاء وتعيين القائمة الرئيسية.</li>";
} else {
    echo "<li>القائمة الرئيسية موجودة مسبقاً.</li>";
}

echo "</ul>";
echo "<h3 style='color:green'>اكتمل التثبيت بنجاح! <a href='" . home_url() . "'>انتقل للموقع</a></h3>";
echo "<p style='color:red; font-weight:bold;'>تنبيه: يرجى حذف ملف setup-demo.php الآن من الخادم للحفاظ على الأمان.</p>";

?>
