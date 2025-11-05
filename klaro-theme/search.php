<?php
/**
 * The template for displaying search results pages
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
                <h1 class="page-title">
                    <?php
                    printf(
                        /* translators: %s: search query */
                        esc_html__( 'Search Results for: %s', 'klaro' ),
                        '<span>' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
                <p class="search-result-count" role="status">
                    <?php
                    printf(
                        /* translators: %s: number of results */
                        esc_html( _n( 'Found %s result', 'Found %s results', $wp_query->found_posts, 'klaro' ) ),
                        number_format_i18n( $wp_query->found_posts )
                    );
                    ?>
                </p>
            </header><!-- .page-header -->

            <?php
            // Start the Loop.
            while ( have_posts() ) :
                the_post();

                /**
                 * Run the loop for the search to output the results.
                 * If you want to overload this in a child theme then include a file
                 * called content-search.php and that will be used instead.
                 */
                get_template_part( 'template-parts/content', 'search' );

            endwhile;

            // Pagination for accessibility
            ?>
            <nav class="pagination" role="navigation" aria-label="<?php esc_attr_e( 'Search results pagination', 'klaro' ); ?>">
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
            ?>
            <header class="page-header">
                <h1 class="page-title">
                    <?php
                    printf(
                        /* translators: %s: search query */
                        esc_html__( 'No Results for: %s', 'klaro' ),
                        '<span>' . get_search_query() . '</span>'
                    );
                    ?>
                </h1>
            </header><!-- .page-header -->

            <div class="no-results">
                <p><?php esc_html_e( 'Sorry, no content matched your search criteria. Please try a different search.', 'klaro' ); ?></p>

                <section class="search-again" aria-label="<?php esc_attr_e( 'Try another search', 'klaro' ); ?>">
                    <h2><?php esc_html_e( 'Try Another Search', 'klaro' ); ?></h2>
                    <?php get_search_form(); ?>
                </section>

                <section class="helpful-links" aria-label="<?php esc_attr_e( 'Helpful links', 'klaro' ); ?>">
                    <h2><?php esc_html_e( 'Helpful Links', 'klaro' ); ?></h2>
                    <ul>
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Return to Homepage', 'klaro' ); ?></a></li>
                        <?php if ( has_nav_menu( 'primary' ) ) : ?>
                            <li><a href="#primary-navigation"><?php esc_html_e( 'Browse our main menu', 'klaro' ); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </section>
            </div><!-- .no-results -->
            <?php
        endif;
        ?>

    </div><!-- .content-area -->

    <?php get_sidebar(); ?>

</main><!-- #main-content -->

<?php
get_footer();
