<?php
/**
 * Klaro Admin Accessibility Enhancements
 * 
 * Makes the WordPress admin area more accessible for users with disabilities
 *
 * @package Klaro
 * @since 1.0.0
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Admin Accessibility Settings Page
 */
function klaro_admin_accessibility_menu() {
    add_theme_page(
        esc_html__( 'Admin Accessibility', 'klaro' ),
        esc_html__( 'Admin Accessibility', 'klaro' ),
        'manage_options',
        'klaro-admin-accessibility',
        'klaro_admin_accessibility_page'
    );
}
add_action( 'admin_menu', 'klaro_admin_accessibility_menu' );

/**
 * Render Admin Accessibility Settings Page
 */
function klaro_admin_accessibility_page() {
    // Check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Save settings
    if ( isset( $_POST['klaro_admin_accessibility_nonce'] ) && 
         wp_verify_nonce( $_POST['klaro_admin_accessibility_nonce'], 'klaro_admin_accessibility_save' ) ) {
        
        update_option( 'klaro_disable_gutenberg', isset( $_POST['klaro_disable_gutenberg'] ) );
        update_option( 'klaro_admin_high_contrast', isset( $_POST['klaro_admin_high_contrast'] ) );
        update_option( 'klaro_admin_large_text', isset( $_POST['klaro_admin_large_text'] ) );
        update_option( 'klaro_disable_admin_animations', isset( $_POST['klaro_disable_admin_animations'] ) );
        update_option( 'klaro_simplify_admin_menu', isset( $_POST['klaro_simplify_admin_menu'] ) );
        update_option( 'klaro_focus_indicators', isset( $_POST['klaro_focus_indicators'] ) );
        update_option( 'klaro_screen_reader_shortcuts', isset( $_POST['klaro_screen_reader_shortcuts'] ) );
        
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings saved successfully!', 'klaro' ) . '</p></div>';
    }

    // Get current settings
    $disable_gutenberg = get_option( 'klaro_disable_gutenberg', false );
    $admin_high_contrast = get_option( 'klaro_admin_high_contrast', false );
    $admin_large_text = get_option( 'klaro_admin_large_text', false );
    $disable_animations = get_option( 'klaro_disable_admin_animations', false );
    $simplify_menu = get_option( 'klaro_simplify_admin_menu', false );
    $focus_indicators = get_option( 'klaro_focus_indicators', true );
    $screen_reader_shortcuts = get_option( 'klaro_screen_reader_shortcuts', true );
    ?>
    
    <div class="wrap">
        <h1><?php esc_html_e( 'Admin Accessibility Settings', 'klaro' ); ?></h1>
        
        <p class="description">
            <?php esc_html_e( 'Configure accessibility enhancements for the WordPress admin area. These settings help users with visual, motor, and cognitive disabilities.', 'klaro' ); ?>
        </p>

        <form method="post" action="">
            <?php wp_nonce_field( 'klaro_admin_accessibility_save', 'klaro_admin_accessibility_nonce' ); ?>
            
            <table class="form-table" role="presentation">
                <tbody>
                    
                    <!-- Disable Gutenberg -->
                    <tr>
                        <th scope="row">
                            <label for="klaro_disable_gutenberg">
                                <?php esc_html_e( 'Disable Block Editor (Gutenberg)', 'klaro' ); ?>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <label for="klaro_disable_gutenberg">
                                    <input type="checkbox" 
                                           name="klaro_disable_gutenberg" 
                                           id="klaro_disable_gutenberg" 
                                           value="1" 
                                           <?php checked( $disable_gutenberg ); ?>>
                                    <?php esc_html_e( 'Use Classic Editor instead of Gutenberg', 'klaro' ); ?>
                                </label>
                                <p class="description">
                                    <?php esc_html_e( 'The block editor (Gutenberg) can be difficult for screen reader users and those with visual disabilities. The Classic Editor provides a simpler, more accessible interface.', 'klaro' ); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>

                    <!-- High Contrast Admin -->
                    <tr>
                        <th scope="row">
                            <label for="klaro_admin_high_contrast">
                                <?php esc_html_e( 'High Contrast Admin', 'klaro' ); ?>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <label for="klaro_admin_high_contrast">
                                    <input type="checkbox" 
                                           name="klaro_admin_high_contrast" 
                                           id="klaro_admin_high_contrast" 
                                           value="1" 
                                           <?php checked( $admin_high_contrast ); ?>>
                                    <?php esc_html_e( 'Enable high contrast mode in admin', 'klaro' ); ?>
                                </label>
                                <p class="description">
                                    <?php esc_html_e( 'Increases contrast in the admin area for better visibility. Helpful for users with low vision or color blindness.', 'klaro' ); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>

                    <!-- Large Text Admin -->
                    <tr>
                        <th scope="row">
                            <label for="klaro_admin_large_text">
                                <?php esc_html_e( 'Large Admin Text', 'klaro' ); ?>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <label for="klaro_admin_large_text">
                                    <input type="checkbox" 
                                           name="klaro_admin_large_text" 
                                           id="klaro_admin_large_text" 
                                           value="1" 
                                           <?php checked( $admin_large_text ); ?>>
                                    <?php esc_html_e( 'Increase text size in admin area', 'klaro' ); ?>
                                </label>
                                <p class="description">
                                    <?php esc_html_e( 'Makes all admin text larger (18px base instead of 13px). Easier to read for users with visual impairments.', 'klaro' ); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>

                    <!-- Disable Animations -->
                    <tr>
                        <th scope="row">
                            <label for="klaro_disable_admin_animations">
                                <?php esc_html_e( 'Disable Admin Animations', 'klaro' ); ?>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <label for="klaro_disable_admin_animations">
                                    <input type="checkbox" 
                                           name="klaro_disable_admin_animations" 
                                           id="klaro_disable_admin_animations" 
                                           value="1" 
                                           <?php checked( $disable_animations ); ?>>
                                    <?php esc_html_e( 'Remove animations and transitions', 'klaro' ); ?>
                                </label>
                                <p class="description">
                                    <?php esc_html_e( 'Disables all animations in the admin area. Helpful for users with vestibular disorders or ADHD who find motion distracting.', 'klaro' ); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>

                    <!-- Simplify Menu -->
                    <tr>
                        <th scope="row">
                            <label for="klaro_simplify_admin_menu">
                                <?php esc_html_e( 'Simplify Admin Menu', 'klaro' ); ?>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <label for="klaro_simplify_admin_menu">
                                    <input type="checkbox" 
                                           name="klaro_simplify_admin_menu" 
                                           id="klaro_simplify_admin_menu" 
                                           value="1" 
                                           <?php checked( $simplify_menu ); ?>>
                                    <?php esc_html_e( 'Reduce menu complexity', 'klaro' ); ?>
                                </label>
                                <p class="description">
                                    <?php esc_html_e( 'Hides less-used menu items and simplifies navigation. Makes the admin easier to learn and use for all users.', 'klaro' ); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>

                    <!-- Enhanced Focus Indicators -->
                    <tr>
                        <th scope="row">
                            <label for="klaro_focus_indicators">
                                <?php esc_html_e( 'Enhanced Focus Indicators', 'klaro' ); ?>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <label for="klaro_focus_indicators">
                                    <input type="checkbox" 
                                           name="klaro_focus_indicators" 
                                           id="klaro_focus_indicators" 
                                           value="1" 
                                           <?php checked( $focus_indicators ); ?>>
                                    <?php esc_html_e( 'Show highly visible focus outlines', 'klaro' ); ?>
                                </label>
                                <p class="description">
                                    <?php esc_html_e( 'Makes keyboard focus indicators more visible (3px thick, high contrast). Essential for keyboard-only users.', 'klaro' ); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>

                    <!-- Screen Reader Shortcuts -->
                    <tr>
                        <th scope="row">
                            <label for="klaro_screen_reader_shortcuts">
                                <?php esc_html_e( 'Screen Reader Enhancements', 'klaro' ); ?>
                            </label>
                        </th>
                        <td>
                            <fieldset>
                                <label for="klaro_screen_reader_shortcuts">
                                    <input type="checkbox" 
                                           name="klaro_screen_reader_shortcuts" 
                                           id="klaro_screen_reader_shortcuts" 
                                           value="1" 
                                           <?php checked( $screen_reader_shortcuts ); ?>>
                                    <?php esc_html_e( 'Add ARIA landmarks and labels', 'klaro' ); ?>
                                </label>
                                <p class="description">
                                    <?php esc_html_e( 'Adds descriptive ARIA labels and landmark regions throughout the admin. Makes navigation with screen readers much easier.', 'klaro' ); ?>
                                </p>
                            </fieldset>
                        </td>
                    </tr>

                </tbody>
            </table>

            <?php submit_button( esc_html__( 'Save Accessibility Settings', 'klaro' ) ); ?>
        </form>

        <hr>

        <h2><?php esc_html_e( 'Additional Accessibility Tips', 'klaro' ); ?></h2>
        
        <div class="notice notice-info inline">
            <h3><?php esc_html_e( 'WordPress Built-in Accessibility Features', 'klaro' ); ?></h3>
            <ul>
                <li><strong><?php esc_html_e( 'Screen Options:', 'klaro' ); ?></strong> <?php esc_html_e( 'Click "Screen Options" at the top of any admin page to customize what you see.', 'klaro' ); ?></li>
                <li><strong><?php esc_html_e( 'Keyboard Shortcuts:', 'klaro' ); ?></strong> <?php esc_html_e( 'In the Classic Editor, press Shift+Alt+H to see available shortcuts.', 'klaro' ); ?></li>
                <li><strong><?php esc_html_e( 'User Profile:', 'klaro' ); ?></strong> <?php esc_html_e( 'Go to Users > Your Profile to enable "Keyboard Shortcuts" and choose admin color scheme.', 'klaro' ); ?></li>
            </ul>
        </div>

        <div class="notice notice-warning inline">
            <h3><?php esc_html_e( 'Need Help?', 'klaro' ); ?></h3>
            <p>
                <?php esc_html_e( 'If you\'re having difficulty using the WordPress admin:', 'klaro' ); ?>
            </p>
            <ul>
                <li><?php esc_html_e( 'Try the Classic Editor (disable Gutenberg above)', 'klaro' ); ?></li>
                <li><?php esc_html_e( 'Enable high contrast and large text', 'klaro' ); ?></li>
                <li><?php esc_html_e( 'Use a screen reader (NVDA for Windows, VoiceOver for Mac)', 'klaro' ); ?></li>
                <li><?php esc_html_e( 'Navigate with keyboard: Tab, Shift+Tab, Enter, Escape', 'klaro' ); ?></li>
            </ul>
        </div>

    </div>
    <?php
}

