=== Klaro ===

Contributors: rafaelminuesa
Author: Rafael Minuesa
Author URI: https://github.com/rafael-minuesa
Tags: accessibility-ready, one-column, two-columns, custom-colors, custom-menu, featured-images, threaded-comments, translation-ready, block-styles, wide-blocks, e-commerce
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.4.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Klaro WordPress Theme, Copyright 2025 Rafael Minuesa.
Klaro is free software: you can redistribute it and/or modify it
under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Klaro is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License
for more details.

You should have received a copy of the GNU General Public License
along with Klaro. If not, see http://www.gnu.org/licenses/gpl-2.0.html.

Klaro is an uncompromisingly accessible WordPress theme that prioritizes users with disabilities above all else.

== Description ==

Klaro (Spanish/Portuguese for "clear/bright") is a WordPress theme built from the ground up with accessibility as the primary focus, not an afterthought. While most themes add accessibility features after design, Klaro starts with WCAG AAA compliance and builds everything around that foundation.

= Key Features =

* WCAG AAA Contrast Ratios (7:1 minimum for all text)
* Full keyboard navigation with highly visible focus indicators
* Comprehensive ARIA implementation for screen readers
* User-adjustable text sizes (18px base, up to 32px)
* Multiple color modes (standard, high contrast, monochrome)
* Skip links to all major page sections
* Alt text enforcement (prevents publishing without alt text)
* Breadcrumb navigation on all pages
* No autoplay on any media
* Respects prefers-reduced-motion
* WooCommerce accessibility support

= Visual Accessibility =

* 18px base font size (larger than typical)
* 1.8 line height for generous spacing
* Maximum line length of 70 characters
* High contrast mode and monochrome mode
* Flexible typography system

= Keyboard & Motor Accessibility =

* Every feature accessible via keyboard
* 3px thick, high-contrast focus indicators
* Minimum 44x44px touch targets
* Generous spacing between interactive elements

= Screen Reader Optimization =

* Semantic HTML5 structure
* Proper heading hierarchy
* Meaningful link text
* Comprehensive form labels
* Live regions for dynamic content

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload Theme and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

== Frequently Asked Questions ==

= Why is the base font size so large? =

18px ensures readability for users with visual impairments. Users can adjust the size using the accessibility toolbar if needed.

= Does this theme work with Gutenberg? =

Yes. For blind users and screen reader users who prefer the Classic Editor, the Classic Editor plugin can be installed separately from the WordPress plugin repository.

= Can I use custom fonts? =

Yes, but ensure they're legible and maintain WCAG AAA contrast ratios. System fonts are recommended for optimal accessibility.

= Why no autoplay videos? =

Autoplay creates accessibility and usability issues. Users should control when media plays.

= Does this work with page builders? =

It works with block-based builders, but visual drag-and-drop builders may conflict with accessibility features.

= Does this theme work with WooCommerce? =

Yes! Klaro includes full WooCommerce accessibility support with WCAG AAA compliant shop pages, accessible cart and checkout, screen reader announcements for cart updates, keyboard-navigable product galleries, and 44px minimum touch targets on all interactive elements.

== Changelog ==

= 1.4.0 =
* Added WooCommerce accessibility support
* Added accessible product archive and single product templates
* Added accessible cart template with proper table structure
* Added ARIA live regions for cart and checkout updates
* Added quantity +/- buttons with screen reader announcements
* Added keyboard navigation for product tabs and gallery
* Added accessible notice templates (error, success, info)
* Added WooCommerce skip links for shop, cart, and checkout pages
* Added high contrast and monochrome mode support for WooCommerce
* Added 44px minimum touch targets on all WooCommerce buttons
* Added Shop Sidebar widget area

= 1.3.7 =
* Fixed site description escaping with esc_html() for security
* Added proper license format to readme.txt
* Removed custom admin settings page (not allowed in themes per WordPress.org guidelines)
* Removed plugin recommendation functionality (not allowed in themes per WordPress.org guidelines)
* Updated documentation to reflect changes

= 1.3.6 =
* Improved high contrast mode visited link color (changed from bright pink to pleasant light blue for better user experience)

= 1.3.5 =
* Added block styles support (register_block_style)
* Added block patterns support (accessible call-to-action pattern)
* Added custom logo support (Customizer option)
* Added custom header support (image or video headers)
* Added custom background support (colors and images)
* Added editor styles (editor-style.css) for WYSIWYG experience
* Added all WordPress required CSS classes (.wp-caption, .wp-caption-text, .sticky, .gallery-caption, .bypostauthor, .alignright, .alignleft, .aligncenter)
* Fixed translation function misuse (removed string concatenation)
* Removed plugin-territory functionality (upload_mimes filter)
* Optimized screenshot.png from 649KB to 82KB
* All WordPress.org recommended features now implemented

= 1.1.0 =
* Added WordPress Starter Content (optional pre-created pages and menu)
* Added archive.php template for category/tag/author archives
* Added search.php template with accessible search results
* Fixed skip links displaying bullet points in header
* Created WordPress.org submission documentation
* Created comprehensive CHANGELOG.md
* Updated and standardized all documentation

= 1.0.0 =
* Initial release
* WCAG AAA compliance (7:1 contrast ratios)
* Full keyboard navigation with visible focus indicators
* Screen reader optimization with ARIA landmarks
* User-adjustable text sizes (18px, 24px, 32px)
* Multiple contrast modes (Standard, High Contrast, Monochrome)
* Breadcrumb navigation with Schema.org markup
* Comprehensive skip links system
* Alt text enforcement (prevents publishing without alt text)
* Accessibility toolbar in header
* Reduce motion support

== Upgrade Notice ==

= 1.3.5 =
Major update with WordPress.org recommended features. Adds block styles, block patterns, custom logo/header/background, editor styles, and all required CSS classes. Fully backwards compatible.

= 1.1.0 =
Adds optional starter content and additional templates. All changes are backwards-compatible.

= 1.0.0 =
Initial release of Klaro accessibility-first theme.

== Credits ==

* Based on WordPress starter themes best practices
* Accessibility guidelines from WebAIM and W3C
* Tested with NVDA, JAWS, and VoiceOver

== Resources ==

* Theme documentation: https://github.com/rafael-minuesa/klaro
* Report issues: https://github.com/rafael-minuesa/klaro/issues
* WebAIM: https://webaim.org
* WCAG Guidelines: https://www.w3.org/WAI/WCAG21/quickref/
