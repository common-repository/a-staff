<?php
// The plugin's templating engine



// Choose the right template file to load
function a_staff_template_chooser( $content ) {

    // Post ID
    $post_id = get_the_ID();

	// For the plugin's CPT, load our template
	if ( is_single( $post_id ) && get_post_type( $post_id ) == 'a-staff' ) {
		include a_staff_get_template_hierarchy( 'single-member' );
		return;
	}

    // For all other CPTs, return the standard template
    return $content;

}



// Load the desired template file
function a_staff_get_template_hierarchy( $template ) {

    // Get the template slug
    $template_slug = rtrim( $template, '.php' );
    $template = $template_slug . '.php';

    // Check if a custom template exists in the theme folder, if not, load the plugin template file
    if ( $theme_file = locate_template( array( 'a-staff/' . $template ) ) ) {
        $file = $theme_file;
    }
    else {
        $file = A_STAFF_BASE_DIR . '/templates/' . $template;
    }

    return apply_filters( 'a_staff_template_' . $template, $file );

}



// Disables echoing the thumbnail
function a_staff_disable_thumb( $html, $post_id, $post_thumbnail_id, $size, $attr ) {

	if ( get_post_type( $post_id ) != 'a-staff' ) {
        return $html;
    }

	else if ( is_single() ) {
		return '';
    }

}



// Disables the post title on single member pages
function a_staff_disable_post_title( $title, $post_id ) {

	if ( get_post_type( $post_id ) != 'a-staff' ) {
        return $title;
    }

	else if ( is_single() ) {
		return '';
    }

}



// Setting up template actions
add_action( 'wp_head', function() {
	add_filter( 'post_thumbnail_html', 'a_staff_disable_thumb', 10, 5 );
	add_filter( 'the_title', 'a_staff_disable_post_title', 10, 2 );
	add_filter( 'the_content', 'a_staff_template_chooser' );
} );

add_action( 'a_staff_before_main_content', function() {
	remove_filter( 'post_thumbnail_html', 'a_staff_disable_thumb', 10 );
	remove_filter( 'the_title', 'a_staff_disable_post_title', 10, 2 );
} );

add_action( 'a_staff_after_main_content', function() {
	remove_filter( 'the_content', 'a_staff_template_chooser' );
} );
