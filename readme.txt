=== Klaro ===

Contributors: rafaelminuesa
Author: Rafael Minuesa
Author URI: https://github.com/rafael-minuesa
Tags: accessibility-ready, one-column, two-columns, custom-colors, custom-menu, featured-images, threaded-comments, translation-ready, block-styles, wide-blocks, e-commerce
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 2.6.0
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

Klaro is an uncompromisingly accessible WordPress theme with WCAG AAA color contrast, designed so users with disabilities can browse and shop independently.

== Description ==

Klaro is a WordPress theme built from the ground up with accessibility as the primary focus, not an afterthought. While most themes add accessibility features after design, Klaro starts with WCAG AAA color contrast and builds everything around that foundation.

= Accessibility for Everyone =

**Browse Content** - Users with visual, motor, or cognitive disabilities can easily navigate your website with high contrast modes, adjustable text sizes (5 levels from 18px to 32px), keyboard navigation, and screen reader optimization.

**Shop Independently** - Full WooCommerce accessibility support enables users with disabilities to browse products, add items to cart, complete checkout, and track orders without barriers. All shop elements meet WCAG AAA contrast standards with proper ARIA labels and keyboard navigation.

**Manage Independently** - The free companion plugin, Klaro Admin Accessibility, extends accessibility to the WordPress admin with high contrast mode, large text, enhanced focus indicators, reduced motion, a simplified menu, and a classic editor toggle. Find it in the plugin directory at https://wordpress.org/plugins/klaro-admin-accessibility/

= Key Features =

* WCAG AAA Contrast Ratios (7:1 minimum for all text)
* Full keyboard navigation with highly visible focus indicators
* Comprehensive ARIA implementation for screen readers
* User-adjustable text sizes (18px base, up to 32px)
* Multiple color modes (standard, high contrast, monochrome)
* Skip links to all major page sections
* Alt text visual indicator for images missing alt text
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

Yes! Klaro includes full WooCommerce accessibility support with WCAG AAA color contrast on shop pages, accessible cart and checkout, screen reader announcements for cart updates, keyboard-navigable product galleries, and 44px minimum touch targets on all interactive elements.

== Accessibility ==

Klaro meets WCAG 2.2 AA standards and includes features that often exceed AA requirements. Key implementations:

* Visible skip links as first focusable element
* Strong focus indicators (3px outline, :focus-visible)
* Underlined links in content
* High contrast (tested toward 7:1), monochrome, and text size modes
* Semantic HTML, proper ARIA, keyboard operable navigation
* Tested with NVDA, JAWS, VoiceOver, ORCA

== Changelog ==

= 2.6.0 =
* Added a dyslexia-friendly font toggle to the accessibility toolbar, using the bundled OpenDyslexic typeface (SIL Open Font License 1.1); the font files are only downloaded while the mode is active

= 2.5.0 =
* Added color vision filters to the accessibility toolbar: assistive daltonization for protanopia (red-blindness), deuteranopia (green-blindness), and tritanopia (blue-blindness) that shifts imperceptible color information into a visible range rather than simulating the deficiency

= 2.4.0 =
* Added Dark mode: a softer dark color scheme alongside High Contrast and Monochrome, available in the accessibility toolbar and as a Customizer contrast mode (WCAG AAA verified)
* Fixed the Customizer contrast mode setting producing body classes that matched no stylesheet selector, so the site-wide setting never applied

= 2.3.3 =
* Fixed posts pagination layout: page number links now sit in a row instead of stacking as full-width blocks
* Fixed a spurious nested box drawn around the "Next" pagination link

= 2.3.2 =
* Removed the landmark type word from the remaining landmark accessible names (posts pagination, post navigation, comments navigation, main content, search form)
* Removed nested navigation landmarks around archive and search pagination
* Accessibility toolbar control names now start with their visible text (Label in Name)
* Search results "Read More" links now append the post title as screen reader text instead of overriding the visible text with an aria-label
* Removed a screen-reader-only heading that rendered before the page H1
* External links are no longer forced to open in a new window; author-set new-window links get a visible indicator and translatable screen reader text
* Removed redundant role="region" from widget wrappers
* The "Skip to sidebar" link only renders when the sidebar exists, and all skip link targets now receive keyboard focus reliably (tabindex="-1")
* Quantity and add-to-cart controls use min-height so the largest text size never clips them
* Product gallery thumbnails are real buttons instead of clickable images
* All WooCommerce screen reader announcements are now translatable
* Error and success message colors follow the high contrast and monochrome modes
* Editor styles aligned with the theme color tokens
* Updated theme description

