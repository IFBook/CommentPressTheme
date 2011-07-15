<!-- sidebar.php -->

<div id="sidebar">

<div id="sidebar_inner">

<?php

// plugin global
global $commentpress_obj, $post;

// if we have the plugin enabled...
if ( is_object( $commentpress_obj ) ) {

	
	
	// get sidebar
	$sidebar_flag = $commentpress_obj->get_default_sidebar();

	// is it a commentable page?
	if ( $sidebar_flag == 'comments' ) {
			
		// get comments sidebar
		include (TEMPLATEPATH . '/style/templates/comments_sidebar.php');
	
	// test for Archive Sidebar (everything else)
	} elseif ( $sidebar_flag == 'archive' ) {
	
		// get archive sidebar
		include (TEMPLATEPATH . '/style/templates/archive_sidebar.php');
		
	}
	
	
	
	// always include TOC
	include( TEMPLATEPATH . '/style/templates/toc_sidebar.php' );
	


} else {



// default sidebar when plugin not active...
?><div id="toc_sidebar">



<div class="sidebar_header">

<h2>Table of Contents</h2>

</div>



<div class="sidebar_minimiser">

<div class="sidebar_contents_wrapper">

<ul>
	<?php wp_list_pages('sort_column=menu_order&title_li='); ?>
</ul>

</div><!-- /sidebar_contents_wrapper -->

</div><!-- /sidebar_minimiser -->



</div><!-- /toc_sidebar -->



<?php 

} // end check for plugin

?>



</div><!-- /sidebar_inner -->

</div><!-- /sidebar -->



