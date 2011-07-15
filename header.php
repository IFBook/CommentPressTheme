<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<?php if(is_search()) { ?><meta name="robots" content="noindex, nofollow" /><?php } ?>

<!-- rss -->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> Comments RSS Feed" href="<?php bloginfo('comments_rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!-- styles -->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style/css/ie6.css" media="screen" />
<![endif]-->
<!--[if gte IE 7]>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style/css/ie7.css" media="screen" />
<![endif]-->
<?php if ( is_multisite() ) { if ( 'wp-signup.php' == basename($_SERVER['SCRIPT_FILENAME']) ) { ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style/css/signup.css" media="screen" />
<?php }} ?>
<?php if ( is_multisite() ) { if ( 'wp-activate.php' == basename($_SERVER['SCRIPT_FILENAME']) ) { ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style/css/activate.css" media="screen" />
<?php }} ?>
<?php 

// add custom css file for user-defined theme mods
if( file_exists( TEMPLATEPATH.'/custom.css' )) { 

?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/custom.css" media="screen" />
<?php 

} ?>

<!-- wp_head -->
<?php wp_head(); ?>

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


