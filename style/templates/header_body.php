<?php /*
===============================================================
HTML Body Header
===============================================================
AUTHOR			: Christian Wach <needle@haystack.co.uk>
LAST MODIFIED	: 17/09/2009
---------------------------------------------------------------
NOTES
=====

Separated this out for inclusion in multiple files.

---------------------------------------------------------------
*/



// Start HTML
?>
<a class="skip" href="#content">Skip to Content</a>
<span class="off-left"> | </span>
<a class="skip" href="#toc_list">Skip to Table of Contents</a><!-- /skip_links -->



<div id="book_header">
	
	<div id="titlewrap">
		<?php
		
		// get header image
		cp_get_header_image();
		
		?>
		<div id="page_title">
		<div id="title"><h1><a href="<?php echo home_url(); ?>" title="Home"><?php bloginfo('title'); ?></a></h1></div>
		<div id="tagline"><?php bloginfo('description'); ?></div>
		</div>
	</div>
	
	<div id="book_search">
		<?php get_search_form(); ?>
	</div><!-- /book_search -->
	
	<?php include (get_template_directory() . '/style/templates/user_links.php'); ?>
	
</div><!-- /book_header -->



<div id="header">

	<?php include (get_template_directory() . '/style/templates/navigation.php'); ?>

</div><!-- /header -->



