<?php /*
===============================================================
Commentpress Theme Functions
===============================================================
AUTHOR			: Christian Wach <needle@haystack.co.uk>
LAST MODIFIED	: 22/03/2009
---------------------------------------------------------------
NOTES

---------------------------------------------------------------
*/





if ( ! function_exists( 'cp_remove_adminbar' ) ):
/** 
 * @description: get an ID for the body tag
 * @todo: 
 *
 */
function cp_remove_adminbar( 
	
) { //-->

	global $wp_version;
	
	// in version 3.1 or greater
	if ( version_compare( $wp_version, "3.0.9999", ">" ) === true ) {
	
		// disable admin bar
		remove_action( 'init', 'wp_admin_bar_init' );
		
	}
	
	// Disable Admin Bar
	add_filter('show_admin_bar', '__return_false');
	 
	// Remove the Admin Bar option in user profile
	remove_action('personal_options', '_admin_bar_preferences');
	
}
endif; // cp_adminbar

// CMW: we can now enable the admin bar - fixed via Javascript - enable this 
// function if the problem persists
//cp_remove_adminbar();





// add after theme setup hook
add_action( 'after_setup_theme', 'cp_setup' );

if ( ! function_exists( 'cp_setup' ) ):
/** 
 * @description: get an ID for the body tag
 * @todo: 
 *
 */
function cp_setup( 
	
) { //-->

	// allow custom backgrounds
	add_custom_background();
	
	// header text colour
	define('HEADER_TEXTCOLOR', 'eeeeee');
	
	// set height and width
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'cp_header_image_width', 940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'cp_header_image_height', 67 ) );

	// allow custom header images
	add_custom_image_header( 'cp_header', 'cp_admin_header' );

}
endif; // cp_setup






if ( ! function_exists( 'cp_header' ) ):
/** 
 * @description: custom header
 * @todo: 
 *
 */
function cp_header( 
	
) { //-->

	// init (same as bg in layout.css and default in class_commentpress_db.php)
	$colour = '819565';

	// access plugin
	global $commentpress_obj;

	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// override
		$colour = $commentpress_obj->db->option_get_header_bg();
	
	}
	
	// init background-image
	$bg_image = '';
	
	// get header image
	$header_image = get_header_image();
	
	// do we have a background-image?
	if ( $header_image ) {
	
		$bg_image = 'background-image: url("'.$header_image.'");';
	
	}
	
    ?>
<style type="text/css">

#book_header
{
	background-color: #<?php echo $colour; ?>;
	<?php echo $bg_image; ?>
}

#title h1,
#title h1 a
{
	<?php 
	$_col = get_header_textcolor();
	if ( $_col == 'blank' OR $_col == '' ) {
	?>text-indent: -9999px;<?php
	} else {
	?>color: #<?php header_textcolor(); ?>;<?php
	} ?>
}

#book_header #tagline
{
	<?php 
	$_col = get_header_textcolor();
	if ( $_col == 'blank' OR $_col == '' ) {
	?>text-indent: -9999px;<?php
	} else {
	?>color: #<?php header_textcolor(); ?>;<?php
	} ?>
}

</style><?php

}
endif; // cp_header






if ( ! function_exists( 'cp_admin_header' ) ):
/** 
 * @description: custom admin header
 * @todo: 
 *
 */
function cp_admin_header( 
	
) { //-->

	// init (same as bg in layout.css and default in class_commentpress_db.php)
	$colour = '819565';

	// access plugin
	global $commentpress_obj;

	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// override
		$colour = $commentpress_obj->db->option_get_header_bg();
	
	}
	
	// try and recreate the look of the theme header
	?>
<style type="text/css">
    
.appearance_page_custom-header #headimg
{
	min-height: 67px;
}

#headimg
{
	background-color: #<?php echo $colour; ?>;
}

#headimg #name,
#headimg #desc
{
	margin-left: 20px; 
	font-family: Helvetica, Arial, sans-serif;
	font-weight: normal;
	line-height: 1;
	color: #<?php header_textcolor(); ?>;
}

#headimg h1
{
	margin: 0;
	padding: 0;
	padding-top: 7px;
}

#headimg #name
{
	font-size: 1.6em;
	text-decoration: none;
}

#headimg #desc
{
	padding-top: 3px;
	font-size: 1.2em;
	font-style :italic;
}

</style><?php

}
endif; // cp_admin_header






if ( ! function_exists( 'cp_get_header_image' ) ):
/** 
 * @description: get an ID for the body tag
 * @todo: 
 *
 */
function cp_get_header_image( 
	
) { //-->

	// access plugin
	global $commentpress_obj;

	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// set defaults
		$args = array(
		
			'post_type' => 'attachment',
			'numberposts' => 1,
			'post_status' => null,
			'post_parent' => $commentpress_obj->db->option_get( 'cp_toc_page' )
			
		); 
		
		// get them...
		$attachments = get_posts( $args );
		
		// well?
		if ( $attachments ) {
		
			// we only want the first
			$attachment = $attachments[0];
		
		}
		
		// if we have an image
		if ( $attachment ) { 
			
			// show it
			echo wp_get_attachment_image( $attachment->ID, 'full' );
						
		}
		
	}
	
}
endif; // cp_get_header_image






if ( ! function_exists( 'cp_get_body_id' ) ):
/** 
 * @description: get an ID for the body tag
 * @todo: 
 *
 */
function cp_get_body_id( 
	
) { //-->

	// init
	$_body_id = '';
	
	// is this multisite?
	if ( is_multisite() ) {
	
		// is this the main blog?
		if ( is_main_site() ) {
		
			// set main blog id
			$_body_id = ' id="main_blog"';
		
		}
		
	}
	
	// --<
	return $_body_id;
	
}
endif; // cp_get_body_id






if ( ! function_exists( 'cp_get_body_classes' ) ):
/** 
 * @description: get classes for the body tag
 * @todo: 
 *
 */
