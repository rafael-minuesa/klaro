# Changelog

All notable changes to the Klaro WordPress theme will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.3] - 2026-01-19

### Fixed
- **PHP 8.x compatibility** - Added missing `$commenter = wp_get_current_commenter()` in comment form defaults function
- **Search form accessibility** - Fixed mismatched IDs where `for`, `id`, and `aria-describedby` used different `uniqid()` calls
- **Security** - Sanitized `$_GET` parameter access with `sanitize_text_field()` and `wp_unslash()`
- **Comment callback placement** - Moved `klaro_comment_callback()` from comments.php to functions.php with `function_exists()` guard to prevent redeclaration errors
- **Output escaping** - Added `wp_kses_post()` to tags list output in content template
- **Strict comparisons** - Changed loose comparisons to strict (`===`) in comment template

### Changed
- **Removed redundant ARIA roles** - Removed explicit roles from semantic HTML5 elements (`role="main"` on `<main>`, `role="navigation"` on `<nav>`, etc.) as they're implicit
- **WooCommerce hooks** - Moved hook modifications to `woocommerce_loaded` action for safer timing
- **WooCommerce conditionals** - Added `function_exists()` checks alongside `class_exists('WooCommerce')` for robustness

## [2.0.2] - 2026-01-18

### Fixed
- **Sidebar widget area IDs** - Prefixed IDs with `klaro-` (klaro-sidebar-1, klaro-footer-1) per WordPress.org requirements to avoid global namespace conflicts
- **Skip link focus style** - Replaced `outline: none` with proper outline using CSS variables for accessibility compliance
- **Two-column layout** - Added CSS grid layout for content area and sidebar to match screenshot design
- **Resource declarations** - Added Copyright & License section to readme.txt documenting bundled resources (screenshot, skip-link-focus-fix.js)

## [2.0.1] - 2026-01-05

### Fixed
- **WooCommerce compatibility check** - Added `class_exists('WooCommerce')` check to `klaro_woocommerce_product_thumbnail_alt()` function to prevent fatal error when WooCommerce is not installed

## [2.0.0] - 2025-12-25

### Added - WooCommerce Accessibility Support
- **Complete WooCommerce integration** with WCAG AAA compliance
- **Accessible shop pages** with ARIA landmarks and proper heading hierarchy
- **Accessible product templates** (archive-product.php, content-product.php)
- **Accessible cart template** with proper table structure, th scope, and captions
- **ARIA live regions** for cart updates, checkout errors, and notices
- **Quantity +/- buttons** with screen reader announcements
- **Keyboard navigation** for product tabs and gallery thumbnails
- **Accessible notice templates** (error.php, success.php, notice.php)
- **WooCommerce skip links** for shop, products, cart, and checkout pages
- **Shop Sidebar widget area** for WooCommerce pages
- **woocommerce.css** - Complete accessible styling for all WooCommerce elements
- **js/woocommerce-accessibility.js** - JavaScript accessibility enhancements

### Changed
- **44px minimum touch targets** on all WooCommerce buttons and controls
- **High contrast mode support** for all WooCommerce elements
- **Monochrome mode support** for WooCommerce styling
- **Responsive mobile cart** with stacked card layout
- Added `e-commerce` tag to theme

## [1.3.7] - 2025-12-25

### Fixed
- **Site description escaping** - Added esc_html() wrapper for security

### Changed
- **License format in readme.txt** - Updated to WordPress.org required format

### Removed
- **Custom admin settings page** - Not allowed in themes per WordPress.org guidelines
- **Plugin recommendation functionality** - Not allowed in themes per WordPress.org guidelines
- **inc/admin-accessibility.php** - Removed (plugin territory)
- **inc/recommended-plugins.php** - Removed (plugin territory)

## [1.3.6] - 2025-12-24

### Changed
- **High contrast mode visited link color** - Changed from bright pink to pleasant light blue for better user experience

## [1.3.5] - 2025-11-05

### Added
- **Block Styles Support** (functions.php)
  - Registered accessible button style with high contrast
  - Registered accessible quote style
  - Uses WordPress register_block_style() API
- **Block Patterns** (functions.php)
  - Accessible call-to-action pattern with high contrast
  - Featured in block pattern library
  - Uses large text and proper spacing
