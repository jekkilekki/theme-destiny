<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Destiny
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function destiny_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
                $classes[] = 'archive-view';
	}
	
	// Add a class of no-sidebar when there is no sidebar present
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	} else {
                $classes[] = 'has-sidebar'; 
        }
        
        // Add a class of no-sidebar when there is no sidebar present
	if ( is_page() && is_active_sidebar( 'sidebar-2' ) ) {
		$classes[] = 'has-page-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'destiny_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function destiny_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'destiny_pingback_header' );

/**
 * Add a "STOP" at the end of the Post Content
 */
function destiny_end_content ( $content ) {
    $last_tag = strrpos( $content, '</' );
    $content_end = substr( $content, $last_tag );
    //return substr( $content, 0, $last_tag ) . destiny_get_svg( array( 'icon' => 'material-stop' ) ) . $content_end;
}
//add_filter( 'the_content', 'destiny_end_content' );
/**
 * Filters out the parentheses from Category Count
 * 
 * @param type $variable
 * @return type
 */
function destiny_categories_postcount_filter ( $count ) {
        $count = str_replace( '(', '<span class="post_count">', $count );
        $count = str_replace( ')', '</span>', $count );
        return $count;
}
add_filter( 'wp_list_categories','destiny_categories_postcount_filter' );
/**
 * Filters out the parentheses from Archives Count
 * 
 * @param type $variable
 * @return type
 */
function destiny_archive_postcount_filter ($count) {
   $count = str_replace( '(', '<span class="post_count">', $count );
   $count = str_replace( ')', '</span>', $count );
   return $count;
}
add_filter( 'get_archives_link', 'destiny_archive_postcount_filter' );