function cp_get_body_classes( 
	
) { //-->

	// init
	$_body_classes = '';
	
	// access post and plugin
	global $post, $commentpress_obj;



	// set default sidebar
	$sidebar_flag = 'toc';
	
	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// get sidebar
		$sidebar_flag = $commentpress_obj->get_default_sidebar();
		
	}
	
	// set class by sidebar
	$sidebar_class = 'cp_sidebar_'.$sidebar_flag;
	


	// init layout class
	$layout_class = '';
	
	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// is this the title page?
		if ( $post->ID == $commentpress_obj->db->option_get( 'cp_welcome_page' ) ) {
		
			// init layout
			$layout = '';
			
			// set key
			$key = '_cp_page_layout';
			
			//if the custom field already has a value...
			if ( get_post_meta( $post->ID, $key, true ) != '' ) {
			
				// get it
				$layout = get_post_meta( $post->ID, $key, true );
				
			}
			
			// if wide layout...
			if ( $layout == 'wide' ) {
			
				// set layout class
				$layout_class = ' full_width';
				
			}
			
		}
		
	}


	
	// set default page type
	$page_type = '';
	
	// if blog post...
	if ( is_single() ) {
	
		// get sidebar
		$page_type = ' blog_post';
		
	}
	


	// construct attribute
	$_body_classes = ' class="'.$sidebar_class.$layout_class.$page_type.'"';



	// --<
	return $_body_classes;
	
}
endif; // cp_get_body_classes






if ( ! function_exists( 'remove_more_jump_link' ) ):
/** 
 * @description: disable more link jump - from: http://codex.wordpress.org/Customizing_the_Read_More
 * @todo:
 *
 */
function remove_more_jump_link( $link ) { 

	$offset = strpos($link, '#more-');
	
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	
	// --<
	return $link;
	
}
endif; // remove_more_jump_link

// add a filter for the above
add_filter('the_content_more_link', 'remove_more_jump_link');






if ( ! function_exists( 'cp_page_navigation' ) ):
/** 
 * @description: builds a list of previous and next pages, optionally with comments
 * @todo: 
 *
 */
function cp_page_navigation( $with_comments = false ) {

	// declare access to globals
	global $commentpress_obj;
	
	
	
	// is the plugin active?
	if ( !is_object( $commentpress_obj ) ) {
	
		// --<
		return;
		
	}
	
	
	
	// init formatting
	$before_next = '<li class="alignright">';
	$after_next = ' </li>';
	$before_prev = '<li class="alignleft">';
	$after_prev = '</li>';
	
	
	
	// init
	$next_page_html = '';
	
	// get next page
	$next_page = $commentpress_obj->nav->get_next_page( $with_comments );
	
	//var_dump( $next_page );
	
	// did we get a next page?
	if ( is_object( $next_page ) ) {
	
		// init title
		$img = '';
		$title = 'Next page'; //htmlentities( $next_page->post_title );	
	
		// if we wanted pages with comments...
		if ( $with_comments ) {
		
			// set title
			$title = 'Next page with comments';
			$img = '<img src="'.get_bloginfo('template_directory').'/style/images/next.png" />';	

		}
		
		// define list item 
		$next_page_html = $before_next.
						  $img.'<a href="'.get_permalink( $next_page->ID ).'" id="next_page" class="css_btn" title="Next Page">'.$title.'</a>'.$after_next;
		
	}
	
	
	
	// init
	$prev_page_html = '';
	
	// get next page
	$prev_page = $commentpress_obj->nav->get_previous_page( $with_comments );
	
	// did we get a next page?
	if ( is_object( $prev_page ) ) {
		
		// init title
		$img = '';
		$title = 'Previous page'; //htmlentities( $prev_page->post_title );
	
		// if we wanted pages with comments...
		if ( $with_comments ) {
		
			// set title
			$title = 'Previous page with comments';
			$img = '<img src="'.get_bloginfo('template_directory').'/style/images/prev.png" />';
		
		}
		
		// define list item 
		$prev_page_html = $before_prev.
						  $img.'<a href="'.get_permalink( $prev_page->ID ).'" id="previous_page" class="css_btn" title="Previous Page">'.$title.'</a>'.$after_prev;
		
	}
	
	
	
	// init return
	$nav_list = '';
	
	// did we get either?
	if ( $next_page_html != '' OR $prev_page_html != '' ) {
	
		// construct nav list items
		$nav_list = $prev_page_html."\n".$next_page_html."\n";

	}
	
	
	
	// --<
	return $nav_list;

}
endif; // cp_page_navigation






if ( ! function_exists( 'cp_page_title' ) ):
/** 
 * @description: builds a list of previous and next pages, optionally with comments
 * @todo: 
 *
 */
function cp_page_title( $with_comments = false ) {

	// declare access to globals
	global $commentpress_obj, $post;
	
	
	
	// init
	$_title = '';
	$_sep = ' &#8594; ';
	
	
	//$_title .= get_bloginfo('name');
 
	if ( is_page() OR is_single() OR is_category() ) {

		if (is_page()) {

			$ancestors = get_post_ancestors($post);
 
			if ($ancestors) {
				$ancestors = array_reverse($ancestors);
 				
 				$_crumb = array();
 				
				foreach ($ancestors as $crumb) {
					$_crumb[] = get_the_title($crumb);
				}
				
				$_title .= implode( $_sep, $_crumb ).$_sep;
			}

		}
 
		if (is_single()) {
			//$category = get_the_category();
			//$_title .= $_sep.$category[0]->cat_name;
		}
 
		if (is_category()) {
			$category = get_the_category();
			$_title .= $category[0]->cat_name.$_sep;
		}
 
		// Current page
		if (is_page() OR is_single()) {
			$_title .= get_the_title();
		}

	}

	

	// --<
	return $_title;

}
endif; // cp_page_title





if ( ! function_exists( 'cp_has_page_children' ) ):
/** 
 * @description: query whether a given page has children
 * @todo: 
 *
 */
