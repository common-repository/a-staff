<?php
// Initial settings for the a-staff plugin



// The minimum required Themple Framework version to use with this plugin. It's needed to ensure the plugin is compatible with the theme
define( 'A_STAFF_REQ_TPL_VERSION', '1.3.2' );



// Themple Lite Purgatory
global $tpl_load_version;
$a_staff_tpl_version = array(
	"name"		=> 'a-staff',
	"version"	=> '1.3.2',
);
if ( !is_array( $tpl_load_version ) ) {
	$tpl_load_version = $a_staff_tpl_version;
}
else {
	if ( version_compare( $tpl_load_version["version"], $a_staff_tpl_version["version"] ) < 0 ) {
		$tpl_load_version = $a_staff_tpl_version;
	}
}



// The initializer function
function a_staff_init() {

	global $tpl_load_version, $a_staff_tpl_version;

	// If we use a non-Themple-based theme, go with the plugin's built-in Themple Lite version
	if ( $tpl_load_version["name"] == $a_staff_tpl_version["name"] ) {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . "framework/tpl-fw.php";

		// Load the framework's l10n files in this case
		$mo_filename = plugin_dir_path( dirname( __FILE__ ) ) . 'framework/languages/' . get_locale() . '.mo';
		if ( is_admin() && file_exists( $mo_filename ) ) {
			load_textdomain( 'tpl', $mo_filename );
		}

	}

}
add_action( 'after_setup_theme', 'a_staff_init' );



// This function is needed for interpreting the Settings page settings.
function a_staff_settings () {

	tpl_settings_page( 'a_staff_settings');

}



// Adding subpages to the a-staff menu
function a_staff_add_admin_pages() {

	// Settings sub-page
	add_submenu_page(
		'a_staff_settings',
		__( 'a-staff Settings', 'wpsub' ),
		__( 'Settings', 'wpsub' ),
        'manage_options',
        'a_staff_settings',
        ''
    );

	// Support page
	add_submenu_page(
		'a_staff_settings',
		__( 'a-staff Support', 'wpsub' ),
		__( 'Support', 'wpsub' ),
		'manage_options',
		'a_staff_support',
		'a_staff_support'
	);

}
add_action( 'admin_menu', 'a_staff_add_admin_pages', 99 );



// Add the default image size for the plugin
add_filter( 'tpl_image_sizes', 'a_staff_image_sizes', 10, 1 );

function a_staff_image_sizes( $image_sizes = array() ) {

	// The post thumbnail in sidebar view
	$image_sizes["a-staff-default"] = array(
		'title'		=> __( 'a-staff Default', 'a-staff' ),
		'width'		=> 480,
		'height'	=> 480,
		'crop'		=> array( 'center', 'top' ),
		'select'	=> true,
	);

	return $image_sizes;

}



// Load the plugin's front end CSS if it's enabled in admin
add_action( 'wp_enqueue_scripts', function() {

	if ( tpl_get_option( 'a_staff_load_css' ) == true ) {

		wp_enqueue_style( 'a-staff-style', plugins_url( 'assets/a-staff.min.css', dirname( __FILE__ ) ), array(), A_STAFF_VERSION );

		// Add some responsive code if it was enabled in plugin settings
		if ( tpl_get_option( 'a_staff_responsive' ) == true ) {

			$custom_css = '@media (max-width: ' . tpl_get_value( 'a_staff_responsive_breakpoints/0/breakpoint_1' ) . ') {
				.a-staff-cols-5 .a-staff-member-box-wrapper, .a-staff-cols-6 .a-staff-member-box-wrapper { width: 33.3333%; }
			}
			@media (max-width: ' . tpl_get_value( 'a_staff_responsive_breakpoints/0/breakpoint_2' ) . ') {
				.a-staff-cols-3 .a-staff-member-box-wrapper, .a-staff-cols-4 .a-staff-member-box-wrapper, .a-staff-cols-5 .a-staff-member-box-wrapper, .a-staff-cols-6 .a-staff-member-box-wrapper { width: 50%; }
			}
			@media (max-width: ' . tpl_get_value( 'a_staff_responsive_breakpoints/0/breakpoint_3' ) . ') {
				.a-staff-cols-2 .a-staff-member-box-wrapper, .a-staff-cols-3 .a-staff-member-box-wrapper, .a-staff-cols-4 .a-staff-member-box-wrapper, .a-staff-cols-5 .a-staff-member-box-wrapper, .a-staff-cols-6 .a-staff-member-box-wrapper { width: 100%; }
			}';
			wp_add_inline_style( 'a-staff-style', esc_html( $custom_css ) );

		}

	}

} );



