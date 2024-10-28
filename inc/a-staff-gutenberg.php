<?php
// Functions needed for the Gutenberg editor



// Block: Single team member box
function a_staff_gutenberg_member_block() {

	wp_register_script( 'a-staff-member-block', plugins_url( 'assets/a-staff-member-block.min.js', dirname( __FILE__ ) ), array(
		'wp-blocks',
		'wp-element',
		'wp-editor',
		'wp-i18n',
		'jquery'
	) );

	$members_list = array(
		array(
			"value"	=> 0,
			"label"	=> __( 'Select member', 'a-staff' ),
		)
	);

	$member_list = array_merge( $members_list, a_staff_get_members() );

	wp_localize_script( 'a-staff-member-block', 'A_STAFF_MEMBER_BLOCK', array(
		"memberlist"	=> $member_list,
		"block_title"	=> __( 'a-staff Team Member', 'a-staff' ),
		"select_label"	=> __( 'Select team member', 'a-staff' ),
	) );

	wp_register_style( 'a-staff-style', plugins_url( 'assets/a-staff.min.css', dirname( __FILE__ ) ), array(), A_STAFF_VERSION );

    register_block_type( 'a-staff/member-block', array(
        "editor_script"		=> 'a-staff-member-block',
		"editor_style"		=> 'a-staff-style',
		"style"				=> 'a-staff-style',
		"render_callback"	=> 'a_staff_member_block_output',
		"attributes"		=> array(
			"user_id"	=> array(
				"type"		=> 'number',
				"default"	=> 0,
			),
		),
	) );

}
add_action( 'init', 'a_staff_gutenberg_member_block' );



// Returns a member box to the REST API in Front End
function a_staff_member_block_output( $attributes ) {

	if ( $attributes["user_id"] == '' ) {
		 $attributes["user_id"] = 0;
	}

	$member = a_staff_get_member( $attributes["user_id"] );

	remove_filter( 'the_content', 'wpautop' );

	return $member->get_box();

}




/* Block: a-staff loop */

function a_staff_gutenberg_loop_block() {

	// Registering scripts and styles

	wp_register_script( 'a-staff-loop-block', plugins_url( 'assets/a-staff-loop-block.min.js', dirname( __FILE__ ) ), array(
		'wp-blocks',
		'wp-element',
		'wp-i18n',
		'jquery'
	) );

	wp_register_style( 'a-staff-style', plugins_url( 'assets/a-staff.min.css', dirname( __FILE__ ) ), array(), A_STAFF_VERSION );



	// Setting up the options arrays for the block

	$columns_options	= tpl_get_option_object( 'a_staff_columns' );
	$orderby_options	= tpl_get_option_object( 'a_staff_default_sorting' );
	$order_options		= tpl_get_option_object( 'a_staff_sorting_direction' );



	// The strings
	$a_staff_loop_block_strings = array(
		"block_title"			=> __( 'a-staff Loop', 'a-staff' ),
		"layout_panel_title"	=> __( 'Layout', 'a-staff' ),
		"columns_number_label"	=> __( 'Number of Columns', 'a-staff' ),
		"columns_min"			=> $columns_options->min,
		"columns_max"			=> $columns_options->max,
		"orderby_label"			=> __( 'Order by', 'a-staff' ),
		"orderby_options"		=> $orderby_options->gutenberg_values(),
		"order_label"			=> __( 'Order direction', 'a-staff' ),
		"order_options"			=> $order_options->gutenberg_values(),
		"class_name_label"		=> __( 'CSS Class name', 'a-staff' ),
		"filters_panel_title"	=> __( 'Filters', 'a-staff' ),
		"ids_label"				=> __( 'Show only these Members', 'a-staff' ),
		"ids_options"			=> a_staff_get_members(),
		"exclude_label"			=> __( 'Exclude Members', 'a-staff' ),
	);

	wp_localize_script( 'a-staff-loop-block', 'A_STAFF_LOOP_BLOCK', apply_filters( 'a_staff_loop_block_strings', $a_staff_loop_block_strings ) );



	// Registering the block
	$a_staff_loop_block_attributes = array(
		"columns"		=> array(
			"type"		=> 'number',
			"default"	=> $columns_options->get_option(),
		),
		"orderby"		=> array(
			"type"		=> 'text',
			"default"	=> $orderby_options->get_option(),
		),
		"order"			=> array(
			"type"		=> 'text',
			"default"	=> $order_options->get_option(),
		),
		"class"			=> array(
			"type"		=> 'text',
		),
		"ids"			=> array(
			"type"		=> 'text',
			"default"	=> ''
		),
		"exclude"		=> array(
			"type"		=> 'text',
			"default"	=> ''
		),
	);

    register_block_type( 'a-staff/loop-block', array(
        "editor_script"		=> 'a-staff-loop-block',
		"editor_style"		=> 'a-staff-style',
		"style"				=> 'a-staff-style',
		"render_callback"	=> 'a_staff_loop_block_output',
		"attributes"		=> apply_filters( 'a_staff_loop_block_attributes', $a_staff_loop_block_attributes ),
	) );

}
add_action( 'init', 'a_staff_gutenberg_loop_block', 40 );



// Sets up the shortcode attributes
function a_staff_loop_block_output( $attributes ) {

	if ( isset( $attributes["ids"] ) && is_array( $attributes["ids"] ) && !empty( $attributes["ids"] ) ) {
		$attributes["ids"] = a_staff_prepare_multi( $attributes["ids"] );
	}

	if ( isset( $attributes["exclude"] ) && is_array( $attributes["exclude"] ) && !empty( $attributes["exclude"] ) ) {
		$attributes["exclude"] = a_staff_prepare_multi( $attributes["exclude"] );
	}

	return a_staff_shortcode( apply_filters( 'a_staff_loop_block_output_attributes', $attributes ) );

}
