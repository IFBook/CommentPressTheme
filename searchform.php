<!-- searchform.php -->

<form method="get" id="searchform" action="<?php echo site_url(); ?>/">

<label for="s"><?php _e('Search for:', 'commentpress'); ?></label>

<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />

<input type="submit" id="searchsubmit" value="Search" />

</form>


