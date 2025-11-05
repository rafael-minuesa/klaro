<?php
/**
 * Recommended Plugins for Klaro Theme
 *
 * These plugins enhance accessibility but are NOT required.
 * The theme works perfectly without them.
 *
 * @package Klaro
 * @since 1.0.0
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Display admin notice with recommended plugins
 */
function klaro_recommended_plugins_notice() {
    // Only show to users who can install plugins
    if ( ! current_user_can( 'install_plugins' ) ) {
        return;
    }

    // Check if notice has been dismissed
    if ( get_user_meta( get_current_user_id(), 'klaro_dismissed_plugin_notice', true ) ) {
        return;
    }

    // Check if all recommended plugins are already installed
    $all_installed = klaro_check_recommended_plugins_status();
    if ( $all_installed ) {
        return;
    }

    ?>
    <div class="notice notice-info is-dismissible klaro-plugin-notice">
        <h2><?php esc_html_e( 'Enhance Your Klaro Theme', 'klaro' ); ?></h2>
        <p><?php esc_html_e( 'The following plugins can enhance accessibility features, but the theme works perfectly without them:', 'klaro' ); ?></p>

        <ul style="list-style: disc; margin-left: 2em;">
            <?php if ( ! is_plugin_active( 'classic-editor/classic-editor.php' ) ) : ?>
                <li>
                    <strong><?php esc_html_e( 'Classic Editor', 'klaro' ); ?></strong> -
                    <?php esc_html_e( 'Much better for screen reader users than Gutenberg', 'klaro' ); ?>
                    <?php if ( ! file_exists( WP_PLUGIN_DIR . '/classic-editor/classic-editor.php' ) ) : ?>
                        <a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=classic+editor&tab=search&type=term' ) ); ?>" class="button button-small">
                            <?php esc_html_e( 'Install Now', 'klaro' ); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>" class="button button-small">
                            <?php esc_html_e( 'Activate', 'klaro' ); ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endif; ?>

            <?php if ( ! is_plugin_active( 'wp-accessibility/wp-accessibility.php' ) ) : ?>
                <li>
                    <strong><?php esc_html_e( 'WP Accessibility', 'klaro' ); ?></strong> -
                    <?php esc_html_e( 'Additional accessibility tools and fixes', 'klaro' ); ?>
                    <?php if ( ! file_exists( WP_PLUGIN_DIR . '/wp-accessibility/wp-accessibility.php' ) ) : ?>
                        <a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=wp+accessibility&tab=search&type=term' ) ); ?>" class="button button-small">
                            <?php esc_html_e( 'Install Now', 'klaro' ); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>" class="button button-small">
                            <?php esc_html_e( 'Activate', 'klaro' ); ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endif; ?>

            <?php if ( ! is_plugin_active( 'accessibility-checker/accessibility-checker.php' ) ) : ?>
                <li>
                    <strong><?php esc_html_e( 'Accessibility Checker', 'klaro' ); ?></strong> -
                    <?php esc_html_e( 'Check your content for accessibility issues', 'klaro' ); ?>
                    <?php if ( ! file_exists( WP_PLUGIN_DIR . '/accessibility-checker/accessibility-checker.php' ) ) : ?>
                        <a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=accessibility+checker&tab=search&type=term' ) ); ?>" class="button button-small">
                            <?php esc_html_e( 'Install Now', 'klaro' ); ?>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>" class="button button-small">
                            <?php esc_html_e( 'Activate', 'klaro' ); ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
        </ul>

        <p>
            <em><?php esc_html_e( 'Note: These are optional recommendations. Your theme works great without them!', 'klaro' ); ?></em>
        </p>

        <p>
            <button type="button" class="button" id="klaro-dismiss-plugin-notice">
                <?php esc_html_e( 'Dismiss this notice', 'klaro' ); ?>
            </button>
        </p>
    </div>

    <script>
    jQuery(document).ready(function($) {
        $('#klaro-dismiss-plugin-notice').on('click', function() {
            $.post(ajaxurl, {
                action: 'klaro_dismiss_plugin_notice',
                nonce: '<?php echo wp_create_nonce( 'klaro_dismiss_plugin_notice' ); ?>'
            }, function() {
                $('.klaro-plugin-notice').fadeOut();
            });
        });
    });
    </script>
    <?php
}
add_action( 'admin_notices', 'klaro_recommended_plugins_notice' );

