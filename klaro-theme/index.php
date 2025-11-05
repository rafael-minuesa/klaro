<?php
/**
 * The main template file
 *
 * @package Klaro
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main" role="main" aria-label="<?php esc_attr_e( 'Main content', 'klaro' ); ?>">

    <?php klaro_breadcrumbs(); ?>

    <div class="content-area">

        <?php
        if ( have_posts() ) :

            // Page header for archives
            if ( is_home() && ! is_front_page() ) :
                ?>
                <header class="page-header">
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                </header>
                <?php
            endif;

            if ( is_archive() ) :
                the_archive_title( '<header class="page-header"><h1 class="page-title">', '</h1></header>' );
                the_archive_description( '<div class="archive-description">', '</div>' );
            endif;

            // Start the Loop
            while ( have_posts() ) :
                the_post();

                /*
                 * Include the Post-Type-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                 */
                get_template_part( 'template-parts/content', get_post_type() );

            endwhile;

            // Previous/next page navigation
            the_posts_pagination( array(
                'mid_size'           => 2,
                'prev_text'          => sprintf(
                    '<span class="screen-reader-text">%s</span><span aria-hidden="true">%s</span>',
                    esc_html__( 'Previous page', 'klaro' ),
                    esc_html__( '← Previous', 'klaro' )
                ),
                'next_text'          => sprintf(
                    '<span class="screen-reader-text">%s</span><span aria-hidden="true">%s</span>',
                    esc_html__( 'Next page', 'klaro' ),
                    esc_html__( 'Next →', 'klaro' )
                ),
                'before_page_number' => '<span class="screen-reader-text">' . esc_html__( 'Page', 'klaro' ) . ' </span>',
                'aria_label'         => esc_html__( 'Posts navigation', 'klaro' ),
            ) );

        else :

            get_template_part( 'template-parts/content', 'none' );

        endif;
        ?>

    </div><!-- .content-area -->

    <?php get_sidebar(); ?>

</main><!-- #main-content -->

<?php
get_footer();
