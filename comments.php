<?php
/**
 * The template for displaying comments
 *
 * @package Klaro
 * @since 1.0.0
 */

if ( post_password_required() ) {
    return;
}
?>

<section id="comments" class="comments-area" role="region" aria-labelledby="comments-title">

    <?php
    if ( have_comments() ) :
        ?>
        <h2 id="comments-title" class="comments-title">
            <?php
            $klaro_comment_count = get_comments_number();
            if ( '1' === $klaro_comment_count ) {
                printf(
                    /* translators: %s: Post title */
                    esc_html__( 'One comment on &ldquo;%s&rdquo;', 'klaro' ),
                    '<span>' . wp_kses_post( get_the_title() ) . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: Number of comments, 2: Post title */
                    esc_html( _n( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $klaro_comment_count, 'klaro' ) ),
                    number_format_i18n( $klaro_comment_count ),
                    '<span>' . wp_kses_post( get_the_title() ) . '</span>'
                );
            }
            ?>
        </h2><!-- .comments-title -->

        <?php the_comments_navigation(); ?>

        <ol class="comment-list" aria-label="<?php esc_attr_e( 'Comments list', 'klaro' ); ?>">
            <?php
            wp_list_comments(
                array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 60,
                    'callback'    => 'klaro_comment_callback',
                )
            );
            ?>
        </ol><!-- .comment-list -->

        <?php
        the_comments_navigation();

        // If comments are closed and there are comments, show a notice
        if ( ! comments_open() ) :
            ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'klaro' ); ?></p>
            <?php
        endif;

    endif;

    comment_form(
        array(
            'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
            'title_reply_after'  => '</h2>',
            'title_reply'        => esc_html__( 'Leave a Comment', 'klaro' ),
            'aria_label'         => esc_html__( 'Comment form', 'klaro' ),
        )
    );
    ?>

</section><!-- #comments -->

<?php
/**
 * Custom comment callback for better accessibility
 */
function klaro_comment_callback( $comment, $args, $depth ) {
    ?>
    <li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> role="article" aria-labelledby="comment-<?php comment_ID(); ?>-meta">
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <footer class="comment-meta" id="comment-<?php comment_ID(); ?>-meta">
                <div class="comment-author vcard">
                    <?php
                    if ( 0 != $args['avatar_size'] ) {
                        echo get_avatar( $comment, $args['avatar_size'], '', get_comment_author(), array( 'role' => 'img' ) );
                    }
                    ?>
                    <span class="fn" itemprop="author" itemscope itemtype="https://schema.org/Person">
                        <span itemprop="name"><?php comment_author_link(); ?></span>
                    </span>
                </div><!-- .comment-author -->

                <div class="comment-metadata">
                    <a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
                        <time datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished">
                            <?php
                            /* translators: 1: Comment date, 2: Comment time */
                            printf( esc_html__( '%1$s at %2$s', 'klaro' ), get_comment_date( '', $comment ), get_comment_time() );
                            ?>
                        </time>
                    </a>
                    <?php
                    edit_comment_link( esc_html__( 'Edit', 'klaro' ), '<span class="edit-link">', '</span>' );
                    ?>
                </div><!-- .comment-metadata -->

                <?php if ( '0' == $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation" role="status"><?php esc_html_e( 'Your comment is awaiting moderation.', 'klaro' ); ?></p>
                <?php endif; ?>
            </footer><!-- .comment-meta -->

            <div class="comment-content" itemprop="text">
                <?php comment_text(); ?>
            </div><!-- .comment-content -->

            <?php
            comment_reply_link(
                array_merge(
                    $args,
                    array(
                        'add_below' => 'div-comment',
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                        'before'    => '<div class="reply">',
                        'after'     => '</div>',
                    )
                )
            );
            ?>
        </article><!-- .comment-body -->
    <?php
}
