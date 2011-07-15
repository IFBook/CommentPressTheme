<!-- comments_sidebar.php -->

<div id="comments_sidebar">



<div class="sidebar_header">
<?php

// declare access to globals
global $commentpress_obj;

// if we have the plugin enabled...
if ( is_object( $commentpress_obj ) ) {

	// show the minimise button
	echo $commentpress_obj->get_minimise_button( 'comments' );

	// show the minimise all button
	echo $commentpress_obj->get_minimise_all_button( 'comments' );

}

?>

<h2>Comments</h2>

</div>



<div class="sidebar_minimiser">

<?php comments_template(); ?>
	
</div><!-- /sidebar_minimiser -->



</div><!-- /comments_sidebar -->