// Add some styles for the admin page
function a_staff_admin_style() {
	echo '<style>
		.a-staff-support-list { margin-left: 20px; }
		.a-staff-support-list a { text-decoration: none; }
  		.a-staff-support-list img { vertical-align: bottom; }
	</style>';
}
add_action( 'admin_head', 'a_staff_admin_style' );



// Rewrite rules update to avoid 404 errors
function a_staff_flush_rewrites() {

	a_staff_cpt();
	flush_rewrite_rules();

}



// Set the initial value for using legacy templates based on their previous value
function a_staff_detect_modified_legacy_template() {
	global $tpl_options_array;

	if ( tpl_get_option( 'a_staff_use_legacy_template' ) == true ) {
		return true;
	}

	$a_staff_saved_options = get_option( 'a_staff_settings' );

	// Neutralising both strings to avoid inequalities because of whitespaces
	if ( isset( $a_staff_saved_options["a_staff_box_template"][0] ) ) {
		$saved_template = preg_replace( '/\s+/', '', $a_staff_saved_options["a_staff_box_template"][0] );
	}
	else {
		$saved_template = '';
	}

	$default_template = preg_replace( '/\s+/', '', $tpl_options_array["a_staff_box_template"]->get_default() );

	// If the saved version is different from the default one, but not empty, then save the enabler as true
	if ( $saved_template != $default_template && $saved_template != '' ) {

		if ( !isset( $a_staff_saved_options["a_staff_use_legacy_template"][0] ) ) {
			$a_staff_saved_options["a_staff_use_legacy_template"][0] = '1';
			update_option( 'a_staff_settings', $a_staff_saved_options );
		}

		return true;

	}

	else {

		return false;

	}

}
add_action( 'init', 'a_staff_detect_modified_legacy_template', 50 );



// Show warning that new templating logic is added to the plugin
add_action( 'admin_init', function() {

	if ( version_compare( A_STAFF_VERSION, '1.1.1' ) > 0 && a_staff_detect_modified_legacy_template() ) {
		tpl_error ( __( 'From a-staff v1.2 we are using a new, advanced templating system for displaying staff members. While your old templates will still be usable until the release of v1.5, it\'s strongly recommended that you switch to the new template types as soon as possible. <a href="https://a-idea.studio/a-staff/documentation/templates" target="_blank">Read more in this article</a>', 'a-staff' ), true, 'warning', 'a-staff' );
	}

} );



// Runs when the uninstall hook is called
function a_staff_uninstall() {

	// Do the delete process only if we chose it in a-staff Settings
	$a_staff_settings = get_option( 'a_staff_settings' );


	if ( $a_staff_settings["a_staff_delete_data"][0] == true || $a_staff_settings["a_staff_delete_data"][0] == 'yes' || $a_staff_settings == false ) {


		// Delete the posts and the metadata connected to the posts
		$args = array (
			'post_type'             => array( 'a-staff' ),
			'posts_per_page'        => '-1',
			'post_status'			=> array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash' ),
		);

		$a_staff_posts = new WP_Query( $args );


		// Run a loop through all posts added by the plugin and do the hard delete command
		$relationships_posts = array();

		if ( $a_staff_posts->have_posts() ) {
			while ( $a_staff_posts->have_posts() ) {
				$a_staff_posts->the_post();

				$relationships_posts[] = get_the_ID();
				wp_delete_post( get_the_ID(), true );
			}
		}


		// Delete the taxonomy terms associated with the Member Titles taxonomy
		global $wpdb;

		$terms = $wpdb->get_results( $wpdb->prepare( "SELECT t.*, tt.* FROM $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy IN ('%s') ORDER BY t.name ASC", 'a-staff-member-titles' ) );

		// Delete Terms
		if ( $terms ) {
			foreach ( $terms as $term ) {
				$wpdb->delete( $wpdb->term_taxonomy, array( 'term_taxonomy_id' => $term->term_taxonomy_id ) );
				$wpdb->delete( $wpdb->terms, array( 'term_id' => $term->term_id ) );
			}
		}

		if ( $relationships_posts ) {
			foreach ( $relationships_posts as $r_post ) {
				$wpdb->delete( $wpdb->term_relationships, array( 'object_id' => $r_post ) );
			}
		}

		// Delete Taxonomy
		$wpdb->delete( $wpdb->term_taxonomy, array( 'taxonomy' => 'a-staff-member-titles' ), array( '%s' ) );


		// Delete the central plugin settings
		delete_option( 'a_staff_settings' );
		delete_option( 'a-staff-member-titles_children' );

		// Here you can hook your own uninstall processes into this uninstall hook
		do_action( 'a_staff_uninstall', $relationships_posts );

	}

}
