<!-- searchform.php -->

<form method="get" id="searchform" action="<?php echo get_bloginfo('wpurl'); ?>/">

<label for="s"><?php _e('Search for:'); ?></label>

<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />

<input type="submit" id="searchsubmit" value="Search" />

</form>


