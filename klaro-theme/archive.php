<?php
/**
 * The template for displaying archive pages
 *
 * @package Klaro
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main" role="main" aria-label="<?php esc_attr_e( 'Main content', 'klaro' ); ?>">

    <?php klaro_breadcrumbs(); ?>

    <div class="content-area">

        <?php if ( have_posts() ) : ?>

            <header class="page-header">
                <?php
                the_archive_title( '<h1 class="page-title">', '</h1>' );
                the_archive_description( '<div class="archive-description">', '</div>' );
                ?>
            </header><!-- .page-header -->

            <?php
            // Start the Loop.
            while ( have_posts() ) :
                the_post();

                /*
                 * Include the Post-Type-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                 */
                get_template_part( 'template-parts/content', get_post_type() );

            endwhile;

            // Pagination for accessibility
            ?>
            <nav class="pagination" role="navigation" aria-label="<?php esc_attr_e( 'Archive pagination', 'klaro' ); ?>">
                <?php
                the_posts_pagination(
                    array(
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
                        'before_page_number' => '<span class="screen-reader-text">' . esc_html__( 'Page ', 'klaro' ) . '</span>',
                    )
                );
                ?>
            </nav>

        <?php
        else :
            // If no content, include the "No posts found" template.
            get_template_part( 'template-parts/content', 'none' );

        endif;
        ?>

    </div><!-- .content-area -->

    <?php get_sidebar(); ?>

</main><!-- #main-content -->

<?php
get_footer();
