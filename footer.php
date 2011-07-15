<!-- footer.php -->

<div id="footer" class="clearfix">	

<div id="footer_inner">

	<?php
	
	// compat with wplicense plugin
	if ( function_exists( 'isLicensed' ) AND isLicensed() ) {
	
		// show the license (buggy, use wp_footer() instead)
		//licenseHtml( $display = true );
		
	} else {
		
		// show copyright 
		?>
	
		<p>Website content &copy; <a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a> <?php echo date('Y'); ?>. All rights reserved.</p>
		
		<?php 
		
		/*
		// legacy backlink, leave out for now
		if ( 
		
			"http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] == get_option('home')."/" || 
			"http://www.".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] == get_option('home')."/" || 
			$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] == get_option('home')."/" || 
			"www.".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] == get_option('home')."/" 
			
		) { 
		
		?>
		
		<p>This site is powered by <a href="http://www.futureofthebook.org/commentpress/">Commentpress</a></p>
		
		<?php 
		
		}
		*/
		
	}
	
	?>

	<?php wp_footer() ?>

</div><!-- /footer_inner -->

</div><!-- /footer -->



</div><!-- /container -->



</body>



</html>