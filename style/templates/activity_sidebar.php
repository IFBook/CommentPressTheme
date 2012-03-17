<?php

// set default
$recent = apply_filters(
	'cp_activity_tab_recent_title_blog', 
	__( 'Recent Comments in this Document', 'cp-buddypress' )
);

// if we have the plugin enabled...
global $post, $commentpress_obj;
if ( is_object( $post ) AND is_object( $commentpress_obj ) ) {

	// is this a special page?
	if ( !$commentpress_obj->db->is_special_page() ) {
	
		// set default
		$recent = apply_filters(
			'cp_activity_tab_recent_title_page', 
			__( 'Recent Comments on this Page', 'cp-buddypress' )
		);
		
	}

}

// get page
$output = cp_get_comment_activity();

?><!-- activity_sidebar.php -->

<div id="activity_sidebar" class="sidebar_container">



<div class="sidebar_header">

<h2>Activity</h2>

</div>



<div class="sidebar_minimiser">

<div class="sidebar_contents_wrapper">

<div class="comments_container">

<h3 class="activity_heading"><?php echo $recent; ?></h2>

<div class="paragraph_wrapper">

<?php echo $output; ?>

</div>

<?php



/*
--------------------------------------------------------------------------------
This seems not to work because BP returns no values for the combination we want
--------------------------------------------------------------------------------
NOTE: raise a ticket on BP
--------------------------------------------------------------------------------
Also, need to make this kind of include file properly child-theme adaptable
--------------------------------------------------------------------------------


// access plugin
global $commentpress_obj, $post;

// if we have the plugin enabled and it's BP
if ( 
	
	is_multisite() 
	AND is_object( $commentpress_obj ) 
	AND $commentpress_obj->is_buddypress() 
	AND $commentpress_obj->is_groupblog() 
	
) {
	
	// check if this blog is a group blog...
	$group_id = get_groupblog_group_id( get_current_blog_id() );
	//print_r( $group_id ); die();
	
	// when this blog is a groupblog
	if ( !empty( $group_id ) ) {
	
		// get activities for our activities
		if ( bp_has_activities( array(
			
			// NO RESULTS!
			'object' => 'groups',
			'action' => 'new_groupblog_comment,new_groupblog_post',
			'primary_id' => $group_id
			'secondary_id' => $post_id
			
		) ) ) : ?>
			
			<h3 class="activity_heading">Recent Activity in this Workshop</h2>
	
			<div class="paragraph_wrapper">
			
			<ol class="comment_activity">
		
			<?php while ( bp_activities() ) : bp_the_activity(); ?>
		 
				<?php locate_template( array( 'activity/groupblog.php' ), true, false ); ?>
				
			<?php endwhile; ?>
			
			</ol>
			
			</div>
		 
		<?php
		
		endif; 

	}




} // end BP check
*/


?>

<?php



// access plugin
global $commentpress_obj, $post;

// if we have the plugin enabled and it's BP
if ( is_multisite() AND is_object( $commentpress_obj ) AND $commentpress_obj->is_buddypress() ) {

	// get activities	
	if ( bp_has_activities( array(
	
		'scope' => 'groups',
		'action' => 'new_groupblog_comment,new_groupblog_post',
		
	) ) ) : ?>
		
		<?php if ( is_user_logged_in() ) { ?>
		<h3 class="activity_heading">Recent Activity in your Workshops</h2>
		<?php } else { ?>
		<h3 class="activity_heading">Recent Activity in Public Workshops</h2>
		<?php } ?>

		<div class="paragraph_wrapper">
		
		<ol class="comment_activity">
	
		<?php while ( bp_activities() ) : bp_the_activity(); ?>
	 
			<?php locate_template( array( 'activity/groupblog.php' ), true, false ); ?>
			
		<?php endwhile; ?>
		
		</ol>
		
		</div>
	 
	<?php endif; 



} // end BP check


?>

</div><!-- /comments_container -->

</div><!-- /sidebar_contents_wrapper -->

</div><!-- /sidebar_minimiser -->



</div><!-- /activity_sidebar -->



