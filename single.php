<?php get_header(); ?>



<!-- single.php -->

<div id="wrapper">



<?php if (have_posts()) : while (have_posts()) : the_post(); 



// init class values
$tabs_class = '';
$tabs_classes = '';

// init workflow items
$original = '';
$literal = '';

// do we have workflow?
if ( is_object( $commentpress_obj ) ) {

	// get workflow
	$_workflow = $commentpress_obj->db->option_get( 'cp_blog_workflow' );
	
	// is it enabled?
	if ( $_workflow == '1' ) {
	
		// okay, let's add our tabs
		
		// set key
		$key = '_cp_original_text';
		
		// if the custom field already has a value...
		if ( get_post_meta( $post->ID, $key, true ) != '' ) {
		
			// get it
			$original = get_post_meta( $post->ID, $key, true );
			
		}

		// set key
		$key = '_cp_literal_translation';
		
		// if the custom field already has a value...
		if ( get_post_meta( $post->ID, $key, true ) != '' ) {
		
			// get it
			$literal = get_post_meta( $post->ID, $key, true );
			
		}
		
		// did we get either type of workflow content?
		if ( $literal != '' OR $original != '' ) {
		
			// override tabs class
			$tabs_class = 'with-content-tabs';
	
			// override tabs classes
			$tabs_classes = ' class="'.$tabs_class.'"';
			
			// prefix with space
			$tabs_class = ' '.$tabs_class;
			
		}
		
	}
	
}


// add a class for overridden page types
$type_overridden = '';

// set post meta key
$key = '_cp_post_type_override';

// default to current blog type
$type = $commentpress_obj->db->option_get('cp_blog_type');

// but, if the custom field has a value...
if ( get_post_meta( $post->ID, $key, true ) != '' ) {

	// get it
	$overridden_type = get_post_meta( $post->ID, $key, true );
	
	// is it different to the current blog type?
	if ( $overridden_type != $type ) {
	
		$type_overridden = ' overridden_type-'.$overridden_type;
	
	}

}




?>



<div id="main_wrapper" class="clearfix<?php echo $tabs_class; ?>">



<?php 

// did we get tabs?
if ( $tabs_class != '' ) {
	
	// did we get either type of workflow content?
	if ( $literal != '' OR $original != '' ) {
	
	?>
	<ul id="content-tabs">
		<li id="content_header" class="default-content-tab"><h2><a href="#content">Content</a></h2></li>
		<?php if ( $literal != '' ) { ?>
		<li id="literal_header"><h2><a href="#literal">Literal</a></h2></li>
		<?php } ?>
		<?php if ( $original != '' ) { ?>
		<li id="original_header"><h2><a href="#original">Original</a></h2></li>
		<?php } ?>
	</ul>
	<?php
	
	}
	
}
		
?>

<div id="page_wrapper"<?php echo $tabs_classes; ?>>



<div id="content" class="workflow-wrapper">



<div class="post<?php echo $type_overridden; ?>" id="post-<?php the_ID(); ?>">



<h2 class="post_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

<div class="search_meta">
	
	<?php 
	
	// get avatar
	$author_id = get_the_author_meta( 'ID' );
	echo get_avatar( $author_id, $size='32' );
	
	?>
	
	<cite class="fn"><?php cp_echo_post_author() ?></cite>
	
	<p><a href="<?php the_permalink() ?>"><?php the_time('l, F jS, Y') ?></a></p>

</div>



<?php 

// check for newer version
$newer = '';

// set key
$key = '_cp_newer_version';

// if the custom field already has a value...
if ( get_post_meta( $post->ID, $key, true ) != '' ) {

	// get it
	$newer = get_post_meta( $post->ID, $key, true );
	
}



// if we've got one...
if ( $newer != '' ) {

	// get post
	$newer_post = get_post( $newer );
	
	// is it published?
	if ( $newer_post->post_status == 'publish' ) {

		// get link
		$newer_link = get_permalink( $newer_post->ID );
	
		?>
		<div class="alert">
			<p><a href="<?php echo $newer_link ?>">Newer version available!</a></p>
		</div>
		<?php
		
	}

}

?>



<?php global $more; $more = true; the_content(''); ?>



<?php

// NOTE: Comment permalinks are filtered if the comment is not on the first page 
// in a multipage post... see: cp_multipage_comment_link in functions.php
echo cp_multipager();

?>



<?php the_tags( '<p class="postmetadata">Tags: ', ', ', '</p>'); ?>



<p class="postmetadata">This entry is filed under <?php the_category(', ') ?>. You can follow any responses to this entry through the <?php post_comments_feed_link('RSS 2.0'); ?> feed. <?php 
	
	if (('open' == $post->comment_status) && ('open' == $post->ping_status)) {
		
		// Both Comments and Pings are open 
		?>You can leave a response, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site. <?php 
		
	} elseif (!('open' == $post->comment_status) && ('open' == $post->ping_status)) {
	
		// Only Pings are Open 
		?>Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site. <?php 
		
	} elseif (('open' == $post->comment_status) && !('open' == $post->ping_status)) {
	
		// Comments are open, Pings are not 
		?>You can leave a response. Pinging is currently not allowed. <?php 
		
	} elseif (!('open' == $post->comment_status) && !('open' == $post->ping_status)) {
		
		// Neither Comments, nor Pings are open 
		?>Both comments and pings are currently closed. <?php 
		
	} edit_post_link('Edit this entry','','.'); 
	
?></p>



</div><!-- /post -->



</div><!-- /content -->



<?php 

// did we get tabs?
if ( $tabs_class != '' ) {

	// did we get either type of workflow content?
	if ( $literal != '' OR $original != '' ) {
	
	// did we get literal?
	if ( $literal != '' ) {
	
	?>
	<div id="literal" class="workflow-wrapper">
	
	<div class="post">
	
	<h2 class="post_title"><?php _e( 'Literal Translation', 'commentpress-theme' ); ?></h2>
	
	<?php echo wpautop(convert_chars(wptexturize( stripslashes( $literal ) ))); ?>
	
	</div><!-- /post -->
	
	</div><!-- /literal -->
	
	<?php } ?>
	
	
	<?php
	
	// did we get original?
	if ( $original != '' ) {
	
	?>
	
	<div id="original" class="workflow-wrapper">
	
	<div class="post">
	
	<h2 class="post_title"><?php _e( 'Original Text', 'commentpress-theme' ); ?></h2>
	
	<?php echo wpautop(convert_chars(wptexturize( stripslashes( $original ) ))); ?>
	
	</div><!-- /post -->
	
	</div><!-- /original -->
	
	<?php } ?>
	
	
	
	<?php
	
	}
	
}
		
?>



</div><!-- /page_wrapper -->



</div><!-- /main_wrapper -->



<?php endwhile; else: ?>



<div id="main_wrapper" class="clearfix">



<div id="page_wrapper">



<div id="content">



<div class="post">

<h2 class="post_title">Post Not Found</h2>

<p>Sorry, no posts matched your criteria.</p>

<?php get_search_form(); ?>

</div><!-- /post -->



</div><!-- /content -->



</div><!-- /page_wrapper -->



</div><!-- /main_wrapper -->



<?php endif; ?>



</div><!-- /wrapper -->



<?php get_sidebar(); ?>



<?php get_footer(); ?>