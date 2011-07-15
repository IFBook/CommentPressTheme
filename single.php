<?php get_header(); ?>



<!-- single.php -->

<div id="wrapper">



<div id="main_wrapper" class="clearfix">



<div id="page_wrapper">



<div id="content">



<?php if (have_posts()) : while (have_posts()) : the_post(); ?>



	<div class="post" id="post-<?php the_ID(); ?>">



		<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>

		<p class="postname"><?php the_time('l, F jS, Y') ?> by <?php the_author_posts_link(); ?></p>



		<?php global $more; $more = true; the_content(''); ?>



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
			'echo' => 0
			
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



		<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>



		<p class="postmetadata">This entry is filed under <?php the_category(', ') ?>. You can follow any responses to this entry through the <?php post_comments_feed_link('RSS 2.0'); ?> feed. <?php 
			
			if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
				
				// Both Comments and Pings are open 
				?>You can leave a response, or <a href="<?php trackback_url(); ?>" rel="trackback">trackback</a> from your own site. <?php 
				
			} elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
			
				// Only Pings are Open 
				?>Responses are currently closed, but you can <a href="<?php trackback_url(); ?> " rel="trackback">trackback</a> from your own site. <?php 
				
			} elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
			
				// Comments are open, Pings are not 
				?>You can leave a response. Pinging is currently not allowed. <?php 
				
			} elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
				
				// Neither Comments, nor Pings are open 
				?>Both comments and pings are currently closed. <?php 
				
			} edit_post_link('Edit this entry','','.'); 
			
		?></p>



	</div><!-- /post -->


	
<?php endwhile; else: ?>



	<div class="post">
	
		<h2>Post Not Found</h2>
		
		<p>Sorry, no posts matched your criteria.</p>
		
		<?php get_search_form(); ?>
	
	</div><!-- /post -->
	


<?php endif; ?>

</div><!-- /content -->



</div><!-- /page_wrapper -->



</div><!-- /main_wrapper -->



</div><!-- /wrapper -->



<?php get_sidebar(); ?>



<?php get_footer(); ?>