function cp_has_page_children( 

	$page_obj
	
) { //-->

	// init to look for published pages
	$defaults = array( 

		'post_parent' => $page_obj->ID,
		'post_type' => 'page', 
		'numberposts' => -1,
		'post_status' => 'publish'

	);
				
	// get page children
	$kids =& get_children( $defaults );
	
	// do we have any?
	return ( empty( $kids ) ) ? false : true;

}
endif; // cp_has_page_children






if ( ! function_exists( 'cp_get_children' ) ):
/** 
 * @description: retrieve comment children
 * @todo: 
 *
 */
function cp_get_children( 

	$comment,
	$page_or_post
	
) { //-->

	// declare access to globals
	global $wpdb;

	// construct query for comment children
	$query = "
	SELECT $wpdb->comments.*, $wpdb->posts.post_title, $wpdb->posts.post_name
	FROM $wpdb->comments, $wpdb->posts
	WHERE $wpdb->comments.comment_post_ID = $wpdb->posts.ID 
	AND $wpdb->posts.post_type = '$page_or_post' 
	AND $wpdb->comments.comment_approved = '1' 
	AND $wpdb->comments.comment_parent = '$comment->comment_ID' 
	ORDER BY $wpdb->comments.comment_date ASC
	";
	
	// does it have children?
	return $wpdb->get_results( $query );

}
endif; // cp_get_children






if ( ! function_exists( 'cp_get_comments' ) ):
/** 
 * @description: generate comments recursively
 * @todo: 
 *
 */
function cp_get_comments( 

	$comments,
	$page_or_post
	
) { //-->

	// declare access to globals
	global $cp_comment_output;



	// do we have any comments?
	if( count( $comments ) > 0 ) {
	
		// open ul
		$cp_comment_output .= '<ul>'."\n\n";

		// produce a checkbox for each
		foreach( $comments as $comment ) {
		
			// open li
			$cp_comment_output .= '<li>'."\n\n";
	
			// format this comment
			$cp_comment_output .= cp_format_comment( $comment );

			// get comment children
			$children = cp_get_children( $comment, $page_or_post );

			// do we have any?
			if( count( $children ) > 0 ) {

				// recurse
				cp_get_comments( $children, $page_or_post );

			}
			
			// close li
			$cp_comment_output .= '</li>'."\n\n";

		}

		// close ul
		$cp_comment_output .= '</ul>'."\n\n";

	}

}
endif; // cp_get_comments







if ( ! function_exists( 'cp_format_comment' ) ):
/** 
 * @description: format comment on comments pages
 * @todo: 
 *
 */
function cp_format_comment( $comment, $context='all' ) {

	// enable Wordpress API on comment
	//$GLOBALS['comment'] = $comment;


	// if context is 'all comments'...
	if ( $context == 'all' ) {
	
		// get author
		if ($comment->comment_author != '') {
		
			// was it a registered user?
			if ($comment->user_id != '0') {
			
				// get user details
				$user = get_userdata( $comment->user_id );
				
				// construct link to user url
				$_context = ( $user->user_url != '' AND $user->user_url != 'http://' ) ? 
							'by <a href="'.$user->user_url.'">'.$comment->comment_author.'</a>' : 
							'by '.$comment->comment_author;
				
			} else {
			
				// construct link to commenter url
				$_context = ( $comment->comment_author_url != '' AND $comment->comment_author_url != 'http://' ) ? 
							'by <a href="'.$comment->comment_author_url.'">'.$comment->comment_author.'</a>' : 
							'by '.$comment->comment_author;
				
			}
			
			
		} else { 
		
			// we don't have a name
			$_context = 'by anonymous';
			
		}
	
	// if context is 'by commenter'
	} elseif ( $context == 'by' ) {
	
		// construct link
		$_page_link = trailingslashit( get_permalink( $comment->comment_post_ID ) );
		
		// construct context
		$_context = 'on <a href="'.$_page_link.'">'.$comment->post_title.'</a>';
	
	}
	
	// construct link
	$_comment_link = trailingslashit( get_permalink( $comment->comment_post_ID ) ).
					 '#comment-'.$comment->comment_ID;

	// comment header
	$_comment_meta = '<div class="comment_meta"><a href="'.$_comment_link.'" title="See comment in context">Comment</a> '.$_context.' on '.date('F jS, Y',strtotime($comment->comment_date)).'</div>'."\n";

	// comment content
	$_comment_body = '<div class="comment_content">'.wpautop(convert_chars(wptexturize($comment->comment_content))).'</div>'."\n";
	
	// construct comment
	return '<div class="comment_wrapper">'."\n".$_comment_meta.$_comment_body.'</div>'."\n\n";
	
}
endif; // cp_format_comment






if ( ! function_exists( 'cp_get_all_comments_content' ) ):
/** 
 * @description: all-comments page display function
 * @todo: 
 *
 */