/**
 * Check if recommended plugins are installed
 */
function klaro_check_recommended_plugins_status() {
    $recommended = array(
        'classic-editor/classic-editor.php',
        'wp-accessibility/wp-accessibility.php',
        'accessibility-checker/accessibility-checker.php',
    );

    foreach ( $recommended as $plugin ) {
        if ( ! is_plugin_active( $plugin ) ) {
            return false;
        }
    }

    return true;
}

/**
 * Handle AJAX request to dismiss plugin notice
 */
function klaro_dismiss_plugin_notice_ajax() {
    check_ajax_referer( 'klaro_dismiss_plugin_notice', 'nonce' );

    if ( ! current_user_can( 'install_plugins' ) ) {
        wp_send_json_error();
    }

    update_user_meta( get_current_user_id(), 'klaro_dismissed_plugin_notice', true );
    wp_send_json_success();
}
add_action( 'wp_ajax_klaro_dismiss_plugin_notice', 'klaro_dismiss_plugin_notice_ajax' );

/**
 * Add a Recommended Plugins page under Appearance
 */
function klaro_add_recommended_plugins_page() {
    add_theme_page(
        esc_html__( 'Recommended Plugins', 'klaro' ),
        esc_html__( 'Recommended Plugins', 'klaro' ),
        'install_plugins',
        'klaro-recommended-plugins',
        'klaro_recommended_plugins_page_content'
    );
}
add_action( 'admin_menu', 'klaro_add_recommended_plugins_page' );

/**
 * Display the Recommended Plugins page
 */
