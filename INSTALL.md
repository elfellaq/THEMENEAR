# Travelio Theme - Installation & Setup Guide

## Overview
Travelio is a modern travel & tour WordPress theme inspired by Travila, featuring full integration with WP Travel Engine (FREE) for booking functionality.

## Required Plugins

### 1. WP Travel Engine (FREE) - **RECOMMENDED**
This is the core plugin that powers trip booking functionality.

**Installation:**
1. Go to WordPress Admin → Plugins → Add New
2. Search for "WP Travel Engine"
3. Install and Activate

**OR manually:**
- Download from: https://wordpress.org/plugins/wp-travel-engine/
- Upload via WordPress Admin → Plugins → Add New → Upload Plugin

### 2. WooCommerce (Optional but Recommended)
Enables payment processing and checkout functionality.

**Installation:**
1. Go to WordPress Admin → Plugins → Add New
2. Search for "WooCommerce"
3. Install and Activate

## Theme Features

### Homepage Features (Travila-style)
- **Hero Section** with advanced search including:
  - Destination search
  - Check-in / Check-out date pickers
  - Number of travelers selector
  - Advanced filters (Tour Type, Duration, Price Range, Difficulty)
  
- **Stats Counter** showing destinations, packages, travelers, experience

- **Destinations Grid** - Top destinations with hover effects

- **Featured Tour Packages** with:
  - WTE integration for bookable trips
  - "Book Now" buttons linking to checkout
  - Price, duration, and rating display
  - Featured badges

- **Why Choose Us** section with WTE features:
  - Instant Confirmation
  - E-Voucher Ready
  - Secure Payment
  - Free Cancellation

- **CTA Banner** with "Checkout My Trips" button (when WTE active)

- **Testimonials** slider

- **Blog Section**

### WP Travel Engine Integration
- Automatic detection of WTE plugin
- Uses `trip` post type when WTE is active
- Falls back to `tour_package` CPT when WTE is not installed
- Checkout link in header and CTA sections
- Booking form shortcode: `[travelio_booking]`

## Setup Instructions

### Step 1: Install Theme
1. Upload the theme folder to `/wp-content/themes/`
2. Activate via WordPress Admin → Appearance → Themes

### Step 2: Install Required Plugins
After activation, you'll see a notice recommending WP Travel Engine installation.

### Step 3: Install Demo Content (Optional but Recommended) ⭐
**To make your site look full like the demo:**

1. Navigate to your theme folder: `/wp-content/themes/travelio/`
2. Access the demo importer via browser:
   ```
   https://yoursite.com/wp-content/themes/travelio/setup-demo.php
   ```
3. Wait for "Installation Complete" message
4. **IMPORTANT:** Delete `setup-demo.php` immediately after use for security

**What the demo importer adds:**
- ✅ 6 ready-to-use trips/tours with images, prices, and locations
- ✅ Homepage set as front page
- ✅ Pages: About Us, Contact, My Bookings
- ✅ Primary Navigation Menu

### Step 4: Create Content
1. **Add Destinations**: Go to Destinations → Add New
2. **Add Tours/Trips**: 
   - With WTE: Go to Trip → Add New
   - Without WTE: Go to Tours → Add New Tour

### Step 4: Configure Homepage
1. Go to Settings → Reading
2. Set "Your homepage displays" to "A static page"
3. Select your homepage (create one with front-page.php template)

### Step 5: Customize
Go to Appearance → Customize to modify:
- Hero title and subtitle
- Colors and branding
- Contact information
- Phone number

## Checkout Integration
When WP Travel Engine is active:
- "Book Now" buttons link directly to trip booking pages
- "Checkout My Trips" button appears in CTA section
- Booking forms are integrated with WooCommerce checkout

## Shortcodes Available
- `[travelio_booking]` - Displays WTE booking form

## Support
For theme support, please contact the theme developer.
For WP Travel Engine support, visit: https://wptravelengine.com/support/