function cp_get_all_comments_content( $page_or_post = 'page' ) {

	// declare access to globals
	global $wpdb, $commentpress_obj, $cp_comment_output;

	// init page content
	$_page_content = '';
	
	
	
	// construct query
	$querystr = "
	SELECT $wpdb->comments.*, $wpdb->posts.post_title, $wpdb->posts.post_name, $wpdb->posts.comment_count
	FROM $wpdb->comments, $wpdb->posts
	WHERE $wpdb->comments.comment_post_ID = $wpdb->posts.ID 
	AND $wpdb->posts.post_type = '$page_or_post' 
	AND $wpdb->comments.comment_approved = '1' 
	AND $wpdb->comments.comment_parent = '0' 
	AND $wpdb->comments.comment_type != 'pingback' 
	ORDER BY $wpdb->posts.comment_count DESC, $wpdb->comments.comment_post_ID, $wpdb->comments.comment_date ASC
	";
	
	//echo $querystr; exit();
	
	
	// get data
	$_data = $wpdb->get_results($querystr, OBJECT);
	
	
	
	// did we get any?
	if ( count( $_data ) > 0 ) {
	
	
	
		// open ul
		$_page_content .= '<ul class="all_comments_listing">'."\n\n";
		
		// init title
		$_title = '';
	
		// init global comment output
		$cp_comment_output = '';
		
		// loop
		foreach ($_data as $comment) {
		
	
	
			// show page title, if not shown
			if ( $_title != $comment->post_title ) {
			
				// if not first...
				if ( $_title != '' ) {
				
					// close ul
					$_page_content .= '</ul>'."\n\n";
					
					// close item div
					$_page_content .= '</div><!-- /item_body -->'."\n\n";
					
					// close li
					$_page_content .= '</li><!-- /page li -->'."\n\n\n\n";
					
				}
		
				// open li
				$_page_content .= '<li><!-- page li -->'."\n\n";
				
				// count comments
				if ( $comment->comment_count > 1 ) { $_comment_count_text = 'comments'; } else { $_comment_count_text = 'comment'; }
		
				// show it
				$_page_content .= '<h3>'.$comment->post_title.' <span>('.$comment->comment_count.' '.$_comment_count_text.')</span></h3>'."\n\n";
	
				// open comments div
				$_page_content .= '<div class="item_body">'."\n\n";
				
				// open ul
				$_page_content .= '<ul>'."\n\n";
		
				// set mem
				$_title = $comment->post_title;
	
			}
		
			
			// open li
			$_page_content .= '<li><!-- item li -->'."\n\n";
	
			// show the comment
			$_page_content .= cp_format_comment( $comment );
		
			// get comment children
			$children = cp_get_children( $comment, $page_or_post );
			
			// do we have any?
			if( count( $children ) > 0 ) {
	
				// recurse
				cp_get_comments( $children, $page_or_post );
				
				// show them
				$_page_content .= $cp_comment_output;
				
				// clear global comment output
				$cp_comment_output = '';
				
			}
			
			// close li
			$_page_content .= '</li><!-- /item li -->'."\n\n";
	
		
			
		}
	
		// close ul
		$_page_content .= '</ul>'."\n\n";
		
		// close item div
		$_page_content .= '</div><!-- /item_body -->'."\n\n";
		
		// close li
		$_page_content .= '</li><!-- /page li -->'."\n\n\n\n";
		
		// close ul
		$_page_content .= '</ul><!-- /all_comments_listing -->'."\n\n";
	
	}
	
	
	
	// --<
	return $_page_content;
	
}
endif; // cp_get_all_comments_content
	
	
	



if ( ! function_exists( 'cp_get_all_comments_page_content' ) ):
/** 
 * @description: all-comments page display function
 * @todo: 
 *
 */
function cp_get_all_comments_page_content() {

	// declare access to globals
	global $commentpress_obj;

	
	
	// set title
	$_page_content = '<h2>All Comments</h2>'."\n\n";
	


	// get page or post
	$page_or_post = $commentpress_obj->get_list_option();
	
	
	
	// get title
	$title = ( $page_or_post == 'page' ) ? 'Comments on the Book': 'Comments on the Blog';
	
	// set title
	$_page_content .= '<p class="comments_hl">'.$title.'</p>'."\n\n";
	
	// get data
	$_page_content .= cp_get_all_comments_content( $page_or_post );
	
	
	
	// get data for other page type
	$other_type = ( $page_or_post == 'page' ) ? 'post': 'page';
	
	// get title
	$title = ( $page_or_post == 'page' ) ? 'Comments on the Blog': 'Comments on the Book';
	
	// set title
	$_page_content .= '<p class="comments_hl">'.$title.'</p>'."\n\n";
	
	// get data
	$_page_content .= cp_get_all_comments_content( $other_type );
	
	
	
	// --<
	return $_page_content;
	
}
endif; // cp_get_all_comments_page_content

	
	



if ( ! function_exists( 'cp_get_comments_by_content' ) ):
/** 
 * @description: comments-by page display function
 * @todo: do we want trackbacks?
 *
 */
function cp_get_comments_by_content() {

	// declare access to globals
	global $wpdb, $commentpress_obj;

	// init page content
	$_page_content = '';
	
	
	
	// construct query
	$querystr = "
	SELECT $wpdb->comments.*, $wpdb->posts.post_title, $wpdb->posts.post_name
	FROM $wpdb->comments, $wpdb->posts
	WHERE $wpdb->comments.comment_post_ID = $wpdb->posts.ID 
	AND $wpdb->comments.comment_type != 'pingback' 
	AND $wpdb->comments.comment_approved = '1' 
	ORDER BY $wpdb->comments.comment_author, $wpdb->posts.post_title, $wpdb->comments.comment_post_ID, $wpdb->comments.comment_date ASC
	";
	
	//echo $querystr; exit();
	
	
	// get data
	$_data = $wpdb->get_results( $querystr, OBJECT );
	
	//print_r( $_data ); exit();
	
	
	// did we get any?
	if ( count( $_data ) > 0 ) {
	
	
	
		// open ul
		$_page_content .= '<ul class="all_comments_listing">'."\n\n";
		
		// init title
		$_title = '';
	
		// loop
		foreach ($_data as $comment) {
		
	
	
			// show commenter, if not shown
			if ( $_title != $comment->comment_author ) {
			
				// if not first...
				if ( $_title != '' ) {
				
					// close ul
					$_page_content .= '</ul>'."\n\n";
					
					// close item div
					$_page_content .= '</div><!-- /item_body -->'."\n\n";
					
					// close li
					$_page_content .= '</li><!-- /author li -->'."\n\n\n\n";
					
				}
		
				// open li
				$_page_content .= '<li><!-- author li -->'."\n\n";
				
				// count comments
				//if ( $comment->comment_count > 1 ) { $_comment_count_text = 'comments'; } else { $_comment_count_text = 'comment'; }
		
				// show it --  <span>('.$comment->comment_count.' '.$_comment_count_text.')</span>
				$_page_content .= '<h3>'.$comment->comment_author.'</h3>'."\n\n";
	
				// open comments div
				$_page_content .= '<div class="item_body">'."\n\n";
				
				// open ul
				$_page_content .= '<ul>'."\n\n";
		
				// set mem
				$_title = $comment->comment_author;
	
			}
		
			
			// open li
			$_page_content .= '<li><!-- item li -->'."\n\n";
	
			// show the comment
			$_page_content .= cp_format_comment( $comment, 'by' );
		
			// close li
			$_page_content .= '</li><!-- /item li -->'."\n\n";
	
		
			
		}
	
		// close ul
		$_page_content .= '</ul>'."\n\n";
		
		// close item div
		$_page_content .= '</div><!-- /item_body -->'."\n\n";
		
		// close li
		$_page_content .= '</li><!-- /author li -->'."\n\n\n\n";
		
		// close ul
		$_page_content .= '</ul><!-- /all_comments_listing -->'."\n\n";
	
	}
	
	
	
	// --<
	return $_page_content;
	
}
endif; // cp_get_comments_by_content

	
	



