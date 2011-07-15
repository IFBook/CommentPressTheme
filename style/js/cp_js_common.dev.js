/* 
===============================================================
Common Javascript
===============================================================
AUTHOR			: Christian Wach <needle@haystack.co.uk>
LAST MODIFIED	: 06/10/2010
REQUIRES		: jquery.js
---------------------------------------------------------------
*/



// test for our localisation object
if ( 'undefined' !== typeof CommentpressSettings ) {

	// set our vars
	var cp_wp_adminbar = CommentpressSettings.cp_wp_adminbar;
	var cp_comments_open = CommentpressSettings.cp_comments_open;
	var cp_special_page = CommentpressSettings.cp_special_page;
	var cp_para_comments_enabled = CommentpressSettings.cp_para_comments_enabled;
	var cp_tinymce = CommentpressSettings.cp_tinymce;
	var cp_promote_reading = CommentpressSettings.cp_promote_reading;
	var cp_is_mobile = CommentpressSettings.cp_is_mobile;
	var cp_cookie_path = CommentpressSettings.cp_cookie_path;
	var cp_multipage_page = CommentpressSettings.cp_multipage_page;
	var cp_template_dir = CommentpressSettings.cp_template_dir;
	var cp_plugin_dir = CommentpressSettings.cp_plugin_dir;
	var cp_toc_chapter_is_page = CommentpressSettings.cp_toc_chapter_is_page;
	var cp_show_subpages = CommentpressSettings.cp_show_subpages;
	var cp_default_sidebar = CommentpressSettings.cp_default_sidebar;
	var cp_is_signup_page = CommentpressSettings.cp_is_signup_page;
	var cp_scroll_speed = CommentpressSettings.cp_js_scroll_speed;
	var cp_min_page_width = CommentpressSettings.cp_min_page_width;

}



// browser detection
var msie = jQuery.browser.msie;
var msie6 = jQuery.browser.msie && jQuery.browser.version == "6.0";

// define utility globals
var cp_wp_adminbar_height = 28;
var cp_book_header_height;
var cp_header_animating = false;

// set toc on top flag
var cp_toc_on_top = 'n';

// page defaults to 'not-highlighted'
var page_highlight = false;

// get state of header
var cp_header_minimised = jQuery.cookie( 'cp_header_minimised' );

// get state of sidebar
var cp_sidebar_minimised = jQuery.cookie( 'cp_sidebar_minimised' );

// get container original top
var cp_container_top_max = jQuery.cookie( 'cp_container_top_max' );

// get header offset
var cp_container_top_min = jQuery.cookie( 'cp_container_top_min' );

// is the admin bar shown?
if ( cp_wp_adminbar == 'y' ) {
	
	// bump them up by the height of the admin bar
	cp_container_top_max = parseInt( cp_container_top_max ) + cp_wp_adminbar_height;
	cp_container_top_min = parseInt( cp_container_top_min ) + cp_wp_adminbar_height;

}



/** 
 * @description: define what happens before the page is ready - avoid flash of content
 * @todo: 
 *
 */
function cp_page_setup() {

	// init styles
	var styles = '';



	// wrap with js test
	if ( document.getElementById ) {
	
		// open style declaration
		styles += '<style type="text/css" media="screen">';

	
	
		// avoid flash of all-comments hidden elements
		styles += 'ul.all_comments_listing div.item_body { display: none; } ';
	


		// is the admin bar shown?
		if ( cp_wp_adminbar == 'y' ) {
		
			// move down
			styles += '#header { top: 28px; } ';
			styles += '#book_header { top: 60px; } ';
		
		}
		


		// are subpages to be shown?
		if ( cp_show_subpages == '0' ) {
		
			// avoid flash of hidden elements
			styles += '#toc_sidebar .sidebar_contents_wrapper ul li ul { display: none; } ';
		
		}
		


		// has the header been minimised?
		if ( 
			cp_header_minimised === undefined || 
			cp_header_minimised === null || 
			cp_header_minimised == 'n' 
		) {
		
			// no -> skip
		
			// set tops of divs
			
			// adjust for admin bar
			var cp_container_top = cp_container_top_max;
			
			// is the admin bar shown?
			if ( cp_wp_adminbar == 'y' ) {
				var cp_container_top = cp_container_top_max - cp_wp_adminbar_height;
			}
				
			styles += '#container { top: ' + cp_container_top + 'px; } ';
			styles += '#sidebar { top: ' + cp_container_top_max + 'px; } ';

		} else {
		
			// set visibility of comments
			styles += '#book_header { display: none; } ';

			// adjust for admin bar
			var cp_container_top = cp_container_top_min;
			
			// is the admin bar shown?
			if ( cp_wp_adminbar == 'y' ) {
				var cp_container_top = cp_container_top_min - cp_wp_adminbar_height;
			}
				
			// set tops of divs
			styles += '#container { top: ' + cp_container_top + 'px; } ';
			styles += '#sidebar { top: ' + cp_container_top_min + 'px; } ';

		}
	


		// is this the comments sidebar?
		if ( cp_special_page == '0' ) {
		
			// are comments on paragraphs allowed?
			if ( cp_para_comments_enabled == '1' ) {
			
				// avoid flash of hidden comments
				styles += '.paragraph_wrapper { display: none; } ';
				
			}
	
			// avoid flash of hidden comment form
			styles += '#respond { display: none; } ';
		
			// has the sidebar window been minimised?
			if ( cp_sidebar_minimised == 'y' ) {
			
				// set visibility of comments
				styles += '#comments_sidebar .sidebar_minimiser { display: none; } ';
	
			}
		
		}
		

		
		/*
		// TO DO: make into single cookie
		// has the page been changed?
		if ( jQuery.cookie('cp_page_setup') ) {
		
			// get value
			var cp_page_setup = jQuery.cookie('cp_page_setup');
	
		}
		
		*/
		
		
		
		// has the content column changed?
		if ( jQuery.cookie('cp_container_width') ) {

			// get value
			var cp_container_width = jQuery.cookie('cp_container_width');
	
			// set content width
			if ( cp_is_signup_page == '1' ) {
				styles += '#content { width: ' + cp_container_width + '%; } ';
			} else {
				styles += '#page_wrapper { width: ' + cp_container_width + '%; } ';
			}

			// set footer width
			styles += '#footer { width: ' + cp_container_width + '%; } ';

		}
		
		// has the book nav cookie changed?
		if ( jQuery.cookie('cp_book_nav_width') ) {

			// get book nav width
			var cp_book_nav_width = jQuery.cookie('cp_book_nav_width');

			// set its width
			styles += '#book_nav div#cp_book_nav { width: ' + cp_book_nav_width + '%; } ';

		}
		


		// has the sidebar window changed?
		if ( jQuery.cookie('cp_sidebar_width') ) {
		
			// set width of sidebar
			styles += '#sidebar { width: ' + jQuery.cookie('cp_sidebar_width') + '%; } ';

		}
	
		// has the sidebar window changed?
		if ( jQuery.cookie('cp_sidebar_left') ) {
		
			// set width of sidebar
			styles += '#sidebar { left: ' + jQuery.cookie('cp_sidebar_left') + '%; } ';

		}
	


		// close style declaration
		styles += '</style>';

	}
	
	
	
	// write to page now
	document.write( styles );
	
}

