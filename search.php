<?php get_header(); ?>



<!-- search.php -->

<div id="wrapper">



<div id="main_wrapper" class="clearfix">



<div id="page_wrapper">



<div id="content" class="clearfix">

<?php if (have_posts()) : ?>

	<div class="post">

	<h2>Search Results for &#8216;<?php the_search_query(); ?>&#8217;</h2>

	<?php while (have_posts()) : the_post(); ?>

		<div class="search_result">

			<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			
			<div  class="search_meta">
			
				<p><?php the_time('l, F jS, Y') ?></p>
				
				<p><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
			
			</div>

		</div><!-- /search_result -->

	<?php endwhile; ?>

	</div><!-- /post -->

<?php else : ?>

	<div class="post">

	<h2>Nothing found for &#8216;<?php the_search_query(); ?>&#8217;</h2>
	
	<p>Try a different search?</p>

	<?php get_search_form(); ?>

	</div><!-- /post -->

<?php endif; ?>

</div><!-- /content -->



</div><!-- /page_wrapper -->



</div><!-- /main_wrapper -->



</div><!-- /wrapper -->



<?php get_sidebar(); ?>



<?php get_footer(); ?>