if ( ! function_exists( 'cp_get_comments_by_page_content' ) ):
/** 
 * @description: comments-by page display function
 * @todo: 
 *
 */
function cp_get_comments_by_page_content() {

	// declare access to globals
	global $commentpress_obj;

	
	
	// set title
	$_page_content = '<h2>Comments by Commenter</h2>'."\n\n";

	// get data
	$_page_content .= cp_get_comments_by_content();
	

	
	// --<
	return $_page_content;
	
}
endif; // cp_get_comments_by_page_content

	
	



if ( ! function_exists( 'cp_get_comments_by_para' ) ):
/** 
 * @description: get comments delimited by paragraph
 * @todo: 
 *
 */
function cp_get_comments_by_para() {

	// declare access to globals
	global $post, $commentpress_obj;
	


	// get approved comments for this post, sorted comments by text signature
	$comments_sorted = $commentpress_obj->get_sorted_comments( $post->ID );
	
	// get text signatures
	$text_sigs = $commentpress_obj->db->get_text_sigs();



	// if we have any...
	if ( count( $comments_sorted ) > 0 ) {
	
		// default comment type to get
		$comment_type = 'all';

		// if we don't allow pingbacks...
		if ( !('open' == $post->ping_status) ) {
		
			// just get comments
			$comment_type = 'comment';
	
		}
		
		

		// init new walker
		$walker = new Walker_Comment_Press;
		
		// define args
		$args = array(
			
			// list comments params
			'walker' => $walker,
			'style'=> 'ol', 
			'type'=> $comment_type, 
			'callback' => 'cp_comments'
			
		);

		
		
		// init counter for text_signatures array
		$sig_counter = 0;
		
		// init array for tracking text sigs
		$used_text_sigs = array();
		
		

		// loop through each paragraph
		foreach( $comments_sorted AS $_comments ) {
		
			// is it the whole page
			if ( $sig_counter == 0 ) { 
			
				// clear text signature
				$text_sig = '';
				
				// clear the paragraph number
				$para_num = '';
				
				// set paragraph text
				$paragraph_text = 'the whole page';
				
				// set block identifier
				$block_name = 'page';
			
			} else {
			
				// get text signature
				$text_sig = $text_sigs[$sig_counter-1];
			
				// paragraph number
				$para_num = $sig_counter;
				
				// which parsing method?
				if ( defined( 'CP_BLOCK' ) AND CP_BLOCK == 'block' ) {
				
					// set block identifier
					$block_name = 'block';
				
				} else {
				
					// set block identifier
					$block_name = 'paragraph';
				
				}
				
				// set paragraph text
				$paragraph_text = $block_name.' '.$para_num;
				
			}
			
			// init s
			$s = 's';
			
			// if just one comment
			if ( count( $_comments ) == 1 ) { $s = ''; }
			
			// construct heading
			$heading_text = '<span>'. count( $_comments ) . '</span> Comment'.$s.' on '.$paragraph_text;
			
			// show heading
			echo '<h3 id="para_heading-'.$text_sig.'"><a class="comment_block_permalink" title="Permalink for comments on '.$paragraph_text.'" href="#para_heading-'.$text_sig.'">'.$heading_text.'</a></h3>'."\n\n";

			// open paragraph wrapper
			echo '<div id="para_wrapper-'.$text_sig.'" class="paragraph_wrapper">'."\n\n";

			// have we already used this text signature?
			if( in_array( $text_sig, $used_text_sigs ) ) {
			
				// show some kind of message TO DO: incorporate para order too
				echo '<div class="reply_to_para" id="reply_to_para-'.$para_num.'">'."\n".
						'<p>'.
							'It appears that this paragraph is a duplicate of a previous one.'.
						'</p>'."\n".
					 '</div>'."\n\n";

			} else {
		
				// if we have comments...
				if ( count( $_comments ) > 0 ) {
				
					// open commentlist
					echo '<ol class="commentlist">'."\n\n";
			
					// use WP 2.7+ functionality
					wp_list_comments( $args, $_comments ); 
					
					// close commentlist
					echo '</ol>'."\n\n";
						
				}
				
				// add to used array
				$used_text_sigs[] = $text_sig;
			
				// only add comment-on-para link if comments are open
				if ( 'open' == $post->comment_status ) {
				
					// construct onclick 
					$onclick = "return addComment.moveFormToPara( '$para_num', '$text_sig', '$post->ID' )";
					
					// just show replytopara
					$query = remove_query_arg( array( 'replytocom' ) ); 
		
					// add param to querystring
					$query = esc_html( 
						add_query_arg( 
							array( 'replytopara' => $para_num ),
							$query
						) 
					);
					
					// if we have to log in to comment...
					if ( get_option('comment_registration') AND !is_user_logged_in() ) {
						
						// leave comment link
						echo '<div class="reply_to_para" id="reply_to_para-'.$para_num.'">'."\n".
								'<p><a class="reply_to_para" rel="nofollow" href="' . site_url('wp-login.php?redirect_to=' . get_permalink()) . '">'.
									'Login to leave a comment on '.$paragraph_text.
								'</a></p>'."\n".
							 '</div>'."\n\n";
						
					} else {
						
						// leave comment link
						echo '<div class="reply_to_para" id="reply_to_para-'.$para_num.'">'."\n".
								'<p><a class="reply_to_para" href="'.$query.'#respond" onclick="'.$onclick.'">'.
									'Leave a comment on '.$paragraph_text.
								'</a></p>'."\n".
							 '</div>'."\n\n";
						
					}
						 
				}
					 
			}

			// close paragraph wrapper
			echo '</div>'."\n\n\n\n";
			
			// increment signature array counter
			$sig_counter++;
			
		}
		
	}
	
}
endif; // cp_get_comments_by_para






