<?php
/**
 * Destination card template-part.
 *
 * @package Travelio
 */
?>
<a class="tv-dest" href="<?php the_permalink(); ?>">
    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'travelio-dest' ); }
    else { echo '<img src="https://picsum.photos/600/800?random='. esc_attr( get_the_ID() ) .'&travel" alt="">'; } ?>
    <div class="tv-dest-body">
        <h3><?php the_title(); ?></h3>
        <span><?php esc_html_e( 'View tours &rarr;', 'travelio' ); ?></span>
    </div>
</a>
