<?php
/**
 * Template part for displaying search results
 *
 * @package Klaro
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" aria-labelledby="post-title-<?php the_ID(); ?>">

    <header class="entry-header">
        <?php the_title( sprintf( '<h2 id="post-title-%s" class="entry-title"><a href="%s" rel="bookmark">', get_the_ID(), esc_url( get_permalink() ) ), '</a></h2>' ); ?>

        <?php if ( 'post' === get_post_type() ) : ?>
            <div class="entry-meta">
                <span class="posted-on">
                    <span class="screen-reader-text"><?php esc_html_e( 'Posted on ', 'klaro' ); ?></span>
                    <time class="entry-date published" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
                        <?php echo esc_html( get_the_date() ); ?>
                    </time>
                </span>

                <span class="byline">
                    <span class="screen-reader-text"><?php esc_html_e( 'By ', 'klaro' ); ?></span>
                    <span class="author vcard">
                        <a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                            <?php echo esc_html( get_the_author() ); ?>
                        </a>
                    </span>
                </span>

                <?php if ( has_category() ) : ?>
                    <span class="cat-links">
                        <span class="screen-reader-text"><?php esc_html_e( 'Categories: ', 'klaro' ); ?></span>
                        <?php the_category( ', ' ); ?>
                    </span>
                <?php endif; ?>
            </div><!-- .entry-meta -->
        <?php endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div><!-- .entry-summary -->

    <footer class="entry-footer">
        <a href="<?php the_permalink(); ?>" class="read-more" aria-label="<?php echo esc_attr( sprintf( __( 'Continue reading %s', 'klaro' ), get_the_title() ) ); ?>">
            <?php esc_html_e( 'Read More', 'klaro' ); ?>
            <span aria-hidden="true"> →</span>
        </a>
    </footer><!-- .entry-footer -->

</article><!-- #post-<?php the_ID(); ?> -->
