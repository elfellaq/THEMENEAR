# Travelio — Installation & Setup Guide

A modern, original travel/tour WordPress theme. Warm orange + dark navy palette, custom post types for Tours & Destinations, WP Travel Engine compatible.

## 1. Install the theme

You have two options:

### Option A — Upload as a zip (recommended)
1. Zip the `travelio` folder so that the zip contains `travelio/style.css` at its root.
2. In WordPress admin: **Appearance → Themes → Add New → Upload Theme**.
3. Choose the zip and click **Install Now**, then **Activate**.

### Option B — Copy via FTP / file manager
Copy the entire `travelio` folder into `/wp-content/themes/` on your server. Then activate it from **Appearance → Themes**.

## 2. First-run configuration

After activating, do these in order:

1. **Permalinks** — Go to *Settings → Permalinks* and click **Save Changes** once. This refreshes URLs so the new `tour_package` and `destination` post types route correctly.
2. **Menus** — *Appearance → Menus*. Create a menu, add Home / Tours / Destinations / Blog / About / Contact, then assign it to the **Primary Menu** location.
3. **Customizer** — *Appearance → Customize*:
   - **Site Identity**: upload your logo (recommended 200×60).
   - **Hero Section**: set hero title, accent word, subtitle, and upload a background image (1920×1080).
   - **Contact & Footer**: phone, email, address, social URLs, footer text.

## 3. Add your content

### Tours (Tour Packages)
*Tours → Add New*. Each tour has standard fields plus a **Tour Details** box for:
- Price, Duration, Group Size, Location, Rating
- Featured badge toggle
- "What's included" and "What's NOT included" (HTML lists)

Set a featured image (1200×800 works best).

### Destinations
*Destinations → Add New*. Title + featured image + description. Tours linked by matching the destination name in the tour's **Location** field will appear on each destination page.

### Blog posts
Standard *Posts → Add New*. Set a featured image for the best card layout.

## 4. (Optional) WP Travel Engine

If you need real bookings and payments, install **WP Travel Engine** (free, from the WordPress plugin directory). Travelio detects it automatically:
- Its booking form renders inside the tour single-page booking card (replaces the simple inquiry form).
- If you create a WP Travel Engine "trip" with the same title as a Travelio tour, the tour URL redirects to the trip URL.

## 5. Tweaks & customization

All colors and fonts are CSS variables at the top of `style.css`:

```css
:root{
  --tv-orange: #FF7A2D;
  --tv-navy:   #0B2545;
  --tv-font-body: 'Inter', sans-serif;
  --tv-font-head: 'Poppins', sans-serif;
}
```

Change those values and the whole theme reskins.

The homepage layout lives in `front-page.php` — duplicate or remove sections (hero, destinations, packages, features, CTA, testimonials, blog) freely.

## File structure

```
travelio/
├── style.css                 ← theme header + all CSS
├── functions.php             ← setup, enqueues, helpers
├── header.php / footer.php
├── front-page.php            ← the homepage
├── index.php / page.php / single.php / archive.php / 404.php
├── single-tour_package.php
├── archive-tour_package.php
├── single-destination.php
├── archive-destination.php
├── searchform.php / sidebar.php / comments.php
├── inc/
│   ├── custom-post-types.php ← Tours, Destinations, meta boxes
│   ├── customizer.php        ← Customizer panels
│   ├── template-tags.php     ← menu fallback
│   └── wte-integration.php   ← WP Travel Engine hooks
├── template-parts/
│   ├── content.php           ← blog card
│   ├── content-tour.php      ← tour card
│   └── content-destination.php
├── assets/js/main.js
├── readme.txt
└── INSTALL.md (this file)
```

## Notes on placeholder images

When you have no featured image set, the theme requests a topical placeholder from `source.unsplash.com` so the homepage isn't empty during setup. Replace these with real featured images as you publish content — they're meant as scaffolding only.

## Licensing

The theme code is original, released under the GNU GPL v2 or later. No proprietary code, images, or trademarks from other commercial themes are included.