// call page setup function
cp_page_setup();






/** 
 * @description: page load prodecure
 * @todo: 
 *
 */
function cp_setup_page_layout() {
	
	// is this the signup page?
	if ( cp_is_signup_page == '1' ) {
	
		// target
		var target = jQuery('#content');
	
	} else {
	
		// target
		var target = jQuery('#page_wrapper');
	
	}
	
	
	
	/** 
	 * @description: sets up the main column, if the id exists
	 * @todo: 
	 *
	 */
	target.each( function(i) {
	
		// assign vars
		var me = jQuery(this);
		var content = jQuery('#content');
		var sidebar = jQuery('#sidebar');
		var footer = jQuery('#footer');
		var book_header = jQuery('#book_header');
		var book_nav_wrapper = jQuery('#book_nav_wrapper');
		var book_nav = jQuery('#cp_book_nav');
		var book_info = jQuery('#cp_book_info');
				
		// store original widths
		var original_content_width = me.width();
		var original_sidebar_width = sidebar.width();
		
		// calculate gap to sidebar
		var gap = sidebar.offset().left - original_content_width;
		
		// if Opera...
		if ( jQuery.browser.opera ) {
		
			// set the position of #content to avoid alsoResize bug
			content.css( 'position', 'static' );
		
		}

		// make page wrapper resizable
		me.resizable({ 
		
			handles: 'e',
			minWidth: cp_min_page_width,
			alsoResize: '#footer',
			//grid: 1, // no sub-pixel weirdness please
			


			// on stop... (note: this doesn't fire on the first go in Opera!)
			start: function( event, ui ) {			
				
				// store original widths
				original_content_width = me.width();
				original_sidebar_width = sidebar.width();
				original_nav_width = book_nav.width();
				//alert(original_sidebar_width);
				
				// calculate sidebar left
				original_sidebar_left = sidebar.css( "left" );
				gap = sidebar.offset().left - original_content_width;
				
			},
				


			// while resizing...
			resize: function( event, ui ) {
			
				me.css( 'height', 'auto' );
				footer.css( 'height', 'auto' );
			
				// have the sidebar follow
				sidebar.css( 'left', ( me.width() + gap ) + 'px' );
				
				// diff
				var my_diff = original_content_width - me.width();

				// have the sidebar right remain static
				sidebar.css( 'width', ( original_sidebar_width + my_diff ) + 'px' );

				// have the book nav follow
				book_nav.css( 'width', ( original_nav_width - my_diff ) + 'px' ); // diff in css

			},
			


			// on stop... (note: this doesn't fire on the first go in Opera!)
			stop: function( event, ui ) {
				
				// viewport width
				var ww = parseFloat(jQuery(window).width() );
				
				
				
				// get element width
				var width = me.width();
				
				// compensate for webkit
				if ( jQuery.browser.webkit ) { width = width + 1; }
				
				// get percent to four decimal places
				var me_w = parseFloat( Math.ceil( ( 1000000 * parseFloat( width ) / ww ) ) / 10000 );
				//alert(w);
				
				// set element width
				me.css("width" , me_w + '%');

				// set content width to auto so it resizes properly
				if ( cp_is_signup_page == '0' ) {
					content.css("width" ,'auto');
				}



				// get element width
				var width = book_nav.width();
				
				// compensate for webkit
				if ( jQuery.browser.webkit ) { width = width + 1; }
				
				// get percent to four decimal places
				var book_nav_w = parseFloat( Math.ceil( ( 1000000 * parseFloat( width ) / ww ) ) / 10000 );
				//alert(w);
				
				// set element width
				book_nav.css("width" , book_nav_w + '%');

				

				
				// get element width
				var width = sidebar.width();
				
				// compensate for webkit
				if ( jQuery.browser.webkit ) { width = width + 1; }
				
				// get percent to four decimal places
				var sidebar_w = parseFloat( Math.ceil( ( 1000000 * parseFloat( width ) / ww ) ) / 10000 );
				//alert(w);
				
				// set element width
				sidebar.css("width" , sidebar_w + '%');

				

				// get element left
				var left = sidebar.position().left;
				
				// compensate for webkit
				if ( jQuery.browser.webkit ) { left = left + 1; }
				
				// get percent to four decimal places
				var sidebar_l = parseFloat( Math.ceil( ( 1000000 * parseFloat( left ) / ww ) ) / 10000 );

				// set element left
				sidebar.css("left" , sidebar_l + '%');
				



				// store this width in cookie
				jQuery.cookie( 
				
					'cp_container_width', 
					me_w.toString(), 
					{ expires: 28, path: cp_cookie_path } 
					
				);
				
				// store nav width in cookie
				jQuery.cookie( 
				
					'cp_book_nav_width', 
					book_nav_w.toString(), 
					{ expires: 28, path: cp_cookie_path } 
					
				);
				
				// store location of sidebar in cookie
				jQuery.cookie( 
				
					'cp_sidebar_left', 
					sidebar_l.toString(), 
					{ expires: 28, path: cp_cookie_path } 
					
				);

				// store width of sidebar in cookie
				jQuery.cookie( 
				
					'cp_sidebar_width', 
					sidebar_w.toString(), 
					{ expires: 28, path: cp_cookie_path } 
					
				);


				
			}
			
		});

	});

}






