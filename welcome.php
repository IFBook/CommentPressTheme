<?php
/*
Template Name: Welcome
*/
?>

<?php get_header(); ?>



<!-- page.php -->

<div id="wrapper">



<div id="main_wrapper" class="clearfix">



<div id="page_wrapper">



<div id="content">



<?php if (have_posts()) : while (have_posts()) : the_post(); ?>



<div class="post" id="post-<?php the_ID(); ?>">



	<?php
	
	// init hide (show by default
	$hide = 'show';
	
	// declare access to globals
	global $commentpress_obj;
	
	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// get global hide
		$hide = $commentpress_obj->db->option_get( 'cp_title_visibility' );;
		
	}
	
	// set key
	$key = '_cp_title_visibility';
	
	//if the custom field already has a value...
	if ( get_post_meta( get_the_ID(), $key, true ) != '' ) {
	
		// get it
		$hide = get_post_meta( $post->ID, $key, true );
		
	}
	
	// if show...
	if ( $hide == 'show' ) {

	?><h2 class="post_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
	
	<?php
	
	}
	


	// set defaults
	$args = array(
	
		'post_type' => 'attachment',
		'numberposts' => 1,
		'post_status' => null,
		'post_parent' => get_the_ID()
		
	); 
	
	// get them...
	$attachments = get_posts( $args );
	
	// well?
	if ( $attachments ) {
	
		// we only want the first
		$attachment = $attachments[0];
	
	}
	
	// if we have an image
	if ( $attachment ) { 
		
		// show it
		echo wp_get_attachment_image( $attachment->ID, 'full' );
		
	} else {
		
		// show post content
		global $more; $more = false; the_content('', true);
		
	}
	
	?>



	<?php
	
	// NOTE: Comment permalinks are filtered if the comment is not on the first page 
	// in a multipage post... see: cp_multipage_comment_link in functions.php
	echo cp_multipager();

	?>



	<?php edit_post_link('Edit this entry', '<p class="edit_link">', '</p>'); ?>



</div><!-- /post -->



<?php endwhile; else: ?>



<div class="post">

	<h2 class="post_title">Page Not Found</h2>
	
	<p>Sorry, but you are looking for something that isn't here.</p>
	
	<?php get_search_form(); ?>

</div><!-- /post -->



<?php endif; ?>



</div><!-- /content -->



</div><!-- /page_wrapper -->



</div><!-- /main_wrapper -->



</div><!-- /wrapper -->



<?php get_sidebar(); ?>



<?php get_footer(); ?>