- **Custom Logo Support** (functions.php)
  - Added via add_theme_support('custom-logo')
  - Flexible dimensions (400x100 default, flexible height/width)
  - Available in Customizer under Site Identity
- **Custom Header Support** (functions.php)
  - Added via add_theme_support('custom-header')
  - Supports images and video headers
  - 1200x400 default size, flexible dimensions
  - Header text toggle option
- **Custom Background Support** (functions.php)
  - Added via add_theme_support('custom-background')
  - Supports both colors and images
  - Available in Customizer
- **Editor Styles** (editor-style.css)
  - Complete editor stylesheet matching front-end styles
  - Typography, colors, spacing consistent with theme
  - Includes all WordPress required classes
  - WYSIWYG editing experience
- **WordPress Required CSS Classes** (style.css)
  - .alignleft, .alignright, .aligncenter for image alignment
  - .wp-caption and .wp-caption-text for image captions
  - .gallery-caption for gallery images
  - .sticky for sticky posts with visual indicator
  - .bypostauthor for highlighting post author comments
  - All classes styled for accessibility

### Fixed
- **Translation Function Misuse** (functions.php lines 121-164)
  - Removed string concatenation from esc_html__() calls
  - Starter content now uses plain strings (not translated)
  - Fixes "multiple text domains" scanner warning
  - Fixes "incorrect number of arguments" errors
- **Plugin Territory Functionality** (functions.php)
  - Removed upload_mimes filter (lines 618-635)
  - Removed video caption requirement function
  - Themes should not modify file upload permissions

### Changed
- **Screenshot Optimization** (screenshot.png)
  - Compressed from 649KB to 82KB (87% reduction)
  - Reduced to 256 colors while maintaining quality
  - Still 1200x900 resolution as required
  - Faster download and better performance
- **Version Number**
  - Updated from 1.1.0 to 1.3.5
  - Major version bump for WordPress.org compliance features

### Added
- **CHILD-THEME-GUIDELINES.md** - Complete documentation on child theme handling
  - WordPress.org child theme submission rules
  - What can and cannot be included
  - Best practices for child theme support
  - Packaging instructions that exclude child theme
- **THEME-CHECK-ALTERNATIVES.md** - Guide for testing without Theme Check plugin
  - Alternative testing methods
  - Manual checklist
  - Command-line tools (PHPCS with WordPress standards)
  - Theme Sniffer plugin recommendation
- **UI-IMPROVEMENTS-SUMMARY.md** - Complete documentation of UI changes
- **Default Site Branding** (functions.php)
  - Default Site Title: "Klaro" (shown if WordPress default is present)
  - Default Tagline: "Accessibility First" (shown if WordPress default is present)
  - Default Site Icon: Blue "K" logo (512x512px, included in starter content)
  - Users can easily change these in Settings > General
  - Makes fresh installations look professional immediately
- **Default Site Icon** (assets/icon-512x512.png)
  - 512x512px blue icon with white "K" letter
  - Automatically added via starter content
  - WordPress generates all required sizes (32px, 180px, 192px, 270px)

### Fixed
- **Search button text wrapping on mobile** (searchform.php, style.css)
  - Added white-space: nowrap to button and text span
  - Changed button display to inline-block for better text flow
  - Reduced font size progressively: 0.875rem under 600px, 0.8rem under 400px
  - Reduced padding on mobile for more compact button
  - Fully accessible with proper ARIA labels
  - Maintains 44px minimum touch target

### Changed
- **Accessibility Toolbar Redesign** (header.php, style.css)
  - Moved from full-width below logo to compact top-right position
  - Implemented collapsible <details>/<summary> design
  - Saves significant header space (was 3 full-width sections, now 1 compact button)
  - Dropdown menu appears on click/tap
  - Shortened button labels ("High" instead of "High Contrast", etc.)
  - Added WordPress dashicons-universal-access-alt icon as visual indicator (24x24px)
  - Clean icon with no border or background
  - Uses WordPress standard icon font
  - Button has black background, inverts on hover
  - Position: absolute dropdown from top-right
  - Mobile-responsive: full-width on small screens
  - All functionality maintained, just more compact
