if("undefined"!==typeof CommentpressSettings){var cp_wp_adminbar=CommentpressSettings.cp_wp_adminbar;var cp_bp_adminbar=CommentpressSettings.cp_bp_adminbar;var cp_comments_open=CommentpressSettings.cp_comments_open;var cp_special_page=CommentpressSettings.cp_special_page;var cp_para_comments_enabled=CommentpressSettings.cp_para_comments_enabled;var cp_tinymce=CommentpressSettings.cp_tinymce;var cp_promote_reading=CommentpressSettings.cp_promote_reading;var cp_is_mobile=CommentpressSettings.cp_is_mobile;var cp_is_touch=CommentpressSettings.cp_is_touch;var cp_is_tablet=CommentpressSettings.cp_is_tablet;var cp_cookie_path=CommentpressSettings.cp_cookie_path;var cp_multipage_page=CommentpressSettings.cp_multipage_page;var cp_template_dir=CommentpressSettings.cp_template_dir;var cp_plugin_dir=CommentpressSettings.cp_plugin_dir;var cp_toc_chapter_is_page=CommentpressSettings.cp_toc_chapter_is_page;var cp_show_subpages=CommentpressSettings.cp_show_subpages;var cp_default_sidebar=CommentpressSettings.cp_default_sidebar;var cp_is_signup_page=CommentpressSettings.cp_is_signup_page;var cp_scroll_speed=CommentpressSettings.cp_js_scroll_speed;var cp_min_page_width=CommentpressSettings.cp_min_page_width}var msie=jQuery.browser.msie;var msie6=jQuery.browser.msie&&jQuery.browser.version=="6.0";var cp_wp_adminbar_height=28;var cp_book_header_height;var cp_header_animating=false;var cp_toc_on_top="n";var page_highlight=false;var cp_header_minimised=jQuery.cookie("cp_header_minimised");if(cp_header_minimised===undefined||cp_header_minimised===null){cp_header_minimised="n"}var cp_sidebar_minimised=jQuery.cookie("cp_sidebar_minimised");if(cp_sidebar_minimised===undefined||cp_sidebar_minimised===null){cp_sidebar_minimised="n"}var cp_container_top_max=jQuery.cookie("cp_container_top_max");if(cp_container_top_max===undefined||cp_container_top_max===null){cp_container_top_max=108}var cp_container_top_min=jQuery.cookie("cp_container_top_min");if(cp_container_top_min===undefined||cp_container_top_min===null){cp_container_top_min=108}if(cp_bp_adminbar=="y"){cp_wp_adminbar_height=25;cp_wp_adminbar="y"}if(cp_wp_adminbar=="y"){cp_container_top_max=parseInt(cp_container_top_max)+cp_wp_adminbar_height;cp_container_top_min=parseInt(cp_container_top_min)+cp_wp_adminbar_height}function cp_page_setup(){var b="";if(document.getElementById){b+='<style type="text/css" media="screen">';b+="ul.all_comments_listing div.item_body { display: none; } ";if(cp_wp_adminbar=="y"){b+="#header { top: "+cp_wp_adminbar_height+"px; } ";b+="#book_header { top: "+(cp_wp_adminbar_height+32)+"px; } "}if(cp_show_subpages=="0"){b+="#toc_sidebar .sidebar_contents_wrapper ul li ul { display: none; } "}if(cp_header_minimised===undefined||cp_header_minimised===null||cp_header_minimised=="n"){var c=cp_container_top_max;if(cp_wp_adminbar=="y"){var c=cp_container_top_max-cp_wp_adminbar_height}b+="#container { top: "+c+"px; } ";b+="#sidebar { top: "+cp_container_top_max+"px; } "}else{b+="#book_header { display: none; } ";var c=cp_container_top_min;if(cp_wp_adminbar=="y"){var c=cp_container_top_min-cp_wp_adminbar_height}b+="#container { top: "+c+"px; } ";b+="#sidebar { top: "+cp_container_top_min+"px; } "}if(cp_special_page=="0"){if(cp_para_comments_enabled=="1"){b+=".paragraph_wrapper { display: none; } "}b+="#respond { display: none; } ";if(cp_sidebar_minimised=="y"){b+="#comments_sidebar .sidebar_contents_wrapper { display: none; } "}}b+="#activity_sidebar .paragraph_wrapper { display: none; } ";if(jQuery.cookie("cp_container_width")){var d=jQuery.cookie("cp_container_width");if(cp_is_signup_page=="1"){b+="#content { width: "+d+"%; } "}else{b+="#page_wrapper { width: "+d+"%; } "}b+="#footer { width: "+d+"%; } "}if(jQuery.cookie("cp_book_nav_width")){var a=jQuery.cookie("cp_book_nav_width");b+="#book_nav div#cp_book_nav { width: "+a+"%; } "}if(jQuery.cookie("cp_sidebar_width")){b+="#sidebar { width: "+jQuery.cookie("cp_sidebar_width")+"%; } "}if(jQuery.cookie("cp_sidebar_left")){b+="#sidebar { left: "+jQuery.cookie("cp_sidebar_left")+"%; } "}b+="ul#sidebar_tabs, #toc_header.sidebar_header, body.blog_post #activity_header.sidebar_header { display: block; } ";if(cp_is_mobile=="1"&&cp_is_tablet=="0"){b+=".sidebar_contents_wrapper { height: auto; } "}b+="</style>"}document.write(b)}cp_page_setup();function cp_setup_page_layout(){if(cp_is_signup_page=="1"){var a=jQuery("#content")}else{var a=jQuery("#page_wrapper")}a.each(function(e){var j=jQuery(this);var g=jQuery("#content");var b=jQuery("#sidebar");var m=jQuery("#footer");var h=jQuery("#book_header");var c=jQuery("#book_nav_wrapper");var f=jQuery("#cp_book_nav");var d=jQuery("#cp_book_info");var l=j.width();var n=b.width();var k=b.offset().left-l;if(jQuery.browser.opera){g.css("position","static")}j.resizable({handles:"e",minWidth:cp_min_page_width,alsoResize:"#footer",start:function(i,o){l=j.width();n=b.width();original_nav_width=f.width();original_sidebar_left=b.css("left");k=b.offset().left-l},resize:function(i,o){j.css("height","auto");m.css("height","auto");b.css("left",(j.width()+k)+"px");var p=l-j.width();b.css("width",(n+p)+"px");f.css("width",(original_nav_width-p)+"px")},stop:function(i,u){var t=parseFloat(jQuery(window).width());var o=j.width();if(jQuery.browser.webkit){o=o+1}var r=parseFloat(Math.ceil((1000000*parseFloat(o)/t))/10000);j.css("width",r+"%");if(cp_is_signup_page=="0"){g.css("width","auto")}var o=f.width();if(jQuery.browser.webkit){o=o+1}var p=parseFloat(Math.ceil((1000000*parseFloat(o)/t))/10000);f.css("width",p+"%");var o=b.width();if(jQuery.browser.webkit){o=o+1}var v=parseFloat(Math.ceil((1000000*parseFloat(o)/t))/10000);b.css("width",v+"%");var q=b.position().left;if(jQuery.browser.webkit){q=q+1}var s=parseFloat(Math.ceil((1000000*parseFloat(q)/t))/10000);b.css("left",s+"%");jQuery.cookie("cp_container_width",r.toString(),{expires:28,path:cp_cookie_path});jQuery.cookie("cp_book_nav_width",p.toString(),{expires:28,path:cp_cookie_path});jQuery.cookie("cp_sidebar_left",s.toString(),{expires:28,path:cp_cookie_path});jQuery.cookie("cp_sidebar_width",v.toString(),{expires:28,path:cp_cookie_path})}})})}function cp_get_header_offset(){var a=0-(jQuery.px_to_num(jQuery("#container").css("top")));if(cp_wp_adminbar=="y"){a-=cp_wp_adminbar_height}return a}function cp_scroll_page(a){if(msie6){jQuery(window).scrollTo(0,0);jQuery("#main_wrapper").scrollTo(a,{duration:(cp_scroll_speed*1.5),axis:"y",offset:cp_get_header_offset()},function(){jQuery(window).scrollTo(0,1)})}else{if(cp_is_mobile=="0"||cp_is_tablet=="1"){jQuery.scrollTo(a,{duration:(cp_scroll_speed*1.5),axis:"y",offset:cp_get_header_offset()})}}}function cp_quick_scroll_page(b,a){if(msie6){jQuery(window).scrollTo(0,0);jQuery("#main_wrapper").scrollTo(b,{duration:(a*1.5),axis:"y",offset:cp_get_header_offset()},function(){jQuery(window).scrollTo(0,1)})}else{if(cp_is_mobile=="0"||cp_is_tablet=="1"){jQuery.scrollTo(b,{duration:(a*1.5),axis:"y",offset:cp_get_header_offset()})}}}function cp_scroll_to_top(b,a){if(msie6){jQuery("#main_wrapper").scrollTo(b,{duration:a})}else{if(cp_is_mobile=="0"||cp_is_tablet=="1"){jQuery.scrollTo(b,a)}}}function cp_scroll_comments(c,b,a){switch(arguments.length){case 2:a="noflash";case 3:break;default:throw new Error("illegal argument count")}if(cp_is_mobile=="0"||cp_is_tablet=="1"){if(a=="flash"){jQuery("#comments_sidebar .sidebar_contents_wrapper").scrollTo(c,{duration:b,axis:"y",onAfter:function(){cp_flash_comment_header(c)}})}else{jQuery("#comments_sidebar .sidebar_contents_wrapper").scrollTo(c,{duration:b})}}}function cp_setup_comment_headers(){if(cp_special_page=="1"){return}jQuery("a.comment_block_permalink").unbind("click");jQuery("a.comment_block_permalink").css("cursor","pointer");jQuery("a.comment_block_permalink").click(function(d){d.preventDefault();var k=jQuery(this).parent().attr("id").split("para_heading-")[1];var i=jQuery(this).parent().next("div.paragraph_wrapper");var b=jQuery("#para_wrapper-"+k).find("ol.commentlist");var f=false;var g=i.css("display");if(g=="none"){f=true}if(typeof(k)!="undefined"){if(k!=""){var c=jQuery("#textblock-"+k);if(f){jQuery.unhighlight_para();jQuery.highlight_para(c);cp_scroll_page(c)}else{if(cp_promote_reading=="0"){if(jQuery("#para_wrapper-"+k).find("#respond")[0]){jQuery.unhighlight_para()}else{if(!b[0]){jQuery.unhighlight_para();jQuery.highlight_para(c);cp_scroll_page(c)}}}else{if(jQuery.is_highlighted(c)){jQuery.unhighlight_para()}}}}else{jQuery.unhighlight_para();cp_scroll_to_top(0,cp_scroll_speed);page_highlight=!page_highlight}}if(cp_promote_reading=="0"){if(cp_comments_open=="y"){var h=jQuery("#comment_post_ID").attr("value");var a=jQuery("#para_wrapper-"+k+" .reply_to_para").attr("id");var j=a.split("-")[1];var e=jQuery("#para_wrapper-"+k).find("#respond")[0];if(b.length>0&&b[0]){if(!f&&!e){}else{addComment.moveFormToPara(j,k,h)}}else{if(!e){i.css("display","none");f=true}addComment.moveFormToPara(j,k,h)}}}if(cp_para_comments_enabled=="1"){i.slideToggle("slow",function(){if(f){cp_scroll_comments(jQuery("#para_heading-"+k),cp_scroll_speed)}})}return false})}function cp_enable_comment_permalink_clicks(){jQuery("a.comment_permalink").unbind("click");jQuery("a.comment_permalink").click(function(d){d.preventDefault();var c=this.href.split("#")[1];if(cp_special_page=="1"){var a=cp_get_header_offset();jQuery.scrollTo(jQuery("#"+c),{duration:cp_scroll_speed,axis:"y",offset:a})}else{jQuery.unhighlight_para();var b=cp_get_text_sig_by_comment_id("#"+c);cp_scroll_page_to_textblock(b);cp_scroll_comments(jQuery("#"+c),cp_scroll_speed)}return false})}function cp_flash_comment_header(c){var b=c.children(".comment-identifier");if(!b){return}var a=b.css("backgroundColor");b.animate({backgroundColor:"#819565"},100,function(){b.animate({backgroundColor:a},1000,function(){})})}function cp_setup_context_headers(){jQuery("h3.activity_heading").unbind("click");jQuery("h3.activity_heading").css("cursor","pointer");jQuery("h3.activity_heading").click(function(b){b.preventDefault();var a=jQuery(this).next("div.paragraph_wrapper");a.css("width",jQuery(this).parent().css("width"));a.slideToggle("slow",function(){a.css("width","auto")});return false})}function cp_enable_context_clicks(){if(cp_special_page=="1"){return}jQuery("a.comment_on_post").unbind("click");jQuery("a.comment_on_post").click(function(f){f.preventDefault();cp_activate_sidebar("comments");var d=this.href.split("#")[1];var g=jQuery("#"+d);var a=g.parents("div.paragraph_wrapper").map(function(){return this});if(a.length>0){var e=jQuery(a[0]);e.show();if(cp_special_page=="1"){var b=cp_get_header_offset();jQuery.scrollTo(g,{duration:cp_scroll_speed,axis:"y",offset:b})}else{jQuery.unhighlight_para();var c=e.attr("id").split("-")[1];cp_scroll_page_to_textblock(c);jQuery("#comments_sidebar .sidebar_contents_wrapper").scrollTo(g,{duration:cp_scroll_speed,axis:"y",onAfter:function(){cp_flash_comment_header(g)}})}}return false})}function cp_get_text_sig_by_comment_id(e){var c="";if(e.match("#comment-")){var b=parseInt(e.split("#comment-")[1])}var a=jQuery("#comment-"+b).parents("div.paragraph_wrapper").map(function(){return this});if(a.length>0){var d=jQuery(a[0]);c=d.attr("id").split("-")[1]}return c}function cp_scroll_page_to_textblock(a){if(a!=""){var b=jQuery("#textblock-"+a);jQuery.highlight_para(b);cp_scroll_page(b)}else{if(page_highlight===false){cp_scroll_to_top(0,cp_scroll_speed)}page_highlight=!page_highlight}}function cp_scroll_to_anchor_on_load(){var h="";var c=document.location.toString();if(c.match("#comment-")){var d=c.split("#comment-")[1];var g=jQuery("#comment-"+d).parents("div.paragraph_wrapper").map(function(){return this});if(g.length>0){var i=jQuery(g[0]);if(cp_comments_open=="y"){var h=i.attr("id").split("-")[1];var a=jQuery("#para_wrapper-"+h+" .reply_to_para").attr("id");var f=a.split("-")[1];var e=jQuery("#comment_post_ID").attr("value");if(cp_tinymce=="1"){if(jQuery("#comment-"+d+" > .reply").text()!=""){cp_tinymce="0";addComment.moveForm("comment-"+d,d,"respond",e,h);cp_tinymce="1"}}else{addComment.moveForm("comment-"+d,d,"respond",e,h)}}i.show();cp_scroll_comments(jQuery("#comment-"+d),0,"flash");if(h!=""){var b=jQuery("#textblock-"+h);jQuery.highlight_para(b);cp_scroll_page(b)}else{if(page_highlight===false){cp_scroll_to_top(0,cp_scroll_speed)}page_highlight=!page_highlight}}}else{jQuery("a.para_permalink").each(function(m){var n=jQuery(this).attr("id");if(c.match("#"+n)||c.match("#para_heading-"+n)){if(cp_comments_open=="y"){var k=jQuery("#para_wrapper-"+n+" .reply_to_para").attr("id");var j=k.split("-")[1];var l=jQuery("#comment_post_ID").attr("value");addComment.moveFormToPara(j,n,l)}jQuery("#para_heading-"+n).next("div.paragraph_wrapper").show();cp_scroll_comments(jQuery("#para_heading-"+n),1);var o=jQuery("#textblock-"+n);jQuery.highlight_para(o);cp_scroll_page(o)}})}if(c.match("#respond")){jQuery("h3#para_heading- a.comment_block_permalink").click()}}function cp_scroll_to_comment_on_load(){var a=document.location.toString();if(a.match("#comment-")){var b=a.split("#comment-")[1];if(msie6){jQuery("#main_wrapper").scrollTo(jQuery("#comment-"+b),{duration:cp_scroll_speed,axis:"y",offset:cp_get_header_offset()})}else{if(cp_is_mobile=="0"||cp_is_tablet=="1"){jQuery.scrollTo(jQuery("#comment-"+b),{duration:cp_scroll_speed,axis:"y",offset:cp_get_header_offset()})}}}}function cp_do_comment_icon_action(l,i){cp_activate_sidebar("comments");var j=jQuery("#para_heading-"+l).next("div.paragraph_wrapper");var b=jQuery("#para_wrapper-"+l+" .commentlist");var d=j.find("#respond");var h=addComment.getLevel();var e=false;var g=j.css("display");if(g=="none"){e=true}jQuery.unhighlight_para();if(l!=""){var c=jQuery("#textblock-"+l);if(cp_promote_reading=="1"&&!e){}else{jQuery.highlight_para(c);cp_scroll_page(c)}}if(cp_promote_reading=="0"){if(cp_comments_open=="y"){var f=jQuery("#comment_post_ID").attr("value");var a=jQuery("#para_wrapper-"+l+" .reply_to_para").attr("id");var k=a.split("-")[1]}if(!d[0]){if(cp_comments_open=="y"){addComment.moveFormToPara(k,l,f)}}if(d[0]&&!h){if(cp_comments_open=="y"){addComment.moveFormToPara(k,l,f);if(i=="marker"){cp_scroll_comments(jQuery("#para_heading-"+l),cp_scroll_speed)}else{cp_scroll_comments(jQuery("#respond"),cp_scroll_speed)}}else{cp_scroll_comments(jQuery("#para_heading-"+l),cp_scroll_speed)}return}if(!d[0]&&b[0]&&!e){if(cp_comments_open=="y"){if(i=="marker"){cp_scroll_comments(jQuery("#para_heading-"+l),cp_scroll_speed)}else{cp_scroll_comments(jQuery("#respond"),cp_scroll_speed)}}else{cp_scroll_comments(jQuery("#para_heading-"+l),cp_scroll_speed)}return}if(!e&&b[0]){if(cp_comments_open=="y"){if(i=="marker"){cp_scroll_comments(jQuery("#para_heading-"+l),cp_scroll_speed)}else{cp_scroll_comments(jQuery("#respond"),cp_scroll_speed)}}else{cp_scroll_comments(jQuery("#para_heading-"+l),cp_scroll_speed)}return}if(d[0]&&!b[0]&&!e){if(cp_comments_open=="y"){if(i=="marker"){cp_scroll_comments(jQuery("#para_heading-"+l),cp_scroll_speed)}else{cp_scroll_comments(jQuery("#respond"),cp_scroll_speed)}}else{cp_scroll_comments(jQuery("#para_heading-"+l),cp_scroll_speed)}return}if(!e&&!b[0]){j.css("display","none");e=true}}j.slideToggle("slow",function(){if(cp_promote_reading=="1"&&e){cp_scroll_comments(jQuery("#para_heading-"+l),cp_scroll_speed)}else{if(e){if(cp_comments_open=="y"){if(i=="marker"){cp_scroll_comments(jQuery("#para_heading-"+l),cp_scroll_speed)}else{cp_scroll_comments(jQuery("#respond"),cp_scroll_speed)}}else{cp_scroll_comments(jQuery("#para_heading-"+l),cp_scroll_speed)}}}})}function cp_setup_para_permalink_icons(){jQuery("a.para_permalink").unbind("click");jQuery("a.para_permalink").click(function(b){b.preventDefault();var a=jQuery(this).attr("href").substring(1);cp_do_comment_icon_action(a,"auto");return false});jQuery("a.para_permalink").unbind("hover");jQuery("a.para_permalink").hover(function(b){var a=jQuery(this).attr("href");jQuery("span.para_marker a"+a).addClass("js-hover")},function(b){var a=jQuery(this).attr("href");jQuery("span.para_marker a"+a).removeClass("js-hover")})}function cp_setup_para_marker_icons(){jQuery("span.para_marker a").unbind("click");jQuery("span.para_marker a").click(function(b){b.preventDefault();var a=jQuery(this).attr("href");a=a.substring(1);cp_do_comment_icon_action(a,"marker");return false});jQuery("span.para_marker a").unbind("hover");jQuery("span.para_marker a").hover(function(b){var a=jQuery(this).attr("href");var c=jQuery(this).parent().next().children(".comment_count");c.addClass("js-hover")},function(b){var a=jQuery(this).attr("href");var c=jQuery(this).parent().next().children(".comment_count");c.removeClass("js-hover")})}function cp_open_header(){var b=jQuery("#book_nav").height();var a=jQuery("#sidebar");var d=jQuery.get_sidebar_pane();var f=jQuery("#book_header");var c=jQuery("#container");var g=cp_container_top_max;if(cp_wp_adminbar=="y"){var g=cp_container_top_max-cp_wp_adminbar_height}c.animate({top:g+"px",duration:"fast"},function(){f.fadeIn("fast",function(){cp_header_animating=false})});if(cp_sidebar_minimised=="n"){var e=a.height()-cp_book_header_height;a.animate({top:cp_container_top_max+"px",height:e+"px",duration:"fast"},function(){a.css("height","auto")});d.animate({height:(d.height()-cp_book_header_height)+"px",duration:"fast"},function(){if(cp_is_mobile=="0"||cp_is_tablet=="1"){jQuery.set_sidebar_height()}cp_header_animating=false})}else{a.animate({top:cp_container_top_max+"px",duration:"fast"},function(){cp_header_animating=false;if(cp_is_mobile=="0"||cp_is_tablet=="1"){jQuery.set_sidebar_height()}})}}function cp_close_header(){var b=jQuery("#book_nav").height();var a=jQuery("#sidebar");var d=jQuery.get_sidebar_pane();var f=jQuery("#book_header");var c=jQuery("#container");f.hide();var g=cp_container_top_min;if(cp_wp_adminbar=="y"){var g=cp_container_top_min-cp_wp_adminbar_height}c.animate({top:g+"px",duration:"fast"});if(cp_sidebar_minimised=="n"){var e=a.height()+cp_book_header_height;a.animate({top:cp_container_top_min+"px",height:e+"px",duration:"fast"},function(){a.css("height","auto")});d.animate({height:(d.height()+cp_book_header_height)+"px",duration:"fast"},function(){if(cp_is_mobile=="0"||cp_is_tablet=="1"){jQuery.set_sidebar_height()}cp_header_animating=false})}else{a.animate({top:cp_container_top_min+"px",duration:"fast"},function(){cp_header_animating=false;if(cp_is_mobile=="0"||cp_is_tablet=="1"){jQuery.set_sidebar_height()}})}}function cp_setup_header_minimiser(){if(cp_header_animating===true){return false}cp_header_animating=true;if(cp_header_minimised===undefined||cp_header_minimised===null||cp_header_minimised=="n"){cp_close_header()}else{cp_open_header()}cp_header_minimised=(cp_header_minimised=="y")?"n":"y";jQuery.cookie("cp_header_minimised",cp_header_minimised,{expires:28,path:cp_cookie_path})}function cp_setup_para_links(){jQuery("a.cp_para_link").unbind("click");jQuery("a.cp_para_link").click(function(b){b.preventDefault();var a=jQuery(this).attr("href").substring(1);cp_do_comment_icon_action(a,"auto");return false})}function cp_setup_footnotes_compatibility(){jQuery("span.footnotereverse a").unbind("click");jQuery("span.footnotereverse a, a.footnote-back-link").click(function(a){a.preventDefault();var b=jQuery(this).attr("href");cp_quick_scroll_page(b,100);return false});jQuery(".simple-footnotes ol li a").unbind("click");jQuery(".simple-footnotes ol li a").click(function(a){var b=jQuery(this).attr("href");if(b.match("#return-note-")){a.preventDefault();cp_quick_scroll_page(b,100);return false}});jQuery("a.simple-footnote, sup.footnote a, sup a.footnote-identifier-link").unbind("click");jQuery("a.simple-footnote, sup.footnote a, sup a.footnote-identifier-link").click(function(a){a.preventDefault();var b=jQuery(this).attr("href");cp_quick_scroll_page(b,100);return false})}function cp_get_sidebar_top(){return jQuery.px_to_num(jQuery("#toc_sidebar").css("top"))}function cp_get_sidebar_top_border(){return jQuery.px_to_num(jQuery(".sidebar_minimiser").css("borderTopWidth"))}function cp_activate_sidebar(d){var b=jQuery("#"+d+"_sidebar").css("z-index");if(b=="2001"){jQuery(".sidebar_container").css("z-index","2001");jQuery("#"+d+"_sidebar").css("z-index","2010");var c=cp_get_sidebar_top();var a=cp_get_sidebar_top_border();jQuery(".sidebar_header").css("height",(c-a)+"px");jQuery("#"+d+"_header.sidebar_header").css("height",c+"px");cp_toc_on_top="y"}if(cp_is_mobile=="0"||cp_is_tablet=="1"){jQuery.set_sidebar_height()}else{jQuery(".sidebar_container").css("visibility","hidden");jQuery("#"+d+"_sidebar").css("visibility","visible")}}jQuery(document).ready(function(b){cp_book_header_height=b("#book_header").height();if(cp_is_mobile=="0"||cp_is_tablet=="1"){b.set_sidebar_height()}if(jQuery.cookie("cp_container_top_min")){}else{cp_container_top_max=b.px_to_num(b("#container").css("top"));cp_container_top_min=cp_container_top_max-cp_book_header_height;b.cookie("cp_container_top_min",cp_container_top_min.toString(),{expires:28,path:cp_cookie_path});b.cookie("cp_container_top_max",cp_container_top_max.toString(),{expires:28,path:cp_cookie_path})}cp_setup_page_layout();cp_setup_comment_headers();cp_enable_comment_permalink_clicks();cp_setup_para_permalink_icons();cp_setup_para_marker_icons();cp_setup_para_links();cp_enable_context_clicks();cp_setup_context_headers();cp_setup_footnotes_compatibility();b("#toc_header h2 a").click(function(d){d.preventDefault();cp_activate_sidebar("toc");return false});b("#activity_header h2 a").click(function(d){d.preventDefault();cp_activate_sidebar("activity");return false});b("#comments_header h2 a").click(function(d){d.preventDefault();cp_activate_sidebar("comments");return false});b("a.para_permalink").click(function(d){d.preventDefault();return false});b("a.comment_block_permalink").click(function(d){d.preventDefault();return false});b("#btn_header_min").click(function(d){d.preventDefault();cp_setup_header_minimiser();return false});if(msie6){b("#btn_header_min").hide()}b("#cp_minimise_comments").click(function(d){d.preventDefault();b(this).parent().next().slideToggle();if(cp_sidebar_minimised=="y"){cp_sidebar_minimised="n"}else{cp_sidebar_minimised="y"}b.cookie("cp_sidebar_minimised",cp_sidebar_minimised,{expires:28,path:cp_cookie_path})});b("#cp_minimise_all_comments").click(function(d){d.preventDefault();b("#comments_sidebar div.paragraph_wrapper").slideUp();b.unhighlight_para()});b("#cp_minimise_all_activity").click(function(d){d.preventDefault();b("#activity_sidebar div.paragraph_wrapper").slideUp()});b("#toc_sidebar .sidebar_contents_wrapper ul#toc_list li a").click(function(e){if(cp_toc_chapter_is_page=="0"){var d=b(this).parent().find("ul");if(d.length>0){if(cp_show_subpages=="0"){b(this).next("ul").slideToggle()}e.preventDefault();return false}}});var c=b("#content").css("min-height");var a=b("#content").css("padding-bottom");b("#literal .post").css("display","none");b("#original .post").css("display","none");b("#content-tabs li h2 a").click(function(e){e.preventDefault();var d=this.href.split("#")[1];b(".post").css("display","none");b(".workflow-wrapper").css("min-height","0");b(".workflow-wrapper").css("padding-bottom","0");b("#"+d+".workflow-wrapper").css("min-height",c);b("#"+d+".workflow-wrapper").css("padding-bottom",a);b("#"+d+" .post").css("display","block");b("#content-tabs li").removeClass("default-content-tab");b(this).parent().parent().addClass("default-content-tab");return false});if(cp_special_page=="1"){cp_scroll_to_comment_on_load()}else{cp_scroll_to_anchor_on_load()}});