/** 
 * @description: get header offset
 * @todo: decide whether to use border in offset
 *
 */
function cp_get_header_offset() {
	
	/*
	// get offset including border
	var offset = 0 - ( 
		jQuery.px_to_num( jQuery('#container').css('top') ) + 
		jQuery.px_to_num( jQuery('#page_wrapper').css( 'borderTopWidth' ) ) 
	);
	*/
	
	// get header offset
	var offset = 0 - ( jQuery.px_to_num( jQuery('#container').css('top') ) );
	
	//alert( offset );
	
	// --<
	return offset;

}






/** 
 * @description: scroll page to target
 * @todo: 
 *
 */
function cp_scroll_page( target ) {

	// if IE6, then we have to scroll #wrapper
	if ( msie6 ) {
		
		// 
		jQuery(window).scrollTo( 0, 0 );

		// scroll container to title
		jQuery('#main_wrapper').scrollTo(
			target, 
			{
				duration: (cp_scroll_speed * 1.5), 
				axis:'y', 
				offset: cp_get_header_offset()
			}, function () {
				// when done, make sure page is ok
				jQuery(window).scrollTo( 0, 1 );
			}
		);

	} else {
	
		// only scroll if not mobile
		if ( cp_is_mobile == '0' ) {
	
			// scroll page
			jQuery.scrollTo(
				target, 
				{
					duration: (cp_scroll_speed * 1.5), 
					axis:'y', 
					offset: cp_get_header_offset()
				}
			);
			
		}
		
	}
	
}




/** 
 * @description: scroll page to top
 * @todo: 
 *
 */
function cp_scroll_to_top( target, speed ) {

	// if IE6, then we have to scroll #wrapper
	if ( msie6 ) {
	
		// scroll wrapper to title
		jQuery('#main_wrapper').scrollTo( target, {duration: speed} );

	} else {
	
		// only scroll if not mobile
		if ( cp_is_mobile == '0' ) {
		
			// scroll
			jQuery.scrollTo( target, speed );
			
		}
		
	}
	
}




/** 
 * @description: scroll comments to target
 * @todo: 
 *
 */
function cp_scroll_comments( target, speed ) {

	// only scroll if not mobile
	if ( cp_is_mobile == '0' ) {
	
		// scroll comment area to para heading
		jQuery('#comments_sidebar .sidebar_minimiser').scrollTo( target, {duration: speed} );
		
	}
	
}




/** 
 * @description: set up comment headers
 * @todo: 
 *
 */