/**
 * Disable Gutenberg if option is enabled
 */
function klaro_maybe_disable_gutenberg() {
    if ( get_option( 'klaro_disable_gutenberg', false ) ) {
        // Disable for posts
        add_filter( 'use_block_editor_for_post', '__return_false', 10 );
        
        // Disable for post types
        add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );
        
        // Remove Gutenberg CSS
        remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );
        
        // Show admin notice
        add_action( 'admin_notices', function() {
            $screen = get_current_screen();
            if ( $screen->id === 'theme_page_klaro-admin-accessibility' ) {
                return;
            }
            ?>
            <div class="notice notice-info">
                <p>
                    <strong><?php esc_html_e( 'Klaro Accessibility:', 'klaro' ); ?></strong>
                    <?php 
                    printf(
                        /* translators: %s: Link to settings page */
                        esc_html__( 'Classic Editor is enabled for better accessibility. %s', 'klaro' ),
                        '<a href="' . esc_url( admin_url( 'themes.php?page=klaro-admin-accessibility' ) ) . '">' . esc_html__( 'Change settings', 'klaro' ) . '</a>'
                    );
                    ?>
                </p>
            </div>
            <?php
        }, 5 );
    }
}
add_action( 'plugins_loaded', 'klaro_maybe_disable_gutenberg' );