/**
 * HTML comment list class.
 *
 * @package WordPress
 * @uses Walker
 * @since unknown
 */
class Walker_Comment_Press extends Walker_Comment {

	/**
	 * @see Walker_Comment::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of comment.
	 * @param array $args Uses 'style' argument for type of HTML list.
	 */
	function start_lvl(&$output, $depth, $args) {
	
		// if on top level
		if( $depth === 0 ) {
			//echo '<h3>New Top Level</h3>'."\n";
		}
		
		// store depth
		$GLOBALS['comment_depth'] = $depth + 1;
		
		// open children if necessary
		switch ( $args['style'] ) {
		
			case 'div':
				break;
				
			case 'ol':
				echo "<ol class='children'>\n";
				break;
				
			default:
			case 'ul':
				echo "<ul class='children'>\n";
				break;
		}
		
	}

}






if ( ! function_exists( 'cp_comment_form_title' ) ):
/** 
 * @description: alternative to the built-in WP function
 * @todo: 
 *
 */
function cp_comment_form_title( 
	
	$no_reply_text = 'Leave a Reply', 
	$reply_to_comment_text = 'Leave a Reply to %s', 
	$reply_to_para_text = 'Leave a Comment on %s', 
	$link_to_parent = TRUE 
	
) {

	// declare access to globals
	global $comment, $commentpress_obj;



	// get comment ID to reply to from URL query string
	$reply_to_comment_id = isset($_GET['replytocom']) ? (int) $_GET['replytocom'] : 0;

	// get paragraph number to reply to from URL query string
	$reply_to_para_id = isset($_GET['replytopara']) ? (int) $_GET['replytopara'] : 0;



	// if we have no comment ID AND no paragraph ID to reply to
	if ( $reply_to_comment_id == 0 AND $reply_to_para_id == 0 ) {
		
		// write default title to page
		echo $no_reply_text;
		
	} else {
	
		// if we have a comment ID AND NO paragraph ID to reply to
		if ( $reply_to_comment_id != 0 AND $reply_to_para_id == 0 ) {
	
			// get comment
			$comment = get_comment( $reply_to_comment_id );
			
			// get link to comment
			$author = ( $link_to_parent ) ? 
				'<a href="#comment-' . get_comment_ID() . '">' . get_comment_author() . '</a>' : 
				get_comment_author();
			
			// write to page
			printf( $reply_to_comment_text, $author );
			
		} else {
		
			// get paragraph text signature
			$text_sig = $commentpress_obj->get_text_signature( $reply_to_para_id );
		
			// get link to paragraph
			$paragraph = ( $link_to_parent ) ? 
				'<a href="#para_heading-' . $text_sig . '">Paragraph ' .$reply_to_para_id. '</a>' : 
				'Paragraph ' .$para_num;
			
			// write to page
			printf( $reply_to_para_text, $paragraph );
			
		}
	
	}
	
}
endif; // cp_comment_form_title






if ( ! function_exists( 'cp_comment_reply_link' ) ):
/** 
 * @description: alternative to the built-in WP function
 * @todo: 
 *
 */
function cp_comment_reply_link( $args = array(), $comment = null, $post = null ) {

	global $user_ID;

	$defaults = array(
	
		'add_below' => 'comment', 
		'respond_id' => 'respond', 
		'reply_text' => __('Reply'),
		'login_text' => __('Log in to Reply'), 
		'depth' => 0, 
		'before' => '', 
		'after' => ''
		
	);

	$args = wp_parse_args($args, $defaults);

	if ( 0 == $args['depth'] || $args['max_depth'] <= $args['depth'] ) {
		return;
	}

	extract($args, EXTR_SKIP);

	$comment = get_comment($comment);
	$post = get_post($post);

	// kick out if comments closed
	if ( 'open' != $post->comment_status ) { return false; }

	$link = '';
	
	// if we have to log in to comment...
	if ( get_option('comment_registration') && !$user_ID ) {
	
		$link = '<a rel="nofollow" href="' . site_url('wp-login.php?redirect_to=' . get_permalink()) . '">' . $login_text . '</a>';
		
	} else {
	
		// just show replytocom
		$query = remove_query_arg( array( 'replytopara' ), get_permalink( $post->ID ) ); 

		// define query string
		$addquery = esc_html( 
		
			add_query_arg( 
			
				array( 'replytocom' => $comment->comment_ID ),
				$query
				
			) 
			
		);
		
		// define link
		$link = "<a rel='nofollow' class='comment-reply-link' href='" . $addquery . "#" . $respond_id . "' onclick='return addComment.moveForm(\"$add_below-$comment->comment_ID\", \"$comment->comment_ID\", \"$respond_id\", \"$post->ID\", \"$comment->comment_text_signature\")'>$reply_text</a>";
		
	}
	
	// --<
	return apply_filters('comment_reply_link', $before . $link . $after, $args, $comment, $post);
	
}
endif; // cp_comment_reply_link







if ( ! function_exists( 'cp_comments' ) ):
/** 
 * @description: custom comments display function
 * @todo: 
 *
 */
function cp_comments( $comment, $args, $depth ) {

	// build comment as html
	echo cp_get_comment_markup( $comment, $args, $depth );
	
}
endif; // cp_comments






if ( ! function_exists( 'cp_get_comment_markup' ) ):
/** 
 * @description: wrap comment in its markup
 * @todo: 
 *
 */