function cp_setup_comment_headers() {

	// only on normal cp pages
	if ( cp_special_page == '1' ) { return; }

	// unbind first to allow repeated calls to this function
	jQuery('a.comment_block_permalink').unbind( 'click' );

	// set pointer 
	jQuery('a.comment_block_permalink').css( 'cursor', 'pointer' );

	/** 
	 * @description: comment page headings click
	 * @todo: 
	 *
	 */
	jQuery('a.comment_block_permalink').click( function() {
	
		// get text_sig
		var text_sig = jQuery(this).parent().attr( 'id' ).split('para_heading-')[1];
		
		// get para wrapper
		var para_wrapper = jQuery(this).parent().next('div.paragraph_wrapper');
		
		// get comment list
		var comment_list = jQuery( '#para_wrapper-' + text_sig ).find('ol.commentlist' );
		


		// init
		var opening = false;
		
		// get visibility
		var visible = para_wrapper.css('display');
		
		// override
		if ( visible == 'none' ) { opening = true; }
		


		// did we get one at all?
		if( typeof( text_sig ) != 'undefined' ) {
		
			// if not the whole page...
			if( text_sig != '' ) {
	
				// get text block
				var textblock = jQuery('#textblock-' + text_sig);
									
				// only if opening
				if ( opening ) {
				
					// unhighlight paragraphs
					jQuery.unhighlight_para();
					
					// highlight this paragraph
					jQuery.highlight_para( textblock );
					
					// scroll page
					cp_scroll_page( textblock );
					
				} else {
				
					// if encouraging commenting
					if ( cp_promote_reading == '0' ) {
					
						// closing with a comment form
						if ( jQuery( '#para_wrapper-' + text_sig ).find('#respond' )[0] ) {
						
							// unhighlight paragraphs
							jQuery.unhighlight_para();
							
						} else {
						
							// if we have no comments, always highlight
							if ( !comment_list[0] ) {
							
								// unhighlight paragraphs
								jQuery.unhighlight_para();
								
								// highlight this paragraph
								jQuery.highlight_para( textblock );
								
								// scroll page
								cp_scroll_page( textblock );
								
							}
							
						}
						
					} else {
						
						// if ours is highlighted
						if ( jQuery.is_highlighted( textblock ) ) {
						
							// unhighlight paragraphs
							jQuery.unhighlight_para();

						}
					
					}
					
				}
					
			} else {
			
				// only scroll if page is not highlighted
				if ( page_highlight === false ) {
			
					// scroll to top
					cp_scroll_to_top( 0, cp_scroll_speed );
					
				}
				
				// toggle page highlight flag
				page_highlight = !page_highlight;
				
			}
			
		} // end defined check
				

		
		// if encouraging commenting...
		if ( cp_promote_reading == '0' ) {
		
			// are comments open?
			if ( cp_comments_open == 'y' ) {
		
				// get comment post ID
				var post_id = jQuery('#comment_post_ID').attr('value');
				var para_id = jQuery('#para_wrapper-' + text_sig + ' .reply_to_para').attr('id');
				var para_num = para_id.split('-')[1];
				
				// do we have the comment form?
				var has_form = jQuery( '#para_wrapper-' + text_sig ).find('#respond' )[0];
			
				// if we have a comment list
				if ( comment_list[0] ) {
				
					//alert( 'has' );
					
					// are we closing with no reply form?
					if ( !opening && !has_form ) {
					
						// skip moving form
					
					} else {
					
						// move form to para
						addComment.moveFormToPara( para_num, text_sig, post_id );
						
					}
				
				} else {
				
					// if we have no respond
					if ( !has_form ) {
					
						//alert( 'none' );
						para_wrapper.css('display','none');
						opening = true;
					
					}
	
					// move form to para
					addComment.moveFormToPara( para_num, text_sig, post_id );
					
				}
				
			}
		
		}
		

		
		// are comments on paragraphs allowed?
		if ( cp_para_comments_enabled == '1' ) {
			
			// toggle next paragraph_wrapper
			para_wrapper.slideToggle( 'slow', function() {
			
				// only scroll if opening
				if ( opening ) {
			
					// scroll comments
					cp_scroll_comments( jQuery('#para_heading-' + text_sig), cp_scroll_speed );
					
				}
				
			});
			
		}
		
		// --<
		return false;

	});

}






/** 
 * @description: clicking on the comment permalink
 * @todo: 
 *
 */
function cp_enable_comment_permalink_clicks() {

	// unbind first to allow repeated calls to this function
	jQuery('a.comment_permalink').unbind( 'click' );

	jQuery('a.comment_permalink').click( function(e) {
	
		// get comment id
		var comment_id = this.href.split('#')[1];
		
		// if special page
		if ( cp_special_page == '1' ) {
		
			// get offset
			var header_offset = cp_get_header_offset();
	
			// scroll to comment
			jQuery.scrollTo(
				jQuery('#'+comment_id), 
				{
					duration: cp_scroll_speed, 
					axis:'y', 
					offset: header_offset
				}
			);
		
		} else {
	
			// scroll comments
			cp_scroll_comments( jQuery('#'+comment_id), cp_scroll_speed );
			
		}
		
		// --<
		return false;
		
	});

}






/** 
 * @description: page load prodecure
 * @todo: 
 *
 */
