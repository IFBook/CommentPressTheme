<?php 
/*
Template Name: Archive
*/



get_header(); ?>



<!-- archives.php -->

<div id="wrapper">



<div id="main_wrapper" class="clearfix">



<div id="page_wrapper">



<div id="content" class="clearfix">

<div class="post">



<?php the_post(); ?>

<h2 class="post_title"><?php the_title(); ?></h2>



<div class="archives_search_form">
<?php get_search_form(); ?>
</div>



<h3>Archives by Month</h3>

<ul>
	<?php wp_get_archives('type=monthly'); ?>
</ul>



</div><!-- /post -->

</div><!-- /content -->



</div><!-- /page_wrapper -->



</div><!-- /main_wrapper -->



</div><!-- /wrapper -->



<?php get_sidebar(); ?>



<?php get_footer(); ?>