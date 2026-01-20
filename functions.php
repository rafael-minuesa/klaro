<?php
/**
 * Klaro Theme Functions
 * 
 * Uncompromisingly accessible WordPress theme
 *
 * @package Klaro
 * @since 1.0.0
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Set default site title if not set
 */
function klaro_default_site_title( $option ) {
    if ( empty( $option ) || $option === 'WordPress' ) {
        return 'Klaro';
    }
    return $option;
}
add_filter( 'pre_option_blogname', 'klaro_default_site_title' );

/**
 * Set default site tagline if not set
 */
function klaro_default_site_tagline( $option ) {
    if ( empty( $option ) || $option === 'Just another WordPress site' ) {
        return 'Accessibility First';
    }
    return $option;
}
add_filter( 'pre_option_blogdescription', 'klaro_default_site_tagline' );

/**
 * Theme Setup
 */
function klaro_setup() {
    // Make theme available for translation
    load_theme_textdomain( 'klaro', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails
    add_theme_support( 'post-thumbnails' );

    // Register navigation menus
    register_nav_menus( array(
        'primary' => esc_html__( 'Primary Navigation', 'klaro' ),
        'footer'  => esc_html__( 'Footer Navigation', 'klaro' ),
    ) );

    // Switch default core markup to output valid HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add theme support for selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for Block Styles
    add_theme_support( 'wp-block-styles' );

    // Add support for full and wide align images
    add_theme_support( 'align-wide' );

    // Add support for responsive embedded content
    add_theme_support( 'responsive-embeds' );

    // Add support for custom line height
    add_theme_support( 'custom-line-height' );

    // Add support for custom spacing
    add_theme_support( 'custom-spacing' );

    // Add support for custom units
    add_theme_support( 'custom-units' );

    // Add support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Add support for custom header
    add_theme_support( 'custom-header', array(
        'default-image'      => '',
        'width'              => 1200,
        'height'             => 400,
        'flex-height'        => true,
        'flex-width'         => true,
        'header-text'        => true,
        'default-text-color' => '1a1a1a',
    ) );

    // Add support for custom background
    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff',
    ) );

    // Add editor styles
    add_editor_style( 'editor-style.css' );

    // Add theme starter content
    add_theme_support( 'starter-content', array(
        // Create navigation menu
        'nav_menus' => array(
            'primary' => array(
                'name'  => esc_html__( 'Primary Navigation', 'klaro' ),
                'items' => array(
                    'link_home',
                    'page_about',
                    'page_accessibility',
                ),
            ),
        ),

        // Create sample pages
        'posts' => array(
            'home',
            'about' => array(
                'post_title'   => esc_html__( 'About Klaro', 'klaro' ),
                'post_content' => 'Klaro is an accessibility-first WordPress theme that prioritizes users with disabilities. Built with WCAG AAA compliance from the ground up, Klaro ensures your website is usable by everyone, regardless of their abilities.

Key features include high-contrast modes, adjustable text sizes, comprehensive keyboard navigation, and screen reader optimization. Every element has been carefully designed with accessibility in mind.

The name "Klaro" comes from Spanish and Portuguese, meaning "clear" or "bright" - reflecting our commitment to clarity and accessibility in web design.',
            ),
            'accessibility' => array(
                'post_title'   => esc_html__( 'Accessibility Statement', 'klaro' ),
                'post_content' => 'This website is designed to be accessible to all users, including those with disabilities. We are committed to providing an inclusive digital experience.

<h2>Accessibility Features</h2>
<ul>
<li>WCAG AAA compliance (Level 7:1 contrast ratios)</li>
<li>Full keyboard navigation support</li>
<li>Screen reader optimization with ARIA landmarks</li>
<li>Adjustable text sizes (use the A-/A/A+ buttons in the header)</li>
<li>High contrast and monochrome display modes</li>
<li>Reduced motion option for users with vestibular disorders</li>
<li>Skip links for easier navigation</li>
<li>All images include descriptive alt text</li>
<li>Clear, descriptive link text</li>
<li>No autoplay on videos or audio</li>
</ul>

<h2>Keyboard Shortcuts</h2>
<ul>
<li>Tab - Navigate forward through interactive elements</li>
<li>Shift + Tab - Navigate backward</li>
<li>Enter/Space - Activate buttons and links</li>
<li>Arrow keys - Navigate through menus</li>
</ul>

<h2>Testing</h2>
This website has been tested with:
<ul>
<li>NVDA (NonVisual Desktop Access) screen reader</li>
<li>JAWS screen reader</li>
<li>VoiceOver on macOS and iOS</li>
<li>WAVE accessibility evaluation tool</li>
<li>axe DevTools</li>
</ul>

<h2>Feedback</h2>
We are continually working to improve accessibility. If you encounter any accessibility barriers, please contact us and we will work to resolve the issue.',
            ),
        ),

        // Set the homepage and site identity
        'options' => array(
            'show_on_front'  => 'posts',
            'blogname'       => 'Klaro',
            'blogdescription' => 'Accessibility First',
        ),

        // Attachments (for site icon)
        'attachments' => array(
            'klaro-icon' => array(
                'post_title' => esc_html_x( 'Klaro Site Icon', 'Theme starter content', 'klaro' ),
                'file'       => 'assets/icon-512x512.png',
            ),
        ),

        // Set site icon using the attachment
        'theme_mods' => array(
            'site_icon' => '{{klaro-icon}}',
        ),

        // Add widgets to sidebar
        'widgets' => array(
            'klaro-sidebar-1' => array(
                'search',
                'recent-posts',
                'recent-comments',
                'categories',
            ),
        ),
    ) );
}
add_action( 'after_setup_theme', 'klaro_setup' );