function cp_scroll_to_anchor_on_load() {

	// if there is an anchor in the URL (only on non-special pages)
	var url = document.location.toString();
	
	// do we have a comment permalink?
	if ( url.match('#comment-' ) ) {
	
		// open the matching block

		// get comment ID
		var comment_id = url.split('#comment-')[1];
		
		// get array of parent paragraph_wrapper divs
		var para_wrapper_array = jQuery('#comment-' + comment_id)
									.parents('div.paragraph_wrapper')
									.map( function () {
										return this;
									});

		// did we get one?
		if ( para_wrapper_array.length > 0 ) {
		
			// get the item
			var item = jQuery(para_wrapper_array[0]);
			
			// are comments open?
			if ( cp_comments_open == 'y' ) {

				// move form to para
				var text_sig = item.attr('id').split('-')[1];
				var para_id = jQuery('#para_wrapper-'+text_sig+' .reply_to_para').attr('id');
				var para_num = para_id.split('-')[1];
				var post_id = jQuery('#comment_post_ID').attr('value');
				
				addComment.moveFormToPara( para_num, text_sig, post_id );

			}
			
			// show block
			item.show();
			
			// scroll comments
			cp_scroll_comments( jQuery('#comment-' + comment_id), 0 );
			
			// if not the whole page...
			if( text_sig != '' ) {
	
				// get text block
				var textblock = jQuery('#textblock-' + text_sig);
				
				// highlight this paragraph
				jQuery.highlight_para( textblock );
				
				// scroll page
				cp_scroll_page( textblock );
				
			} else {
				
				// only scroll if page is not highlighted
				if ( page_highlight === false ) {
				
					// scroll to top
					cp_scroll_to_top( 0, cp_scroll_speed );
					
				}
				
				// toggle page highlight flag
				page_highlight = !page_highlight;
				
			}
			
			// if IE6, then we have to scroll the page to the top
			//if ( msie6 ) { jQuery(window).scrollTo( 0, 1 ); }

		}
		
	} else {
		
		/** 
		 * @description: loop through the paragraph permalinks checking for a match
		 * @todo: 
		 *
		 */
		jQuery('a.para_permalink').each( function(i) {
		
			// get text signature
			var text_sig = jQuery(this).attr('id');
			
			// do we have a paragraph or comment block permalink?
			if ( url.match('#' + text_sig ) || url.match('#para_heading-' + text_sig ) ) {
			
				//alert('yep');
			
				// are comments open?
				if ( cp_comments_open == 'y' ) {

					// move form to para
					var para_id = jQuery('#para_wrapper-' + text_sig + ' .reply_to_para').attr('id');
					var para_num = para_id.split('-')[1];
					var post_id = jQuery('#comment_post_ID').attr('value');
					addComment.moveFormToPara( para_num, text_sig, post_id );

				}
				
				// toggle next item_body
				jQuery('#para_heading-' + text_sig).next('div.paragraph_wrapper').show();
				
				// scroll comments
				cp_scroll_comments( jQuery('#para_heading-' + text_sig), 1 );
				
				// get text block
				var textblock = jQuery('#textblock-' + text_sig);
				
				// highlight this paragraph
				jQuery.highlight_para( textblock );
				
				// if IE6, then we have to scroll the page to the top
				//if ( msie6 ) { jQuery(window).scrollTo( 0, 0 ); }
	
				// scroll page
				cp_scroll_page( textblock );
				
			}
			
		});
		
	}

}






/** 
 * @description: page load prodecure
 * @todo: 
 *
 */
function cp_scroll_to_comment_on_load() {

	// if there is an anchor in the URL...
	var url = document.location.toString();
	
	// do we have a comment permalink?
	if ( url.match('#comment-' ) ) {
	
		// get comment ID
		var comment_id = url.split('#comment-')[1];

		// if IE6, then we have to scroll #wrapper
		if ( msie6 ) {
		
			// scroll to new comment
			jQuery('#main_wrapper').scrollTo(
				jQuery('#comment-'+comment_id), 
				{
					duration: cp_scroll_speed, 
					axis:'y', 
					offset: cp_get_header_offset()
				}
			);
			
		} else {
		
			// only scroll if not mobile
			if ( cp_is_mobile == '0' ) {
			
				// scroll to new comment
				jQuery.scrollTo(
					jQuery('#comment-'+comment_id), 
					{
						duration: cp_scroll_speed, 
						axis:'y', 
						offset: cp_get_header_offset()
					}
				);
				
			}
			
		}

	}



}






/** 
 * @description: set up clicks on comment icons
 * @todo: 
 *
 */
