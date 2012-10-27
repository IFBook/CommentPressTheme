<?php /*
===============================================================
Commentpress Theme Functions
===============================================================
AUTHOR			: Christian Wach <needle@haystack.co.uk>
---------------------------------------------------------------
NOTES

---------------------------------------------------------------
*/





/**
 * Set the content width based on the theme's design and stylesheet.
 * This seems to be a Wordpress requirement - though rather dumb in the
 * context of our theme, which has a percentage-based default width.
 * I have arbitrarily set it to the default content-width when viewing
 * on a 1280px-wide screen.
 */
if ( !isset( $content_width ) ) { $content_width = 588; }





if ( ! function_exists( 'cp_setup' ) ):
/** 
 * @description: get an ID for the body tag
 * @todo: 
 *
 */
function cp_setup( 
	
) { //-->

	/** 
	 * Make Commentpress available for translation.
	 * Translations can be added to the /style/languages/ directory.
	 * If you're building a theme based on Commentpress, use a find and replace
	 * to change 'commentpress-theme' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 
	
		'commentpress-theme', 
		get_template_directory() . '/style/languages' 
		
	);

	// add_custom_background function is deprecated in WP 3.4+
	global $wp_version;
	if ( version_compare( $wp_version, '3.4', '>=' ) ) {
		
		// -------------------------
		// TO DO: test 3.4 features
		// -------------------------
	
		// allow custom backgrounds
		add_theme_support( 'custom-background' );
		
		// allow custom header
		add_theme_support( 'custom-header', array( 
			
			'default-text-color' => 'eeeeee',
			'width' => apply_filters( 'cp_header_image_width', 940 ),
			'height' => apply_filters( 'cp_header_image_height', 67 ),
			'wp-head-callback' => 'cp_header',
			'admin-head-callback' => 'cp_admin_header' 
			
		) );
	
	} else {
	
		// retain old declarations for earlier versions
		add_custom_background();
	
		// header text colour
		define( 'HEADER_TEXTCOLOR', 'eeeeee' );
		
		// set height and width
		define( 'HEADER_IMAGE_WIDTH', apply_filters( 'cp_header_image_width', 940 ) );
		define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'cp_header_image_height', 67 ) );
	
		// allow custom header images
		add_custom_image_header( 'cp_header', 'cp_admin_header' );
		
	}
	
	// Default custom headers packaged with the theme (see Twenty Eleven)
	// A nice side-effect of supplying a default header image is that it triggers the
	// "Header Image" option in the Theme Customizer
	// %s is a placeholder for the theme template directory URI
	register_default_headers( 
		array(
			'caves' => array(
				'url' => '%s/style/images/header/caves.jpg',
				'thumbnail_url' => '%s/style/images/header/caves-thumbnail.jpg',
				/* translators: header image description */
				'description' => __( 'Abstract Green', 'commentpress-theme' )
			)
		)
	);
	
	// auto feed links
	add_theme_support( 'automatic-feed-links' );
	
	// style the visual editor with editor-style.css to match the theme style
	add_editor_style();

	// testing the use of wp_nav_menu() - first we need to register it
	register_nav_menu( 'toc', __( 'Table of Contents', 'commentpress-theme' ) );

}
endif; // cp_setup

// add after theme setup hook
add_action( 'after_setup_theme', 'cp_setup' );






if ( ! function_exists( 'cp_enqueue_theme_styles' ) ):
/** 
 * @description: add buddypress front-end styles
 * @todo:
 *
 */
function cp_enqueue_theme_styles() {

	// kick out on admin
	if ( is_admin() ) { return; }

	// init
	$dev = '';
	
	// check for dev
	if ( defined( 'SCRIPT_DEBUG' ) AND SCRIPT_DEBUG === true ) {
		$dev = '.dev';
	}

	// add BuddyPress css
	wp_enqueue_style( 
		
		'cp_buddypress_css', 
		get_template_directory_uri() . '/style/css/bp-overrides'.$dev.'.css'
		
	);
	
}
endif; // cp_enqueue_theme_styles

if ( ! function_exists( 'cp_enqueue_bp_theme_styles' ) ):
/** 
 * @description: enqueue buddypress front-end styles
 * @todo:
 *
 */
function cp_enqueue_bp_theme_styles() {

	// add a filter to include bp-overrides when buddypress is active
	add_action( 'wp_enqueue_scripts', 'cp_enqueue_theme_styles', 40 );
	
}
endif; // cp_enqueue_bp_theme_styles

// add an action for the above
add_action( 'bp_setup_globals', 'cp_enqueue_theme_styles' );






if ( ! function_exists( 'cp_enqueue_print_styles' ) ):
/** 
 * @description: add front-end print styles
 * @todo:
 *
 */
function cp_enqueue_print_styles() {

	// init
	$dev = '';
	
	// check for dev
	if ( defined( 'SCRIPT_DEBUG' ) AND SCRIPT_DEBUG === true ) {
		$dev = '.dev';
	}
	
	// add child print css
	wp_enqueue_style( 
		
		'cp_print_css', 
		get_template_directory_uri() . '/style/css/print'.$dev.'.css',
		false,
		false,
		'print'
		
	);
	
}
endif; // cp_enqueue_print_styles

// add a filter for the above, very late so it (hopefully) is last in the queue
add_action( 'wp_enqueue_scripts', 'cp_enqueue_print_styles', 100 );






if ( ! function_exists( 'cp_header' ) ):
/** 
 * @description: custom header
 * @todo: 
 *
 */
function cp_header( 
	
) { //-->

	// init (same as bg in layout.css and default in class_commentpress_db.php)
	$bg_colour = '819565';

	// access plugin
	global $commentpress_obj;

	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// override
		$bg_colour = $commentpress_obj->db->option_get_header_bg();
	
	}
	
	// allow overrides
	$bg_colour = apply_filters( 'cp_default_header_bgcolor', $bg_colour );	
	
	
	
	// init background-image
	$bg_image = '';
	
	// get header image
	$header_image = get_header_image();
	
	// do we have a background-image?
	if ( $header_image ) {
	
		$bg_image = 'background-image: url("'.$header_image.'");';
	
	}
	
	
	
	// get custom text colour
	// note: this does NOT retrieve the default if not manually set in the Theme Customizer in WP3.4
	$text_color = get_header_textcolor();

	
	
	// WP3.4 seems to behave differently.
	global $wp_version;
	if ( version_compare( $wp_version, '3.4', '>=' ) ) {
	
		// if blank, we're hiding the title
		if ( $text_color == 'blank' ) {
			$css = 'text-indent: -9999px;';
		} else {
			
			// if empty, we need to use default
			if ( $text_color == '' ) {
				$css = 'color: #'.HEADER_TEXTCOLOR.';';
			} else {
				
				// use the custom one. I know this amounts to the same thing.
				$css = 'color: #'.$text_color.';';
			}
			
		}

	} else {
		
		// use previous logic
		if ( $text_color == 'blank' OR $text_color == '' ) {
			$css = 'text-indent: -9999px;';
		} else {
			$css = 'color: #'.$text_color.';';
		}
		
	}
	
    ?>
<style type="text/css">

#book_header
{
	background-color: #<?php echo $bg_colour; ?>;
	<?php echo $bg_image; ?>
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	background-repeat: no-repeat;
	background-position: 50%;
}

#title h1,
#title h1 a
{
	<?php echo $css; ?>

}

#book_header #tagline
{
	<?php echo $css; ?>

}

</style><?php

}
endif; // cp_header



/*
	// if no custom options for text are set, ignore
	if ( $text_color == HEADER_TEXTCOLOR ) {
	
		// set flag
		$ignore = true;
		
	}
	
	// if blank or empty, we're hiding the title
	if ( $text_color == 'blank' OR $text_color == '' ) {
	
	}

	// If we get this far, we have custom styles. Let's do this.
	print_r( ( $text_color ? $text_color : 'nowt<br/>' ) );
	print_r( HEADER_TEXTCOLOR ); die();
	

*/



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
	padding-top: 12px;
}

