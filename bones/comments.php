<?php
/*
The comments page for Bones
*/

// don't load it if you can't comment
if ( post_password_required() ) {
  return;
}

?>

<?php // You can start editing here. ?>

  <?php if ( have_comments() ) : ?>

    <h3 id="comments-title" class="h2"><?php comments_number( __( '<span>No</span> Comments', 'bonestheme' ), __( '<span>One</span> Comment', 'bonestheme' ), __( '<span>%</span> Comments', 'bonestheme' ) );?></h3>

    <section class="commentlist">
      <?php
        wp_list_comments( array(
          'style'             => 'div',
          'short_ping'        => true,
          'avatar_size'       => 40,
          'callback'          => 'bones_comments',
          'type'              => 'all',
          'reply_text'        => __('Reply', 'bonestheme'),
          'page'              => '',
          'per_page'          => '',
          'reverse_top_level' => null,
          'reverse_children'  => ''
        ) );
      ?>
    </section>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
    	<nav class="navigation comment-navigation" role="navigation">
      	<div class="comment-nav-prev"><?php previous_comments_link( __( '&larr; Previous Comments', 'bonestheme' ) ); ?></div>
      	<div class="comment-nav-next"><?php next_comments_link( __( 'More Comments &rarr;', 'bonestheme' ) ); ?></div>
    	</nav>
    <?php endif; ?>

    <?php if ( ! comments_open() ) : ?>
    	<p class="no-comments"><?php _e( 'Comments are closed.' , 'bonestheme' ); ?></p>
    <?php endif; ?>

  <?php endif; ?>

  <?php //comment_form(); ?>


  <?php $args = array(
'id_form'           => 'commentform',
'id_submit'         => 'submit',
'title_reply'       => __( 'Leave a Comment' ),
'title_reply_to'    => __( 'Leave a Comment to %s' ),
'cancel_reply_link' => __( 'Cancel Comment' ),
'label_submit'      => __( 'Post Comment' ),
'comment_notes_after' => '',
'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) .
  '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
'must_log_in' => '<p class="must-log-in">' .
  sprintf(
    __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
    wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
  ) . '</p>',
'logged_in_as' => '<p class="logged-in-as">' .
  sprintf(
  __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
    admin_url( 'profile.php' ),
    $user_identity,
    wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
  ) . '</p>',
'comment_notes_before' => '',
'comment_notes_after' => '',
'fields' => apply_filters( 'comment_form_default_fields', array(
  'author' =>
    '<p class="comment-form-author">' .
    '<label for="author">' . __( 'Name*', 'domainreference' ) . '</label> ' .
    ( $req ? '' : '' ) .
    '<input id="author" class="commentNameField" name="author" type="text" /></p>',
  'email' =>
    '<p class="comment-form-email"><label for="email">' . __( 'Email*', 'domainreference' ) . '</label> ' .
    ( $req ? '' : '' ) .
    '<input id="email" class="commentEmailField" name="email" type="text" /></p>',
  'url' => ''
  )
),
);

ob_start();
comment_form($args);

?>