function cp_setup_comment_icons() {

	// unbind first to allow repeated calls to this function
	jQuery('a.para_permalink').unbind( 'click' );

	/** 
	 * @description: clicking on the little comment icon
	 * @todo: 
	 *
	 */
	jQuery('a.para_permalink').click( function(e) {
	
		// get text signature
		var text_sig = jQuery(this).attr('id');
		
		// get para wrapper
		var para_wrapper = jQuery('#para_heading-' + text_sig).next('div.paragraph_wrapper');
		
		// get comment list
		var comment_list = jQuery( '#para_wrapper-' + text_sig + ' .commentlist' );
		
		// get respond
		var respond = para_wrapper.find('#respond');
		
		// is it a direct child of para wrapper?
		var top_level = addComment.getLevel();



		// init
		var opening = false;
		
		// get visibility
		var visible = para_wrapper.css('display');
		
		// override
		if ( visible == 'none' ) { opening = true; }
		


		// clear other highlights
		jQuery.unhighlight_para();
		
		// did we get a text_sig?
		if ( text_sig != '' ) {
		
			// get text block
			var textblock = jQuery('#textblock-' + text_sig);
			//alert(text_sig);
			
			// if encouraging reading and closing
			if ( cp_promote_reading == '1' && !opening ) {
			
				// skip the highlight
			
			} else {
			
				// highlight this paragraph
				jQuery.highlight_para( textblock );
				
				// scroll page
				cp_scroll_page( textblock );
				
			}
			
		}
		


		// if encouraging commenting
		if ( cp_promote_reading == '0' ) {
		
			// are comments open?
			if ( cp_comments_open == 'y' ) {

				// get comment post ID
				var post_id = jQuery('#comment_post_ID').attr('value');
				var para_id = jQuery('#para_wrapper-'+text_sig+' .reply_to_para').attr('id');
				var para_num = para_id.split('-')[1];
				
			}
			
			
			
			// Choices, choices...
			
			
			
			// if it doesn't have the commentform
			if ( !respond[0] ) {
			
				// are comments open?
				if ( cp_comments_open == 'y' ) {
					addComment.moveFormToPara( para_num, text_sig, post_id );
				}
				
			}
				
			// if it has the commentform but is not top level
			if ( respond[0] && !top_level ) {
			
				// are comments open?
				if ( cp_comments_open == 'y' ) {

					// move comment form
					addComment.moveFormToPara( para_num, text_sig, post_id );
				
					// scroll comments to comment form
					cp_scroll_comments( jQuery('#respond'), cp_scroll_speed );
				
				} else {
				
					// scroll comments to comment form
					cp_scroll_comments( jQuery('#para_heading-' + text_sig), cp_scroll_speed );
				
				}

				return;
				
			}
				
			// if it doesn't have the commentform but has a comment
			if ( !respond[0] && comment_list[0] && !opening ) {
			
				// are comments open?
				if ( cp_comments_open == 'y' ) {

					// scroll comments to comment form
					cp_scroll_comments( jQuery('#respond'), cp_scroll_speed );
				
				} else {
				
					// scroll comments to comment form
					cp_scroll_comments( jQuery('#para_heading-' + text_sig), cp_scroll_speed );
				
				}

				return;
				
			}

			// if closing with comment list
			if ( !opening && comment_list[0] ) {
			
				// are comments open?
				if ( cp_comments_open == 'y' ) {

					// scroll comments to comment form
					cp_scroll_comments( jQuery('#respond'), cp_scroll_speed );
				
				} else {
				
					// scroll comments to comment form
					cp_scroll_comments( jQuery('#para_heading-' + text_sig), cp_scroll_speed );
				
				}

				return;
			
			}
			
			// if commentform but no comments and closing
			if ( respond[0] && !comment_list[0] && !opening ) {
			
				// are comments open?
				if ( cp_comments_open == 'y' ) {

					// scroll comments to comment form
					cp_scroll_comments( jQuery('#respond'), cp_scroll_speed );
				
				} else {
				
					// scroll comments to comment form
					cp_scroll_comments( jQuery('#para_heading-' + text_sig), cp_scroll_speed );
				
				}

				// --<
				return;
				
			}
			
			// if closing with no comment list
			if ( !opening && !comment_list[0] ) {
			
				//alert( 'none + closing' );
				para_wrapper.css( 'display', 'none' );
				opening = true;

			}
		
		}
		


		// toggle next item_body
		para_wrapper.slideToggle( 'slow', function () {
		
			// animation finished
		
			// are we encouraging reading?
			if ( cp_promote_reading == '1' && opening ) {
			
				// scroll comments
				cp_scroll_comments( jQuery('#para_heading-' + text_sig), cp_scroll_speed );
				
			} else {
			
				// only if opening
				if ( opening ) {
				
					// are comments open?
					if ( cp_comments_open == 'y' ) {
	
						// scroll comments to comment form
						cp_scroll_comments( jQuery('#respond'), cp_scroll_speed );
					
					} else {
					
						// scroll comments to comment form
						cp_scroll_comments( jQuery('#para_heading-' + text_sig), cp_scroll_speed );
					
					}
	
				}
				
			}
			
			
		});
		


		// --<
		return false;
		
	});

}





	
/** 
 * @description: open header
 * @todo: 
 *
 */
function cp_open_header() {

	// ------------------------------------
	//alert( 'open' );
	// ------------------------------------



	// get nav height
	var book_nav_h = jQuery('#book_nav').height();
	
	var target_sidebar = jQuery('#sidebar');
	var target_sidebar_pane = jQuery.get_sidebar_pane();
	var book_header = jQuery('#book_header');
	var container = jQuery('#container');
	
	
	
	// set max height
	var cp_container_top = cp_container_top_max;

	// is the admin bar shown?
	if ( cp_wp_adminbar == 'y' ) {
	
		// deduct height of admin bar
		var cp_container_top = cp_container_top_max - cp_wp_adminbar_height;
	}
	
	// animate container
	container.animate({
	
		top: cp_container_top + 'px',
		duration: 'fast'

	}, function () {
	
		//book_header.show();

		// slide book header
		book_header.fadeIn('fast', function() {
			
			// when done
			cp_header_animating = false;
	
		});
	
	});




	// is the sidebar minimised?
	if ( cp_sidebar_minimised == 'n' ) {
	


		// get sidebar height
		var cp_sidebar_height = target_sidebar.height() - cp_book_header_height;
		
		// animate main wrapper
		target_sidebar.animate({
		
			top: cp_container_top_max + 'px',
			height: cp_sidebar_height + 'px',
			duration: 'fast'
		
		}, function() {
		
			// when done
			target_sidebar.css('height','auto');
	
		});
		
		// animate inner
		target_sidebar_pane.animate({
		
			height: ( target_sidebar_pane.height() - cp_book_header_height ) + 'px',
			duration: 'fast'
		
			}, function() {
			
				// fit column
				jQuery.set_sidebar_height();
				
				// when done
				cp_header_animating = false;
		
			}
			
		);
		
	} else {
	


		// animate sidebar
		target_sidebar.animate({
		
			top: cp_container_top_max + 'px',
			duration: 'fast'
		
			}, function() {
			
				// when done
				cp_header_animating = false;

				// fit column
				jQuery.set_sidebar_height();
				
			}
			
		);
		
	}

}





	
/** 
 * @description: close header
 * @todo: 
 *
 */
