<?php
/**
 * Archive: Activities.
 *
 * @package NearTrips
 */

get_header();
?>

<div class="nt-page-hero">
    <div class="nt-container">
        <h1><?php esc_html_e( 'Activities', 'neartrips' ); ?></h1>
        <p class="nt-text-muted"><?php printf( __( '%d activities available', 'neartrips' ), (int) $wp_query->found_posts ); ?></p>
    </div>
</div>

<div class="nt-section nt-section--sm">
    <div class="nt-container">
        <div class="nt-archive-layout">

            <aside class="nt-archive-sidebar">
                <div class="nt-filter-box">
                    <div class="nt-filter-box__title"><?php esc_html_e( 'Category', 'neartrips' ); ?></div>
                    <?php $cats = get_terms( [ 'taxonomy' => 'nt_activity_cat', 'hide_empty' => true ] );
                    if ( ! is_wp_error( $cats ) ) : foreach ( $cats as $cat ) : ?>
                        <label class="nt-filter-option"><input type="checkbox" name="activity_cat[]" value="<?php echo esc_attr( $cat->slug ); ?>"><?php echo esc_html( $cat->name ); ?></label>
                    <?php endforeach; endif; ?>
                </div>
                <div class="nt-filter-box">
                    <div class="nt-filter-box__title"><?php esc_html_e( 'Difficulty', 'neartrips' ); ?></div>
                    <?php foreach ( [ 'easy' => __( 'Easy', 'neartrips' ), 'moderate' => __( 'Moderate', 'neartrips' ), 'hard' => __( 'Hard', 'neartrips' ) ] as $val => $label ) : ?>
                        <label class="nt-filter-option"><input type="radio" name="difficulty" value="<?php echo esc_attr( $val ); ?>"><?php echo esc_html( $label ); ?></label>
                    <?php endforeach; ?>
                </div>
            </aside>

            <div>
                <?php if ( have_posts() ) : ?>
                    <div class="nt-grid-3" data-anim="stagger">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php get_template_part( 'template-parts/cards/card', 'activity', [ 'post_id' => get_the_ID() ] ); ?>
                        <?php endwhile; ?>
                    </div>
                    <?php nt_pagination(); ?>
                <?php else : ?>
                    <div class="nt-notice nt-notice--info"><?php esc_html_e( 'No activities found.', 'neartrips' ); ?></div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); ?>