#headimg #name
{
	font-size: 1em;
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






if ( ! function_exists( 'cp_customize_register' ) ) {
/**
 * Implements Commentpress theme options into Theme Customizer
 *
 * @param $wp_customize Theme Customizer object
 * @return void
 *
 */
function cp_customize_register( 

	$wp_customize 

) { //-->

	// access plugin
	global $commentpress_obj;
	
	// kick out if buddypress groupblog...
	if ( is_object( $commentpress_obj ) AND $commentpress_obj->is_groupblog() ) return;

	// add customizer section title
	$wp_customize->add_section( 'cp_inline_header_image', array(
		'title'          => 'Site Logo',
		'priority'       => 35,
	) );
	
	// add image
	$wp_customize->add_setting('cp_theme_settings[cp_inline_header_image]', array(
		 'default'           => '',
		 'capability'        => 'edit_theme_options',
		 'type'           => 'option'
	));
	 
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'cp_inline_header_image', array(
		 'label'    => __('Logo Image', 'commentpress-theme'),
		 'section'  => 'cp_inline_header_image',
		 'settings' => 'cp_theme_settings[cp_inline_header_image]',
		 'priority'	=>	1
	)));
	
	// add padding
	$wp_customize->add_setting('cp_theme_settings[cp_inline_header_padding]', array(
		 'default'           => '',
		 'capability'        => 'edit_theme_options',
		 'type'           => 'option'
	));
	 
	$wp_customize->add_control( 'cp_theme_settings[cp_inline_header_padding]', array(
		'label'   => 'Top padding in px',
		'section' => 'cp_inline_header_image',
		'type'    => 'text'
	) );

}
}
add_action( 'customize_register', 'cp_customize_register' );





if ( ! function_exists( 'cp_admin_menu' ) ) {
/** 
 * @description: adds more prominent menu item
 * @todo:
 *
 */
function cp_admin_menu() {

	// Only add for WP3.4+
	global $wp_version;
	if ( version_compare( $wp_version, '3.4', '>=' ) ) {

		// add the Customize link to the admin menu
		add_theme_page( 'Customize', 'Customize', 'edit_theme_options', 'customize.php' );
		
	}
	
}
}
add_action( 'admin_menu', 'cp_admin_menu' );






if ( ! function_exists( 'cp_get_header_image' ) ):
/** 
 * @description: function that sets a header foreground image (a logo, for example)
 * @todo: inform users that header images are using a different method
 *
 */
function cp_get_header_image( 
	
) { //-->

	// access plugin
	global $commentpress_obj;

	// test for groupblog
	if ( is_object( $commentpress_obj ) AND $commentpress_obj->is_groupblog() ) {
	
		// get group ID
		$group_id = get_groupblog_group_id( get_current_blog_id() );
	
		// get group avatar
		$avatar_options = array ( 
			'item_id' => $group_id, 
			'object' => 'group', 
			'type' => 'full', 
			'alt' => 'Group avatar', 
			'class' => 'cp_logo_image cp_group_avatar', 
			'width' => 48, 
			'height' => 48, 
			'html' => true 
		);
        
        // show group avatar
        echo bp_core_fetch_avatar( $avatar_options );
		
		// --<
		return;
	
	}
	
	
	
	// -------------------------------------------------------------------------
	// implement compatibility with WordPress Theme Customizer
	// -------------------------------------------------------------------------

	// get the new options
	$options = get_option( 'cp_theme_settings' );
	//print_r( $options ); die();
	
	// test for our new theme customizer option
	if ( isset( $options['cp_inline_header_image'] ) AND !empty( $options['cp_inline_header_image'] ) ) {
	
		// init top padding
		$style = '';
		
		// test for top padding	
		if ( isset( $options['cp_inline_header_padding'] ) AND !empty( $options['cp_inline_header_padding'] ) ) {
		
			// override
			$style = ' style="padding-top: '.$options['cp_inline_header_padding'].'px"';
			
		}		
		
		// show the uploaded image
		echo '<img src="'.$options['cp_inline_header_image'].'" class="cp_logo_image" '.$style.'alt="Logo" />';
		
		// --<
		return;
	
	}
	
	
	
	// -------------------------------------------------------------------------
	// our fallback is to go with the legacy method that some people might still be using
	// -------------------------------------------------------------------------

	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) AND $commentpress_obj->db->option_get( 'cp_toc_page' ) ) {
	
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
		if ( isset( $attachment ) ) { 
			
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

	$raw = false
	
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
	


	// init commentable class
	$commentable = '';
	
	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
		
		// set class
		$commentable = ( $commentpress_obj->is_commentable() ) ? ' commentable' : ' not_commentable';
		
	}
	
	
	
	// init layout class
	$layout_class = '';
	
	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// is this the title page?
		if ( 
			
			// be more defensive
			is_object( $post )
			AND isset( $post->ID )
			AND $post->ID == $commentpress_obj->db->option_get( 'cp_welcome_page' ) 
			
		) {
		
			// init layout
			$layout = '';
			
			// set key
			$key = '_cp_page_layout';
			
			// if the custom field already has a value...
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
	
		// add blog post class
		$page_type = ' blog_post';
		
	}
	
	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// is it a BP special page?
		if ( $commentpress_obj->is_buddypress_special_page() ) {
	
			// add buddypress page class
			$page_type = ' buddypress_page';
		
		}
		
		// is it a CP special page?
		if ( $commentpress_obj->db->is_special_page() ) {
	
			// add buddypress page class
			$page_type = ' commentpress_page';
		
		}
		
	}
	

	
	// set default type
	$groupblog_type = ' not-groupblog';
	
	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// if it's a groupblog
		if ( $commentpress_obj->is_groupblog() ) {
			$groupblog_type = ' is-groupblog';
		}
		
	}
	


	// set default type
	$blog_type = '';
	
	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// get type
		$_type = $commentpress_obj->db->option_get( 'cp_blog_type' );
		//print_r( $_type ); die();
		
		// get workflow
		$_workflow = $commentpress_obj->db->option_get( 'cp_blog_workflow' );
		
		// allow plugins to override the blog type - for example if workflow is enabled, 
		// it might be a new blog type as far as buddypress is concerned
		$_blog_type = apply_filters( 'cp_get_group_meta_for_blog_type', $_type, $_workflow );

		// if it's not the main site, add class
		if ( is_multisite() AND !is_main_site() ) {
			$blog_type = ' blogtype-'.intval( $_blog_type );
		}
		
	}
	


	// construct attribute
	$_body_classes = $sidebar_class.$commentable.$layout_class.$page_type.$groupblog_type.$blog_type;

	// if we want them wrapped, do so
	if ( !$raw ) {
		
		// preserve backwards compat for older child themes
		$_body_classes = ' class="'.$_body_classes.'"';

	}


	// --<
	return $_body_classes;
	
}
endif; // cp_get_body_classes






if ( ! function_exists( 'cp_blog_title' ) ):
/** 
 * @description: disable more link jump - from: http://codex.wordpress.org/Customizing_the_Read_More
 * @todo:
 *
 */
