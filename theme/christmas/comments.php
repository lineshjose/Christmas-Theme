<!-- #comments -->
<fieldset id="comments">
<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'twentyten' ); ?></p>
		</fieldset>
<!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>
<?php 	// You can start editing here -- including this comment! ?>
<?php if ( have_comments() ) : ?>
<legend><?php printf( _n( 'One Comment', '%1$s Comments', get_comments_number(), 'twentyten' ), number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );?></legend>
<ol class="commentlist">
<?php wp_list_comments( array( 'callback' => 'twentyten_comment' ) ); ?>
</ol>
<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
<div class="navigation">
<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'twentyten' ) ); ?></div>
<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?></div>
<div class="clearboth"></div>
</div>
<!-- .navigation -->
<?php endif; // check for comment navigation ?>
<?php else : // this is displayed if there are no comments so far ?>
<?php if ('open' == $post->comment_status) : ?>
<!-- If comments are open, but there are no comments. -->
<?php else : // comments are closed ?>	<!-- If comments are closed. -->
<p class="nocomments">Comments are closed.</p>
<?php endif; ?>
<?php endif; ?>


<fieldset id="comments">
<?php if ('open' == $post->comment_status) : ?>
<legend>Leave a comment</legend>
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<?php if ( $user_ID ) : ?>
<table cellpadding="0" cellspacing="5" >
<?php else : ?>
<table cellpadding="0" cellspacing="5" >
<tr>
<th ><span><?php if ($req) echo "*"; ?></span><label for="author"> Name</label></th>
<td>
<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1"  class="textbox" />
</td>
</tr>
<tr>
<th ><span><?php if ($req) echo "**"; ?></span><label for="email"> Mail</label></th>
<td>
<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" class="textbox" />
</td>
</tr>
<tr>
<th ><label for="url">Website</label></th>
<td>
<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" class="textbox"  />
</td>
</tr>
<?php endif; ?>
<tr>
<th ><span><?php if ($req) echo "*"; ?></span><label for="comment">Your Comment</label></th>
<td><textarea name="comment" id="comment" cols="25" rows="5" tabindex="4" class="textarea" ></textarea><br/>
</td>
</tr>
<tr>
<td></td>
<td>
<small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small>
<br /><br />
<input name="submit" type="submit" id="submit" tabindex="5" value="Post"  class="button"/>
<input name="Reset" type="Reset" id="submit" tabindex="5" value="Clear"  class="button"/>
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
<span>*</span> Required , <span>**</span> will not be published.
</td>
</tr>
</table>
</p>
<?php do_action('comment_form', $post->ID); ?>
</form>
<?php endif; // If registration required and not logged in ?>
<?php endif; // if you delete this the sky will fall on your head ?>
</fieldset>