<?php



// set default link name
$cp_comments_title = apply_filters(

	// filter name
	'cp_tab_title_comments', 
	
	// default value
	__( 'Comments', 'commentpress-theme' )
	
);

// set default link name
$cp_toc_title = apply_filters(

	// filter name
	'cp_tab_title_toc', 
	
	// default value
	__( 'Contents', 'commentpress-theme' )
	
);



// init
$_min = '';

// declare access to globals
global $commentpress_obj;

// if we have the plugin enabled...
if ( is_object( $commentpress_obj ) ) {

	// show the minimise all button
	$_min = $commentpress_obj->get_minimise_all_button( 'comments' );

}




?><!-- sidebar.php -->

<div id="sidebar">

<div id="sidebar_inner">



<ul id="sidebar_tabs">

<li id="comments_header" class="sidebar_header">
<h2><a href="#comments_sidebar"><?php echo $cp_comments_title; ?></a></h2>
<?php

// show the minimise all button
echo $_min;

?>
</li>

<?php 

// do we want to show activity tab?
if ( cp_show_activity_tab() ) {
	
	// set default link name
	$cp_activity_title = apply_filters(
	
		// filter name
		'cp_tab_title_activity', 
		
		// default value
		__( 'Activity', 'commentpress-theme' )
		
	);
	
	?>
	<li id="activity_header" class="sidebar_header">
	<h2><a href="#activity_sidebar"><?php echo $cp_activity_title; ?></a></h2>
	<?php
	
	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// show the minimise all button
		echo $commentpress_obj->get_minimise_all_button( 'activity' );
	
	}
	
	?>
	</li>
	<?php

} else {

	// ignore activity
		
}

?>
<li id="toc_header" class="sidebar_header">
<h2><a href="#toc_sidebar"><?php echo $cp_toc_title; ?></a></h2>
</li>
<?php ?>

</ul>



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
		include (get_template_directory() . '/style/templates/comments_sidebar.php');
		
		// get activity sidebar
		include (get_template_directory() . '/style/templates/activity_sidebar.php');
		
		// get TOC
		include( get_template_directory() . '/style/templates/toc_sidebar.php' );
		
	} else {
	
		// always include TOC
		include( get_template_directory() . '/style/templates/toc_sidebar.php' );
		
		// do we want to show activity tab?
		if ( cp_show_activity_tab() ) {
			
			// get activity sidebar
			include (get_template_directory() . '/style/templates/activity_sidebar.php');
			
		} else {
			
		}
		
	}
	


} else {





// default sidebar when plugin not active...
?><div id="toc_sidebar">



<div class="sidebar_header">

<h2><?php echo $cp_toc_title; ?></h2>

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



