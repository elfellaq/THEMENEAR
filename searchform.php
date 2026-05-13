<?php
/**
 * Search form.
 *
 * @package Travelio
 */
?>
<form role="search" method="get" class="tv-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="display:flex;gap:10px">
    <label class="screen-reader-text"><?php esc_html_e( 'Search', 'travelio' ); ?></label>
    <input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search tours, destinations, posts...', 'travelio' ); ?>" style="flex:1">
    <button type="submit" class="tv-btn tv-btn--primary"><?php esc_html_e( 'Search', 'travelio' ); ?></button>
</form>