/**
 * Set content width
 */
function klaro_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'klaro_content_width', 1400 );
}
add_action( 'after_setup_theme', 'klaro_content_width', 0 );

/**
 * Register block styles
 */
function klaro_register_block_styles() {
    // Accessible button style
    register_block_style(
        'core/button',
        array(
            'name'  => 'klaro-accessible',
            'label' => esc_html__( 'Accessible High Contrast', 'klaro' ),
        )
    );

    // High contrast quote
    register_block_style(
        'core/quote',
        array(
            'name'  => 'klaro-accessible',
            'label' => esc_html__( 'Accessible High Contrast', 'klaro' ),
        )
    );
}
add_action( 'init', 'klaro_register_block_styles' );

/**
 * Register block patterns
 */
function klaro_register_block_patterns() {
    // Accessible call-to-action pattern
    register_block_pattern(
        'klaro/accessible-cta',
        array(
            'title'       => esc_html__( 'Accessible Call to Action', 'klaro' ),
            'description' => esc_html_x( 'A call-to-action section with high contrast and large text', 'Block pattern description', 'klaro' ),
            'content'     => '<!-- wp:group {"style":{"spacing":{"padding":{"top":"3rem","right":"2rem","bottom":"3rem","left":"2rem"}}},"backgroundColor":"contrast","textColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-base-color has-contrast-background-color has-text-color has-background" style="padding-top:3rem;padding-right:2rem;padding-bottom:3rem;padding-left:2rem">
<!-- wp:heading {"textAlign":"center","level":2,"fontSize":"large"} -->
<h2 class="has-text-align-center has-large-font-size">' . esc_html__( 'Get Started Today', 'klaro' ) . '</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","fontSize":"medium"} -->
<p class="has-text-align-center has-medium-font-size">' . esc_html__( 'Join thousands of users who trust our accessible platform.', 'klaro' ) . '</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button {"fontSize":"medium"} -->
<div class="wp-block-button has-custom-font-size has-medium-font-size"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Learn More', 'klaro' ) . '</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->',
            'categories'  => array( 'featured', 'call-to-action' ),
        )
    );
}
add_action( 'init', 'klaro_register_block_patterns' );

/**
 * Register Widget Areas
 */
function klaro_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Primary Sidebar', 'klaro' ),
        'id'            => 'klaro-sidebar-1',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'klaro' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s" role="region" aria-labelledby="%1$s-title">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 id="%1$s-title" class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widgets', 'klaro' ),
        'id'            => 'klaro-footer-1',
        'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'klaro' ),
        'before_widget' => '<section id="%1$s" class="footer-widget widget %2$s" role="region" aria-labelledby="%1$s-title">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 id="%1$s-title" class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'klaro_widgets_init' );

/**
 * Enqueue Scripts and Styles
 */