function cp_get_comment_markup( $comment, $args, $depth ) {

	//print_r( $comment );
	//print_r( $args );

	// enable Wordpress API on comment
	$GLOBALS['comment'] = $comment;



	if ($comment->comment_approved == '0') {
		$author = '<cite class="fn">'.get_comment_author().'</cite>';
	} else {
		$author = '<cite class="fn">'.get_comment_author_link().'</cite>';
	}
	
	
	
	if ($comment->comment_approved == '0') {
		$comment_text = '<p><em>Comment awaiting moderation</em></p>';
	} else {
		$comment_text = get_comment_text();
	}


	
	// empty reply div by default
	$comment_reply = '';

	// enable access to post
	global $post;
		
	// if comments are open...
	if ( $post->comment_status == 'open' AND $comment->comment_type != 'pingback' ) {
	
		// are we threading comments?
		if ( get_option( 'thread_comments', false ) ) {
		
			// custom comment_reply_link
			$comment_reply = cp_comment_reply_link(
			
				array_merge(
				
					$args, 
					array(
						'reply_text' => 'Reply to '.get_comment_author(),
						'depth' => $depth, 
						'max_depth' => $args['max_depth']
					)
				)
				
			);
			
			// wrap in div
			$comment_reply = '<div class="reply">'.$comment_reply.'</div><!-- /reply -->';
			
		}
		
	}
	
	
	
	// init edit link
	$editlink = '';
	
	// if logged in and has capability
	if ( is_user_logged_in() AND current_user_can('edit_posts') ) {

		// get edit comment link
		$editlink = '<span class="alignright"><a class="comment-edit-link" href="'.get_edit_comment_link().'" title="Edit comment">(Edit)</a></span>';
		
	}
	
	
	
	// get comment class(es)
	$_comment_class = comment_class( null, $comment->comment_ID, $post->ID, false );
	
	
	
	// stripped source
	$html = '	
<li id="li-comment-'.$comment->comment_ID.'"'.$_comment_class.'>
<div class="comment-wrapper">
<div id="comment-'.$comment->comment_ID.'">



<div class="comment-identifier">
'.get_avatar( $comment, $size='32' ).'
'.$editlink.'
'.$author.'		
<a class="comment_permalink" href="'.htmlspecialchars( get_comment_link() ).'">'.get_comment_date().' at '.get_comment_time().'</a>
</div><!-- /comment-identifier -->



<div class="comment-content">
'.apply_filters('comment_text', get_comment_text() ).'
</div><!-- /comment-content -->



'.$comment_reply.'



</div><!-- /comment-'.$comment->comment_ID.' -->
</div><!-- /comment-wrapper -->
';



	// --<
	return $html;
	
}
endif; // cp_get_comment_markup






if ( ! function_exists( 'cp_get_full_name' ) ):
/** 
 * @description: utility to concatenate names
 * @todo: 
 *
 */
function cp_get_full_name( $forename, $surname ) {

	// init return
	$fullname = '';
	
	

	// add forename
	if ($forename != '' ) { $fullname .= $forename; } 
	
	// add surname
	if ($surname != '' ) { $fullname .= ' '.$surname; }
	
	// strip any whitespace
	$fullname = trim( $fullname );
	
	
	
	// --<
	return $fullname;
	
}
endif; // cp_get_full_name






if ( ! function_exists( 'cp_excerpt_length' ) ):
/** 
 * @description: utility to define length of excerpt
 * @todo: 
 *
 */
function cp_excerpt_length() {

	// declare access to globals
	global $commentpress_obj;
	
	
	
	// is the plugin active?
	if ( !is_object( $commentpress_obj ) ) {
	
		// --<
		return 55; // Wordpress default
		
	}
	
	
	
	// get length of excerpt from option
	$length = $commentpress_obj->db->option_get( 'cp_excerpt_length' );



	// --<
	return $length;
	
}
endif; // cp_excerpt_length

// add filter for excerpt length
add_filter( 'excerpt_length', 'cp_excerpt_length' );






if ( ! function_exists( 'cp_add_link_css' ) ):
/** 
 * @description: utility to add button css class to blog nav links
 * @todo: 
 *
 */
function cp_add_link_css( $link ) {

	// add css
	$link = str_replace( '<a ', '<a class="css_btn" ', $link );

	// --<
	return $link;
	
}
endif; // cp_add_link_css

// add filter for next/previous links
add_filter( 'previous_post_link', 'cp_add_link_css' );
add_filter( 'next_post_link', 'cp_add_link_css' );






if ( ! function_exists( 'cp_get_link_css' ) ):
/** 
 * @description: utility to add button css class to blog nav links
 * @todo: 
 *
 */
function cp_get_link_css() {

	// add css
	$link = 'class="css_btn"';

	// --<
	return $link;
	
}
endif; // cp_get_link_css

// add filter for next/previous posts links
add_filter( 'previous_posts_link_attributes', 'cp_get_link_css' );
add_filter( 'next_posts_link_attributes', 'cp_get_link_css' );






if ( ! function_exists( 'cp_add_loginout_id' ) ):
/** 
 * @description: utility to add button css id to login links
 * @todo: 
 *
 */
function cp_add_loginout_id( $link ) {

	// if logged in
	if ( is_user_logged_in() ) {
	
		// logout
		$_id = 'btn_logout';
		
	} else {
	
		// login
		$_id = 'btn_login';

	}
	
	// add css
	$link = str_replace( '<a ', '<a id="'.$_id.'" ', $link );

	// --<
	return $link;
	
}
endif; // cp_add_loginout_id

// add filter for next/previous links
add_filter( 'loginout', 'cp_add_link_css' );
add_filter( 'loginout', 'cp_add_loginout_id' );






if ( ! function_exists( 'cp_multipage_comment_link' ) ):
/** 
 * @description: filter comment permalinks for multipage posts
 * @todo: should this go in the plugin?
 *
 */
