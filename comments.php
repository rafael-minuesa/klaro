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

<section id="comments" class="comments-area" aria-labelledby="comments-title">

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