function cp_site_title( $sep = '', $echo = true ){

	// is this multisite?
	if ( is_multisite() ) {
	
		// if we're on a sub-blog
		if ( !is_main_site() ) {
			
			global $current_site;
			
			// print?
			if( $echo ) {
			
				// add site name
				echo ' '.trim($sep).' '.$current_site->site_name;
				
			} else {
			
				// add site name
				return ' '.trim($sep).' '.$current_site->site_name;
				
			}
			
		}
		
	}
	
}
endif; // cp_site_title






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
		$title = __( 'Next page', 'commentpress-theme' ); //htmlentities( $next_page->post_title );	
	
		// if we wanted pages with comments...
		if ( $with_comments ) {
		
			// set title
			$title = __( 'Next page with comments', 'commentpress-theme' );
			$img = '<img src="'.get_bloginfo('template_directory').'/style/images/next.png" />';	

		}
		
		// define list item 
		$next_page_html = $before_next.
						  $img.'<a href="'.get_permalink( $next_page->ID ).'" id="next_page" class="css_btn" title="'.$title.'">'.$title.'</a>'.$after_next;
		
	}
	
	
	
	// init
	$prev_page_html = '';
	
	// get next page
	$prev_page = $commentpress_obj->nav->get_previous_page( $with_comments );
	
	// did we get a next page?
	if ( is_object( $prev_page ) ) {
		
		// init title
		$img = '';
		$title = __( 'Previous page', 'commentpress-theme' ); //htmlentities( $prev_page->post_title );
	
		// if we wanted pages with comments...
		if ( $with_comments ) {
		
			// set title
			$title = __( 'Previous page with comments', 'commentpress-theme' );
			$img = '<img src="'.get_bloginfo('template_directory').'/style/images/prev.png" />';
		
		}
		
		// define list item 
		$prev_page_html = $before_prev.
						  $img.'<a href="'.get_permalink( $prev_page->ID ).'" id="previous_page" class="css_btn" title="'.$title.'">'.$title.'</a>'.$after_prev;
		
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
		$cp_comment_output .= '<ul class="item_ul">'."\n\n";

		// produce a checkbox for each
		foreach( $comments as $comment ) {
		
			// open li
			$cp_comment_output .= '<li class="item_li">'."\n\n";
	
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







if ( ! function_exists( 'cp_get_user_link' ) ):
/** 
 * @description: get user link in vanilla WP scenarios
 * @todo: 
 *
 */
function cp_get_user_link( 

	&$user
	
) { //-->

	/**
	 * In default single install mode, just link to their URL, unless 
	 * they are	an author, in which case we link to their author page.
	 *
	 * In multisite, the same.
	 *
	 * When BuddyPress is enabled, always link to their profile
	 */
	
	// kick out if not a user
	if ( !is_object( $user ) ) { return false; }
	
	// we're through: the user is on the system
	global $commentpress_obj;
	
	// if buddypress...
	if ( is_object( $commentpress_obj ) AND $commentpress_obj->is_buddypress() ) {
	
		// buddypress link ($no_anchor = null, $just_link = true)
		$url = bp_core_get_userlink( $user->ID, null, true );
		
	} else {
	
		// get standard WP author url
	
		// get author url
		$url = get_author_posts_url( $user->ID );
		//print_r( $url ); die();
		
		// WP sometimes leaves 'http://' or 'https://' in the field
		if (  $url == 'http://'  OR $url == 'https://' ) {
		
			// clear
			$url = '';
		
		}
		
	}
	
	
	
	// --<
	return $url;
	 
}
endif; // cp_get_user_link







if ( ! function_exists( 'cp_echo_post_meta' ) ):
/** 
 * @description: show user(s) in the loop
 * @todo: 
 *
 */
function cp_echo_post_meta() {

	// compat with Co-Authors Plus
	if ( function_exists( 'get_coauthors' ) ) {
	
		// get multiple authors
		$authors = get_coauthors();
		//print_r( $authors ); die();
		
		// if we get some
		if ( !empty( $authors ) ) {
		
			// use the Co-Authors format of "name, name, name & name"
			$author_html = '';
			
			// init counter
			$n = 1;
			
			// find out how many author we have
			$author_count = count( $authors );
		
			// loop
			foreach( $authors AS $author ) {
				
				// default to comma
				$sep = ', ';
				
				// if we're on the penultimate
				if ( $n == ($author_count - 1) ) {
				
					// use ampersand
					$sep = __( ' &amp; ', 'commentpress-theme' );
					
				}
				
				// if we're on the last, don't add
				if ( $n == $author_count ) { $sep = ''; }
				
				// get name
				$author_html .= cp_echo_post_author( $author->ID, false );
				
				// and separator
				$author_html .= $sep;
				
				// increment
				$n++;
				
				// yes - are we showing avatars?
				if ( get_option('show_avatars') ) {
				
					// get avatar
					echo get_avatar( $author->ID, $size='32' );
					
				}
					
			}
			
			?><cite class="fn"><?php echo $author_html; ?></cite>
			
			<p><a href="<?php the_permalink() ?>"><?php the_time('l, F jS, Y') ?></a></p>
			
			<?php
				
		}
	
	} else {
	
		// get avatar
		$author_id = get_the_author_meta( 'ID' );
		echo get_avatar( $author_id, $size='32' );
		
		?>
		
		<cite class="fn"><?php cp_echo_post_author( $author_id ) ?></cite>
		
		<p><a href="<?php the_permalink() ?>"><?php the_time('l, F jS, Y') ?></a></p>
		
		<?php 
	
	}
		
}
endif; // cp_echo_post_meta





if ( ! function_exists( 'cp_show_source_url' ) ):
/** 
 * @description: show source URL for print
 * @todo: 
 *
 */
function cp_show_source_url() {

	// add the URL - hidden, but revealed by print stylesheet
	?><p class="hidden_page_url"><?php 
		
		// label
		echo __( 'Source: ', 'commentpress-theme' ); 
		
		// path from server array, if set
		$path = ( isset( $_SERVER['REQUEST_URI'] ) ) ? $_SERVER['REQUEST_URI'] : '';
		
		// get server, if set
		$server = ( isset( $_SERVER['SERVER_NAME'] ) ) ? $_SERVER['SERVER_NAME'] : '';
		
		// get protocol, if set
		$protocol = ( !empty( $_SERVER['HTTPS'] ) ) ? 'https' : 'http';
		
		// construct URL
		$url = $protocol.'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		
		// echo
		echo $url;
		
	?></p><?php 

}
endif; // cp_show_source_url

// add after theme setup hook
add_action( 'wp_footer', 'cp_show_source_url' );





if ( ! function_exists( 'cp_echo_post_author' ) ):
/** 
 * @description: show username (with link) in the loop
 * @todo: 
 *
 */
function cp_echo_post_author( $author_id, $echo = true ) {

	// get author details
	$user = get_userdata( $author_id );
	
	// kick out if we don't have a user with that ID
	if ( !is_object( $user ) ) { return; }
	
	
	
	// access plugin
	global $commentpress_obj, $post;

	// if we have the plugin enabled and it's BP
	if ( is_object( $post ) AND is_object( $commentpress_obj ) AND $commentpress_obj->is_buddypress() ) {
	
		// construct user link
		$author = bp_core_get_userlink( $user->ID );

	} else {
	
		// link to theme's author page
		$link = sprintf(
			'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
			get_author_posts_url( $user->ID, $user->user_nicename ),
			esc_attr( sprintf( __( 'Posts by %s' ), $user->display_name ) ),
			esc_html( $user->display_name )
		);
		$author = apply_filters( 'the_author_posts_link', $link );

	}
	
	// if we're echoing
	if ( $echo ) { 
		echo $author;
	} else {
		return $author;
	}
		
}
endif; // cp_echo_post_author







if ( ! function_exists( 'cp_format_comment' ) ):
/** 
 * @description: format comment on comments pages
 * @todo: 
 *
 */
function cp_format_comment( $comment, $context = 'all' ) {

	// declare access to globals
	global $wpdb, $commentpress_obj, $cp_comment_output;

	// enable Wordpress API on comment
	//$GLOBALS['comment'] = $comment;


	// if context is 'all comments'...
	if ( $context == 'all' ) {
	
		// get author
		if ( $comment->comment_author != '' ) {
		
			// was it a registered user?
			if ( $comment->user_id != '0' ) {
			
				// get user details
				$user = get_userdata( $comment->user_id );
				//print_r( $user->display_name ); die();
				
				// get user link
				$user_link = cp_get_user_link( $user );
				
				// construct link to user url
				$_context = ( $user_link != '' AND $user_link != 'http://' ) ? 
							'by <a href="'.$user_link.'">'.$comment->comment_author.'</a>' : 
							'by '.$comment->comment_author;
				
			} else {
			
				// construct link to commenter url
				$_context = ( $comment->comment_author_url != '' AND $comment->comment_author_url != 'http://' ) ? 
							'by <a href="'.$comment->comment_author_url.'">'.$comment->comment_author.'</a>' : 
							'by '.$comment->comment_author;
				
			}
			
			
		} else { 
		
			// we don't have a name
			$_context = __( 'by Anonymous', 'commentpress-theme' );
			
		}
	
	// if context is 'by commenter'
	} elseif ( $context == 'by' ) {
	
		// construct link
		$_page_link = trailingslashit( get_permalink( $comment->comment_post_ID ) );
		
		// construct context
		$_context = 'on <a href="'.$_page_link.'">'.$comment->post_title.'</a>';
	
	}
	
	// construct link
	$_comment_link = get_comment_link( $comment->comment_ID );

	// comment header
	$_comment_meta = '<div class="comment_meta"><a href="'.$_comment_link.'" title="See comment in context">Comment</a> '.$_context.' on '.date('F jS, Y',strtotime($comment->comment_date)).'</div>'."\n";

	// comment content
	$_comment_body = '<div class="comment-content">'.wpautop(convert_chars(wptexturize($comment->comment_content))).'</div>'."\n";
	
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
	AND $wpdb->posts.post_status = 'publish' 
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
				$_page_content .= '<li class="page_li"><!-- page li -->'."\n\n";
				
				// count comments
				if ( $comment->comment_count > 1 ) { $_comment_count_text = 'comments'; } else { $_comment_count_text = 'comment'; }
		
				// show it
				$_page_content .= '<h3>'.$comment->post_title.' <span>('.$comment->comment_count.' '.$_comment_count_text.')</span></h3>'."\n\n";
	
				// open comments div
				$_page_content .= '<div class="item_body">'."\n\n";
				
				// open ul
				$_page_content .= '<ul class="item_ul">'."\n\n";
		
				// set mem
				$_title = $comment->post_title;
	
			}
		
			
			// open li
			$_page_content .= '<li class="item_li"><!-- item li -->'."\n\n";
	
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

	
	
	// set default
	$pagetitle = apply_filters( 
		'cp_page_all_comments_title', 
		__( 'All Comments', 'commentpress-theme' )
	);

	// set title
	$_page_content = '<h2 class="post_title">'.$pagetitle.'</h2>'."\n\n";
	


	// get page or post
	$page_or_post = $commentpress_obj->get_list_option();
	
	
	
	// set default
	$blogtitle = apply_filters( 
		'cp_page_all_comments_blog_title', 
		__( 'Comments on the Blog', 'commentpress-theme' )
	);

	// set default
	$booktitle = apply_filters( 
		'cp_page_all_comments_book_title', 
		__( 'Comments on the Book', 'commentpress-theme' )
	);

	// get title
	$title = ( $page_or_post == 'page' ) ? $booktitle : $blogtitle;
	
	// set title
	$_page_content .= '<p class="comments_hl">'.$title.'</p>'."\n\n";
	
	// get data
	$_page_content .= cp_get_all_comments_content( $page_or_post );
	
	
	
	// get data for other page type
	$other_type = ( $page_or_post == 'page' ) ? 'post': 'page';
	
	// get title
	$title = ( $page_or_post == 'page' ) ? $blogtitle : $booktitle;
	
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
	AND $wpdb->posts.post_status = 'publish' 
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
		
			// test for anonymous comment (usually generated by WP itself in multisite installs)
			if ( empty( $comment->comment_author ) ) {
			
				$comment->comment_author = 'Anonymous';
			
			}
	
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
				$_page_content .= '<li class="author_li"><!-- author li -->'."\n\n";
				
				// count comments
				//if ( $comment->comment_count > 1 ) { $_comment_count_text = 'comments'; } else { $_comment_count_text = 'comment'; }
		
				// show it --  <span>('.$comment->comment_count.' '.$_comment_count_text.')</span>
				
				// add gravatar
				$_page_content .= '<h3>'.get_avatar( $comment, $size='24' ).$comment->comment_author.'</h3>'."\n\n";
	
				// open comments div
				$_page_content .= '<div class="item_body">'."\n\n";
				
				// open ul
				$_page_content .= '<ul class="item_ul">'."\n\n";
		
				// set mem
				$_title = $comment->comment_author;
	
			}
		
			
			// open li
			$_page_content .= '<li class="item_li"><!-- item li -->'."\n\n";
	
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
	$_page_content = '<h2 class="post_title">Comments by Commenter</h2>'."\n\n";

	// get data
	$_page_content .= cp_get_comments_by_content();
	

	
	// --<
	return $_page_content;
	
}
endif; // cp_get_comments_by_page_content

	
	




