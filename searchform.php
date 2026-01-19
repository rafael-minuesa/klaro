<?php
/**
 * Template for displaying search forms
 *
 * @package Klaro
 * @since 1.0.0
 */

$unique_id = wp_unique_id( 'search-field-' );
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Search this website', 'klaro' ); ?>">
    <label for="<?php echo esc_attr( $unique_id ); ?>">
        <span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'klaro' ); ?></span>
        <input
            type="search"
            id="<?php echo esc_attr( $unique_id ); ?>"
            class="search-field"
            placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'klaro' ); ?>"
            value="<?php echo get_search_query(); ?>"
            name="s"
            autocomplete="off"
            aria-describedby="<?php echo esc_attr( $unique_id ); ?>-description"
        />
        <span id="<?php echo esc_attr( $unique_id ); ?>-description" class="screen-reader-text">
            <?php esc_html_e( 'Press enter to search or escape to close', 'klaro' ); ?>
        </span>
    </label>
    <button type="submit" class="search-submit">
        <span class="search-text"><?php echo esc_html_x( 'Search', 'submit button', 'klaro' ); ?></span>
        <span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'klaro' ); ?></span>
    </button>
</form>
