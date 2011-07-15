<?php
/*
Template Name: Group
*/
?>

<?php get_header(); ?>



<!-- group.php -->

<div id="wrapper">



<div id="main_wrapper" class="clearfix">



<div id="page_wrapper">



<div id="content">



<div class="post">



<h2>Group Members</h2>



<?php 

// get the users
$_users = get_users_of_blog();

// did we get any?
if ( count( $_users ) > 0 ) {

	// open list
	echo '<ul id="group_list">'."\n";

	// loop
	foreach( $_users AS $_user ) {
	
		// exclude admin
		if( $_user->user_id != '1' ) {
		
			// open item
			echo '<li>'."\n";
		
			// show display name
			echo  '<a href="'.get_option('home').'/author/'.$_user->user_login.'/">'.$_user->display_name.'</a>';
			
			// close item
			echo '</li>'."\n\n";
		
		}
	
	}

	// close list
	echo '</ul>'."\n\n";

} ?>


</div><!-- /post -->



</div><!-- /content -->



</div><!-- /page_wrapper -->



</div><!-- /main_wrapper -->



</div><!-- /wrapper -->



<?php get_sidebar(); ?>



<?php get_footer(); ?>