/**
 * Admin Accessibility Styles
 */
function klaro_admin_accessibility_styles() {
    $admin_high_contrast = get_option( 'klaro_admin_high_contrast', false );
    $admin_large_text = get_option( 'klaro_admin_large_text', false );
    $disable_animations = get_option( 'klaro_disable_admin_animations', false );
    $focus_indicators = get_option( 'klaro_focus_indicators', true );
    
    if ( ! $admin_high_contrast && ! $admin_large_text && ! $disable_animations && ! $focus_indicators ) {
        return;
    }
    
    ?>
    <style type="text/css">
        <?php if ( $admin_large_text ) : ?>
        /* Large Text Mode */
        body,
        #wpcontent,
        .wrap {
            font-size: 18px !important;
            line-height: 1.8 !important;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="url"],
        input[type="password"],
        input[type="search"],
        input[type="number"],
        textarea,
        select {
            font-size: 16px !important;
            padding: 8px 12px !important;
        }
        
        .wp-list-table td,
        .wp-list-table th {
            font-size: 16px !important;
            padding: 12px !important;
        }
        
        #adminmenu a {
            font-size: 16px !important;
            padding: 10px !important;
        }
        
        .button,
        .button-primary,
        .button-secondary {
            font-size: 16px !important;
            padding: 10px 18px !important;
            min-height: 44px !important;
        }
        <?php endif; ?>
        
        <?php if ( $admin_high_contrast ) : ?>
        /* High Contrast Mode */
        body {
            background: #000000 !important;
            color: #FFFFFF !important;
        }
        
        #wpcontent,
        .wrap,
        .wp-core-ui .button,
        .wp-core-ui .button-secondary,
        .tablenav,
        .widefat {
            background: #000000 !important;
            color: #FFFFFF !important;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="url"],
        input[type="password"],
        input[type="search"],
        input[type="number"],
        textarea,
        select {
            background: #000000 !important;
            color: #FFFFFF !important;
            border: 2px solid #FFFFFF !important;
        }
        
        .wp-core-ui .button-primary {
            background: #FFFFFF !important;
            color: #000000 !important;
            border: 3px solid #FFFFFF !important;
        }
        
        .wp-core-ui .button-primary:hover,
        .wp-core-ui .button-primary:focus {
            background: #000000 !important;
            color: #FFFFFF !important;
        }
        
        #adminmenu,
        #adminmenuback,
        #adminmenuwrap {
            background: #000000 !important;
        }
        
        #adminmenu a,
        #adminmenu .wp-submenu a {
            color: #FFFFFF !important;
        }
        
        #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head,
        #adminmenu .wp-menu-arrow,
        #adminmenu .wp-menu-arrow div,
        #adminmenu li.current a.menu-top,
        #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu {
            background: #FFFFFF !important;
            color: #000000 !important;
        }
        
        .widefat thead th,
        .widefat thead td {
            background: #FFFFFF !important;
            color: #000000 !important;
            border: 2px solid #FFFFFF !important;
        }
        
        .widefat tbody tr:nth-child(odd) {
            background: #1a1a1a !important;
        }
        
        a {
            color: #00D4FF !important;
        }
        
        a:hover,
        a:focus {
            color: #FFFFFF !important;
        }
        <?php endif; ?>
        
        <?php if ( $disable_animations ) : ?>
        /* Disable All Animations */
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
        <?php endif; ?>
        
        <?php if ( $focus_indicators ) : ?>
        /* Enhanced Focus Indicators */
        a:focus,
        button:focus,
        input:focus,
        textarea:focus,
        select:focus,
        .wp-core-ui .button:focus,
        #adminmenu a:focus {
            outline: 3px solid #FF6B00 !important;
            outline-offset: 2px !important;
            box-shadow: 0 0 0 3px rgba(255, 107, 0, 0.3) !important;
        }
        
        /* Remove browser default focus */
        *:focus {
            outline: 3px solid #FF6B00 !important;
            outline-offset: 2px !important;
        }
        
        /* Skip link visibility */
        .skip-link:focus {
            position: fixed !important;
            top: 7px !important;
            left: 6px !important;
            z-index: 100000 !important;
            background: #FF6B00 !important;
            color: #FFFFFF !important;
            padding: 15px 23px 14px !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            text-decoration: none !important;
            outline: none !important;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action( 'admin_head', 'klaro_admin_accessibility_styles' );

/**
 * Simplify Admin Menu
 */
function klaro_simplify_admin_menu() {
    if ( ! get_option( 'klaro_simplify_admin_menu', false ) ) {
        return;
    }
    
    // Remove less essential menu items for non-admin users
    if ( ! current_user_can( 'manage_options' ) ) {
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'edit-comments.php' );
    }
    
    // Remove dashboard widgets that add clutter
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
}
add_action( 'admin_menu', 'klaro_simplify_admin_menu', 999 );

