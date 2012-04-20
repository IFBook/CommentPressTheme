<?php get_header(); ?>



<!-- page.php -->

<div id="main_wrapper" class="clearfix">



<div id="page_wrapper">



<div id="content">



<?php if (have_posts()) : while (have_posts()) : the_post(); 



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



<div class="post<?php echo $type_overridden; ?>" id="post-<?php the_ID(); ?>">



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
	
	// if the custom field already has a value...
	if ( get_post_meta( get_the_ID(), $key, true ) != '' ) {
	
		// get it
		$hide = get_post_meta( $post->ID, $key, true );
		
	}
	
	// if show...
	if ( $hide == 'show' ) {

	?>
	<h2 class="post_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
	<?php
	
	}

	?>
	


	<?php
	
	// init hide (hide by default)
	$hide_meta = 'hide';
	
	// declare access to globals
	global $commentpress_obj;
	
	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// get global hide_meta
		$hide_meta = $commentpress_obj->db->option_get( 'cp_page_meta_visibility' );;
		
	}
	
	// set key
	$key = '_cp_page_meta_visibility';
	
	// if the custom field already has a value...
	if ( get_post_meta( get_the_ID(), $key, true ) != '' ) {
	
		// override with local value
		$hide_meta = get_post_meta( $post->ID, $key, true );
		
	}
	
	// if show...
	if ( $hide_meta == 'show' ) {

	?>
	<div class="search_meta">
		
		<?php cp_echo_post_meta(); ?>
		
		<?php /*
		
		// get avatar
		$author_id = get_the_author_meta( 'ID' );
		echo get_avatar( $author_id, $size='32' );
		
		?>
		
		<cite class="fn"><?php cp_echo_post_author() ?></cite>
		
		<p><a href="<?php the_permalink() ?>"><?php the_time('l, F jS, Y') ?></a></p>
		
		<?php */ ?>
		
	</div>
	<?php
	
	}

	?>
	
	
	
	<?php global $more; $more = true; the_content(''); ?>



	<?php
	
	// NOTE: Comment permalinks are filtered if the comment is not on the first page 
	// in a multipage post... see: cp_multipage_comment_link in functions.php
	echo cp_multipager();

	?>



	<?php edit_post_link('Edit this entry', '<p class="edit_link">', '</p>'); ?>



	<?php 

	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// get page num
		$num = $commentpress_obj->nav->get_page_number( get_the_ID() );
		
		//print_r( $num ); die();
	
		// if we get one
		if ( $num ) {
			
			// is it arabic?
			if ( is_numeric( $num ) ) {
			
				// add page number
				?><div class="running_header_bottom">page <?php echo $num; ?></div><?php 
		
			} else {
			
				// add page number
				?><div class="running_header_bottom">page <?php echo strtolower( $num ); ?></div><?php 
		
			}
			
		}
		
	} 
	
	?>


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



<?php get_sidebar(); ?>



<?php get_footer(); ?>