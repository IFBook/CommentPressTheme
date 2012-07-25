<?php /*
===============================================================
Commentpress Theme Comment Form
===============================================================
AUTHOR			: Christian Wach <needle@haystack.co.uk>
LAST MODIFIED	: 21/10/2010
---------------------------------------------------------------
NOTES

Comment form template for Commentpress

---------------------------------------------------------------
*/



// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comment_form.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
	die ('Please do not load this page directly. Thanks!');
}



// access post
global $post;

?>



<!-- comment_form.php -->

<?php if ('open' == $post->comment_status) : ?>



<div id="respond_wrapper">



<div id="respond">



<h4 id="respond_title"><?php cp_comment_form_title( 'Leave a Comment', 'Leave a Reply to %s' ); ?></h4>

<div class="cancel-comment-reply">
	<p><?php cancel_comment_reply_link('Cancel'); ?></p>
</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>

	<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>

<?php else : ?>

	<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="commentform">
	
	<fieldset id="author_details">
	
		<legend class="off-left">Your details</legend>
		
		<?php if ( $user_ID ) : ?>
		
			<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
		
		<?php else : ?>
		
			<p><label for="author"><small>Name<?php if ($req) echo ' <span class="req">(required)</span>'; ?></small></label><br />
			<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="30"<?php if ($req) echo ' aria-required="true"'; ?> /></p>
			
			<p><label for="email"><small>Mail (will not be published)<?php if ($req) echo ' <span class="req">(required)</span>'; ?></small></label><br />
			<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="30"<?php if ($req) { echo ' aria-required="true"'; } ?> /></p>
			
			<p><label for="url"><small>Website</small></label><br />
			<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="30" /></p>
		
		<?php endif; ?>
		
	</fieldset>
	
	<fieldset id="comment_details">
	
		<legend class="off-left">Your comment</legend>
		
		<p><label for="comment" class="off-left">Comment</label><br />
		<?php
		
		// in functions.php
		if ( false === cp_add_wp_editor() ) {
			
			?>
			<textarea name="comment" class="comment" id="comment" cols="100%" rows="10"></textarea>
			<?php
		
		}
		
		?>		
		</p>
	
	</fieldset>
	
	<?php 
	
	// add default wp fields
	comment_id_fields();
	
	// get text sig input
	global $commentpress_obj;
	if ( is_object( $commentpress_obj ) ) {
		echo $commentpress_obj->get_signature_field();
	}
	
	// add page for multipage situations
	global $page;
	if ( !empty( $page ) ) {
		echo "\n".'<input type="hidden" name="page" value="'.$page.'" />'."\n";
	}
	?>

	<p id="respond_button"><input name="submit" type="submit" id="submit" value="Submit Comment" /></p>

	<?php do_action('comment_form', $post->ID); ?>

	</form>

<?php endif; // If registration required and not logged in ?>



</div><!-- /respond -->



</div><!-- /respond_wrapper -->



<?php endif; // end open comment status check ?>