= 2.3.1 =
* Tested up to WordPress 7.0

= 2.3.0 =
* Updated to meet the 2026 WordPress.org accessibility-ready requirements
* Removed the word "navigation" from navigation landmark labels (Primary, Footer, Shop, Pages)
* Darkened the focus indicator and accent color to #C2410C so focus outlines and the skip link meet color contrast requirements
* Added explicit skip link colors so visited/hover states keep sufficient contrast
* Rebuilt navigation submenus as button-controlled disclosures with correct aria-expanded state; submenu items are now reachable with Shift + Tab and close with the Escape key
* Accessibility toolbar popup now closes with the Escape key and announces its open/closed state dynamically
* Added accessibility.txt accessibility statement following the WordPress standard
* Canonicalized the screen reader text class
* Disabled WordPress core and remote block patterns that fail color contrast requirements

= 2.1.0 =
* Escaped output in searchform.php, search.php, header.php, and content templates for security
* Fixed horizontal scrollbar on mobile screens
* Unified breadcrumbs across all pages including WooCommerce shop
* Added WooCommerce Blocks cart/checkout accessibility styles
* Accessible quantity selector with flex layout and 44px touch targets
* My Account navigation and buttons restyled to match primary navigation
* High contrast visited link color changed to light purple for better distinction from unvisited links
* Fixed quantity input padding causing number cutoff

= 2.0.8 =
* Added 5-level text size adjustment (18px, 20px, 22px, 26px, 32px) for finer control
* Improved accessibility toolbar UI with refined padding and font sizes
* Enhanced theme description highlighting WooCommerce accessibility for shopping and store management

= 2.0.7 =
* Removed site title/tagline override (now managed via WordPress Settings)
* Removed sample pages from starter content
* Removed alt text publishing enforcement (plugin territory)
* Made accessibility statement footer link user-configurable via Customizer
* Removed unnecessary files and commented code
* Updated Tested up to WordPress 6.9
* Fixed header/main spacing and submenu padding
* Added consistent site title styling across all pages
* Fixed WooCommerce breadcrumbs placement

= 2.0.6 =
* Fixed shop product grid widths by removing legacy floats/width constraints
* Moved WooCommerce product tab padding to list items for consistent hit areas
* Removed duplicate product link wrappers to prevent malformed markup

= 2.0.3 =
* Fixed PHP 8.x compatibility issue in comment form (missing $commenter variable)
* Fixed search form accessibility with consistent IDs for label/input/aria-describedby
* Fixed security issue with unsanitized $_GET parameter
* Moved comment callback function to functions.php to prevent redeclaration errors
* Added proper escaping to tags list output
* Removed redundant ARIA roles from semantic HTML5 elements
* Improved WooCommerce hook timing and conditional checks

= 2.0.2 =
* Fixed sidebar widget area IDs to use prefixed names (klaro-sidebar-1, klaro-footer-1) per WordPress.org requirements
* Fixed skip-link:focus to use proper outline instead of outline:none for accessibility compliance
* Added two-column grid layout for content and sidebar to match screenshot
* Added Copyright & License declarations for bundled resources in readme.txt

= 2.0.0 =
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
* Alt text visual indicator for images missing alt text
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

= Fonts =
OpenDyslexic (fonts/OpenDyslexic-*.woff2) by Abbie Gonzalez, licensed under the SIL Open Font License 1.1. The license text is bundled at fonts/OFL.txt.
https://opendyslexic.org/
https://github.com/antijingoist/opendyslexic

= Screenshot =
The screenshot.png is created by the theme author and licensed under GPL-2.0-or-later.

= JavaScript =
skip-link-focus-fix.js is based on code from Underscores (_s) theme by Automattic, licensed under GPL-2.0-or-later.
https://github.com/Automattic/_s

= Icons =
The accessibility icon uses the Unicode universal access symbol.

= External Links =
* Theme documentation: https://github.com/rafael-minuesa/klaro
* Report issues: https://github.com/rafael-minuesa/klaro/issues
* WebAIM: https://webaim.org
* WCAG Guidelines: https://www.w3.org/WAI/WCAG21/quickref/