function klaro_scripts() {
    // Dashicons for accessibility icon
    wp_enqueue_style( 'dashicons' );

    // Main stylesheet
    wp_enqueue_style( 'klaro-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Accessibility enhancements script
    wp_enqueue_script( 'klaro-accessibility', get_template_directory_uri() . '/js/accessibility.js', array(), '1.0.0', true );

    // Skip link focus fix for IE11
    wp_enqueue_script( 'klaro-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '1.0.0', true );

    // Comments reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // Localize script for accessibility settings
    wp_localize_script( 'klaro-accessibility', 'klaroSettings', array(
        'fontSizeLabel' => esc_html__( 'Text Size', 'klaro' ),
        'contrastLabel' => esc_html__( 'Contrast Mode', 'klaro' ),
        'saved'         => esc_html__( 'Settings saved', 'klaro' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'klaro_scripts' );

/**
 * Add skip links
 */
function klaro_skip_links() {
    ?>
    <nav class="skip-links" aria-label="<?php esc_attr_e( 'Skip links', 'klaro' ); ?>">
        <ul>
            <li><a href="#primary-navigation" class="skip-link"><?php esc_html_e( 'Skip to navigation', 'klaro' ); ?></a></li>
            <li><a href="#main-content" class="skip-link"><?php esc_html_e( 'Skip to main content', 'klaro' ); ?></a></li>
            <li><a href="#sidebar" class="skip-link"><?php esc_html_e( 'Skip to sidebar', 'klaro' ); ?></a></li>
            <li><a href="#site-footer" class="skip-link"><?php esc_html_e( 'Skip to footer', 'klaro' ); ?></a></li>
        </ul>
    </nav>
    <?php
}

/**
 * Require alt text for images in posts
 */
function klaro_require_image_alt( $data, $postarr ) {
    // Only check when publishing
    if ( $data['post_status'] !== 'publish' ) {
        return $data;
    }

    // Check for images without alt text
    if ( preg_match( '/<img(?![^>]*alt=)[^>]*>/i', $data['post_content'] ) ) {
        // Prevent publishing
        $data['post_status'] = 'draft';
        
        // Set admin notice
        add_filter( 'redirect_post_location', function( $location ) {
            return add_query_arg( 'klaro_alt_missing', '1', $location );
        } );
    }

    return $data;
}
add_filter( 'wp_insert_post_data', 'klaro_require_image_alt', 10, 2 );

/**
 * Admin notice for missing alt text
 */
function klaro_alt_text_admin_notice() {
    // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Display-only notice, no action taken
    if ( isset( $_GET['klaro_alt_missing'] ) && sanitize_text_field( wp_unslash( $_GET['klaro_alt_missing'] ) ) === '1' ) {
        ?>
        <div class="notice notice-error is-dismissible">
            <p><strong><?php esc_html_e( 'Publication prevented: All images must have alt text for accessibility.', 'klaro' ); ?></strong></p>
            <p><?php esc_html_e( 'Please add descriptive alt text to all images before publishing.', 'klaro' ); ?></p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'klaro_alt_text_admin_notice' );

/**
 * Enhanced excerpt with proper length
 */
function klaro_custom_excerpt_length( $length ) {
    return 40; // Reasonable length for screen readers
}
add_filter( 'excerpt_length', 'klaro_custom_excerpt_length', 999 );

/**
 * Better excerpt more link
 */
function klaro_excerpt_more( $more ) {
    if ( is_admin() ) {
        return $more;
    }
    
    $link = sprintf(
        '<a href="%1$s" class="more-link" aria-label="%2$s">%3$s</a>',
        esc_url( get_permalink() ),
        /* translators: %s: Post title */
        esc_attr( sprintf( __( 'Continue reading %s', 'klaro' ), get_the_title() ) ),
        esc_html__( 'Continue reading', 'klaro' )
    );
    
    return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'klaro_excerpt_more' );

/**
 * Add ARIA labels to navigation
 */
function klaro_nav_menu_args( $args ) {
    $args['container_aria_label'] = $args['theme_location'];
    return $args;
}
add_filter( 'wp_nav_menu_args', 'klaro_nav_menu_args' );

/**
 * Add accessibility toolbar to admin bar
 */
function klaro_admin_bar_accessibility_menu( $wp_admin_bar ) {
    if ( ! is_admin() ) {
        $wp_admin_bar->add_node( array(
            'id'    => 'klaro-accessibility',
            'title' => '<span class="ab-icon dashicons-universal-access" aria-hidden="true"></span><span class="ab-label">' . esc_html__( 'Accessibility', 'klaro' ) . '</span>',
            'href'  => '#',
            'meta'  => array(
                'class' => 'klaro-accessibility-menu',
            ),
        ) );
    }
}
add_action( 'admin_bar_menu', 'klaro_admin_bar_accessibility_menu', 100 );

/**
 * Breadcrumb function
 */
function klaro_breadcrumbs() {
    if ( is_front_page() ) {
        return;
    }

    $separator = '<span aria-hidden="true">›</span>';
    
    echo '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'klaro' ) . '">';
    echo '<ol vocab="https://schema.org/" typeof="BreadcrumbList">';
    
    // Home link
    echo '<li property="itemListElement" typeof="ListItem">';
    echo '<a property="item" typeof="WebPage" href="' . esc_url( home_url( '/' ) ) . '">';
    echo '<span property="name">' . esc_html__( 'Home', 'klaro' ) . '</span>';
    echo '</a>';
    echo '<meta property="position" content="1">';
    echo '</li>';
    
    $position = 2;
    
    if ( is_category() || is_single() ) {
        $categories = get_the_category();
        if ( $categories ) {
            $category = $categories[0];
            echo '<li property="itemListElement" typeof="ListItem">';
            echo '<a property="item" typeof="WebPage" href="' . esc_url( get_category_link( $category->term_id ) ) . '">';
            echo '<span property="name">' . esc_html( $category->name ) . '</span>';
            echo '</a>';
            echo '<meta property="position" content="' . $position . '">';
            echo '</li>';
            $position++;
        }
    } elseif ( is_page() ) {
        $parent_id = wp_get_post_parent_id( get_the_ID() );
        $breadcrumbs = array();
        
        while ( $parent_id ) {
            $page = get_post( $parent_id );
            $breadcrumbs[] = array(
                'title' => get_the_title( $page->ID ),
                'url'   => get_permalink( $page->ID ),
            );
            $parent_id = $page->post_parent;
        }
        
        $breadcrumbs = array_reverse( $breadcrumbs );
        
        foreach ( $breadcrumbs as $crumb ) {
            echo '<li property="itemListElement" typeof="ListItem">';
            echo '<a property="item" typeof="WebPage" href="' . esc_url( $crumb['url'] ) . '">';
            echo '<span property="name">' . esc_html( $crumb['title'] ) . '</span>';
            echo '</a>';
            echo '<meta property="position" content="' . $position . '">';
            echo '</li>';
            $position++;
        }
    }
    
    // Current page
    if ( is_single() || is_page() ) {
        echo '<li property="itemListElement" typeof="ListItem">';
        echo '<span property="name" aria-current="page">' . esc_html( get_the_title() ) . '</span>';
        echo '<meta property="position" content="' . $position . '">';
        echo '</li>';
    } elseif ( is_category() ) {
        echo '<li property="itemListElement" typeof="ListItem">';
        echo '<span property="name" aria-current="page">' . esc_html( single_cat_title( '', false ) ) . '</span>';
        echo '<meta property="position" content="' . $position . '">';
        echo '</li>';
    } elseif ( is_tag() ) {
        echo '<li property="itemListElement" typeof="ListItem">';
        echo '<span property="name" aria-current="page">' . esc_html( single_tag_title( '', false ) ) . '</span>';
        echo '<meta property="position" content="' . $position . '">';
        echo '</li>';
    } elseif ( is_archive() ) {
        // Handle WooCommerce shop pages
        if ( class_exists( 'WooCommerce' ) && function_exists( 'is_shop' ) && is_shop() ) {
            $archive_title = woocommerce_page_title( false );
        } elseif ( class_exists( 'WooCommerce' ) && function_exists( 'is_product_category' ) && is_product_category() ) {
            $archive_title = single_term_title( '', false );
        } elseif ( class_exists( 'WooCommerce' ) && function_exists( 'is_product_tag' ) && is_product_tag() ) {
            $archive_title = single_term_title( '', false );
        } else {
            // Strip HTML from archive title (WordPress wraps it in <span>)
            $archive_title = wp_strip_all_tags( get_the_archive_title() );
        }
        echo '<li property="itemListElement" typeof="ListItem">';
        echo '<span property="name" aria-current="page">' . esc_html( $archive_title ) . '</span>';
        echo '<meta property="position" content="' . $position . '">';
        echo '</li>';
    } elseif ( is_search() ) {
        echo '<li property="itemListElement" typeof="ListItem">';
        echo '<span property="name" aria-current="page">' . sprintf( esc_html__( 'Search Results for: %s', 'klaro' ), get_search_query() ) . '</span>';
        echo '<meta property="position" content="' . $position . '">';
        echo '</li>';
    } elseif ( is_404() ) {
        echo '<li property="itemListElement" typeof="ListItem">';
        echo '<span property="name" aria-current="page">' . esc_html__( 'Page Not Found', 'klaro' ) . '</span>';
        echo '<meta property="position" content="' . $position . '">';
        echo '</li>';
    }
    
    echo '</ol>';
    echo '</nav>';
}

/**
 * Add language attribute
 */
function klaro_language_attributes( $output ) {
    $output .= ' prefix="og: http://ogp.me/ns#"';
    return $output;
}
add_filter( 'language_attributes', 'klaro_language_attributes' );

/**
 * Accessibility customizer options
 */
function klaro_customize_register( $wp_customize ) {
    // Accessibility Panel
    $wp_customize->add_panel( 'klaro_accessibility', array(
        'title'       => esc_html__( 'Accessibility Options', 'klaro' ),
        'description' => esc_html__( 'Customize accessibility features for your site.', 'klaro' ),
        'priority'    => 10,
    ) );

    // Typography Section
    $wp_customize->add_section( 'klaro_typography', array(
        'title'    => esc_html__( 'Typography', 'klaro' ),
        'panel'    => 'klaro_accessibility',
        'priority' => 10,
    ) );

    // Base font size
    $wp_customize->add_setting( 'klaro_font_size', array(
        'default'           => '18',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'klaro_font_size', array(
        'label'       => esc_html__( 'Base Font Size (px)', 'klaro' ),
        'section'     => 'klaro_typography',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 14,
            'max'  => 36,
            'step' => 1,
        ),
    ) );

    // Line height
    $wp_customize->add_setting( 'klaro_line_height', array(
        'default'           => '1.8',
        'sanitize_callback' => 'klaro_sanitize_float',
        'transport'         => 'postMessage',
    ) );

    $wp_customize->add_control( 'klaro_line_height', array(
        'label'       => esc_html__( 'Line Height', 'klaro' ),
        'section'     => 'klaro_typography',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1.2,
            'max'  => 3.0,
            'step' => 0.1,
        ),
    ) );

    // Contrast Section
    $wp_customize->add_section( 'klaro_contrast', array(
        'title'    => esc_html__( 'Contrast & Colors', 'klaro' ),
        'panel'    => 'klaro_accessibility',
        'priority' => 20,
    ) );

    // Contrast mode
    $wp_customize->add_setting( 'klaro_contrast_mode', array(
        'default'           => 'standard',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'klaro_contrast_mode', array(
        'label'   => esc_html__( 'Contrast Mode', 'klaro' ),
        'section' => 'klaro_contrast',
        'type'    => 'select',
        'choices' => array(
            'standard'      => esc_html__( 'Standard (AAA)', 'klaro' ),
            'high-contrast' => esc_html__( 'High Contrast', 'klaro' ),
            'monochrome'    => esc_html__( 'Monochrome', 'klaro' ),
        ),
    ) );
}
add_action( 'customize_register', 'klaro_customize_register' );

/**
 * Sanitize float values
 */
function klaro_sanitize_float( $value ) {
    return floatval( $value );
}

/**
 * Output customizer CSS
 */
function klaro_customizer_css() {
    $font_size   = get_theme_mod( 'klaro_font_size', '18' );
    $line_height = get_theme_mod( 'klaro_line_height', '1.8' );
    
    ?>
    <style type="text/css">
        :root {
            --font-size-base: <?php echo absint( $font_size ); ?>px;
            --line-height-base: <?php echo floatval( $line_height ); ?>;
        }
    </style>
    <?php
}
add_action( 'wp_head', 'klaro_customizer_css' );

/**
 * Add body classes for accessibility modes
 */
function klaro_body_classes( $classes ) {
    $contrast_mode = get_theme_mod( 'klaro_contrast_mode', 'standard' );
    
    if ( $contrast_mode !== 'standard' ) {
        $classes[] = sanitize_html_class( $contrast_mode );
    }
    
    return $classes;
}
add_filter( 'body_class', 'klaro_body_classes' );

/**
 * Disable autoplay for embeds
 */
function klaro_disable_autoplay( $html, $url ) {
    // YouTube
    if ( strpos( $url, 'youtube.com' ) !== false || strpos( $url, 'youtu.be' ) !== false ) {
        $html = str_replace( '?feature=oembed', '?feature=oembed&autoplay=0', $html );
    }
    
    // Vimeo
    if ( strpos( $url, 'vimeo.com' ) !== false ) {
        $html = str_replace( '?', '?autoplay=0&', $html );
    }
    
    return $html;
}
add_filter( 'oembed_result', 'klaro_disable_autoplay', 10, 2 );

/**
 * Custom comment form for better accessibility
 */
function klaro_comment_form_defaults( $defaults ) {
    $commenter = wp_get_current_commenter();

    $defaults['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'klaro' ) . ' <span class="required" aria-label="' . esc_attr__( 'required', 'klaro' ) . '">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required aria-required="true" aria-describedby="comment-description"></textarea><span id="comment-description" class="screen-reader-text">' . esc_html__( 'Your comment will be posted publicly on this page.', 'klaro' ) . '</span></p>';

    $defaults['fields']['author'] = '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'klaro' ) . ' <span class="required" aria-label="' . esc_attr__( 'required', 'klaro' ) . '">*</span></label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245" required aria-required="true" /></p>';

    $defaults['fields']['email'] = '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'klaro' ) . ' <span class="required" aria-label="' . esc_attr__( 'required', 'klaro' ) . '">*</span></label><input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes" required aria-required="true" /><span id="email-notes" class="screen-reader-text">' . esc_html__( 'Your email address will not be published.', 'klaro' ) . '</span></p>';

    $defaults['fields']['url'] = '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'klaro' ) . '</label><input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>';

    return $defaults;
}
add_filter( 'comment_form_defaults', 'klaro_comment_form_defaults' );

/**
 * ==========================================================================
 * WOOCOMMERCE SUPPORT
 * ==========================================================================
 */

/**
 * WooCommerce Theme Support
 */
function klaro_woocommerce_setup() {
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width' => 300,
		'single_image_width'    => 600,
		'product_grid'          => array(
			'default_rows'    => 3,
			'min_rows'        => 1,
			'max_rows'        => 10,
			'default_columns' => 3,
			'min_columns'     => 1,
			'max_columns'     => 4,
		),
	) );

	// Gallery features
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'klaro_woocommerce_setup' );

/**
 * Register WooCommerce-specific widget areas
 */
function klaro_woocommerce_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'klaro' ),
		'id'            => 'sidebar-shop',
		'description'   => esc_html__( 'Add widgets here to appear in shop pages sidebar.', 'klaro' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s" role="region" aria-labelledby="%1$s-title">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 id="%1$s-title" class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'klaro_woocommerce_widgets_init' );

/**
 * Enqueue WooCommerce accessibility scripts and styles
 */
function klaro_woocommerce_scripts() {
	if ( class_exists( 'WooCommerce' ) ) {
		// WooCommerce accessibility styles
		wp_enqueue_style(
			'klaro-woocommerce',
			get_template_directory_uri() . '/woocommerce.css',
			array( 'klaro-style' ),
			'1.0.0'
		);

		// WooCommerce accessibility scripts
		wp_enqueue_script(
			'klaro-woocommerce-accessibility',
			get_template_directory_uri() . '/js/woocommerce-accessibility.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		wp_localize_script( 'klaro-woocommerce-accessibility', 'klaroWcSettings', array(
			'cartUpdatedMessage'     => esc_html__( 'Cart updated', 'klaro' ),
			'addedToCartMessage'     => esc_html__( 'Product added to cart', 'klaro' ),
			'removedFromCartMessage' => esc_html__( 'Product removed from cart', 'klaro' ),
			'quantityUpdated'        => esc_html__( 'Quantity updated to', 'klaro' ),
		) );
	}
}
add_action( 'wp_enqueue_scripts', 'klaro_woocommerce_scripts' );

/**
 * WooCommerce wrapper start
 */
function klaro_woocommerce_wrapper_before() {
	?>
	<main id="main-content" class="site-main" aria-label="<?php esc_attr_e( 'Main content', 'klaro' ); ?>">
		<div class="content-area">
	<?php
}

/**
 * WooCommerce wrapper end
 */
function klaro_woocommerce_wrapper_after() {
	?>
		</div><!-- .content-area -->
	</main><!-- #main-content -->
	<?php
}

/**
 * WooCommerce sidebar - disabled by default for cleaner layout
 * Uncomment the code below to enable shop sidebar
 */
function klaro_woocommerce_sidebar() {
	// Sidebar disabled by default - single column layout
	// To enable, uncomment the following:
	/*
	if ( is_active_sidebar( 'sidebar-shop' ) ) {
		?>
		<aside id="sidebar" class="widget-area shop-sidebar" aria-label="<?php esc_attr_e( 'Shop sidebar', 'klaro' ); ?>">
			<?php dynamic_sidebar( 'sidebar-shop' ); ?>
		</aside>
		<?php
	}
	*/
}

/**
 * Register WooCommerce hook modifications
 * Only runs when WooCommerce is fully loaded
 */
function klaro_woocommerce_hooks() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	add_action( 'woocommerce_before_main_content', 'klaro_woocommerce_wrapper_before', 10 );

	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	add_action( 'woocommerce_after_main_content', 'klaro_woocommerce_wrapper_after', 10 );

	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	add_action( 'woocommerce_sidebar', 'klaro_woocommerce_sidebar', 10 );
}
add_action( 'woocommerce_loaded', 'klaro_woocommerce_hooks' );

/**
 * Add WooCommerce body classes
 */
function klaro_woocommerce_body_classes( $classes ) {
	if ( class_exists( 'WooCommerce' ) && function_exists( 'is_shop' ) ) {
		$classes[] = 'klaro-woocommerce';

		if ( is_shop() || is_product_category() || is_product_tag() ) {
			$classes[] = 'klaro-shop-page';
		}

		if ( is_product() ) {
			$classes[] = 'klaro-product-page';
		}

		if ( is_cart() ) {
			$classes[] = 'klaro-cart-page';
		}

		if ( is_checkout() ) {
			$classes[] = 'klaro-checkout-page';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'klaro_woocommerce_body_classes' );

/**
 * Fix WooCommerce archive title (remove "Archives:" prefix and HTML)
 */
function klaro_woocommerce_archive_title( $title ) {
	if ( class_exists( 'WooCommerce' ) && function_exists( 'is_shop' ) && is_shop() ) {
		return woocommerce_page_title( false );
	}
	if ( class_exists( 'WooCommerce' ) && function_exists( 'is_product_category' ) && is_product_category() ) {
		return single_term_title( '', false );
	}
	if ( class_exists( 'WooCommerce' ) && function_exists( 'is_product_tag' ) && is_product_tag() ) {
		return single_term_title( '', false );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'klaro_woocommerce_archive_title', 20 );

/**
 * Enhance product thumbnails with descriptive alt text
 */
function klaro_woocommerce_product_thumbnail_alt( $html, $post_thumbnail_id ) {
	if ( ! class_exists( 'WooCommerce' ) || ! function_exists( 'is_product' ) ) {
		return $html;
	}

	if ( ! is_product() && ! is_shop() && ! is_product_category() ) {
		return $html;
	}

	global $product;
	if ( ! $product ) {
		return $html;
	}

	$alt_text = $product->get_name();
	if ( $product->is_on_sale() ) {
		$alt_text .= ' - ' . __( 'On Sale', 'klaro' );
	}

	// Replace empty alt with descriptive text
	$html = preg_replace( '/alt=""/', 'alt="' . esc_attr( $alt_text ) . '"', $html );

	return $html;
}
add_filter( 'post_thumbnail_html', 'klaro_woocommerce_product_thumbnail_alt', 10, 2 );

/**
 * Add screen reader text to sale badge
 */
function klaro_woocommerce_sale_flash( $html, $post, $product ) {
	return '<span class="onsale"><span aria-hidden="true">' . esc_html__( 'Sale!', 'klaro' ) . '</span><span class="screen-reader-text">' . esc_html__( 'This product is on sale', 'klaro' ) . '</span></span>';
}
add_filter( 'woocommerce_sale_flash', 'klaro_woocommerce_sale_flash', 10, 3 );

/**
 * Enhance add to cart button accessibility
 */
function klaro_woocommerce_loop_add_to_cart_args( $args, $product ) {
	$args['attributes']['aria-label'] = sprintf(
		/* translators: %s: Product name */
		esc_attr__( 'Add %s to cart', 'klaro' ),
		$product->get_name()
	);

	return $args;
}
add_filter( 'woocommerce_loop_add_to_cart_args', 'klaro_woocommerce_loop_add_to_cart_args', 10, 2 );

/**
 * Add accessible labels to cart item remove links
 */
function klaro_woocommerce_cart_item_remove_link( $link, $cart_item_key ) {
	$cart = WC()->cart->get_cart();
	if ( isset( $cart[ $cart_item_key ] ) ) {
		$product_name = $cart[ $cart_item_key ]['data']->get_name();
		$link = str_replace(
			'class="remove"',
			'class="remove" aria-label="' . esc_attr( sprintf( __( 'Remove %s from cart', 'klaro' ), $product_name ) ) . '"',
			$link
		);
	}
	return $link;
}
add_filter( 'woocommerce_cart_item_remove_link', 'klaro_woocommerce_cart_item_remove_link', 10, 2 );

/**
 * Add skip links for WooCommerce pages
 */
function klaro_woocommerce_skip_links() {
	if ( ! class_exists( 'WooCommerce' ) || ! function_exists( 'is_shop' ) ) {
		return;
	}

	$additional_links = array();

	if ( is_shop() || is_product_category() || is_product_tag() ) {
		$additional_links[] = '<li><a href="#products-list" class="skip-link">' . esc_html__( 'Skip to products', 'klaro' ) . '</a></li>';
	}

	if ( is_product() ) {
		$additional_links[] = '<li><a href="#product-details" class="skip-link">' . esc_html__( 'Skip to product details', 'klaro' ) . '</a></li>';
		$additional_links[] = '<li><a href="#add-to-cart-form" class="skip-link">' . esc_html__( 'Skip to add to cart', 'klaro' ) . '</a></li>';
	}

	if ( is_cart() ) {
		$additional_links[] = '<li><a href="#cart-contents" class="skip-link">' . esc_html__( 'Skip to cart contents', 'klaro' ) . '</a></li>';
		$additional_links[] = '<li><a href="#cart-totals" class="skip-link">' . esc_html__( 'Skip to cart totals', 'klaro' ) . '</a></li>';
	}

	if ( is_checkout() && ! is_order_received_page() ) {
		$additional_links[] = '<li><a href="#customer_details" class="skip-link">' . esc_html__( 'Skip to billing details', 'klaro' ) . '</a></li>';
		$additional_links[] = '<li><a href="#order_review" class="skip-link">' . esc_html__( 'Skip to order review', 'klaro' ) . '</a></li>';
	}

	if ( ! empty( $additional_links ) ) {
		echo '<nav class="skip-links woocommerce-skip-links" aria-label="' . esc_attr__( 'Shop navigation', 'klaro' ) . '">';
		echo '<ul>' . implode( '', $additional_links ) . '</ul>';
		echo '</nav>';
	}
}
add_action( 'wp_body_open', 'klaro_woocommerce_skip_links', 6 );

/**
 * Enhance star rating accessibility
 */
function klaro_woocommerce_star_rating_html( $html, $rating, $count ) {
	$rating_text = sprintf(
		/* translators: 1: Rating value, 2: Maximum rating */
		esc_html__( 'Rated %1$s out of %2$s', 'klaro' ),
		$rating,
		5
	);

	return '<div class="star-rating" role="img" aria-label="' . esc_attr( $rating_text ) . '">' . $html . '</div>';
}
add_filter( 'woocommerce_get_star_rating_html', 'klaro_woocommerce_star_rating_html', 10, 3 );

/**
 * Add ARIA live region for cart updates
 */
function klaro_woocommerce_cart_live_region() {
	if ( class_exists( 'WooCommerce' ) ) {
		echo '<div id="wc-cart-announcer" class="screen-reader-text" role="status" aria-live="polite" aria-atomic="true"></div>';
	}
}
add_action( 'wp_footer', 'klaro_woocommerce_cart_live_region' );

/**
 * ==========================================================================
 * COMMENTS
 * ==========================================================================
 */

/**
 * Custom comment callback for better accessibility
 *
 * @param WP_Comment $comment The comment object.
 * @param array      $args    An array of arguments.
 * @param int        $depth   Depth of the current comment.
 */
if ( ! function_exists( 'klaro_comment_callback' ) ) {
	function klaro_comment_callback( $comment, $args, $depth ) {
		?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> aria-labelledby="comment-<?php comment_ID(); ?>-meta">
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta" id="comment-<?php comment_ID(); ?>-meta">
					<div class="comment-author vcard">
						<?php
						if ( 0 !== $args['avatar_size'] ) {
							echo get_avatar( $comment, $args['avatar_size'], '', get_comment_author(), array( 'role' => 'img' ) );
						}
						?>
						<span class="fn" itemprop="author" itemscope itemtype="https://schema.org/Person">
							<span itemprop="name"><?php comment_author_link(); ?></span>
						</span>
					</div><!-- .comment-author -->

					<div class="comment-metadata">
						<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
							<time datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished">
								<?php
								/* translators: 1: Comment date, 2: Comment time */
								printf( esc_html__( '%1$s at %2$s', 'klaro' ), get_comment_date( '', $comment ), get_comment_time() );
								?>
							</time>
						</a>
						<?php
						edit_comment_link( esc_html__( 'Edit', 'klaro' ), '<span class="edit-link">', '</span>' );
						?>
					</div><!-- .comment-metadata -->

					<?php if ( '0' === $comment->comment_approved ) : ?>
						<p class="comment-awaiting-moderation" role="status"><?php esc_html_e( 'Your comment is awaiting moderation.', 'klaro' ); ?></p>
					<?php endif; ?>
				</footer><!-- .comment-meta -->

				<div class="comment-content" itemprop="text">
					<?php comment_text(); ?>
				</div><!-- .comment-content -->

				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="reply">',
							'after'     => '</div>',
						)
					)
				);
				?>
			</article><!-- .comment-body -->
		<?php
	}
}
