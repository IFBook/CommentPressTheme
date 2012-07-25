<?php

// access globals
global $post, $commentpress_obj;



// init output
$page_comments_output = '';

// is it commentable?
$cp_commentable = cp_is_commentable();

// if a commentable post...
if ( $cp_commentable ) {

	// set default phrase
	$paragraph_text = __( 'Recent Comments on this Page', 'commentpress-theme' );

	$current_type = get_post_type();
	//print_r( $current_type ); die();
	
	switch( $current_type ) {
		
		// we can add more of these if needed
		case 'post': $paragraph_text = __( 'Recent Comments on this Post', 'commentpress-theme' ); break;
		case 'page': $paragraph_text = __( 'Recent Comments on this Page', 'commentpress-theme' ); break;
		
	}
	
	// set default
	$page_comments_title = apply_filters(
		'cp_activity_tab_recent_title_page', 
		$paragraph_text
	);
	
	// get page comments
	$page_comments_output = cp_get_comment_activity( 'post' );
	
}





// set default
$all_comments_title = apply_filters(
	'cp_activity_tab_recent_title_blog', 
	__( 'Recent Comments in this Document', 'commentpress-theme' )
);

// get all comments
$all_comments_output = cp_get_comment_activity( 'all' );





// set maximum number to show - put into option?
$max_members = 10;




?><!-- activity_sidebar.php -->

<div id="activity_sidebar" class="sidebar_container">



<div class="sidebar_header">

<h2>Activity</h2>

</div>



<div class="sidebar_minimiser">

<div class="sidebar_contents_wrapper">

<div class="comments_container">





<?php

// show page comments if we can
if ( $cp_commentable AND $page_comments_output != '' ) {

?><h3 class="activity_heading"><?php echo $page_comments_title; ?></h3>

<div class="paragraph_wrapper page_comments_output">

<?php echo $page_comments_output; ?>

</div>

<?php

} // end commentable post/page check






// show all comments from site if we can
if ( $all_comments_output != '' ) {

?><h3 class="activity_heading"><?php echo $all_comments_title; ?></h3>

<div class="paragraph_wrapper all_comments_output">

<?php echo $all_comments_output; ?>

</div>

<?php

} // end comments from site check






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
			
			<h3 class="activity_heading">Recent Activity in this Workshop</h3>
	
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
		
	) ) ) :
	
		// change header depending on logged in status
		if ( is_user_logged_in() ) {
		
			// set default
			$section_header_text = apply_filters(
				'cp_activity_tab_recent_title_all_yours', 
				__( 'Recent Activity in your Documents', 'commentpress-theme' )
			);
			
		} else { 
		
			// set default
			$section_header_text = apply_filters(
				'cp_activity_tab_recent_title_all_public', 
				__( 'Recent Activity in Public Documents', 'commentpress-theme' )
			);
		
		 } ?>

		<h3 class="activity_heading"><?php echo $section_header_text; ?></h3>
		
		<div class="paragraph_wrapper workshop_comments_output">
		
		<ol class="comment_activity">
	
		<?php while ( bp_activities() ) : bp_the_activity(); ?>
	 
			<?php locate_template( array( 'activity/groupblog.php' ), true, false ); ?>
			
		<?php endwhile; ?>
		
		</ol>
		
		</div>
	 
	<?php endif; ?>



	<?php 
	
	// get recently active members
	if ( bp_has_members( 
	
		'user_id=0'.
		'&type=active'.
		'&per_page='.$max_members.
		'&max='.$max_members.
		'&populate_extras=0' 
		
	) ) : ?>
	
		<h3 class="activity_heading">Recently Active Members</h3>
	
		<div class="paragraph_wrapper active_members_output">
	
		<ul class="item-list cp-recently-active">
	
		<?php while ( bp_members() ) : bp_the_member(); ?>
	
			<li>
	
				<div class="item-avatar">
					<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
				</div>
	
				<div class="item">
					<div class="item-title">
						<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
	
						<?php if ( bp_get_member_latest_update() ) : ?>
	
							<span class="update"> <?php bp_member_latest_update(); ?></span>
	
						<?php endif; ?>
	
					</div>
	
					<div class="item-meta"><span class="activity"><?php bp_member_last_active(); ?></span></div>
	
					<?php do_action( 'bp_directory_members_item' ); ?>
	
					<?php
					 /***
					  * If you want to show specific profile fields here you can,
					  * but it'll add an extra query for each member in the loop
					  * (only one regardless of the number of fields you show):
					  *
					  * bp_member_profile_data( 'field=the field name' );
					  */
					?>
				</div>
	
				<div class="clear"></div>
	
			</li>
	
		<?php endwhile; ?>
	
		</ul>
	
		</div>
	
	<?php endif; ?>
	
	
	
	<?php 
	
	// get online members
	if ( bp_has_members( 
	
		'user_id=0'.
		'&type=online'.
		'&per_page='.$max_members.
		'&max='.$max_members.
		'&populate_extras=0' 
		
	) ) : ?>
	
		<h3 class="activity_heading">Who's Online</h3>
	
		<div class="paragraph_wrapper online_members_output">
	
		<ul class="item-list cp-online-members">
	
		<?php while ( bp_members() ) : bp_the_member(); ?>
	
			<li>
	
				<div class="item-avatar">
					<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(); ?></a>
				</div>
	
				<div class="item">
					<div class="item-title">
						<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
	
						<?php if ( bp_get_member_latest_update() ) : ?>
	
							<span class="update"> <?php bp_member_latest_update(); ?></span>
	
						<?php endif; ?>
	
					</div>
	
					<div class="item-meta"><span class="activity"><?php bp_member_last_active(); ?></span></div>
	
					<?php do_action( 'bp_directory_members_item' ); ?>
	
					<?php
					 /***
					  * If you want to show specific profile fields here you can,
					  * but it'll add an extra query for each member in the loop
					  * (only one regardless of the number of fields you show):
					  *
					  * bp_member_profile_data( 'field=the field name' );
					  */
					?>
				</div>
	
				<div class="clear"></div>
	
			</li>
	
		<?php endwhile; ?>
	
		</ul>
	
		</div>
	
	<?php endif; ?>
	
	
	
<?php 

} // end BP check


?>



</div><!-- /comments_container -->

</div><!-- /sidebar_contents_wrapper -->

</div><!-- /sidebar_minimiser -->



</div><!-- /activity_sidebar -->



