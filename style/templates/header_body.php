<?php /*
===============================================================
HTML Body Header
===============================================================
AUTHOR			: Christian Wach <needle@haystack.co.uk>
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
	
	<?php 
	
	// until WordPress supports a locate_theme_file() function, use filter
	$include = apply_filters( 
		'cp_template_user_links',
		get_template_directory() . '/style/templates/user_links.php'
	);
	
	include( $include );
	
	?>
	
</div><!-- /book_header -->



<div id="header">

	<?php 
	
	// until WordPress supports a locate_theme_file() function, use filter
	$include = apply_filters( 
		'cp_template_navigation',
		get_template_directory() . '/style/templates/navigation.php'
	);
	
	include( $include );

	?>

</div><!-- /header -->



