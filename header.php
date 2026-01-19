<?php
/**
 * The header template file
 *
 * @package Klaro
 * @since 1.0.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php klaro_skip_links(); ?>

<div id="page" class="site-container">

    <header id="masthead" class="site-header">

        <div class="header-top">
            <div class="site-branding">
                <?php
                if ( has_custom_logo() ) :
                    the_custom_logo();
                endif;
                ?>

                <div class="site-title-group">
                    <?php
                    if ( is_front_page() && is_home() ) :
                        ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </h1>
                        <?php
                    else :
                        ?>
                        <p class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <?php bloginfo( 'name' ); ?>
                            </a>
                        </p>
                        <?php
                    endif;

                    $klaro_description = get_bloginfo( 'description', 'display' );
                    if ( $klaro_description || is_customize_preview() ) :
                        ?>
                        <p class="site-description"><?php echo esc_html( $klaro_description ); ?></p>
                        <?php
                    endif;
                    ?>
                </div><!-- .site-title-group -->
            </div><!-- .site-branding -->

            <!-- Accessibility Toolbar -->
            <div class="accessibility-toolbar" role="region" aria-label="<?php esc_attr_e( 'Accessibility settings', 'klaro' ); ?>">
                <details class="accessibility-menu">
                    <summary class="accessibility-toggle" aria-label="<?php esc_attr_e( 'Open accessibility options', 'klaro' ); ?>">
                        <span class="dashicons dashicons-universal-access-alt accessibility-icon" aria-hidden="true"></span>
                        <span class="accessibility-label"><?php esc_html_e( 'Accessibility', 'klaro' ); ?></span>
                    </summary>

                    <div class="accessibility-controls">
                        <h2 class="screen-reader-text"><?php esc_html_e( 'Adjust text and display settings', 'klaro' ); ?></h2>

                        <div class="accessibility-section">
                            <span class="accessibility-section-label"><?php esc_html_e( 'Text Size', 'klaro' ); ?></span>
                            <div class="accessibility-buttons">
                                <button type="button" id="decrease-font" class="accessibility-button" aria-label="<?php esc_attr_e( 'Decrease text size', 'klaro' ); ?>">
                                    <span aria-hidden="true">A-</span>
                                </button>
                                <button type="button" id="reset-font" class="accessibility-button" aria-label="<?php esc_attr_e( 'Reset text size to default', 'klaro' ); ?>">
                                    <span aria-hidden="true">A</span>
                                </button>
                                <button type="button" id="increase-font" class="accessibility-button" aria-label="<?php esc_attr_e( 'Increase text size', 'klaro' ); ?>">
                                    <span aria-hidden="true">A+</span>
                                </button>
                            </div>
                        </div>

                        <div class="accessibility-section">
                            <span class="accessibility-section-label"><?php esc_html_e( 'Contrast', 'klaro' ); ?></span>
                            <div class="accessibility-buttons">
                                <button type="button" id="toggle-contrast" class="accessibility-button" aria-label="<?php esc_attr_e( 'Toggle high contrast mode', 'klaro' ); ?>" aria-pressed="false">
                                    <span aria-hidden="true"><?php esc_html_e( 'High', 'klaro' ); ?></span>
                                </button>
                                <button type="button" id="toggle-monochrome" class="accessibility-button" aria-label="<?php esc_attr_e( 'Toggle monochrome mode', 'klaro' ); ?>" aria-pressed="false">
                                    <span aria-hidden="true"><?php esc_html_e( 'Mono', 'klaro' ); ?></span>
                                </button>
                            </div>
                        </div>

                        <div class="accessibility-section">
                            <span class="accessibility-section-label"><?php esc_html_e( 'Motion', 'klaro' ); ?></span>
                            <div class="accessibility-buttons">
                                <button type="button" id="toggle-animations" class="accessibility-button" aria-label="<?php esc_attr_e( 'Disable animations and transitions', 'klaro' ); ?>" aria-pressed="false">
                                    <span aria-hidden="true"><?php esc_html_e( 'Reduce', 'klaro' ); ?></span>
                                </button>
                            </div>
                        </div>
                    </div><!-- .accessibility-controls -->

                    <div id="accessibility-status" class="screen-reader-text" role="status" aria-live="polite" aria-atomic="true"></div>
                </details>
            </div><!-- .accessibility-toolbar -->
        </div><!-- .header-top -->

        <nav id="primary-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'klaro' ); ?>">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'primary-menu',
                        'container'      => false,
                        'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
                    )
                );
            } else {
                ?>
                <p>
                    <a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>">
                        <?php esc_html_e( 'Set up your primary navigation menu', 'klaro' ); ?>
                    </a>
                </p>
                <?php
            }
            ?>
        </nav><!-- #primary-navigation -->

    </header><!-- #masthead -->
