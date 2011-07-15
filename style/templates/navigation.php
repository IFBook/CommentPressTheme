<?php

global $commentpress_obj;

?><!-- navigation.php -->

<div id="book_nav">



<div id="book_nav_wrapper">


	
<div id="cp_book_nav">

<?php

// is it a page?
if ( is_page() ) {

	// get our custom page navigation
	$cp_page_nav = cp_page_navigation();
	
	// if we get any...
	if ( $cp_page_nav != '' ) { 

		?><ul>
			<?php echo $cp_page_nav; ?>
		</ul>
		<?php
	
	}

	?><div id="cp_book_info"><p><?php echo cp_page_title(); ?></p></div>
	<?php

}



// is it a post?
elseif ( is_single() ) {

	?><ul id="blog_navigation">
		<?php next_post_link('<li class="alignright">%link</li>'); ?>
		<?php previous_post_link('<li class="alignleft">%link</li>'); ?>
	</ul>
	
	<div id="cp_book_info"><p><?php echo cp_page_title(); ?></p></div>
	<?php

}


// is this the homepage?
elseif ( is_home() ) {

	$nl = get_next_posts_link('&laquo; Older Entries');
	$pl = get_previous_posts_link('Newer Entries &raquo;');
	
	// did we get either?
	if ( $nl != '' OR $pl != '' ) { ?>
	
	<ul id="blog_navigation">
		<?php if ( $nl != '' ) { ?><li class="alignright"><?php echo $nl; ?></li><?php } ?>
		<?php if ( $pl != '' ) { ?><li class="alignleft"><?php echo $pl; ?></li><?php } ?>
	</ul>
	
	<?php } ?>
	
	<div id="cp_book_info"><p>Blog</p></div>
	<?php

}



// archives?
elseif ( is_day() || is_month() || is_year() ) {

	$nl = get_next_posts_link('&laquo; Older Entries');
	$pl = get_previous_posts_link('Newer Entries &raquo;');
	
	// did we get either?
	if ( $nl != '' OR $pl != '' ) { ?>
	
	<ul id="blog_navigation">
		<?php if ( $nl != '' ) { ?><li class="alignright"><?php echo $nl; ?></li><?php } ?>
		<?php if ( $pl != '' ) { ?><li class="alignleft"><?php echo $pl; ?></li><?php } ?>
	</ul>
	
	<?php } ?>
	
	<div id="cp_book_info"><p><?php echo 'Blog Archives: '; wp_title(''); ?></p></div>
	<?php

}



// search?
elseif ( is_search() ) {

	$nl = get_next_posts_link('&laquo; Older Entries');
	$pl = get_previous_posts_link('Newer Entries &raquo;');
	
	// did we get either?
	if ( $nl != '' OR $pl != '' ) { ?>
	
	<ul id="blog_navigation">
		<?php if ( $nl != '' ) { ?><li class="alignright"><?php echo $nl; ?></li><?php } ?>
		<?php if ( $pl != '' ) { ?><li class="alignleft"><?php echo $pl; ?></li><?php } ?>
	</ul>
	
	<?php } ?>
	
	<div id="cp_book_info"><p><?php wp_title(''); ?></p></div>
	<?php

}



else {

	// catchall for other page types	
	?><div id="cp_book_info"><p><?php wp_title(''); ?></p></div>
	<?php

}




?>

</div><!-- /cp_book_nav -->



<ul id="nav">
	<?php
	
	// do we have the plugin?
	if ( is_object( $commentpress_obj ) ) {
	
		// get title id and url
		$title_id = $commentpress_obj->db->option_get( 'cp_welcome_page' );
		$title_url = $commentpress_obj->get_page_url( 'cp_welcome_page' );
		
		// is it different to home?
		if ( $title_id != get_option('page_on_front') ) {
	
		// show home
		?><li><a href="<?php echo get_bloginfo('wpurl'); ?>" id="btn_home" class="css_btn" title="Home Page">Home Page</a></li><?php
		
		}
	
		?><li><a href="<?php echo $title_url; ?>" id="btn_cover" class="css_btn" title="Title Page">Title Page</a></li><?php
	
		// show link to general comments page if we have one
		echo $commentpress_obj->get_page_link( 'cp_general_comments_page' );
		
		// show link to all comments page if we have one
		echo $commentpress_obj->get_page_link( 'cp_all_comments_page' );
		
		// show link to comments-by-user page if we have one
		echo $commentpress_obj->get_page_link( 'cp_comments_by_page' );
		
		// show link to book blog page if we have one
		echo $commentpress_obj->get_page_link( 'cp_blog_page' );
		
	}
		
	?>
</ul>



<ul id="minimiser_trigger">
	<?php
	
	// do we have the plugin?
	if ( is_object( $commentpress_obj ) ) {
	
		// show minimise header button
		echo $commentpress_obj->get_header_min_link();
		
	}
	
	?>
</ul>



<ul id="toc_trigger">
	<li><a href="<?php echo get_bloginfo('wpurl'); ?>" id="btn_contents" class="css_btn" title="Table of Contents">Table of Contents</a></li>
</ul>



</div><!-- /book_nav_wrapper -->



</div><!-- /book_nav -->
	
	
	
