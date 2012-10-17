<?php

// declare access to globals
global $commentpress_obj;



// init tab order
$cp_tab_order = array( 'comments', 'activity', 'contents' );

// if we have the plugin enabled and the method exists...
if ( 

	is_object( $commentpress_obj ) AND 
	method_exists( $commentpress_obj, 'get_sidebar_order' ) 
	
) {

	// get order from plugin options
	$cp_tab_order = $commentpress_obj->get_sidebar_order();

}

//print_r( $cp_tab_order ); die();



?><!-- sidebar.php -->

<div id="sidebar">

<div id="sidebar_inner">



<ul id="sidebar_tabs">

<?php

// ----------------------------------------
// SIDEBAR HEADERS
// ----------------------------------------


foreach( $cp_tab_order AS $cp_tab ) {

	switch ( $cp_tab ) {
	
	
	
		// Comments Header
		case 'comments':



?><li id="comments_header" class="sidebar_header">
<h2><a href="#comments_sidebar"><?php 

// set default link name
$cp_comments_title = apply_filters(

	// filter name
	'cp_tab_title_comments', 
	
	// default value
	__( 'Comments', 'commentpress-theme' )
	
);

echo $cp_comments_title; 

?></a></h2>
<?php

// init
$_min = '';

// if we have the plugin enabled...
if ( is_object( $commentpress_obj ) ) {

	// show the minimise all button
	$_min = $commentpress_obj->get_minimise_all_button( 'comments' );

}

// show the minimise all button
echo $_min;

?>
</li>

<?php 

break;



		// Activity Header
		case 'activity':



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

break;



		// Contents Header
		case 'contents':



?>
<li id="toc_header" class="sidebar_header">
<h2><a href="#toc_sidebar"><?php 

// set default link name
$cp_toc_title = apply_filters(

	// filter name
	'cp_tab_title_toc', 
	
	// default value
	__( 'Contents', 'commentpress-theme' )
	
);

echo $cp_toc_title; 

?></a></h2>
</li>
<?php 

break;



	} // end switch
	
} // end foreach


?>

</ul>



<?php




// ----------------------------------------
// THE SIDEBARS THEMSELVES
// ----------------------------------------

// plugin global
global $commentpress_obj, $post;

// if we have the plugin enabled...
if ( is_object( $commentpress_obj ) ) {



	// check commentable status
	$commentable = $commentpress_obj->is_commentable();

	// is it commentable?
	if ( $commentable ) {
	
		// until WordPress supports a locate_theme_file() function, use filter
		$include = apply_filters( 
			'cp_template_comments_sidebar',
			get_template_directory() . '/style/templates/comments_sidebar.php'
		);
		
		// get comments sidebar
		include( $include );
		
	}
	
	// until WordPress supports a locate_theme_file() function, use filter
	$include = apply_filters( 
		'cp_template_toc_sidebar',
		get_template_directory() . '/style/templates/toc_sidebar.php'
	);
	
	// always include TOC
	include( $include );
	
	// do we want to show activity tab?
	if ( cp_show_activity_tab() ) {
		
		// until WordPress supports a locate_theme_file() function, use filter
		$include = apply_filters( 
			'cp_template_activity_sidebar',
			get_template_directory() . '/style/templates/activity_sidebar.php'
		);
		
		// get activity sidebar
		include( $include );
		
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