if ( ! function_exists( 'cp_show_activity_tab' ) ):
/** 
 * @description: decide whether or not to show the Activity Sidebar
 * @todo: 
 *
 */
function cp_show_activity_tab() {

	// declare access to globals
	global $commentpress_obj, $post;

	
	
	/*
	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// is this multisite?
		if ( 
		
			( is_multisite() 
			AND is_main_site() 
			AND $commentpress_obj->is_buddypress_special_page() )
			OR !is_object( $post )
			
		) {
		
			// ignore activity
			return false;
			
		}
		
	}
	*/



	// --<
	return true;
	
}
endif; // cp_show_activity_tab

	
	




if ( ! function_exists( 'cp_is_commentable' ) ):
/** 
 * @description: decide whether or not to show the Activity Sidebar
 * @todo: 
 *
 */
function cp_is_commentable() {

	// declare access to plugin
	global $commentpress_obj;
	
	// if we have it...
	if ( is_object( $commentpress_obj ) ) {
	
		// return what it reports
		return $commentpress_obj->is_commentable();
		
	}
	
	// --<
	return false;
	
}
endif; // cp_is_commentable

	
	




if ( ! function_exists( 'cp_get_comment_activity' ) ):
/** 
 * @description: activity sidebar display function
 * @todo: do we want trackbacks?
 *
 */
