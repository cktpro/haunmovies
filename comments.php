<?php
if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if ( have_comments() ) : ?>
        <h2 class="comments-title">
            <?php
                printf(
                    _nx('Một bình luận', '%1$s bình luận', get_comments_number(), 'comments title'),
                    number_format_i18n(get_comments_number())
                );
            ?>
        </h2>

        <ol class="comment-list">
            <?php
                wp_list_comments(array(
                    'style'      => 'ol',
                    'short_ping' => true,
                ));
            ?>
        </ol>

        <?php the_comments_navigation(); ?>

    <?php endif; ?>

    <?php
    if ( comments_open() ) :
        comment_form(array(
            'title_reply'       => 'Viết bình luận',
            'label_submit'      => 'Gửi',
            'comment_field'     => '<p><textarea name="comment" id="comment" rows="5" placeholder="Nội dung..." required></textarea></p>',
        ));
    endif;
    ?>
</div>