/**
 * Add ARIA landmarks to admin
 */
function klaro_admin_aria_landmarks() {
    if ( ! get_option( 'klaro_screen_reader_shortcuts', true ) ) {
        return;
    }
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Add landmark roles
        $('#wpcontent').attr({
            'role': 'main',
            'aria-label': '<?php echo esc_js( __( 'Main content', 'klaro' ) ); ?>'
        });
        
        $('#adminmenu').attr({
            'role': 'navigation',
            'aria-label': '<?php echo esc_js( __( 'Main navigation', 'klaro' ) ); ?>'
        });
        
        $('#wpfooter').attr({
            'role': 'contentinfo',
            'aria-label': '<?php echo esc_js( __( 'Footer', 'klaro' ) ); ?>'
        });
        
        // Add skip link
        if ($('.skip-link').length === 0) {
            $('body').prepend(
                '<a href="#wpcontent" class="skip-link screen-reader-shortcut">' +
                '<?php echo esc_js( __( 'Skip to main content', 'klaro' ) ); ?>' +
                '</a>'
            );
        }
        
        // Improve form labels
        $('input, textarea, select').each(function() {
            var $this = $(this);
            var id = $this.attr('id');
            
            if (id && $('label[for="' + id + '"]').length === 0) {
                var placeholder = $this.attr('placeholder');
                if (placeholder) {
                    $this.attr('aria-label', placeholder);
                }
            }
        });
        
        // Add aria-current to current menu item
        $('#adminmenu .wp-has-current-submenu').attr('aria-current', 'page');
    });
    </script>
    <?php
}
add_action( 'admin_footer', 'klaro_admin_aria_landmarks' );