function cp_get_comment_activity( $scope = 'all' ) {

	// declare access to globals
	global $wpdb, $commentpress_obj, $post;

	// init page content
	$_page_content = '';
	
	
	
	// define defaults
	$args = array(
	
		'number' => 10,
		'status' => 'approve',
		
		// exclude trackbacks and pingbacks until we decide what to do with them
		'type' => '' 
	
	);
	


	// if we are on a 404, for example
	if ( $scope == 'post' AND is_object( $post ) ) {
	
		// get all comments
		$args['post_id'] = $post->ID;

	}
	


	// get 'em
	$_data = get_comments( $args );
	//print_r( $_data ); exit();
	
	
	
	// did we get any?
	if ( count( $_data ) > 0 ) {
	
	
	
		// open ul
		$_page_content .= '<ol class="comment_activity">'."\n\n";
		
		// init title
		$_title = '';
		
		// loop
		foreach ($_data as $comment) {
		
			// enable Wordpress API on comment
			$GLOBALS['comment'] = $comment;
		
			// only comments until we decide what to do with pingbacks
			if ( $comment->comment_type != 'pingback' ) //{



			// test for anonymous comment (usually generated by WP itself in multisite installs)
			if ( empty( $comment->comment_author ) ) {
			
				$comment->comment_author = 'Anonymous';
			
			}
			
			

			// was it a registered user?
			if ( $comment->user_id != '0' ) {
			
				// get user details
				$user = get_userdata( $comment->user_id );
				//print_r( $user->display_name ); die();
				
				// get user link
				$user_link = cp_get_user_link( $user );
				
				// construct author citation
				$author = '<cite class="fn"><a href="'.$user_link.'">'.esc_html( $comment->comment_author ).'</a></cite>';
				
				// construct link to user url
				$author = ( $user_link != '' AND $user_link != 'http://' ) ? 
							'<cite class="fn"><a href="'.$user_link.'">'.esc_html( $comment->comment_author ).'</a></cite>' : 
							 '<cite class="fn">'.esc_html( $comment->comment_author ).'</cite>';
				
			} else {
			
				// construct link to commenter url
				$author = ( $comment->comment_author_url != '' AND $comment->comment_author_url != 'http://' ) ? 
							'<cite class="fn"><a href="'.$comment->comment_author_url.'">'.esc_html( $comment->comment_author ).'</a></cite>' : 
							 '<cite class="fn">'.esc_html( $comment->comment_author ).'</cite>';
			
			}
				
			
			
			// approved comment?
			if ($comment->comment_approved == '0') {
				$comment_text = '<p><em>Comment awaiting moderation</em></p>';
			} else {
				$comment_text = get_comment_text( $comment->comment_ID );
			}
		
		
			
			// default to not on post
			$is_on_current_post = '';

			// on current post?
			if ( is_singular() AND is_object( $post ) AND $comment->comment_post_ID == $post->ID ) {
				
				// access paging globals
				global $multipage, $page;
				
				// is it the same page, if paged?
				if ( $multipage ) {
					
					/*
					print_r( array( 
						'multipage' => $multipage, 
						'page' => $page 
					) ); die();
					*/
					
					// if it has a text sig
					if ( 
					
						!is_null( $comment->comment_text_signature ) 
						AND $comment->comment_text_signature != '' 
						
					) {
		
						// set key
						$key = '_cp_comment_page';
						
						// if the custom field already has a value...
						if ( get_comment_meta( $comment->comment_ID, $key, true ) != '' ) {
						
							// get comment's page from meta
							$page_num = get_comment_meta( $comment->comment_ID, $key, true );
							
							// is it this one?
							if ( $page_num == $page ) {
							
								// is the right page
								$is_on_current_post = ' comment_on_post';
							
							}
							
						}
					
					} else {
					
						// it's always the right page for page-level comments
						$is_on_current_post = ' comment_on_post';
					
					}
					
				} else {
					
					// must be the right page
					$is_on_current_post = ' comment_on_post';
				
				}
				
			}
		
		
			
			// open li
			$_page_content .= '<li><!-- item li -->'."\n\n";
	
			// show the comment
			$_page_content .= '
<div class="comment-wrapper">

<div class="comment-identifier">
'.get_avatar( $comment, $size='32' ).'
'.$author.'		
<p class="comment_activity_date"><a class="comment_activity_link'.$is_on_current_post.'" href="'.htmlspecialchars( get_comment_link() ).'">'.get_comment_date().' at '.get_comment_time().'</a></p>
</div><!-- /comment-identifier -->



<div class="comment-content">
'.apply_filters('comment_text', $comment_text ).'
</div><!-- /comment-content -->

<div class="reply"><p><a class="comment_activity_link'.$is_on_current_post.'" href="'.htmlspecialchars( get_comment_link() ).'">'.__( 'See in context', 'commentpress-theme' ).'</a></p></div><!-- /reply -->

</div><!-- /comment-wrapper -->

';

			// close li
			$_page_content .= '</li><!-- /item li -->'."\n\n";
			
		}
	
		// close ul
		$_page_content .= '</ol><!-- /comment_activity -->'."\n\n";
	
	}
	
	
	
	// --<
	return $_page_content;
	
}
endif; // cp_get_comment_activity

	
	



if ( ! function_exists( 'cp_get_comments_by_para' ) ):
/** 
 * @description: get comments delimited by paragraph
 * @todo: translation
 *
 */