function cp_multipage_comment_link( $link, $comment, $args ) {

	// get multipage
	global $multipage; 
	
	// are there multiple (sub)pages?
	if ( $multipage ) {
	
		// exclude page level comments
		if ( $comment->comment_text_signature != '' ) {
		
			// get current comment info
			$comment_path_info = parse_url( $link );
		
			// we need to use the current page path
			$current_page_info = $_SERVER['REQUEST_URI'];
			
			// set comment path
			return $current_page_info.'#'.$comment_path_info[fragment];

		}
		
	}

	// --<
	return $link;

}
endif; // cp_multipage_comment_link

// add filter for the above
add_filter( 'get_comment_link', 'cp_multipage_comment_link', 10, 3 );






if ( ! function_exists( 'cp_multipager' ) ):
/** 
 * @description: adds some style
 * @todo: 
 *
 */
function cp_multipager() {

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
	
	// --<
	return $page_links;

}
endif; // cp_multipager






if ( ! function_exists( 'cp_comment_post_redirect' ) ):
/** 
 * @description: filter comment post redirects for multipage posts
 * @todo: should this go in the plugin?
 *
 */
function cp_comment_post_redirect( $link ) {

	// get page var, indicating subpage
	$page = (isset($_POST['page'])) ? $_POST['page'] : 0;

	// are we on a subpage?
	if ( $page ) {
	
		// get current redirect
		$current_redirect = parse_url( $link );
	
		// we need to use the page that submitted the comment
		$page_info = $_SERVER['HTTP_REFERER'];
		
		// set redirect to comment on subpage
		return $page_info.'#'.$current_redirect[fragment];
		
	}

	// --<
	return $link;

}
endif; // cp_comment_post_redirect

// add filter for the above, making it run early so it can be overridden by AJAX commenting
add_filter( 'comment_post_redirect', 'cp_comment_post_redirect', 4, 1 );






// remove caption shortcode
remove_shortcode( 'caption' );

if ( ! function_exists( 'cp_image_caption_shortcode' ) ):
/** 
 * @description: rebuild caption shortcode output
 * @param array $attr Attributes attributed to the shortcode.
 * @param string $content Optional. Shortcode content.
 * @return string
 * @todo: Do we need to hook into this?
 *
 */
function cp_image_caption_shortcode( $attr, $content ) {

	// Allow plugins/themes to override the default caption template.
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' )
		return $output;

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));

	if ( 1 > (int) $width || empty($caption) )
		return $content;
	
	// sanitise id
	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
	
	// add space prior to alignment
	$_alignment = ' '.esc_attr($align);
	
	// get width
	$_width = (0 + (int) $width);

	return '<span class="captioned_image'.$_alignment.'" style="width: '.$_width.'px"><span '.$id.' class="wp-caption">'
	. do_shortcode( $content ) . '</span><small class="wp-caption-text">'.$caption.'</small></span>';
	
}
endif; // cp_image_caption_shortcode

// add a shortcode for the above
add_shortcode('caption', 'cp_image_caption_shortcode');






if ( ! function_exists( 'add_commentblock_button' ) ):
/** 
 * @description: add filters for adding our custom TinyMCE button
 * @todo:
 *
 */
function add_commentblock_button() {

	// don't bother doing this stuff if the current user lacks permissions
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
		return;
	}
	
	// add only in Rich-text Editor mode
	if ( get_user_option('rich_editing') == 'true') {
	
		add_filter("mce_external_plugins", "add_commentblock_tinymce_plugin");
		add_filter('mce_buttons', 'register_commentblock_button');
	
	}

}
endif; // cp_image_caption_shortcode






if ( ! function_exists( 'register_commentblock_button' ) ):
/** 
 * @description: add filters for adding our custom TinyMCE button
 * @todo:
 *
 */
function register_commentblock_button($buttons) {
	
	// add our button to the editor button array
	array_push($buttons, "|", "commentblock");
	
	// --<
	return $buttons;

}
endif; // cp_image_caption_shortcode






if ( ! function_exists( 'add_commentblock_tinymce_plugin' ) ):
/** 
 * @description: load the TinyMCE plugin : cp_editor_plugin.js
 * @todo:
 *
 */
function add_commentblock_tinymce_plugin($plugin_array) {

	$plugin_array['commentblock'] = get_bloginfo('template_url').'/style/js/tinymce/cp_editor_plugin.js';
	return $plugin_array;

}
endif; // add_commentblock_tinymce_plugin






if ( ! function_exists( 'cp_refresh_mce' ) ):
/** 
 * @description: load the TinyMCE plugin : cp_editor_plugin.js
 * @todo: can this be removed? doesn't seem to affect things...
 *
 */
function cp_refresh_mce($ver) {

	$ver += 3;
	return $ver;

}
endif; // cp_refresh_mce

// init process for button control
//add_filter( 'tiny_mce_version', 'cp_refresh_mce');
add_action('init', 'add_commentblock_button');






if ( ! function_exists( 'cp_trap_empty_search' ) ):
/** 
 * @description: trap empty search queries and redirect
 * @todo: this isn't ideal, but works - awaiting core updates
 *
 */
function cp_trap_empty_search() {

	// take care of empty searches
	if ( isset( $_GET['s'] ) AND empty( $_GET['s'] ) ) {
	
		// send to search page
		return locate_template( array( 'search.php' ) );

	}

}
endif; // cp_trap_empty_search

// add filter for the above
add_filter( 'front_page_template', 'cp_trap_empty_search' );




if ( ! function_exists( 'cp_amend_password_form' ) ):
/** 
 * @description: adds some style
 * @todo: 
 *
 */
function cp_amend_password_form( $output ) {

	// add css class to form
	$output = str_replace( '<form ', '<form class="post_password_form" ', $output );
	
	// add css class to text field
	$output = str_replace( '<input name="post_password" ', '<input class="post_password_field" name="post_password" ', $output );

	// add css class to submit button
	$output = str_replace( '<input type="submit" ', '<input class="post_password_button" type="submit" ', $output );

	// --<
	return $output;

}
endif; // cp_amend_password_form

// add filter for the above
add_filter( 'the_password_form', 'cp_amend_password_form' );



?>