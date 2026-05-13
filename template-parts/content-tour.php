<?php
/**
 * Tour card template-part.
 *
 * @package Travelio
 */
$price    = travelio_meta( '_tv_tour_price', '$899' );
$duration = travelio_meta( '_tv_tour_duration', __( '5 Days', 'travelio' ) );
$rating   = travelio_meta( '_tv_tour_rating', '4.8' );
$is_feat  = (bool) travelio_meta( '_tv_tour_featured', '' );
?>
<article <?php post_class( 'tv-card' ); ?>>
    <a href="<?php the_permalink(); ?>" class="tv-card-media">
        <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'travelio-card' ); }
        else { echo '<img src="https://source.unsplash.com/600x450/?'. esc_attr( sanitize_title( get_the_title() ) ) .',travel" alt="">'; } ?>
        <?php if ( $is_feat ) : ?><span class="tv-card-badge"><?php esc_html_e( 'Featured', 'travelio' ); ?></span><?php endif; ?>
    </a>
    <div class="tv-card-body">
        <div class="tv-card-meta"><span>&#9201; <?php echo esc_html( $duration ); ?></span></div>
        <h3 class="tv-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p style="color:var(--tv-muted);font-size:.92rem;margin:0"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></p>
        <div class="tv-card-foot">
            <span class="tv-price"><?php echo esc_html( $price ); ?><small><?php esc_html_e( ' / person', 'travelio' ); ?></small></span>
            <span class="tv-rating">&#9733; <span class="num"><?php echo esc_html( $rating ); ?></span></span>
        </div>
    </div>
</article>