- **Border Styles Modernized** (style.css)
  - All borders changed from 2px to 1px thickness
  - Added 8px border-radius to all bordered elements
  - Affects: navigation links, buttons, forms, widgets, comments, pagination
  - More modern, softer appearance
  - Better visual consistency
- **Header Layout Restructured** (header.php, style.css)
  - New .header-top container with flexbox layout
  - Logo/branding on left, accessibility toolbar on right
  - Justify-space-between for proper spacing
  - Navigation menu below header-top (full width)
  - Improved visual hierarchy
- **README.md** - Expanded child theme documentation
  - Added detailed child theme creation instructions
  - Included complete code examples for style.css and functions.php
  - Added best practices section
  - Clarified that child themes are not bundled with parent
- **WORDPRESS-ORG-CHECKLIST.md** - Updated packaging instructions
  - Added explicit exclusion of child theme folder
  - Updated file removal list
  - Added verification steps to ensure child theme not included
  - Added critical note about WordPress.org one-theme-per-submission rule

## [1.1.0] - 2025-11-04

### Added
- **WordPress Starter Content API integration** - Provides optional pre-created content on fresh installs
  - "About Klaro" page with theme description
  - "Accessibility Statement" page with comprehensive accessibility information
  - Primary Navigation menu with Home, About, and Accessibility Statement links
  - Default sidebar widgets (Search, Recent Posts, Recent Comments, Categories)
  - User must explicitly approve importing starter content in Customizer
- **Plugin Recommendations System** (inc/recommended-plugins.php)
  - Dismissible admin notice suggesting optional accessibility plugins
  - Dedicated "Appearance > Recommended Plugins" page with plugin cards
  - Recommends: Classic Editor, WP Accessibility, Accessibility Checker
  - Clear messaging that all plugins are optional
  - AJAX-powered notice dismissal
- **archive.php template** - Proper template for category, tag, and author archives
  - Breadcrumb navigation integration
  - Accessible pagination with screen reader text
  - Proper ARIA labels and semantic HTML
- **search.php template** - Dedicated search results page
  - Search result count display with role="status"
  - Helpful "no results" page with search form and navigation links
  - Accessible pagination
- **template-parts/content-search.php** - Search result item template
  - Optimized excerpt display
  - Proper metadata for posts
  - Accessible "Read More" links with context
- **readme.txt** - WordPress.org standard format
  - Complete theme description and features
  - Installation instructions
  - FAQ section
  - Changelog
  - Credits and resources
- **screenshot.png** - 1200x900px placeholder image
  - Includes instructions text
  - Proper dimensions for WordPress.org
- **SCREENSHOT-INSTRUCTIONS.txt** - Detailed guide for creating proper theme screenshot
  - Multiple methods (browser tools, WordPress Customizer, online tools)
  - Requirements and best practices
  - What to show and what to avoid
- **WORDPRESS-ORG-CHECKLIST.md** - Complete submission preparation guide
  - Required files checklist
  - Step-by-step testing procedures
  - Theme Check plugin instructions
  - Packaging guidelines
  - Common rejection reasons to avoid
- **WORDPRESS-ORG-GUIDELINES.md** - Detailed explanation of WordPress.org compliance
  - Starter content implementation details
  - Plugin recommendation best practices
  - What themes can and cannot do
  - Testing procedures
- **NEW-FEATURES-SUMMARY.md** - Quick reference for new features
- **DEVELOPMENT-STATUS.md** - Complete project status document
- **CHANGELOG.md** - This file, tracking all version changes

### Fixed
- **Skip links CSS displaying bullet points** (style.css lines 141-174)
  - Added `.skip-links ul` and `.skip-links li` selectors
  - Set `list-style: none` and proper margins/padding
  - Skip links now properly hidden until focused
  - Issue: Default list styles were showing through nested ul/li structure
  - Impact: Visual accessibility improved, cleaner header appearance

### Changed
- **Version standardization throughout theme**
  - Updated THEME-SUMMARY.txt to reflect current version
  - Ensured consistency between style.css, readme.txt, and documentation
  - Clarified version numbering for WordPress.org submission

## [1.0.0] - 2025-11-03

### Added - Front-End Accessibility Features
- **WCAG AAA compliance** (7:1 minimum contrast ratios)
- **Comprehensive skip links system**
  - Skip to navigation
  - Skip to main content
  - Skip to sidebar
  - Skip to footer
  - Highly visible on focus with orange background
