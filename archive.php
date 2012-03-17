<?php get_header(); ?>



<!-- archive.php -->

<div id="wrapper">



<div id="main_wrapper" class="clearfix">



<div id="page_wrapper">



<div id="content" class="clearfix">

<div class="post">



<?php if (have_posts()) : ?>

	<?php //$post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<h3 class="post_title">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h3>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<h3 class="post_title">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h3>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
	<h3 class="post_title">Archive for <?php the_time('F jS, Y'); ?></h3>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<h3 class="post_title">Archive for <?php the_time('F, Y'); ?></h3>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<h3 class="post_title">Archive for <?php the_time('Y'); ?></h3>
	<?php /* If this is an author archive */ } elseif (is_author()) { ?>
	<h3 class="post_title">Author Archive</h3>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<h3 class="post_title">Archives</h3>
	<?php } ?>
	
	<?php while (have_posts()) : the_post(); ?>

		<div class="search_result">

		<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
		
		<div class="search_meta">
			
			<p><?php 
			
			// get avatar
			$author_id = get_the_author_meta( 'ID' );
			echo get_avatar( $author_id, $size='32' );
			
			?></p>
			
			<p><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_time('l, F jS, Y') ?></a></p>
			
			<p><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
		
		</div>
		
		<?php the_excerpt() ?>
		
		</div><!-- /archive_item -->
	
	<?php endwhile; ?>


	
<?php else : ?>

	<h2 class="post_title">Not Found</h2>

	<?php get_search_form(); ?>

<?php endif; ?>



</div><!-- /post -->

</div><!-- /content -->



</div><!-- /page_wrapper -->



</div><!-- /main_wrapper -->



</div><!-- /wrapper -->



<?php get_sidebar(); ?>



<?php get_footer(); ?>