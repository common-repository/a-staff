<?php
// Shortcodes added by the a-staff plugin



// Add Shortcode: [a-staff]
function a_staff_shortcode( $atts ) {

	// Default Attributes
	$default_atts = array(
		'class'			=> '',
		'ids'			=> '',
		'exclude'		=> '',
		'columns'		=> tpl_get_option( 'a_staff_columns' ),
		'orderby'		=> tpl_get_option( 'a_staff_default_sorting' ),
		'order'			=> tpl_get_option( 'a_staff_sorting_direction' ),
	);

	$atts = shortcode_atts( apply_filters( 'a_staff_shortcode_default_atts', $default_atts ), $atts );


	// Run a loop with the system's Staff Members
	$args = array (
		'post_type'              => array( 'a-staff' ),
		'nopaging'               => true,
		'posts_per_page'         => '-1',
		'ignore_sticky_posts'    => true,
		'order'                  => $atts["order"],
		'orderby'                => $atts["orderby"],
	);


	// Display only the posts with specific IDs if the ids="" parameter is not empty
	if ( $atts["ids"] != '' && is_string( $atts["ids"] ) ) {

		$args["post__in"] = explode( ',', $atts["ids"] );

	}


	// Or exclude some posts in the other case
	if ( $atts["exclude"] != '' && is_string( $atts["exclude"] ) ) {

		$args["post__not_in"] = explode( ',', $atts["exclude"] );

	}


	// Default to 3 columns if there is no setting in the database nor in the shortcode
	if ( $atts["columns"] == '' || !is_numeric( $atts["columns"] ) ) {
		$atts["columns"] = 3;
	}


	// Initialize the output
	$output = '';

	// Do the query
	$query = new WP_Query( apply_filters( 'a_staff_loop_args', $args, $atts ) );

	// The Loop
	if ( $query->have_posts() ) {


		// Add extra classes to the container if needed
		if ( $atts["class"] != '' ) {
			$extra_class = ' ' . $atts["class"];
		}
		else {
			$extra_class = '';
		}

		// Setting up the number of columns
		$extra_class .= ' a-staff-cols-' . $atts["columns"];


		// If no social icons are added in settings, add a special extra class
		$social_network_blocks = tpl_get_option( 'a_staff_social_networks' );
		if ( empty( $social_network_blocks[0] ) ) {
			$extra_class .= ' a-staff-noicons';
		}

		if ( tpl_get_option( 'a_staff_enable_phone_numbers' ) != true ) {
			$extra_class .= ' a-staff-nophone';
		}


		// Start adding the output
		$output .= '<div class="a-staff-members' . esc_attr( $extra_class ) . '">';


		while ( $query->have_posts() ) {
			$query->the_post();


			// Set up the current member object
			$member = a_staff_get_member( get_the_ID() );

			$output .= $member->get_box();

		}

		$output .= '</div>';

	}

	else {
		// no posts found
		$output .= '<p>' . __( 'No team members found', 'a-staff' ) . '</p>';
	}

	// Restore original Post Data
	wp_reset_postdata();

	// And return the output
	return $output;

}

add_shortcode( 'a-staff', 'a_staff_shortcode' );
