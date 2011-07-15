/* 
===============================================================
Show/Hide All Comments
===============================================================
AUTHOR			: Christian Wach <needle@haystack.co.uk>
LAST MODIFIED	: 06/10/2010
REQUIRES		: jquery.js
---------------------------------------------------------------
*/

jQuery(document).ready( function($) {

	// hide all comment content
	$('ul.all_comments_listing div.item_body').hide();
	
	// set pointer 
	$("ul.all_comments_listing h3").css( 'cursor', 'pointer' );

	// all comment page headings toggle slide
	$("ul.all_comments_listing h3").click( function() {
	
		// toggle next item_body
		$(this).next('div.item_body').slideToggle( 'slow' );
		
	});
	
});
