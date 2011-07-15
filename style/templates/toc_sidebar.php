<!-- toc_sidebar.php -->

<div id="toc_sidebar">



<div class="sidebar_header">

<?php

// declare access to globals
global $commentpress_obj;

// if we have the plugin enabled...
if ( is_object( $commentpress_obj ) ) {

	// show the minimise button
	//echo $commentpress_obj->get_minimise_button( 'toc' );

}

?>

<h2>Table of Contents</h2>

</div>



<div class="sidebar_minimiser">

<div class="sidebar_contents_wrapper">

<?php 

// if we have the plugin enabled...
if ( is_object( $commentpress_obj ) ) {

	?><ul id="toc_list">
	<?php

	// show the TOC
	echo $commentpress_obj->get_toc_list();

	?></ul>
	<?php

}

?>
	
</div><!-- /sidebar_contents_wrapper -->

</div><!-- /sidebar_minimiser -->



</div><!-- /toc_sidebar -->