function cp_close_header() {

	// ------------------------------------
	//alert( 'close' );
	// ------------------------------------



	// get nav height
	var book_nav_h = jQuery('#book_nav').height();
	
	var target_sidebar = jQuery('#sidebar');
	var target_sidebar_pane = jQuery.get_sidebar_pane();
	var book_header = jQuery('#book_header');
	var container = jQuery('#container');
	
	
	
	// slide header
	book_header.hide();
	


	// set min height
	var cp_container_top = cp_container_top_min;

	// is the admin bar shown?
	if ( cp_wp_adminbar == 'y' ) {
	
		// deduct height of admin bar
		var cp_container_top = cp_container_top_min - cp_wp_adminbar_height;
	}
	
	container.animate({
	
		top: cp_container_top + 'px',
		duration: 'fast'
	
	});
	


	// is the sidebar minimised?
	if ( cp_sidebar_minimised == 'n' ) {
	
		// get sidebar height
		var cp_sidebar_height = target_sidebar.height() + cp_book_header_height;
		
		//jQuery('#container').css('top','40px');
		target_sidebar.animate({
		
			top: cp_container_top_min + 'px',
			height: cp_sidebar_height + 'px',
			duration: 'fast'
		
			}, function() {
			
				// when done
				target_sidebar.css('height','auto');
		
			}
			
		);
			
		//jQuery('#container').css('top','40px');
		target_sidebar_pane.animate({
		
			height: ( target_sidebar_pane.height() + cp_book_header_height ) + 'px',
			duration: 'fast'
		
		}, function() {
		
			// fit column
			jQuery.set_sidebar_height();
			
			// when done
			cp_header_animating = false;
	
		});
		
	} else {
	
		// animate just sidebar
		target_sidebar.animate({
		
			top: cp_container_top_min + 'px',
			duration: 'fast'
	
		}, function() {
		
			// when done
			cp_header_animating = false;
	
			// fit column
			jQuery.set_sidebar_height();
			
		});
		
	}
	
}





	
/** 
 * @description: set up header minimiser button
 * @todo: 
 *
 */
function cp_setup_header_minimiser() {

	// if animating, kick out
	if ( cp_header_animating === true ) { return false; }
	cp_header_animating = true;
	
	
	// toggle
	if ( 
		cp_header_minimised === undefined || 
		cp_header_minimised === null || 
		cp_header_minimised == 'n' 
	) {
	
		cp_close_header();
	
	} else {
	
		cp_open_header();
	
	}



	// toggle
	cp_header_minimised = ( cp_header_minimised == 'y' ) ? 'n' : 'y';
	
	// store flag in cookie
	jQuery.cookie( 
	
		'cp_header_minimised', 
		cp_header_minimised, 
		{ expires: 28, path: cp_cookie_path } 
		
	);
	
}





	
/** 
 * @description: set up paragraph links: cp_para_link is a class writers can use
 * in their markup to create nicely scrolling links within their pages
 * @todo: 
 *
 */
function cp_setup_para_links() {

	// unbind first to allow repeated calls to this function
	jQuery('a.cp_para_link').unbind( 'click' );

	/** 
	 * @description: clicking on links to paragraphs
	 * @todo: 
	 *
	 */
	jQuery('a.cp_para_link').click( function(e) {
	
		// get text signature
		var text_sig = jQuery(this).attr('href').split('#')[1];
		
		// get text block
		var textblock = jQuery('#textblock-' + text_sig);
		//alert(text_sig);
		
		// scroll page
		cp_scroll_page( textblock );
		
		// --<
		return false;
		
	});

}





	
/** 
 * @description: define what happens when the page is ready
 * @todo: 
 *
 */