/**
 * Add accessibility notification to admin dashboard
 */
function klaro_admin_accessibility_dashboard_widget() {
    wp_add_dashboard_widget(
        'klaro_accessibility_widget',
        esc_html__( 'Klaro Accessibility Features', 'klaro' ),
        'klaro_accessibility_dashboard_widget_content'
    );
}
add_action( 'wp_dashboard_setup', 'klaro_admin_accessibility_dashboard_widget' );

/**
 * Dashboard widget content
 */
function klaro_accessibility_dashboard_widget_content() {
    ?>
    <div class="klaro-dashboard-widget">
        <h3><?php esc_html_e( 'Admin Accessibility Active', 'klaro' ); ?></h3>
        
        <p><?php esc_html_e( 'Klaro is enhancing the WordPress admin for better accessibility:', 'klaro' ); ?></p>
        
        <ul style="list-style: disc; margin-left: 20px;">
            <?php if ( get_option( 'klaro_disable_gutenberg' ) ) : ?>
                <li><?php esc_html_e( '✓ Classic Editor enabled', 'klaro' ); ?></li>
            <?php endif; ?>
            
            <?php if ( get_option( 'klaro_admin_high_contrast' ) ) : ?>
                <li><?php esc_html_e( '✓ High contrast mode active', 'klaro' ); ?></li>
            <?php endif; ?>
            
            <?php if ( get_option( 'klaro_admin_large_text' ) ) : ?>
                <li><?php esc_html_e( '✓ Large text mode active', 'klaro' ); ?></li>
            <?php endif; ?>
            
            <?php if ( get_option( 'klaro_focus_indicators' ) ) : ?>
                <li><?php esc_html_e( '✓ Enhanced focus indicators', 'klaro' ); ?></li>
            <?php endif; ?>
        </ul>
        
        <p>
            <a href="<?php echo esc_url( admin_url( 'themes.php?page=klaro-admin-accessibility' ) ); ?>" class="button button-primary">
                <?php esc_html_e( 'Configure Accessibility Settings', 'klaro' ); ?>
            </a>
        </p>
        
        <hr>
        
        <h4><?php esc_html_e( 'Quick Tips:', 'klaro' ); ?></h4>
        <ul style="list-style: disc; margin-left: 20px;">
            <li><?php esc_html_e( 'Press Tab to navigate between elements', 'klaro' ); ?></li>
            <li><?php esc_html_e( 'Press Shift+Alt+H for keyboard shortcuts (Classic Editor)', 'klaro' ); ?></li>
            <li><?php esc_html_e( 'Click "Screen Options" to customize your view', 'klaro' ); ?></li>
        </ul>
    </div>
    <?php
}

