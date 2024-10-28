<?php
// Additional functions used by the a-staff plugin



// Gets the available default and user-defined image sizes. Used by the image size selector dropdown on the settings page
function a_staff_get_image_sizes () {

	global $_wp_additional_image_sizes;

	$sizes = array();

	foreach ( get_intermediate_image_sizes() as $_size ) {

		if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {

			$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
			$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );

		}

		elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

			$sizes[$_size] = array(
				'width'  => $_wp_additional_image_sizes[$_size]['width'],
				'height' => $_wp_additional_image_sizes[$_size]['height'],
				'crop'   => $_wp_additional_image_sizes[$_size]['crop'],
			);

		}

	}

	// Sort them by item width
	uasort( $sizes, function( $a, $b ) {
		if ( $a["width"] == $b["width"] ) {
	        return 0;
	    }
	    return ( $a["width"] < $b["width"] ) ? -1 : 1;
	} );

	return $sizes;

}



// Creates a formatted excerpt of the $text (html text) variable. $excerpt_length is in words
function a_staff_trim_excerpt( $text, $excerpt_length = 55 ) {

	// Other than $allowed_tags will be removed from the $text
	$allowed_tags = array( 'b' ,'strong', 'i', 'em', 'br', 'span', 'a' );
    $text = apply_filters( 'the_content', $text );
    $text = str_replace( '\]\]\>', ']]&gt;', $text );

	$allowed_tags_text = '';
	foreach ( $allowed_tags as $tag ) {
		$allowed_tags_text .= '<' . $tag . '>,';
	}
	$allowed_tags_text = rtrim( $allowed_tags_text, ',' );

    $text = strip_tags( $text, $allowed_tags_text );
    $words = explode( ' ', $text, $excerpt_length + 1 );

    if ( count( $words ) > $excerpt_length ) {
        array_pop( $words );
		$open_tags = array();

		foreach ( $words as $i => $word ) {
			$word = $word . ' ';
			foreach ( $allowed_tags as $tag ) {
				if ( strpos( $word, '<' . $tag . ' ' ) !== false || strpos( $word, '<' . $tag . '>' ) ) {
					if ( $tag != 'br' ) {
						$open_tags[] = $tag;
					}
				}
				if ( strpos( $word, '</' . $tag . ' ' ) !== false || strpos( $word, '</' . $tag . '>' ) ) {
					for ( $j = count( $open_tags ) - 1; $j >= 0; $j-- ) {
					    if ( $open_tags[$j] == $tag ) {
							array_splice( $open_tags, $j, 1 );
						}
					}
				}
			}
		}

		$words[] = '...';
		if ( !empty( $open_tags ) ) {
			foreach ( array_reverse( $open_tags ) as $tag ) {
				$words[] = '</' . $tag . '>';
			}
		}
		$text = implode( ' ', $words );
    }

	$text = wpautop( $text );
	$text = str_replace( array( '<p>', '</p>' ), '', $text );

    return $text;

}



// Gets an A_STAFF_Member object based on its ID
function a_staff_get_member( $member_id ) {

	$class_name = A_STAFF_MEMBER_CLASS;
	return new $class_name( $member_id );

}



// Gets array of member ID => member names
function a_staff_get_members() {

	// Run a loop with the system's Staff Members
	$args = array (
		'post_type'              => array( 'a-staff' ),
		'nopaging'               => true,
		'posts_per_page'         => '-1',
		'ignore_sticky_posts'    => true,
		'order'                  => 'ASC',
		'orderby'                => 'title',
	);


	// Do the query
	$query		= new WP_Query( $args );
	$member_list = array();

	// The Loop
	if ( $query->have_posts() ) {

		while ( $query->have_posts() ) {
			$query->the_post();

			// Set up the current member object
			$member = a_staff_get_member( get_the_ID() );

			// Add to the array
			$member_list[] = array(
				"value"	=> $member->get_id(),
				"label"	=> $member->get_name(),
			);

		}

	}

	// Restore original Post Data
	wp_reset_postdata();

	// Return the member list
	return $member_list;

}



// Extracts the multiple value from Gutenberg multiselect to be usable in the shortcode
function a_staff_prepare_multi( $multi_array ) {

	$ret = '';

	if ( is_array( $multi_array ) ) {

		foreach ( $multi_array as $value ) {
			$ret .= $value . ',';
		}

		$ret = rtrim( $ret, ',' );

	}

	return $ret;

}
