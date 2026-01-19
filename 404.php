<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Klaro
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main" aria-label="<?php esc_attr_e( 'Main content', 'klaro' ); ?>">

    <?php klaro_breadcrumbs(); ?>

    <div class="content-area">

        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e( 'Oops! That page cannot be found.', 'klaro' ); ?></h1>
            </header><!-- .page-header -->

            <div class="page-content">
                <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'klaro' ); ?></p>

                <?php
                get_search_form();
                ?>

                <h2><?php esc_html_e( 'Recent Posts', 'klaro' ); ?></h2>
                <?php
                the_widget(
                    'WP_Widget_Recent_Posts',
                    array(
                        'number' => 5,
                    ),
                    array(
                        'before_widget' => '<div class="widget widget_recent_entries">',
                        'after_widget'  => '</div>',
                        'before_title'  => '<h3 class="widget-title">',
                        'after_title'   => '</h3>',
                    )
                );
                ?>

                <h2><?php esc_html_e( 'Categories', 'klaro' ); ?></h2>
                <?php
                the_widget(
                    'WP_Widget_Categories',
                    array(
                        'count'        => 1,
                        'hierarchical' => 1,
                        'dropdown'     => 0,
                    ),
                    array(
                        'before_widget' => '<div class="widget widget_categories">',
                        'after_widget'  => '</div>',
                        'before_title'  => '<h3 class="widget-title">',
                        'after_title'   => '</h3>',
                    )
                );
                ?>

                <h2><?php esc_html_e( 'Archives', 'klaro' ); ?></h2>
                <?php
                the_widget(
                    'WP_Widget_Archives',
                    array(
                        'count'    => 1,
                        'dropdown' => 0,
                    ),
                    array(
                        'before_widget' => '<div class="widget widget_archive">',
                        'after_widget'  => '</div>',
                        'before_title'  => '<h3 class="widget-title">',
                        'after_title'   => '</h3>',
                    )
                );
                ?>

                <h2><?php esc_html_e( 'Tag Cloud', 'klaro' ); ?></h2>
                <?php
                the_widget(
                    'WP_Widget_Tag_Cloud',
                    array(
                        'taxonomy' => 'post_tag',
                    ),
                    array(
                        'before_widget' => '<div class="widget widget_tag_cloud">',
                        'after_widget'  => '</div>',
                        'before_title'  => '<h3 class="widget-title">',
                        'after_title'   => '</h3>',
                    )
                );
                ?>

            </div><!-- .page-content -->
        </section><!-- .error-404 -->

    </div><!-- .content-area -->

    <?php get_sidebar(); ?>

</main><!-- #main-content -->

<?php
get_footer();