- **Accessibility toolbar in header**
  - Text size controls (A-, A, A+)
  - High contrast mode toggle
  - Monochrome mode toggle
  - Reduce motion toggle
  - Settings persist in localStorage
  - Screen reader announcements for changes
- **Three text size modes**
  - Normal (18px base)
  - Large (24px base)
  - Extra Large (32px base)
- **Three color contrast modes**
  - Standard AAA (7:1 contrast)
  - High Contrast (black/white with 21:1)
  - Monochrome (grayscale only)
- **Enhanced focus indicators**
  - 3px thick orange outline
  - 2px offset for clarity
  - Visible on all interactive elements
  - :focus-visible support for mouse vs keyboard
- **Keyboard navigation optimizations**
  - Tab/Shift+Tab for navigation
  - Enter/Space for activation
  - Escape key support for modals
  - Focus trap implementation for dialogs
  - Keyboard usage detection with .keyboard-nav class
- **Screen reader optimizations**
  - Semantic HTML5 structure
  - Comprehensive ARIA landmarks (banner, navigation, main, complementary, contentinfo)
  - ARIA labels on all regions
  - ARIA live regions for dynamic content updates
  - Proper heading hierarchy
  - Meaningful link text enforcement
  - Form labels with instructions
- **Motion control**
  - Respects prefers-reduced-motion media query
  - User toggle for animations
  - Instant transitions when animations disabled
  - No autoplay on any media
- **Breadcrumb navigation** (functions.php lines 250-343)
  - Schema.org structured data
  - Proper hierarchy for pages and posts
  - ARIA labels
  - Automatic generation on all pages except homepage
- **Alt text enforcement** (functions.php lines 157-191)
  - Prevents publishing posts with images missing alt text
  - Admin notice when alt text is missing
  - Visual warning (red border) in development
  - Post automatically saved as draft if alt text missing

### Added - Admin Accessibility Features
- **Admin accessibility settings page** (inc/admin-accessibility.php)
  - Located at Appearance > Admin Accessibility
  - Comprehensive help tabs
  - Settings saved per-user
- **Disable Gutenberg option**
  - Enables Classic Editor for screen reader users
  - Gutenberg notoriously difficult for blind users
  - Classic Editor is linear, predictable, and accessible
- **High contrast admin mode**
  - Black background, white text
  - 7:1 contrast ratios
  - Improved button visibility
- **Large admin text option**
  - Increases base font size to 18px throughout admin
  - Larger form fields and buttons
  - Better for low vision users
- **Disable admin animations**
  - Removes all transitions and animations
  - Helps users with vestibular disorders
  - Reduces cognitive load
- **Enhanced focus indicators in admin**
  - Enabled by default
  - 3px orange outline
  - High visibility for keyboard navigation
- **ARIA landmarks in admin**
  - Added to admin wrapper and content areas
  - Helps screen readers navigate WordPress admin
- **Simplified admin menu option**
  - Reduces cognitive load
  - Hides less-used menu items
  - Cleaner interface
- **Admin toolbar accessibility shortcut**
  - Quick access to accessibility settings
  - Shows on front-end admin bar
- **Dashboard widget**
  - Quick settings overview
  - Direct links to accessibility options

### Added - Core Theme Files
- **style.css** - Complete accessible styling system
  - CSS custom properties for easy customization
  - No animations by default
  - Generous spacing (1.8 line height)
  - Large touch targets (44x44px minimum)
  - Mobile-first responsive design
- **functions.php** - Core theme functionality
  - Theme setup and features
  - Widget areas registration
  - Script and style enqueuing
  - Custom excerpt handling
  - Navigation enhancements
  - Customizer options
  - Breadcrumb function
  - Alt text validation
- **header.php** - Semantic header with skip links and toolbar
- **footer.php** - Semantic footer with proper ARIA
- **index.php** - Main blog template
- **single.php** - Single post template
- **page.php** - Page template
- **404.php** - Error page template
- **sidebar.php** - Accessible sidebar with ARIA
- **comments.php** - Accessible comments system
- **searchform.php** - Accessible search form
- **template-parts/content.php** - Post content template
- **template-parts/content-none.php** - No content found template
- **js/accessibility.js** - Front-end accessibility enhancements
  - Font size controls
  - Contrast mode toggles
  - Animation controls
  - Focus management
  - External link handling
  - Image alt text validation
  - Live region management
