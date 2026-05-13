<?php
/**
 * Sidebar.
 *
 * @package Travelio
 */
if ( ! is_active_sidebar( 'sidebar-main' ) ) {
    ?>
    <div class="widget">
        <h3 class="widget-title"><?php esc_html_e( 'Search', 'travelio' ); ?></h3>
        <?php get_search_form(); ?>
    </div>
    <div class="widget">
        <h3 class="widget-title"><?php esc_html_e( 'Recent Posts', 'travelio' ); ?></h3>
        <ul>
            <?php
            $rp = new WP_Query( array( 'posts_per_page' => 5, 'no_found_rows' => true ) );
            while ( $rp->have_posts() ) : $rp->the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php endwhile; wp_reset_postdata(); ?>
        </ul>
    </div>
    <div class="widget">
        <h3 class="widget-title"><?php esc_html_e( 'Categories', 'travelio' ); ?></h3>
        <ul><?php wp_list_categories( array( 'title_li' => '' ) ); ?></ul>
    </div>
    <?php
} else {
    dynamic_sidebar( 'sidebar-main' );
}
