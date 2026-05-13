<?php
/**
 * Comments template.
 *
 * @package Travelio
 */
if ( post_password_required() ) { return; } ?>

<div id="comments" class="comments-area">
    <?php if ( have_comments() ) : ?>
        <h3><?php
            printf(
                esc_html( _n( '%s comment', '%s comments', get_comments_number(), 'travelio' ) ),
                number_format_i18n( get_comments_number() )
            );
        ?></h3>
        <ol class="comment-list"><?php wp_list_comments( array( 'avatar_size' => 48, 'style' => 'ol' ) ); ?></ol>
        <?php the_comments_pagination(); ?>
    <?php endif; ?>
    <?php
    if ( comments_open() ) {
        comment_form();
    }
    ?>
</div>