- **js/skip-link-focus-fix.js** - IE11 skip link focus fix
- **inc/admin-accessibility.php** - Admin accessibility features

### Added - Documentation
- **README.md** - Comprehensive theme documentation
  - Installation instructions
  - Feature descriptions
  - Content guidelines
  - Customization options
  - Browser support
  - Testing recommendations
- **ADMIN-ACCESSIBILITY.md** - Admin accessibility features guide
- **THEME-SUMMARY.txt** - Quick overview and feature list
- **QUICK-REFERENCE.md** - Fast reference guide
- **INSTALL.md** - Setup instructions
- **START-HERE.txt** - Getting started guide

### Theme Support Features
- **Automatic feed links**
- **Title tag management**
- **Post thumbnails**
- **Two navigation menus** (primary and footer)
- **HTML5 markup** for search forms, comments, galleries, captions
- **Selective refresh for widgets**
- **Block styles**
- **Wide and full alignment** support
- **Responsive embeds**
- **Custom line height**
- **Custom spacing**
- **Custom units**
- **Two widget areas** (Primary Sidebar and Footer Widgets)

### Customizer Options
- **Base font size** (14-36px, default 18px)
- **Line height** (1.2-3.0, default 1.8)
- **Contrast mode** (Standard AAA, High Contrast, Monochrome)
- **Real-time preview** with postMessage transport

### Accessibility Standards Met
- ✅ WCAG 2.1 Level AAA compliance
- ✅ Section 508 compliance
- ✅ ARIA 1.2 specifications
- ✅ Keyboard navigation (all features)
- ✅ Screen reader compatibility (NVDA, JAWS, VoiceOver)
- ✅ Color contrast (7:1 minimum)
- ✅ Focus indicators (3px visible)
- ✅ Touch targets (44x44px minimum)
- ✅ Semantic HTML5
- ✅ No motion by default
- ✅ Text spacing adjustable
- ✅ Zoom support (up to 200%)

### Browser Support
- Chrome/Edge (last 2 versions) - Full support
- Firefox (last 2 versions) - Full support
- Safari (last 2 versions) - Full support
- Opera (last 2 versions) - Full support
- Internet Explorer 11 - Partial support with graceful degradation

---

## Version History Summary

- **1.1.0** (2025-11-04) - WordPress.org preparation, starter content, plugin recommendations
- **1.0.0** (2025-11-03) - Initial release with comprehensive accessibility features

---

## Upgrade Notes

### 1.0.0 → 1.1.0

**New Features:**
- Starter content will be offered on fresh installations
- Plugin recommendation notice will appear on first activation
- No breaking changes
- All existing features continue to work identically

**Action Required:**
- None - all changes are additive
- Optional: Visit Appearance > Recommended Plugins to see suggestions
- Optional: Reset site and re-activate theme to test starter content

---

## Semantic Versioning Guide

This theme follows [Semantic Versioning](https://semver.org/):

- **MAJOR version** (X.0.0) - Incompatible changes, breaking changes
- **MINOR version** (1.X.0) - New features, backwards-compatible
- **PATCH version** (1.0.X) - Bug fixes, backwards-compatible

### Examples:
- **2.0.0** - Would require PHP 8.0 (breaking change)
- **1.2.0** - Adds new template files (new feature)
- **1.1.1** - Fixes a CSS bug (bug fix)

---

## Contributing

When making changes:
1. Update this CHANGELOG.md with your changes
2. Use appropriate categories: Added, Changed, Deprecated, Removed, Fixed, Security
3. Update version number following semantic versioning
4. Update style.css, readme.txt, and THEME-SUMMARY.txt with new version

---

## Links

- [WordPress.org Theme Directory](https://wordpress.org/themes/)
- [Theme Repository](https://github.com/yourusername/klaro)
- [Report Issues](https://github.com/yourusername/klaro/issues)
- [WCAG Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [WebAIM Resources](https://webaim.org/)

---

**Made with ♿ for everyone**