function klaro_recommended_plugins_page_content() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Recommended Plugins for Klaro Theme', 'klaro' ); ?></h1>

        <div class="notice notice-info">
            <p>
                <strong><?php esc_html_e( 'Important:', 'klaro' ); ?></strong>
                <?php esc_html_e( 'These plugins are completely optional. The Klaro theme is fully functional and accessible without them. These suggestions simply provide additional tools you may find useful.', 'klaro' ); ?>
            </p>
        </div>

        <div class="klaro-plugins-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 30px;">

            <!-- Classic Editor -->
            <div class="plugin-card" style="padding: 20px; background: #fff; border: 1px solid #ccd0d4; border-radius: 4px;">
                <h2><?php esc_html_e( 'Classic Editor', 'klaro' ); ?></h2>
                <p><?php esc_html_e( 'Replaces the block editor (Gutenberg) with the classic WordPress editor, which is significantly better for screen reader users.', 'klaro' ); ?></p>

                <h3><?php esc_html_e( 'Why Recommended:', 'klaro' ); ?></h3>
                <ul style="list-style: disc; margin-left: 2em;">
                    <li><?php esc_html_e( 'Better screen reader support', 'klaro' ); ?></li>
                    <li><?php esc_html_e( 'Simpler, linear interface', 'klaro' ); ?></li>
                    <li><?php esc_html_e( 'Predictable keyboard navigation', 'klaro' ); ?></li>
                    <li><?php esc_html_e( 'No complex nested blocks', 'klaro' ); ?></li>
                </ul>

                <?php if ( is_plugin_active( 'classic-editor/classic-editor.php' ) ) : ?>
                    <p><span class="dashicons dashicons-yes-alt" style="color: green;"></span> <strong><?php esc_html_e( 'Active', 'klaro' ); ?></strong></p>
                <?php elseif ( file_exists( WP_PLUGIN_DIR . '/classic-editor/classic-editor.php' ) ) : ?>
                    <a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>" class="button button-primary">
                        <?php esc_html_e( 'Activate', 'klaro' ); ?>
                    </a>
                <?php else : ?>
                    <a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=classic+editor&tab=search&type=term' ) ); ?>" class="button button-primary">
                        <?php esc_html_e( 'Install Now', 'klaro' ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- WP Accessibility -->
            <div class="plugin-card" style="padding: 20px; background: #fff; border: 1px solid #ccd0d4; border-radius: 4px;">
                <h2><?php esc_html_e( 'WP Accessibility', 'klaro' ); ?></h2>
                <p><?php esc_html_e( 'Adds helpful accessibility features like skip links removal detection, long description support, and more.', 'klaro' ); ?></p>

                <h3><?php esc_html_e( 'Features:', 'klaro' ); ?></h3>
                <ul style="list-style: disc; margin-left: 2em;">
                    <li><?php esc_html_e( 'Force focus state styling', 'klaro' ); ?></li>
                    <li><?php esc_html_e( 'Add outline to elements', 'klaro' ); ?></li>
                    <li><?php esc_html_e( 'Remove title attributes', 'klaro' ); ?></li>
                    <li><?php esc_html_e( 'Add language/text direction attributes', 'klaro' ); ?></li>
                </ul>

                <?php if ( is_plugin_active( 'wp-accessibility/wp-accessibility.php' ) ) : ?>
                    <p><span class="dashicons dashicons-yes-alt" style="color: green;"></span> <strong><?php esc_html_e( 'Active', 'klaro' ); ?></strong></p>
                <?php elseif ( file_exists( WP_PLUGIN_DIR . '/wp-accessibility/wp-accessibility.php' ) ) : ?>
                    <a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>" class="button button-primary">
                        <?php esc_html_e( 'Activate', 'klaro' ); ?>
                    </a>
                <?php else : ?>
                    <a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=wp+accessibility&tab=search&type=term' ) ); ?>" class="button button-primary">
                        <?php esc_html_e( 'Install Now', 'klaro' ); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Accessibility Checker -->
            <div class="plugin-card" style="padding: 20px; background: #fff; border: 1px solid #ccd0d4; border-radius: 4px;">
                <h2><?php esc_html_e( 'Accessibility Checker', 'klaro' ); ?></h2>
                <p><?php esc_html_e( 'Automatically checks your content for accessibility problems as you create it, providing instant feedback.', 'klaro' ); ?></p>

                <h3><?php esc_html_e( 'Features:', 'klaro' ); ?></h3>
                <ul style="list-style: disc; margin-left: 2em;">
                    <li><?php esc_html_e( 'Real-time accessibility checks', 'klaro' ); ?></li>
                    <li><?php esc_html_e( 'Checks for missing alt text', 'klaro' ); ?></li>
                    <li><?php esc_html_e( 'Heading structure validation', 'klaro' ); ?></li>
                    <li><?php esc_html_e( 'Color contrast checking', 'klaro' ); ?></li>
                </ul>

                <?php if ( is_plugin_active( 'accessibility-checker/accessibility-checker.php' ) ) : ?>
                    <p><span class="dashicons dashicons-yes-alt" style="color: green;"></span> <strong><?php esc_html_e( 'Active', 'klaro' ); ?></strong></p>
                <?php elseif ( file_exists( WP_PLUGIN_DIR . '/accessibility-checker/accessibility-checker.php' ) ) : ?>
                    <a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>" class="button button-primary">
                        <?php esc_html_e( 'Activate', 'klaro' ); ?>
                    </a>
                <?php else : ?>
                    <a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=accessibility+checker&tab=search&type=term' ) ); ?>" class="button button-primary">
                        <?php esc_html_e( 'Install Now', 'klaro' ); ?>
                    </a>
                <?php endif; ?>
            </div>

        </div>

        <div style="margin-top: 40px; padding: 20px; background: #f0f0f1; border-left: 4px solid #2271b1;">
            <h2><?php esc_html_e( 'Other Useful Accessibility Plugins', 'klaro' ); ?></h2>
            <p><?php esc_html_e( 'These additional plugins can also help improve accessibility:', 'klaro' ); ?></p>
            <ul style="list-style: disc; margin-left: 2em;">
                <li><strong>UserWay Accessibility Widget</strong> - <?php esc_html_e( 'Adds an accessibility menu to your site', 'klaro' ); ?></li>
                <li><strong>One Click Accessibility</strong> - <?php esc_html_e( 'Quick accessibility improvements', 'klaro' ); ?></li>
                <li><strong>WP ADA Compliance Check</strong> - <?php esc_html_e( 'Check your site for ADA compliance', 'klaro' ); ?></li>
            </ul>
        </div>
    </div>
    <?php
}
