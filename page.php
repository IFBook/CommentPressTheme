<?php get_header(); ?>



<!-- page.php -->

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

	?>
	<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
	<?php
	
	}

	?>
	


	<?php global $more; $more = false; the_content('', true); ?>



	<?php
	
	// NOTE: Comment permalinks are filtered if the comment is not on the first page 
	// in a multipage post... see: cp_multipage_comment_link in functions.php
	
	// set default behaviour
	$defaults = array(
		
		'before' => '<div class="multipager">', // . __('Pages: '), 
		'after' => '</div>',
		'link_before' => '', 
		'link_after' => '',
		'next_or_number' => 'next', 
		'nextpagelink' => '<span class="alignright">'.__('Next page').' &raquo;</span>', // <li class="alignright"></li>
		'previouspagelink' => '<span class="alignleft">&laquo; '.__('Previous page').'</span>', // <li class="alignleft"></li>
		'pagelink' => '%',
		'more_file' => '', 
		'echo' => 1
		
	);

	// get page links
	$page_links = wp_link_pages( $defaults );
	
	// add separator when there are two links
	$page_links = str_replace( 
	
		'a><a', 
		'a> <span class="multipager_sep">|</span> <a', 
		$page_links 
		
	);
	
	echo $page_links;
	
	?>



	<?php edit_post_link('Edit this entry', '<p class="edit_link">', '</p>'); ?>



	<?php 

	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// get page num
		$num = $commentpress_obj->nav->get_page_number( get_the_ID() );
		
		// if we get one
		if ( $num ) {
			
			//print_r( $num ); die();
	
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

	<h2>Page Not Found</h2>
	
	<p>Sorry, but you are looking for something that isn't here.</p>
	
	<?php get_search_form(); ?>

</div><!-- /post -->



<?php endif; ?>



</div><!-- /content -->



</div><!-- /page_wrapper -->



</div><!-- /main_wrapper -->



<?php get_sidebar(); ?>



<?php get_footer(); ?>