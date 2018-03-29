<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Destiny
 */

if ( ! function_exists( 'destiny_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function destiny_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'destiny' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'destiny_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function destiny_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'destiny' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'destiny_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function destiny_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'destiny' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'destiny' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'destiny' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'destiny' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'destiny' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'destiny' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'destiny_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function destiny_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'destiny_post_navigation' ) ) :
	/**
 * Post navigation (previous / next post) for single posts.
 */
function destiny_post_navigation() {
    the_post_navigation( array(
            'next_text'         => '<span class="meta-nav" aria-hidden="true">' . __( 'Next post:', 'destiny' ) . '</span>' .
                                        '<span class="screen-reader-text">' . __( 'Next post:', 'destiny' ) . '</span>' .
                                        '<span class="post-title">%title</span>',
            'prev_text'         => '<span class="meta-nav" aria-hidden="true">' . __( 'Previously:', 'destiny' ) . '</span>' .
                                        '<span class="screen-reader-text">' . __( 'Previously:', 'destiny' ) . '</span>' .
                                        '<span class="post-title">%title</span>',
            'in_same_term'      => true,
    ) );
}
endif;

if ( ! function_exists( 'destiny_excerpt_more' ) ) :
	/**
 * Customize ellipsis at end of excerpts.
 */
function destiny_excerpt_more( $more ) {
    $more_str = " <a href='" . get_permalink() . "'><span class='screen-reader-text'>Continue reading " . get_the_title() . "</span>&hellip;</a>";
    return $more_str;
}
add_filter( 'excerpt_more', 'destiny_excerpt_more' );
endif;

/**
 * Filter excerpt length to 100 words.
 */
function destiny_excerpt_length( $length ) {
    return 100;
}
add_filter( 'excerpt_length', 'destiny_excerpt_length' );

/**
 * Fancy excerpts
 * 
 * @link: http://wptheming.com/2015/01/excerpt-versus-content-for-archives/
 */
function destiny_fancy_excerpt() {
    global $post;
    if ( has_excerpt() ) :
        the_excerpt();
    elseif ( @strpos ( $post->post_content, '<!--more-->' ) ) :
        the_content();
    elseif ( str_word_count ( $post->post_content ) < 100 ) :
        the_content();
    else :
        the_excerpt();
    endif;
}
/**
 * Add an author box below posts
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-add-an-author-info-box-in-wordpress-posts/
 */
function destiny_author_box() {
    global $post;
    
    // Detect if a post author is set
    if ( isset( $post->post_author ) ) {
        
        /*
         * Get Author info
         */
        $display_name = get_the_author_meta( 'display_name', $post->post_author );                  // Get the author's display name  
            if ( empty ( $display_name ) ) $display_name = get_the_author_meta( 'nickname', $post->post_author ); // If display name is not available, use nickname
        $user_desc =    get_the_author_meta( 'user_description', $post->post_author );              // Get bio info
        $user_site =    get_the_author_meta( 'url', $post->post_author );                           // Website URL
        $user_posts =   get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) );    // Link to author archive page
        if( get_header_image() ) $header_image = 'style="background-image: url(\'' . get_header_image() . '\');"';
        //echo $header_image;
        /*
         * Create the Author box
         */
        ?>
        <aside class="author_bio_section_bg" style="background-image: url('<?php header_image(); ?>');">
        <?php
        // $author_details  = '<aside class="author_bio_section_bg" ' . $header_image . '>';
              $author_details .= '<div class="author_bio_section">';  
        $author_details .= '<div class="author_bio_container">';
        $author_details .= '<p class="entry-meta label">' . esc_html__( 'About the author', 'destiny' ) . ' <span class="show-hide-author"><i class="fa fa-minus-circle"></i></span></p>';
        
//        $author_details .= '<h3 class="author-title"><span>' . esc_html__( 'About ', 'destiny' );
//            if ( is_author() ) $author_details .= $display_name;        // If an author archive, just show the author name
//            else $author_details .= esc_html__( 'the Author', 'destiny' ); // If a regular page, show "About the Author"
//        $author_details .= '</span></h3>';
        
        $author_details .= '<div class="author-box">';
                $author_details .= '<section class="author-avatar">' . get_avatar( get_the_author_meta( 'user_email' ), 240 );
                $author_details .= '</section>';
        $author_details .= '<section class="author-info">';
        
        if ( ! empty( $display_name ) && ! is_author() ) {          // Don't show this name on an author archive page
            $author_details .= '<h3 class="author-name">';
            $author_details .= '<a class="fn" href="' . esc_url( $user_posts ) . '">' . $display_name . '</a>';
            $author_details .= '</h3>';
        }
        if ( ! is_author() ) {  // Don't show the meta info on an author archive page
                $author_details .= '<p class="author-links entry-meta"><span class="vcard"><a class="fn" href="' . esc_url( $user_posts ) . '">' . esc_html__( 'More posts', 'destiny' ) . '</a></span>';
                // Check if author has a website in their profile
                if ( ! empty( $user_site ) ) 
                    $author_details .= '<a class="author-site" href="' . esc_url( $user_site ) . '" target="_blank" rel="nofollow">' . esc_html__( 'Website', 'destiny' ) . '</a></p>';
                else $author_details .= '</p>';
                }
        if ( ! empty( $user_desc ) ) 
            $author_details .= '<p class="author-description">' . $user_desc . '</p>';
        
        $author_details .= '</section>';
        $author_details .= '</div>';
        $author_details .= '</div><!-- .author_bio_container -->';
            $author_details .= '</div><!-- .author_bio_container_bg -->';
        $author_details .= '</aside>';
        
        echo wp_kses_post( $author_details );
    }
    
}
/**
 * Dynamic Copyright
 */
 function destiny_dynamic_copyright() {
    
    global $wpdb;
    
    $copyright_dates = $wpdb->get_results( "SELECT YEAR(min(post_date_gmt)) AS firstdate, YEAR(max(post_date_gmt)) AS lastdate FROM $wpdb->posts WHERE post_status = 'publish' " );
    $output = '';
    $blog_name = get_bloginfo();
    
    if ( $copyright_dates ) {
        $copyright = "&copy; " . $copyright_dates[0]->firstdate;
        if ( $copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate ) {
            $copyright .= " &ndash; " . $copyright_dates[0]->lastdate;
        }
        $output = $copyright . " " . $blog_name;
    }
    echo $output;
    
}