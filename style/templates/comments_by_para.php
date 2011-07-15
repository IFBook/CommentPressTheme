<?php /*
===============================================================
Commentpress Theme Comments
===============================================================
AUTHOR			: Christian Wach <needle@haystack.co.uk>
LAST MODIFIED	: 09/04/2009
---------------------------------------------------------------
NOTES

Comments template for Commentpress

---------------------------------------------------------------
*/



// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments_by_para.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
	die ('Please do not load this page directly. Thanks!');
}



?>



<!-- comments_by_para.php -->

<div class="sidebar_contents_wrapper">



<div class="comments_container">



<?php if ('closed' == $post->comment_status) : ?>

	<!-- comments are closed. -->
	<h3 class="nocomments">Comments are closed</h3>

<?php endif; ?>

<?php cp_get_comments_by_para(); ?>



</div><!-- /comments_container -->



</div><!-- /sidebar_contents_wrapper -->



<?php

// include comment form
include( TEMPLATEPATH . '/style/templates/comment_form.php');

?>