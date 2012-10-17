<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">

<!-- title -->
<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); cp_site_title( '|' ) ?></title>

<!-- meta -->
<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
<meta name="description" content="<?php bloginfo('description') ?>" />
<meta name="MSSmartTagsPreventParsing" content="true" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<?php if(is_search()) { ?><meta name="robots" content="noindex, nofollow" /><?php } ?>

<!-- pingbacks -->
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!-- styles -->
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style/css/ie6.css" media="screen" />
<![endif]-->
<!--[if gte IE 7]>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style/css/ie7.css" media="screen" />
<![endif]-->
<?php if ( is_multisite() ) { if ( 'wp-signup.php' == basename($_SERVER['SCRIPT_FILENAME']) ) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style/css/signup.css" media="screen" />
<?php }} ?>
<?php if ( is_multisite() ) { if ( 'wp-activate.php' == basename($_SERVER['SCRIPT_FILENAME']) ) { ?>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style/css/activate.css" media="screen" />
<?php }} ?>
<?php 

// add custom css file for user-defined theme mods (legacy)
if( file_exists( get_template_directory().'/custom.css' )) { 

?>
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/custom.css" media="screen" />
<?php 

} ?>

<!-- wp_head -->
<?php wp_head(); ?>

</head>



<?php 

// get body id
$_body_id = cp_get_body_id();

// get body classes
$_body_classes = cp_get_body_classes( true );

// BODY starts here
?><body<?php echo $_body_id; ?> <?php body_class( $_body_classes ); ?>>



<?php 

// until WordPress supports a locate_theme_file() function, use filter
$include = apply_filters( 
	'cp_template_header_body',
	get_template_directory() . '/style/templates/header_body.php'
);

include( $include );

?>



<div id="container">


