<?php
/**
 * Template part for displaying posts
 *
 * @package Klaro
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" aria-labelledby="post-title-<?php the_ID(); ?>">
    
    <header class="entry-header">
        <?php
        if ( is_singular() ) :
            the_title( '<h1 id="post-title-' . get_the_ID() . '" class="entry-title">', '</h1>' );
        else :
            the_title( '<h2 id="post-title-' . get_the_ID() . '" class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;
        ?>

        <?php if ( 'post' === get_post_type() ) : ?>
            <div class="entry-meta">
                <span class="posted-on">
                    <span class="screen-reader-text"><?php esc_html_e( 'Posted on', 'klaro' ); ?> </span>
                    <time class="entry-date published" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
                        <?php echo esc_html( get_the_date() ); ?>
                    </time>
                    <?php if ( get_the_modified_date() !== get_the_date() ) : ?>
                        <time class="updated" datetime="<?php echo esc_attr( get_the_modified_date( DATE_W3C ) ); ?>">
                            <?php
                            /* translators: %s: Post modified date */
                            printf( esc_html__( 'Updated: %s', 'klaro' ), esc_html( get_the_modified_date() ) );
                            ?>
                        </time>
                    <?php endif; ?>
                </span>

                <span class="byline">
                    <span class="screen-reader-text"><?php esc_html_e( 'By', 'klaro' ); ?> </span>
                    <span class="author vcard">
                        <a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                            <?php echo esc_html( get_the_author() ); ?>
                        </a>
                    </span>
                </span>

                <?php
                $categories = get_the_category();
                if ( ! empty( $categories ) ) :
                    ?>
                    <span class="cat-links">
                        <span class="screen-reader-text"><?php esc_html_e( 'Categories:', 'klaro' ); ?> </span>
                        <?php
                        echo '<ul class="post-categories">';
                        foreach ( $categories as $category ) {
                            echo '<li><a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a></li>';
                        }
                        echo '</ul>';
                        ?>
                    </span>
                    <?php
                endif;
                ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->

    <?php if ( has_post_thumbnail() && ! is_singular() ) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                <?php
                the_post_thumbnail( 'medium', array(
                    'alt' => the_title_attribute( array( 'echo' => false ) ),
                ) );
                ?>
            </a>
        </div><!-- .post-thumbnail -->
    <?php endif; ?>

    <div class="entry-content">
        <?php
        if ( is_singular() ) :
            the_content(
                sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post */
                        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'klaro' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post( get_the_title() )
                )
            );

            wp_link_pages(
                array(
                    'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page navigation', 'klaro' ) . '"><span class="page-links-title">' . esc_html__( 'Pages:', 'klaro' ) . '</span>',
                    'after'  => '</nav>',
                )
            );
        else :
            the_excerpt();
        endif;
        ?>
    </div><!-- .entry-content -->

    <?php if ( is_singular() ) : ?>
        <footer class="entry-footer">
            <?php
            $tags_list = get_the_tag_list();
            if ( $tags_list ) :
                ?>
                <div class="tags-links">
                    <span class="screen-reader-text"><?php esc_html_e( 'Tags:', 'klaro' ); ?> </span>
                    <?php echo $tags_list; ?>
                </div>
                <?php
            endif;
            ?>

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
