<?php

global $commentpress_obj;

?><!-- user_links.php -->

<div id="user_links">

<ul>
<?php

// login/logout
?><li><?php wp_loginout(); ?></li>
<?php

// is this multisite?
if ( is_multisite() ) {

	// can users register?
	if ( get_option('users_can_register') ) {
		
		// this works for get_site_option( 'registration' ) == 'none' and 'user'
		?><li><?php wp_register(' ' , ' '); ?></li>
		<?php 

	}

	// multisite signup and blog create
	if ( 
	
		( is_user_logged_in() AND get_site_option( 'registration' ) == 'blog' ) OR
		get_site_option( 'registration' ) == 'all'
		
	) {
	
		// test whether we have BuddyPress
		if ( defined( 'BP_VERSION' ) ) {
		
			// different behaviour when logged in or not
			if ( is_user_logged_in() ) {
		
				// set default link name
				$new_site_title = apply_filters( 
					'cp_user_links_new_site_title', 
					__( 'Create a new document', 'commentpress-theme' )
				);
		
				// BP uses its own signup page at /blogs/create/ but doesn't redirect to it
				?><li><a href="<?php echo site_url(); ?>/blogs/create/" title="<?php echo $new_site_title; ?>" id="btn_create"><?php echo $new_site_title; ?></a></li>
				<?php 
			
			} else {
			
				// not directly allowed - done through signup form
			
			}

		} else {
			
			// set default link name
			$new_site_title = apply_filters( 
				'cp_user_links_new_site_title', 
				__( 'Create a new document', 'commentpress-theme' )
			);
	
			// standard WP multisite
			?><li><a href="<?php echo site_url(); ?>/wp-signup.php" title="<?php echo $new_site_title; ?>" id="btn_create"><?php echo $new_site_title; ?></a></li>
			<?php 
		
		}
	
	}

} else {

	// if logged in
	if ( is_user_logged_in() ) {
	
		// set default link name
		$dashboard_title = apply_filters( 
			'cp_user_links_dashboard_title', 
			__( 'Dashboard', 'commentpress-theme' )
		);

		?>
		<li><a href="<?php echo admin_url(); ?>" title="<?php echo $dashboard_title; ?>" id="btn_dash"><?php echo $dashboard_title; ?></a></li>
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