jQuery(document).ready( function($) {


	
	// get global book_header top
	cp_book_header_height = $('#book_header').height();
	
	// set sidebar height
	$.set_sidebar_height();



	// if we have a cookie
	if ( jQuery.cookie( 'cp_container_top_min' ) ) {
	
		// skip -> we only set these values once (or when the cookie expires)
	
	} else {

		// set global container top max
		cp_container_top_max = $.px_to_num( $('#container').css('top') );
		
		// set global container top min
		cp_container_top_min = cp_container_top_max - cp_book_header_height;
		
		// set cookie for further loads
		$.cookie( 
		
			'cp_container_top_min', 
			cp_container_top_min.toString(), 
			{ expires: 28, path: cp_cookie_path } 
			
		);
	
		// set cookie for further loads
		$.cookie( 
		
			'cp_container_top_max', 
			cp_container_top_max.toString(), 
			{ expires: 28, path: cp_cookie_path } 
			
		);
	
	}







	// set up page layout
	cp_setup_page_layout();
	
	// set up comment headers
	cp_setup_comment_headers();
	
	// enable animations on clicking comment permalinks
	cp_enable_comment_permalink_clicks();
	
	// set up comment icons (paragraph permalinks)
	cp_setup_comment_icons();
	
	// set up user-defined links to paragraphs
	cp_setup_para_links();






	/** 
	 * @description: clicking on the TOC button
	 * @todo: 
	 *
	 */
	$('#btn_contents').click( function() {
	
		// kick out if toc
		if ( cp_default_sidebar == 'toc' ) { return false; }
	
	
	
		// get visibilty of TOC
		var toc_visible = $('#toc_sidebar').css('display');
		
		// is it hidden
		if ( toc_visible == 'none' ) {
		
			// show toc
			$('#toc_sidebar').show();

			// hide default
			$('#'+cp_default_sidebar+'_sidebar').hide();
			
			// set flag
			cp_toc_on_top = 'y';
			
		} else {
			
			// hide toc
			$('#toc_sidebar').hide();

			// show default
			$('#'+cp_default_sidebar+'_sidebar').show();

			// set flag
			cp_toc_on_top = 'n';
			
		}
		
		// just to make sure...
		$.set_sidebar_height();
	
	
	
		// --<
		return false;
		
	});






	/** 
	 * @description: clicking on the paragraph permalink
	 * @todo: 
	 *
	 */
	$('a.para_permalink').click( function(e) {

		// --<
		return false;
		
	});






	/** 
	 * @description: clicking on the comment block permalink
	 * @todo: 
	 *
	 */
	$('a.comment_block_permalink').click( function(e) {

		// --<
		return false;
		
	});

	/** 
	 * @description: when a comment block permalink comes into focus
	 * @todo: in development for keyboard accessibility
	 *
	 */
	/*
	if ( $().jquery >= 1.4 ) {
		$('a.comment_block_permalink').focusin( function(e) {
	
			// test -> needs refinement
			//jQuery(this).click();
			
		});
	}
	*/

	/** 
	 * @description: when a comment block permalink loses focus
	 * @todo: in development for keyboard accessibility
	 *
	 */
	/*
	$('a.comment_block_permalink').blur( function(e) {

		// test -> needs refinement
		//jQuery(this).click();
		
	});
	*/
	





	/** 
	 * @description: clicking on the contents button
	 * @todo: 
	 *
	 */
	$('#btn_header_min').click( function() {
	
		// call function
		cp_setup_header_minimiser();
		
		// --<
		return false;
			
	});

	// if IE6, then sod it
	if ( msie6 ) { $('#btn_header_min').hide(); }
	





	/** 
	 * @description: clicking on the minimise archive icon
	 * @todo: 
	 *
	 */
	$('#cp_minimise_archive').click( function() {
	
		// toggle next div
		$(this).parent().next().slideToggle();
		
	});





	/** 
	 * @description: clicking on the minimise comments icon
	 * @todo: 
	 *
	 */
	$('#cp_minimise_comments').click( function() {
	
		// toggle next div
		$(this).parent().next().slideToggle();

		// has the sidebar window been minimised?
		if ( cp_sidebar_minimised == 'y' ) {
		
			cp_sidebar_minimised = 'n';
		
		} else {
		
			cp_sidebar_minimised = 'y';
		
		}
		
		// store flag in cookie
		$.cookie( 
		
			'cp_sidebar_minimised', 
			cp_sidebar_minimised, 
			{ expires: 28, path: cp_cookie_path } 
			
		);
		
	});

	
	
	
	
	/** 
	 * @description: clicking on the minimise comments icon
	 * @todo: 
	 *
	 */
	$('#cp_minimise_all_comments').click( function() {
	
		// slide all paragraph comment wrappers up
		$('div.paragraph_wrapper').slideUp();
		
		// unhighlight paragraphs
		jQuery.unhighlight_para();

	});

	



	
	/** 
	 * @description: chapter page headings click
	 * @todo: 
	 *
	 */
	$("#toc_sidebar .sidebar_contents_wrapper ul#toc_list li a").click( function(e) {
	
		// are our chapters pages?
		if ( cp_toc_chapter_is_page == '0' ) {
		
			// no, find child lists of the enclosing <li>
			var myArr = $(this).parent().find('ul');
			
			// do we have a child list?
			if( myArr.length > 0 ) {
			
				// are subpages to be shown?
				if ( cp_show_subpages == '0' ) {
				
					// toggle next list
					$(this).next('ul').slideToggle();

				}
			
				// --<
				return false;
				
			}
		
		}
		
	});





	/** 
	 * @description: clicking on the minimise toc icon
	 * @todo: 
	 *
	 */
	$('#cp_minimise_toc').click( function() {
	
		// toggle next div
		$(this).parent().next().slideToggle();
		
	});
	
	
	
	
	// scroll the page on load
	if ( cp_special_page == '1' ) {
		cp_scroll_to_comment_on_load();
	} else {
		cp_scroll_to_anchor_on_load();
	}

});






/** 
 * @description: define what happens when the page is unloaded
 * @todo: 
 *
 */
/*
jQuery(window).unload( function() { 

	// debug
	//alert('Bye now!'); 
	
});
*/