/**
 * Add admin toolbar menu for quick accessibility toggle
 */
function klaro_admin_bar_accessibility_quick_menu( $wp_admin_bar ) {
    if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
        return;
    }
    
    $wp_admin_bar->add_node( array(
        'id'    => 'klaro-admin-accessibility',
        'title' => '<span class="ab-icon dashicons-universal-access" aria-hidden="true"></span>' .
                   '<span class="ab-label">' . esc_html__( 'Admin Accessibility', 'klaro' ) . '</span>',
        'href'  => admin_url( 'themes.php?page=klaro-admin-accessibility' ),
        'meta'  => array(
            'title' => esc_html__( 'Configure admin accessibility settings', 'klaro' ),
        ),
    ) );
}
add_action( 'admin_bar_menu', 'klaro_admin_bar_accessibility_quick_menu', 100 );

/**
 * Add help tabs to admin screens
 */
function klaro_add_accessibility_help_tabs() {
    $screen = get_current_screen();
    
    $screen->add_help_tab( array(
        'id'      => 'klaro-accessibility-help',
        'title'   => esc_html__( 'Accessibility', 'klaro' ),
        'content' => '<h3>' . esc_html__( 'Klaro Accessibility Features', 'klaro' ) . '</h3>' .
                     '<p>' . esc_html__( 'This admin area has been enhanced for accessibility by the Klaro theme.', 'klaro' ) . '</p>' .
                     '<h4>' . esc_html__( 'Keyboard Navigation:', 'klaro' ) . '</h4>' .
                     '<ul>' .
                     '<li>' . esc_html__( 'Tab - Move to next element', 'klaro' ) . '</li>' .
                     '<li>' . esc_html__( 'Shift + Tab - Move to previous element', 'klaro' ) . '</li>' .
                     '<li>' . esc_html__( 'Enter - Activate links and buttons', 'klaro' ) . '</li>' .
                     '<li>' . esc_html__( 'Escape - Close dialogs and dropdowns', 'klaro' ) . '</li>' .
                     '</ul>' .
                     '<p><a href="' . esc_url( admin_url( 'themes.php?page=klaro-admin-accessibility' ) ) . '">' .
                     esc_html__( 'Configure accessibility settings', 'klaro' ) . '</a></p>',
    ) );
}
add_action( 'admin_head', 'klaro_add_accessibility_help_tabs' );