function cp_get_comments_by_para() {

	// declare access to globals
	global $post, $commentpress_obj;
	


	// get approved comments for this post, sorted comments by text signature
	$comments_sorted = $commentpress_obj->get_sorted_comments( $post->ID );
	//print_r( $comments_sorted ); die();
	
	// get text signatures
	//$text_sigs = $commentpress_obj->db->get_text_sigs();



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
		foreach( $comments_sorted AS $text_signature => $_comments ) {
		
			// count comments
			$comment_count = count( $_comments );
			
			// switch, depending on key
			switch( $text_signature ) {
				
				// whole page comments
				case 'WHOLE_PAGE_OR_POST_COMMENTS':

					// clear text signature
					$text_sig = '';
					
					// clear the paragraph number
					$para_num = '';
					
					// define default phrase
					$paragraph_text = __( 'the whole page', 'commentpress-theme' );
					
					$current_type = get_post_type();
					//print_r( $current_type ); die();
					
					switch( $current_type ) {
						
						// we can add more of these if needed
						case 'post': $paragraph_text = __( 'the whole post', 'commentpress-theme' ); break;
						case 'page': $paragraph_text = __( 'the whole page', 'commentpress-theme' ); break;
						
					}
				
					// set permalink text
					$permalink_text = __('Permalink for comments on ', 'commentpress-theme' ).$paragraph_text;
					
					// define heading text
					$heading_text = sprintf( _n(
						
						// singular
						'<span>%d</span> Comment on ', 
						
						// plural
						'<span>%d</span> Comments on ', 
						
						// number
						$comment_count, 
						
						// domain
						'commentpress-theme'
					
					// substitution
					), $comment_count );
					
					// append para text
					$heading_text .= $paragraph_text;
					
					break;
				
				// pingbacks etc
				case 'PINGS_AND_TRACKS':

					// set "unique-enough" text signature
					$text_sig = 'pingbacksandtrackbacks';
					
					// clear the paragraph number
					$para_num = '';
					
					// define heading text
					$heading_text = sprintf( _n(
						
						// singular
						'<span>%d</span> Pingback or trackback', 
						
						// plural
						'<span>%d</span> Pingbacks and trackbacks', 
						
						// number
						$comment_count, 
						
						// domain
						'commentpress-theme'
					
					// substitution
					), $comment_count );
					
					// set permalink text
					$permalink_text = __('Permalink for pingbacks and trackbacks', 'commentpress-theme' );
					
					break;
					
				// textblock comments
				default:

					// get text signature
					$text_sig = $text_signature;
				
					// paragraph number
					$para_num = $sig_counter;
					
					// which parsing method?
					if ( defined( 'CP_BLOCK' ) ) {
					
						switch ( CP_BLOCK ) {
						
							case 'tag' :
								
								// set block identifier
								$block_name = __( 'paragraph', 'commentpress-theme' );
							
								break;
								
							case 'block' :
								
								// set block identifier
								$block_name = __( 'block', 'commentpress-theme' );
							
								break;
								
							case 'line' :
								
								// set block identifier
								$block_name = __( 'line', 'commentpress-theme' );
							
								break;
								
						}
					
					} else {
					
						// set block identifier
						$block_name = __( 'paragraph', 'commentpress-theme' );
					
					}
					
					// set paragraph text
					$paragraph_text = $block_name.' '.$para_num;
					
					// set permalink text
					$permalink_text = __('Permalink for comments on ', 'commentpress-theme' ).$paragraph_text;
					
					// define heading text
					$heading_text = sprintf( _n(
						
						// singular
						'<span>%d</span> Comment on ', 
						
						// plural
						'<span>%d</span> Comments on ', 
						
						// number
						$comment_count, 
						
						// domain
						'commentpress-theme'
					
					// substitution
					), $comment_count );
					
					// append para text
					$heading_text .= $paragraph_text;
					
			} // end switch
		


			// init no comment class
			$no_comments_class = '';
			
			// override if there are no comments (for print stylesheet to hide them)
			if ( $comment_count == 0 ) { $no_comments_class = ' class="no_comments"'; }
			
			// eclude pings if there are none
			if ( $comment_count == 0 AND $text_signature == 'PINGS_AND_TRACKS' ) {
			
				// skip
				
			} else {
			
				// show heading
				echo '<h3 id="para_heading-'.$text_sig.'"'.$no_comments_class.'><a class="comment_block_permalink" title="'.$permalink_text.'" href="#para_heading-'.$text_sig.'">'.$heading_text.'</a></h3>'."\n\n";
	
				// override if there are no comments (for print stylesheet to hide them)
				if ( $comment_count == 0 ) { $no_comments_class = ' no_comments'; }
				
				// open paragraph wrapper
				echo '<div id="para_wrapper-'.$text_sig.'" class="paragraph_wrapper'.$no_comments_class.'">'."\n\n";
	
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
				
					// only add comment-on-para link if comments are open and it's not the pingback section
					if ( 'open' == $post->comment_status AND $text_signature != 'PINGS_AND_TRACKS' ) {
					
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
										__( 'Login to leave a comment on ', 'commentpress-theme' ).$paragraph_text.
									'</a></p>'."\n".
								 '</div>'."\n\n";
							
						} else {
							
							// leave comment link
							echo '<div class="reply_to_para" id="reply_to_para-'.$para_num.'">'."\n".
									'<p><a class="reply_to_para" href="'.$query.'#respond" onclick="'.$onclick.'">'.
										__( 'Leave a comment on ', 'commentpress-theme' ).$paragraph_text.
									'</a></p>'."\n".
								 '</div>'."\n\n";
							
						}
							 
					}
						 
				}
	
				// close paragraph wrapper
				echo '</div>'."\n\n\n\n";
				
			}
			
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
				echo '<ol class="children">'."\n";
				break;
				
			default:
			case 'ul':
				echo '<ul class="children">'."\n";
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
		'reply_text' => __('Reply','commentpress-theme'),
		'login_text' => __('Log in to Reply','commentpress-theme'), 
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
	return apply_filters( 'comment_reply_link', $before . $link . $after, $args, $comment, $post );
	
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



	// was it a registered user?
	if ( $comment->user_id != '0' ) {
	
		// get user details
		$user = get_userdata( $comment->user_id );
		//print_r( $user->display_name ); die();
		
		// get user link
		$user_link = cp_get_user_link( $user );
		//print_r( array( 'u' => $user_link ) ); die();
		
		// construct author citation
		$author = ( $user_link != '' AND $user_link != 'http://' ) ? 
					'<cite class="fn"><a href="'.$user_link.'">'.get_comment_author().'</a></cite>' : 
					 '<cite class="fn">'.get_comment_author().'</cite>';
		
		//print_r( array( 'a' => $author ) ); die();

	} else {
	
		// construct link to commenter url
		$author = ( $comment->comment_author_url != '' AND $comment->comment_author_url != 'http://' AND $comment->comment_approved != '0' ) ? 
					'<cite class="fn"><a href="'.$comment->comment_author_url.'">'.get_comment_author().'</a></cite>' : 
					 '<cite class="fn">'.get_comment_author().'</cite>';
	
	}
		
	
	
	/*
	if ($comment->comment_approved == '0') {
		$author = '<cite class="fn">'.get_comment_author().'</cite>';
	} else {
		$author = '<cite class="fn">'.get_comment_author_link().'</cite>';
	}
	*/
	
	
	
	if ( $comment->comment_approved == '0' ) {
		$comment_text = '<p><em>'.__( 'Comment awaiting moderation', 'commentpress-theme' ).'</em></p>';
	} else {
		$comment_text = get_comment_text();
	}


	
	// empty reply div by default
	$comment_reply = '';

	// enable access to post
	global $post;
	
	// can we reply?
	if ( 
		
		// not if comments are closed
		$post->comment_status == 'open' 
		
		// we don't want reply to on pingbacks
		AND $comment->comment_type != 'pingback' 
		
		// nor on unapproved comments
		AND $comment->comment_approved == '1' 
		
	) {
	
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
	if ( 
		is_user_logged_in() 
	AND 
		current_user_can('edit_posts') 
	AND 
		current_user_can( 'edit_comment', $comment->comment_ID ) 
	) {
	
		// set default edit link title text
		$edit_title_text = apply_filters( 
			'cp_comment_edit_link_title_text', 
			__( 'Edit this comment', 'commentpress-theme' )
		);
	
		// set default edit link text
		$edit_text = apply_filters( 
			'cp_comment_edit_link_text', 
			__( 'Edit', 'commentpress-theme' )
		);
	
		// get edit comment link
		$editlink = '<span class="alignright comment-edit"><a class="comment-edit-link" href="'.get_edit_comment_link().'" title="'.$edit_title_text.'">'.$edit_text.'</a></span>';
		
		// add a filter for plugins
		$editlink = apply_filters( 'cp_comment_edit_link', $editlink, $comment );
		
	}
	
	
	
	// get comment class(es)
	$_comment_class = comment_class( null, $comment->comment_ID, $post->ID, false );
	
	// if orphaned, add class to identify as such
	$_comment_orphan = ( isset( $comment->orphan ) ) ? ' comment-orphan' : '';
	
	
	
	// stripped source
	$html = '	
<li id="li-comment-'.$comment->comment_ID.'"'.$_comment_class.'>
<div class="comment-wrapper">
<div id="comment-'.$comment->comment_ID.'">



<div class="comment-identifier'.$_comment_orphan.'">
'.get_avatar( $comment, $size='32' ).'
'.$editlink.'
'.$author.'		
<a class="comment_permalink" href="'.htmlspecialchars( get_comment_link() ).'">'.get_comment_date().' at '.get_comment_time().'</a>
</div><!-- /comment-identifier -->



<div class="comment-content">
'.apply_filters('comment_text', $comment_text ).'
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

	// get multipage and post
	global $multipage, $post;
	
	// are there multiple (sub)pages?
	//if ( is_object( $post ) AND $multipage ) {
	
		// exclude page level comments
		if ( $comment->comment_text_signature != '' ) {
		
			// init page num
			$page_num = 1;
		
			// set key
			$key = '_cp_comment_page';
			
			// if the custom field already has a value...
			if ( get_comment_meta( $comment->comment_ID, $key, true ) != '' ) {
			
				// get the page number
				$page_num = get_comment_meta( $comment->comment_ID, $key, true );
				
			}
			
			// get current comment info
			$comment_path_info = parse_url( $link );
			
			// set comment path
			return cp_get_post_multipage_url( $page_num, get_post( $comment->comment_post_ID ) ).'#'.$comment_path_info['fragment'];

		}
		
	//}

	// --<
	return $link;

}
endif; // cp_multipage_comment_link

// add filter for the above
add_filter( 'get_comment_link', 'cp_multipage_comment_link', 10, 3 );






/**
 * Copied from wp-includes/post-template.php _wp_link_page()
 * @param int $i Page number.
 * @return string url.
 */
