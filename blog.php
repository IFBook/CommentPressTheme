<?php
/*
Template Name: Blog
*/
?>

<?php get_header(); ?>



<!-- blog.php -->

<div id="wrapper">



<div id="main_wrapper" class="clearfix">



<div id="page_wrapper">



<div id="content" class="clearfix">

<div class="post">

<?php

// show river of news
if (have_posts()) : ?>

	<?php while (have_posts()) : the_post(); ?>

		<div class="archive_item">
		
		<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			<small><?php the_time('F jS, Y') ?> <!-- by <?php the_author() ?> --></small>

			<div class="entry">
				<?php the_content('Read the rest of this entry &raquo;'); ?>
			</div>

			<p class="postmetadata"><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>

		</div>

		</div><!-- /archive_item -->
	
	<?php endwhile; ?>
	
<?php else : ?>

	<h2>Not Found</h2>
	
	<p>Sorry, but you are looking for something that isn't here.</p>
	
	<?php get_search_form(); ?>

<?php endif; ?>

</div><!-- /post -->

</div><!-- /content -->



</div><!-- /page_wrapper -->



</div><!-- /main_wrapper -->



</div><!-- /wrapper -->



<?php get_sidebar(); ?>



<?php get_footer(); ?>