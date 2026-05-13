<?php
/**
 * Default content template-part.
 *
 * @package Travelio
 */
?>
<article <?php post_class( 'tv-post' ); ?>>
    <a class="tv-post-media" href="<?php the_permalink(); ?>">
        <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'travelio-card' ); }
        else { ?><img src="https://source.unsplash.com/600x400/?travel,<?php echo esc_attr( get_the_ID() ); ?>" alt=""><?php } ?>
    </a>
    <div class="tv-post-body">
        <div class="tv-post-meta"><?php echo esc_html( get_the_date() ); ?> &middot; <?php the_category( ', ' ); ?></div>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
        <a href="<?php the_permalink(); ?>" class="tv-readmore"><?php esc_html_e( 'Read article &rarr;', 'travelio' ); ?></a>
    </div>
</article>