function cp_get_post_multipage_url( $i, $post = '' ) {

	// if we have no passed value
	if ( $post == '' ) {
		
		// we assume we're in the loop
		global $post, $wp_rewrite;
	
		if ( 1 == $i ) {
			$url = get_permalink();
		} else {
			if ( '' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')) )
				$url = add_query_arg( 'page', $i, get_permalink() );
			elseif ( 'page' == get_option('show_on_front') && get_option('page_on_front') == $post->ID )
				$url = trailingslashit(get_permalink()) . user_trailingslashit("$wp_rewrite->pagination_base/" . $i, 'single_paged');
			else
				$url = trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged');
		}
		
	} else {
		
		// use passed post object
		if ( 1 == $i ) {
			$url = get_permalink( $post->ID );
		} else {
			if ( '' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')) )
				$url = add_query_arg( 'page', $i, get_permalink( $post->ID ) );
			elseif ( 'page' == get_option('show_on_front') && get_option('page_on_front') == $post->ID )
				$url = trailingslashit(get_permalink( $post->ID )) . user_trailingslashit("$wp_rewrite->pagination_base/" . $i, 'single_paged');
			else
				$url = trailingslashit(get_permalink( $post->ID )) . user_trailingslashit($i, 'single_paged');
		}
		
	}
	
	return esc_url( $url );
}







if ( ! function_exists( 'cp_multipager' ) ):
/** 
 * @description: adds some style
 * @todo: 
 *
 */
function cp_multipager() {

	// set default behaviour
	$defaults = array(
		
		'before' => '<div class="multipager">',
		'after' => '</div>',
		'link_before' => '', 
		'link_after' => '',
		'next_or_number' => 'next', 
		'nextpagelink' => '<span class="alignright">'.__('Next page','commentpress-theme').' &raquo;</span>',
		'previouspagelink' => '<span class="alignleft">&laquo; '.__('Previous page','commentpress-theme').'</span>',
		'pagelink' => '%',
		'more_file' => '', 
		'echo' => 0
		
	);
	
	// get page links
	$page_links = wp_link_pages( $defaults );
	//print_r( $page_links ); die();
	
	// add separator when there are two links
	$page_links = str_replace( 
	
		'a><a', 
		'a> <span class="multipager_sep">|</span> <a', 
		$page_links 
		
	);
	
	// get page links
	$page_links .= wp_link_pages( array(
	
		'before' => '<div class="multipager multipager_all"><span>' . __('Pages: ','commentpress-theme') . '</span>', 
		'after' => '</div>',
		'pagelink' => '<span class="multipager_link">%</span>',
		'echo' => 0 
		
	) );
	
	// --<
	return $page_links;

}
endif; // cp_multipager






/**
 * @description; adds our styles to the TinyMCE editor
 * @param string $mce_css The default TinyMCE stylesheets as set by WordPress
 * @return string $mce_css The list of stylesheets with ours added
 */
function cp_add_wp_editor() {
	
	// init option
	$rich_text = false;
	
	global $commentpress_obj;
	
	// kick out if wp_editor doesn't exist
	// TinyMCE will be handled by including the script using the pre- wp_editor() method
	if ( !function_exists( 'wp_editor' ) ) {
	
		// --<
		return false;
	
	}

	// kick out if plugin not active
	if ( !is_object( $commentpress_obj ) ) {
	
		// --<
		return false;
	
	}

	// only allow through if plugin says so
	if ( !$commentpress_obj->display->is_tinymce_allowed() ) {
	
		// --<
		return false;

	}
	


	// add our buttons
	$mce_buttons = apply_filters( 
		
		// filter for plugins
		'cp_tinymce_buttons', 
		
		// basic buttons
		array(
			'bold', 
			'italic', 
			'underline', 
			'|',
			'bullist',
			'numlist',
			'|',
			'link', 
			'unlink', 
			'|', 
			'removeformat',
			'fullscreen'
		)
		
	);
	
	// our settings
	$settings = array(
		
		// configure comment textarea
		'media_buttons' => false,
		'textarea_name' => 'comment',
		'textarea_rows' => 10,
		
		// might as well start with teeny
		'teeny' => true,
		
		// give the iframe a white background
		'editor_css' => '
			<style type="text/css">
				/* <![CDATA[ */
				
				.wp_themeSkin iframe
				{
					background: #fff;
				}
				
				/* ]]> */
			</style>
		',
		
		// configure TinyMCE
		'tinymce' => array(
			
			'theme' => 'advanced',
			'theme_advanced_buttons1' => implode( ',', $mce_buttons ),
			'theme_advanced_statusbar_location' => 'none',
		
		),
		
		// no quicktags
		'quicktags' => false
	
	);
	
	/*
	had we wanted quicktags, we could have used:
	
		'quicktags' => array(
			'buttons' => 'strong,em,ul,ol,li,link,close'
		)

	*/
	
	// create editor
	wp_editor(
	
		'', // initial content
		'comment', // id of comment textarea
		$settings
	
	);
	
	
	
	// don't show textarea
	return true;

}






/**
 * @description; makes TinyMCE the default editor on the front end
 * @param string $r The default editor as set by WordPress
 * @return string 'tinymce' our overridden default editor
 */
function cp_assign_default_editor( $r ) {

	// only on front-end
	if ( is_admin() ) { return $r; }
	
	
	
	// always return 'tinymce' as the default editor, or else the comment form will not show up!
	
	// --<
	return 'tinymce';
	
}

add_filter( 'wp_default_editor', 'cp_assign_default_editor', 10, 1 );






/**
 * @description; adds our styles to the TinyMCE editor
 * @param string $mce_css The default TinyMCE stylesheets as set by WordPress
 * @return string $mce_css The list of stylesheets with ours added
 */
function cp_add_tinymce_styles( $mce_css ) {

	// only on front-end
	if ( is_admin() ) { return $mce_css; }
	
	// add comma if not empty
	if ( !empty( $mce_css ) ) { $mce_css .= ','; }
	
	// add our editor styles
	$mce_css .= get_template_directory_uri().'/style/css/comment-form.css';
	
	return $mce_css;
	
}

// add filter for the above
add_filter( 'mce_css', 'cp_add_tinymce_styles' );





/**
 * @description; adds the Next Page button to the TinyMCE editor
 * @param array $buttons The default TinyMCE buttons as set by WordPress
 * @return array $buttons The buttons with More removed
 */
function cp_add_tinymce_nextpage_button( $buttons ) {
	
	// only on back-end
	if ( !is_admin() ) { return $buttons; }
	
	// try and place Next Page after More button
	$pos = array_search( 'wp_more', $buttons, true );
	
	// is it there?
	if ($pos !== false) {
	
		// get array up to that point
		$tmp_buttons = array_slice( $buttons, 0, $pos + 1 );
		
		// add Next Page button
		$tmp_buttons[] = 'wp_page';
		
		// recombine
		$buttons = array_merge( $tmp_buttons, array_slice( $buttons, $pos + 1 ) );
		
	}
	
	
	
	// --<
	return $buttons;

}

// add filter for the above
add_filter( 'mce_buttons', 'cp_add_tinymce_nextpage_button' );





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
		return $page_info.'#'.$current_redirect['fragment'];
		
	}

	// --<
	return $link;

}
endif; // cp_comment_post_redirect

// add filter for the above, making it run early so it can be overridden by AJAX commenting
add_filter( 'comment_post_redirect', 'cp_comment_post_redirect', 4, 1 );






if ( ! function_exists( 'cp_image_caption_shortcode' ) ):
/** 
 * @description: rebuild caption shortcode output
 * @param array $empty WordPress passes '' as the first param!
 * @param array $attr Attributes attributed to the shortcode.
 * @param string $content Optional. Shortcode content.
 * @return string
 * @todo:
 *
 */
function cp_image_caption_shortcode( $empty=null, $attr, $content ) {
	
	// get our shortcode vars
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));
	
	/*
	print_r( array(
		'content' => $content,
		'caption' => $caption,
	) ); die();
	*/
	
	if ( 1 > (int) $width || empty($caption) )
		return $content;
	
	// sanitise id
	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
	
	// add space prior to alignment
	$_alignment = ' '.esc_attr($align);
	
	// get width
	$_width = (0 + (int) $width);
	
	// construct
	$_caption = '<!-- cp_caption_start --><span class="captioned_image'.$_alignment.'" style="width: '.$_width.'px"><span '.$id.' class="wp-caption">'
	. do_shortcode( $content ) . '</span><small class="wp-caption-text">'.$caption.'</small></span><!-- cp_caption_end -->';
	
	// --<
	return $_caption;
	
}
endif; // cp_image_caption_shortcode

// add a filter for the above
add_filter( 'img_caption_shortcode', 'cp_image_caption_shortcode', 10, 3 );






if ( ! function_exists( 'add_commentblock_button' ) ):
/** 
 * @description: add filters for adding our custom TinyMCE button
 * @todo:
 *
 */
function add_commentblock_button() {

	// only on back-end
	if ( !is_admin() ) { return; }
	
	// don't bother doing this stuff if the current user lacks permissions
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
		return;
	}
	
	// add only if user can edit in Rich-text Editor mode
	if ( get_user_option('rich_editing') == 'true') {
	
		add_filter( 'mce_external_plugins', 'add_commentblock_tinymce_plugin' );
		add_filter( 'mce_buttons', 'register_commentblock_button' );
	
	}

}
endif; // add_commentblock_button






if ( ! function_exists( 'register_commentblock_button' ) ):
/** 
 * @description: add filters for adding our custom TinyMCE button
 * @todo:
 *
 */
function register_commentblock_button( $buttons ) {
	
	// add our button to the editor button array
	array_push( $buttons, '|', 'commentblock' );
	
	// --<
	return $buttons;

}
endif; // register_commentblock_button






if ( ! function_exists( 'add_commentblock_tinymce_plugin' ) ):
/** 
 * @description: load the TinyMCE plugin : cp_editor_plugin.js
 * @todo:
 *
 */
