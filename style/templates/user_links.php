<?php

global $commentpress_obj;

?><!-- user_links.php -->

<div id="user_links">

<ul>
<?php

// login/logout
?><li><?php wp_loginout(); ?></li>
<?php

// is this multisite?
if ( is_multisite() ) {

	// can users register?
	if ( get_option('users_can_register') ) {
		
		// this works for get_site_option( 'registration' ) == 'none' and 'user'
		?><li><?php wp_register(' ' , ' '); ?></li>
		<?php 

	}

	// multisite signup and blog create
	if ( 
	
		( is_user_logged_in() AND get_site_option( 'registration' ) == 'blog' ) OR
		get_site_option( 'registration' ) == 'all'
		
	) {
	
		?><li><a href="<?php echo get_bloginfo('wpurl'); ?>/wp-signup.php" title="Create a new document" id="btn_create">Create a new document</a></li>
		<?php 
	
	}

} else {

	// if logged in
	if ( is_user_logged_in() ) {
	
		?>
		<li><a href="<?php echo admin_url(); ?>" title="Dashboard" id="btn_dash">Dashboard</a></li>
		<?php
		
	}
	
	/*
	// testing JS
	?>
	<li><a href="#" title="Javascript" id="btn_js">Javascript</a></li>
	<?php
	*/
	
}
	
?></ul>
</div>

<!-- /user_links.php -->



