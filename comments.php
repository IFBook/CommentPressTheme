<?php /*
===============================================================
Commentpress Theme Comments
===============================================================
AUTHOR			: Christian Wach <needle@haystack.co.uk>
LAST MODIFIED	: 22/03/2009
---------------------------------------------------------------
NOTES

---------------------------------------------------------------
*/



// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
	die ('Please do not load this page directly. Thanks!');
}

if ( post_password_required() ) { ?>

<div class="sidebar_contents_wrapper">
<div class="comments_container">
	<h3 class="nocomments">Enter the password to view comments</h3>
</div><!-- /comments_container -->
</div><!-- /sidebar_contents_wrapper -->

<?php
	return;
}



// declare access to globals
global $commentpress_obj, $post;

// if we have the plugin enabled...
if ( is_object( $commentpress_obj ) ) {

	// are we asking for in-page comments?
	if ( $commentpress_obj->db->is_special_page() ) {

		// include 'comments in page' template
		include(get_template_directory() . '/style/templates/comments_in_page.php');
		return;
		
	}

	// are we allowing comments on paragraphs?
	if ( $commentpress_obj->comments_by_paragraph() ) {

		// include comments split by paragraph template
		include(get_template_directory() . '/style/templates/comments_by_para.php');
		return;
		
	}

}



?>



<!-- comments.php -->

<div id="sidebar_contents_wrapper">



<div class="comments_container">



<?php if ( have_comments() ) : ?>



	<h3 id="para-heading-"><?php 
	
	comments_number(
		'<span>0</span> comments', 
		'<span>1</span> comment', 
		'<span>%</span> comments'
	); 
	
	?> on the whole page</h3>



	<div class="paragraph_wrapper">

		<ol class="commentlist">
	
		<?php wp_list_comments(
		
			array(
			
				// list comments params
				'type'=> 'comment', 
				'reply_text' => 'Reply to this comment',
				'callback' => 'cp_comments'
				
			)
			
		); ?>
	
		</ol>

		<div class="reply_to_para" id="reply_to_para-">
		<p><a class="reply_to_para" href="<?php the_permalink() ?>?replytopara#respond" onclick="return addComment.moveFormToPara( '', '', '1' )">Leave a comment on the whole page</a></p>
		</div>
		
	</div><!-- /paragraph_wrapper -->



<?php else : // this is displayed if there are no comments so far ?>



	<?php if ('open' == $post->comment_status) : ?>

		<!-- comments are open, but there are no comments. -->
		<h3 class="nocomments">No comments on the whole page</h3>

		<div class="paragraph_wrapper">
	
			<div class="reply_to_para" id="reply_to_para-">
			<p><a class="reply_to_para" href="<?php the_permalink() ?>?replytopara#respond" onclick="return addComment.moveFormToPara( '', '', '1' )">Leave a comment on the whole page</a></p>
			</div>
			
		</div><!-- /paragraph_wrapper -->
	
	 <?php else : // comments are closed ?>

		<!-- comments are closed. -->
		<h3 class="nocomments">Comments are closed.</h3>

	<?php endif; ?>



<?php endif; ?>



</div><!-- /comments_container -->



</div><!-- /sidebar_contents_wrapper -->



<?php

// include comment form
include( get_template_directory() . '/style/templates/comment_form.php');

?>