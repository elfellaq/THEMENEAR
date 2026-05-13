# NearTrips Theme - Installation Guide

## 🌍 Theme Overview
**NearTrips** is a modern travel WordPress theme with full integration for:
- ✅ **WP Travel Engine** (FREE) - Tour booking & management
- ✅ **WooCommerce** - Payment processing & checkout
- ✅ **Elementor** - Drag & drop page builder
- ✅ **10 Demo Tours** - Ready-to-use tour packages
- ✅ **10 Demo Destinations** - Beautiful destination cards

---

## 📦 Installation Steps

### Step 1: Upload & Activate Theme
1. Download the `NearTrips-Theme.zip` file
2. Go to **WordPress Admin → Appearance → Themes**
3. Click **"Add New" → "Upload Theme"**
4. Choose `NearTrips-Theme.zip` and click **"Install Now"**
5. Click **"Activate"**

---

### Step 2: Install Required Plugins

#### A. WP Travel Engine (REQUIRED)
1. Go to **Plugins → Add New**
2. Search for **"WP Travel Engine"**
3. Click **"Install Now"** then **"Activate"**
4. This enables:
   - Tour/Trip post type
   - Booking system
   - Itinerary management
   - Payment integration

#### B. WooCommerce (RECOMMENDED)
1. Go to **Plugins → Add New**
2. Search for **"WooCommerce"**
3. Click **"Install Now"** then **"Activate"**
4. Complete the WooCommerce setup wizard
5. This enables:
   - Checkout functionality
   - Payment gateways
   - Order management

#### C. Elementor (OPTIONAL)
1. Go to **Plugins → Add New**
2. Search for **"Elementor"**
3. Click **"Install Now"** then **"Activate"**
4. This enables:
   - Visual page builder
   - Custom layouts
   - Drag & drop editing

---

### Step 3: Import Demo Content

1. Go to **Appearance → Import Demo**
2. You'll see: **"Ready to Import!"** message
3. Click **"🚀 Import Demo Content Now"**
4. Wait for success message

**What gets imported:**
- 🌍 **10 Tours** (Paris, Tokyo, NYC, Bali, Rome, Dubai, Santorini, Switzerland, Maldives, Iceland)
- 🏝️ **10 Destinations** with images
- 📄 **3 Pages** (About Us, Contact, FAQ)
- 📋 **Primary Menu** (automatically configured)
- 🏠 **Home Page** (set as front page)

---

### Step 4: Configure Homepage

1. Go to **Settings → Reading**
2. Select **"A static page"**
3. Choose **"Home"** as Homepage
4. Click **"Save Changes"**

---

### Step 5: Save Permalinks

1. Go to **Settings → Permalinks**
2. Select **"Post name"** (recommended)
3. Click **"Save Changes"**

---

## 🎨 Customization

### Using Elementor
1. Edit any page with **"Edit with Elementor"**
2. Use shortcodes:
   - `[neartrips_home]` - Full homepage
   - `[neartrips_tours count="6" columns="3"]` - Tours grid
   - `[neartrips_destinations count="6" columns="3"]` - Destinations
   - `[neartrips_features]` - Features section
   - `[neartrips_cta]` - Call-to-action section

### Using WordPress Customizer
1. Go to **Appearance → Customize**
2. Customize:
   - Site Identity (Logo, Title)
   - Colors
   - Menus
   - Widgets
   - Homepage Settings

---

## 🔧 Troubleshooting

### Issue: "Tours: 0 | Destinations: 0"
**Solution:** 
- Make sure **WP Travel Engine** plugin is installed AND activated
- Deactivate and reactivate the plugin
- Try importing demo content again

### Issue: No CSS Styling
**Solution:**
- Clear browser cache (Ctrl+F5)
- Clear WordPress cache if using caching plugin
- Check if theme is properly activated

### Issue: Warning about array offset
**Solution:**
- This has been fixed in version 2.0.0
- Re-upload the latest theme version
- Delete old theme files first

---

## 📁 Theme Structure

```
NearTrips/
├── style.css                 # Main stylesheet (560+ lines)
├── functions.php             # Theme functions
├── front-page.php            # Homepage template
├── header.php                # Header template
├── footer.php                # Footer template
├── index.php                 # Default template
├── single.php                # Single post template
├── page.php                  # Page template
├── archive.php               # Archive template
├── search.php                # Search results
├── 404.php                   # 404 page
├── screenshot.png            # Theme screenshot
├── css/                      # Additional CSS
├── js/                       # JavaScript files
│   └── main.js              # Main JS
├── includes/                 # Include files
│   ├── demo-importer.php    # Demo content importer
│   ├── plugin-recommendations.php
│   ├── elementor-support.php
│   ├── woocommerce-support.php
│   └── wte-integration.php
├── inc/                      # Additional includes
│   ├── template-tags.php
│   └── customizer.php
└── template-parts/           # Template parts
    ├── home-hero.php
    ├── tours-grid.php
    ├── tour-card.php
    ├── destinations-grid.php
    ├── features-section.php
    └── cta-section.php
```

---

## 🎯 Features Included

### WP Travel Engine Integration
- ✅ Automatic detection of WTE plugin
- ✅ Uses 'trip' post type when WTE is active
- ✅ Falls back to 'tour_package' if not
- ✅ Booking buttons on tour cards
- ✅ Price display from WTE meta
- ✅ Duration and availability info

### WooCommerce Integration
- ✅ Checkout button on tours
- ✅ "Checkout My Trips" in CTA section
- ✅ Product gallery support
- ✅ Cart integration

### Elementor Compatibility
- ✅ Full Elementor support
- ✅ Custom shortcodes for tours/destinations
- ✅ Header/Footer builder support
- ✅ Widget compatibility

### Demo Content
- ✅ 10 professional tour packages
- ✅ 10 beautiful destinations
- ✅ Essential pages (About, Contact, FAQ)
- ✅ Pre-configured menu
- ✅ Homepage auto-setup

---

## 📞 Support

For issues or questions:
1. Check this README first
2. Ensure all required plugins are active
3. Clear caches (browser & WordPress)
4. Re-import demo content if needed

---

## 📝 Version History

**v2.0.0** - Current Version
- ✅ Added 10 demo tours (was 6)
- ✅ Added 10 destinations (was 6)
- ✅ Fixed null array offset warning
- ✅ Improved WTE detection
- ✅ Added Elementor shortcodes
- ✅ Enhanced WooCommerce checkout integration
- ✅ Better plugin recommendation system
- ✅ Optimized CSS (560+ lines)

**v1.0.0** - Initial Version
- Basic theme structure
- 6 demo tours
- Basic WTE integration

---

## 🙏 Credits

- Images from Unsplash (free to use)
- Font Awesome icons
- Google Fonts (Poppins)
- WP Travel Engine plugin
- WooCommerce plugin
- Elementor plugin

---

**Enjoy your NearTrips website! 🌍✈️**
