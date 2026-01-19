<?php
/**
 * The template for displaying pages
 *
 * @package Klaro
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main" aria-label="<?php esc_attr_e( 'Main content', 'klaro' ); ?>">

    <?php klaro_breadcrumbs(); ?>

    <div class="content-area">

        <?php
        while ( have_posts() ) :
            the_post();

            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> aria-labelledby="page-title-<?php the_ID(); ?>">
                
                <header class="entry-header">
                    <?php the_title( '<h1 id="page-title-' . get_the_ID() . '" class="entry-title">', '</h1>' ); ?>
                </header><!-- .entry-header -->

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="post-thumbnail">
                        <?php
                        the_post_thumbnail( 'large', array(
                            'alt' => the_title_attribute( array( 'echo' => false ) ),
                        ) );
                        ?>
                    </div><!-- .post-thumbnail -->
                <?php endif; ?>

                <div class="entry-content">
                    <?php
                    the_content();

                    wp_link_pages(
                        array(
                            'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page navigation', 'klaro' ) . '"><span class="page-links-title">' . esc_html__( 'Pages:', 'klaro' ) . '</span>',
                            'after'  => '</nav>',
                        )
                    );
                    ?>
                </div><!-- .entry-content -->

                <?php if ( get_edit_post_link() ) : ?>
                    <footer class="entry-footer">
                        <?php
                        edit_post_link(
                            sprintf(
                                wp_kses(
                                    /* translators: %s: Name of current post */
                                    __( 'Edit <span class="screen-reader-text">"%s"</span>', 'klaro' ),
                                    array(
                                        'span' => array(
                                            'class' => array(),
                                        ),
                                    )
                                ),
                                wp_kses_post( get_the_title() )
                            ),
                            '<span class="edit-link">',
                            '</span>'
                        );
                        ?>
                    </footer><!-- .entry-footer -->
                <?php endif; ?>

            </article><!-- #post-<?php the_ID(); ?> -->

            <?php
            // If comments are open or there is at least one comment, load the comment template
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        endwhile;
        ?>

    </div><!-- .content-area -->

    <?php get_sidebar(); ?>

</main><!-- #main-content -->

<?php
get_footer();