function add_commentblock_tinymce_plugin( $plugin_array ) {

	// add comment block
	$plugin_array['commentblock'] = get_template_directory_uri().'/style/js/tinymce/cp_editor_plugin.js';
	
	// --<
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
add_action( 'init', 'add_commentblock_button' );






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

// front_page_template filter is deprecated in WP 3.2+
if ( version_compare( $wp_version, '3.2', '>=' ) ) {

	// add filter for the above
	add_filter( 'home_template', 'cp_trap_empty_search' );

} else {

	// retain old filter for earlier versions
	add_filter( 'front_page_template', 'cp_trap_empty_search' );

}




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





if ( ! function_exists( 'commentpress_widgets_init' ) ):
/**
 * Register our widgets
 */
function commentpress_widgets_init() {

	// define an area where a widget may be placed
	register_sidebar( array(
		'name' => __( 'Commentpress Footer', 'commentpress-theme' ),
		'id' => 'cp-license-8',
		'description' => __( 'An optional widget area in the page footer of Commentpress theme', 'commentpress-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => "</div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// widget definitions
	require( get_template_directory() . '/style/widgets/widgets.php' );

	// and the widget
	register_widget( 'Commentpress_License_Widget' );

}
endif; // commentpress_widgets_init

add_action( 'widgets_init', 'commentpress_widgets_init' );






if ( ! function_exists( 'commentpress_license_image_css' ) ):
/**
 * Amend display of license plugin image
 */
function commentpress_license_image_css() {

	// give a bit more room to the image
	return 'display: block; float: left; margin: 0 6px 3px 0;';

}
endif; // commentpress_license_image_css

add_action( 'license_img_style', 'commentpress_license_image_css' );






if ( ! function_exists( 'commentpress_license_widget_compat' ) ):
/**
 * Remove license from footer when widget not active - wp_footer() is not inside #footer
 */
function commentpress_license_widget_compat() {

	// if the widget is not active, (i.e. the plugin is installed but the widget has not been 
	// dragged to a sidebar), then DO NOT display the license in the footer as a default
	if (!is_active_widget(false, false, 'license-widget', true) ) {
		remove_action( 'wp_footer', 'license_print_license_html' );			
	}

}
endif; // commentpress_license_widget_compat

// do this late, so license ought to be declared by then
add_action( 'widgets_init', 'commentpress_license_widget_compat', 100 );






if ( ! function_exists( 'commentpress_wplicense_compat' ) ):
/**
 * Remove license from footer - wp_footer() is not inside #footer
 */
function commentpress_wplicense_compat() {
	
	// let's not have the default footer
	remove_action('wp_footer', 'cc_showLicenseHtml');

}
endif; // commentpress_wplicense_compat

// do this late, so license ought to be declared by then
add_action( 'init', 'commentpress_wplicense_compat', 100 );






if ( ! function_exists( 'commentpress_groupblog_classes' ) ):
/**
 * Add classes to #content in BuddyPress, so that we can distinguish different groupblog types
 */
function commentpress_groupblog_classes() {
	
	// init empty
	$groupblog_class = '';
	
	// only add classes when bp-groupblog is active
	if ( function_exists( 'get_groupblog_group_id' ) ) {
	
		// init groupblogtype
		$groupblogtype = 'groupblog';
		
		// get group blogtype
		$groupblog_type = groups_get_groupmeta( bp_get_current_group_id(), 'groupblogtype' );
		
		// did we get one?
		if ( $groupblog_type ) {
		
			// add to default
			$groupblogtype .= ' '.$groupblog_type;
		
		}
		
		// complete
		$groupblog_class = ' class="'.$groupblogtype.'"';
		
	}
	
	
	
	// --<
	return $groupblog_class;
	
}
endif; // commentpress_groupblog_classes






if ( ! function_exists( 'cp_get_post_version_info' ) ):
/**
 * Get links to previous and next versions, should they exist
 */
function cp_get_post_version_info( $post ) {
	
	// check for newer version
	$newer_link = '';
	
	// assume no newer version
	$newer_id = '';
	
	// set key
	$key = '_cp_newer_version';
	
	// if the custom field already has a value...
	if ( get_post_meta( $post->ID, $key, true ) !== '' ) {
	
		// get it
		$newer_id = get_post_meta( $post->ID, $key, true );
		
	}
	
	
	
	// if we've got one...
	if ( $newer_id !== '' ) {
	
		// get post
		$newer_post = get_post( $newer_id );
		
		// is it published?
		if ( $newer_post->post_status == 'publish' ) {
	
			// get link
			$_link = get_permalink( $newer_post->ID );
		
			// construct anchor
			$newer_link = '<a href="'.$_link.'" title="Newer version">Newer version &rarr;</a>';
		
		}
	
	}
	
	
	
	// check for older version
	$older_link = '';
	
	// get post with this post's ID as their _cp_newer_version meta value
	$args = array(
	
		'numberposts' => 1,
		'meta_key' => '_cp_newer_version',
		'meta_value' => $post->ID
	
	);
	
	// get the array
	$previous_posts = get_posts( $args );
	
	// did we get one?
	if ( is_array( $previous_posts ) AND count( $previous_posts ) == 1 ) {
	
		// get it
		$older_post = $previous_posts[0];
	
		// is it published?
		if ( $older_post->post_status == 'publish' ) {
	
			// get link
			$_link = get_permalink( $older_post->ID );
			
			// construct anchor
			$older_link = '<a href="'.$_link.'" title="Older version">&larr; Older version</a>';
		
		}
	
	}
	
	
	
	// did we get either?
	if ( $newer_link != '' OR $older_link != '' ) {
	
		?>
		<div class="version_info">
			<ul>
				<?php if ( $newer_link != '' ) echo '<li class="newer_version">'.$newer_link.'</li>'; ?>
				<?php if ( $older_link != '' ) echo '<li class="older_version">'.$older_link.'</li>'; ?>
			</ul>
		</div>
		<?php
			
	}
	
}
endif; // cp_get_post_version_info






if ( ! function_exists( 'cp_get_post_css_override' ) ):
/**
 * Get links to previous and next versions, should they exist
 */
function cp_get_post_css_override( $post_id ) {
	
	// add a class for overridden page types
	$type_overridden = '';
	
	// declare access to globals
	global $commentpress_obj;
	//print_r(array( 'here' )); die();
	
	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// default to current blog type
		$type = $commentpress_obj->db->option_get( 'cp_blog_type' );
		//print_r($type); die();
		
		// set post meta key
		$key = '_cp_post_type_override';
		
		// but, if the custom field has a value...
		if ( get_post_meta( $post_id, $key, true ) !== '' ) {
		
			// get it
			$overridden_type = get_post_meta( $post_id, $key, true );
			
			// is it different to the current blog type?
			if ( $overridden_type != $type ) {
			
				$type_overridden = ' overridden_type-'.$overridden_type;
			
			}
		
		}
		
	}
	
	// --<
	return $type_overridden;

}
endif; // cp_get_post_css_override





if ( ! function_exists( 'cp_get_post_title_visibility' ) ):
/**
 * Get links to previous and next versions, should they exist
 */
function cp_get_post_title_visibility( $post_id ) {
	
	// init hide (show by default)
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
	if ( get_post_meta( $post_id, $key, true ) != '' ) {
	
		// get it
		$hide = get_post_meta( $post_id, $key, true );
		
	}
	
	// --<
	return ( $hide == 'show' ) ? true : false;

}
endif; // cp_get_post_title_visibility





if ( ! function_exists( 'cp_get_post_meta_visibility' ) ):
/**
 * Get links to previous and next versions, should they exist
 */
function cp_get_post_meta_visibility( $post_id ) {
	
	// init hide (hide by default)
	$hide_meta = 'hide';
	
	// declare access to globals
	global $commentpress_obj;
	
	// if we have the plugin enabled...
	if ( is_object( $commentpress_obj ) ) {
	
		// get global hide_meta
		$hide_meta = $commentpress_obj->db->option_get( 'cp_page_meta_visibility' );;
		
		// set key
		$key = '_cp_page_meta_visibility';
		
		// if the custom field already has a value...
		if ( get_post_meta( $post_id, $key, true ) != '' ) {
		
			// override with local value
			$hide_meta = get_post_meta( $post_id, $key, true );
			
		}
		
	}
	
	// --<
	return ( $hide_meta == 'show' ) ? true : false;

}
endif; // cp_get_post_meta_visibility





