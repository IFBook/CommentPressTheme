<?php /*
===============================================================
Commentpress 'Comments by Commenter' Page Header
===============================================================
AUTHOR			: Christian Wach <needle@haystack.co.uk>
LAST MODIFIED	: 12/10/2009
---------------------------------------------------------------
NOTES
=====

cp_get_comments_by_page_content() function can be found in the
theme's functions.php file. However, since this is loaded for
every page that the theme displays, it migth be better to include
in in a separate file for inclusion only when this page is called.

---------------------------------------------------------------
*/



// get page content --> I prefer to do this before the page is sent
// to the browser: the markup is generated before anything is displayed
$_page_content = cp_get_comments_by_page_content();



// Start HTML
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

<!-- title -->
<title><?php 

echo bloginfo('name');

if (is_home()) {
	echo ' &raquo; Book Blog';
} elseif (is_404()) {
	echo ' &raquo; Not Found';
} elseif (is_category()) {
	echo ' &raquo; Category: '; wp_title('');
} elseif (is_search()) {
	echo ' &raquo; Search Results';
} elseif ( is_day() || is_month() || is_year() ) {
	echo ' &raquo; Archives: '; wp_title('');
} else {
	wp_title('&raquo;',true,'left');
}

?></title>

<!-- meta -->
<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
<meta name="description" content="<?php bloginfo('description') ?>" />
<meta name="MSSmartTagsPreventParsing" content="true" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

<!-- rss -->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Comments RSS Feed" href="<?php bloginfo('comments_rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!-- styles -->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style/css/ie6.css" media="screen" />
<![endif]-->
<!--[if gte IE 7]>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style/css/ie7.css" media="screen" />
<![endif]-->
<?php 

// add custom css file for user-defined theme mods
if( file_exists( TEMPLATEPATH.'/custom.css' )) { 

?>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/custom.css" media="screen" />
<?php 

} ?>

<?php wp_head(); ?>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/style/js/cp_js_all_comments.js"></script>

</head>



<?php 

// get body id
$_body_id = cp_get_body_id();

// get body classes
$_body_classes = cp_get_body_classes();

// BODY starts here
?><body<?php echo $_body_id; echo $_body_classes; ?>>



<?php include (TEMPLATEPATH . '/style/templates/header_body.php'); ?>



<div id="container">


