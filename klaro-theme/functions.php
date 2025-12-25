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
            'sidebar-1' => array(
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
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'klaro' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s" role="region" aria-labelledby="%1$s-title">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 id="%1$s-title" class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => esc_html__( 'Footer Widgets', 'klaro' ),
        'id'            => 'footer-1',
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
    if ( isset( $_GET['klaro_alt_missing'] ) && $_GET['klaro_alt_missing'] == '1' ) {
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
        echo '<li property="itemListElement" typeof="ListItem">';
        echo '<span property="name" aria-current="page">' . esc_html( get_the_archive_title() ) . '</span>';
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
    $defaults['comment_field'] = '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'klaro' ) . ' <span class="required" aria-label="' . esc_attr__( 'required', 'klaro' ) . '">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required aria-required="true" aria-describedby="comment-description"></textarea><span id="comment-description" class="screen-reader-text">' . esc_html__( 'Your comment will be posted publicly on this page.', 'klaro' ) . '</span></p>';
    
    $defaults['fields']['author'] = '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'klaro' ) . ' <span class="required" aria-label="' . esc_attr__( 'required', 'klaro' ) . '">*</span></label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245" required aria-required="true" /></p>';
    
    $defaults['fields']['email'] = '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'klaro' ) . ' <span class="required" aria-label="' . esc_attr__( 'required', 'klaro' ) . '">*</span></label><input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes" required aria-required="true" /><span id="email-notes" class="screen-reader-text">' . esc_html__( 'Your email address will not be published.', 'klaro' ) . '</span></p>';
    
    $defaults['fields']['url'] = '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'klaro' ) . '</label><input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>';
    
    return $defaults;
}
add_filter( 'comment_form_defaults', 'klaro_comment_form_defaults' );
