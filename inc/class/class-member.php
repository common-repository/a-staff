<?php
// a-staff Member class


class A_STAFF_Member {


	// Set up initial values
	function __construct( $id = 0 ) {

		$this->post = get_post( $id );
		$this->id = $id;

	}



	// Get the member ID
	function get_id() {

		return $this->id;

	}


	// Get the member's name (same as the post title)
	function get_name() {

		if ( $this->id == 0 ) {
			return __( '(empty item)', 'a-staff' );
		}

		return $this->post->post_title;

	}


	// Get the member's name (same as the post tutle)
	function get_excerpt() {

		// No excerpt if this is an empty member object
		if ( $this->id == 0 ) {
			return;
		}

		if ( tpl_get_option( 'a_staff_format_bio' ) == true ) {

			if ( has_excerpt( $this->id ) ) {
				$excerpt = nl2br( get_the_excerpt( $this->id ) );
			}
			else {
				$excerpt = $this->post->post_content;
			}


			$excerpt = a_staff_trim_excerpt( $excerpt, tpl_get_option( 'a_staff_bio_length' ) );

		}

		else {

			global $post;
			$post = get_post( $this->id, OBJECT );
			setup_postdata( $post );

			$excerpt = get_the_excerpt( $this->id );

			wp_reset_postdata();

		}

		return $excerpt;

	}


	// Get the full description
	function get_full_description() {

		return $this->post->post_content;

	}


	// Get the member titles
	function get_titles() {

		return wp_get_post_terms( $this->id, 'a-staff-member-titles' );

	}


	// List the member titles
	function list_titles() {

		$titles		= $this->get_titles();
		$output	= '';

		foreach ( $titles as $i => $title ) {

			if ( $i > 0 ) {
				$output .=', ';
			}

			$output .= $title->name;

		}

		return $output;

	}


	// Get the member's social icons
	function get_social_icons( $formatted = true ) {

		// Get the social networks setup from the Plugin Settings page
		$social_networks = tpl_get_option( 'a_staff_social_networks' );
		$icons = array();

		// Do it only if any social network is found
		if ( !empty( $social_networks[0] ) ) {

			foreach ( $social_networks as $key => $network ) {

				$sname = sanitize_title( $network["network_name"] );
				$field_name = 'a_staff_member_social_' . $sname;
				$network_url = tpl_get_option( $field_name, $this->id );

				if ( $network_url != '' ) {

					if ( tpl_get_option( 'a_staff_social_target' ) == 'new' ) {
						$newtab = true;
					}
					else {
						$newtab = false;
					}

					$icon_args = array(
						"name"		=> 'a_staff_social_networks/' . $key . '/network_icon',
						"size"		=> esc_attr( tpl_get_option( 'a_staff_social_icon_size' ) ),
						"url"		=> esc_url( $network_url ),
						"newtab"	=> $newtab,
						"title"		=> esc_attr( $network["network_name"] ),
						"class"		=> 'fa-fw',
					);

					if ( tpl_get_option( 'a_staff_icon_colors' ) == true ) {
						$icon_args["color"] = tpl_get_option( 'a_staff_social_networks/' . $key . '/icon_color' );
					}

					if ( $icon_args["size"] == 'n' ) {
						$icon_args["size"] = '';
					}

					// We use TPL Framework's inner tool to format the icon with the $args above
					$icons[$sname] = tpl_get_value( $icon_args );

				}

			}

		}

		return $icons;

	}


	// List the social icons for the member
	function list_social_icons( $without_ul = false ) {

		$socicons	= $this->get_social_icons();
		$output		= '';

		if ( !empty( $socicons ) ) {

			if ( !$without_ul ) {
				$output .= '<ul class="a-staff-member-social">';
			}

			foreach ( $socicons as $icon ) {
				$output .= '<li>' . $icon . '</li>';
			}

			if ( !$without_ul ) {
				$output .= '</ul>';
			}

		}

		return $output;

	}


	// Gets the member's single page URL
	function get_url() {

		return get_the_permalink( $this->id );

	}


	// Gets the member's image
	function get_image_url( $single = false ) {

		$thumb_id	= get_post_thumbnail_id( $this->id );

		// Jump out early with default image if entity not found
		if ( $thumb_id == '' || $this->id == 0 ) {
			return A_STAFF_BASE_URL . 'assets/avatar.png';
		}

		// Single and box templates can have different sizes
		if ( $single == false ) {
			$image_size	= tpl_get_option( 'a_staff_image_size' );
		}
		else {
			$image_size	= tpl_get_option( 'a_staff_single_image_size' );
		}

		$thumb_url_array = wp_get_attachment_image_src( $thumb_id, $image_size, true );
		$thumb_url = $thumb_url_array[0];

		return $thumb_url;

	}


	// Get the member's phone number
	function get_phone() {

		$phone = tpl_get_value( 'a_staff_member_phone', $this->id );

		if ( $phone != '' ) {
			$phone = '<i class="fa fa-fw fa-phone ' . esc_attr( tpl_get_option( 'a_staff_social_icon_size' ) ) . '"></i> ' . $phone;
		}

		return apply_filters( 'a_staff_member_phone', $phone );

	}


	// Gets the member box output
	function get_box( $click_action = 'single' ) {

		$member = $this;

		// Use the lagacy template?
		if ( tpl_get_value( 'a_staff_use_legacy_template' ) == true ) {

			$template = tpl_kses( tpl_get_option( 'a_staff_box_template' ) );

			// Register the shorttags in the template
			$shorttags = array(
				0	=> '{MEMBER_NAME}',
				1	=> '{MEMBER_EXCERPT}',
				2	=> '{MEMBER_TITLE}',
				3	=> '{MEMBER_SOCICONS}',
				4	=> '{MEMBER_URL}',
				5	=> '{MEMBER_IMAGE}',
				6	=> '{MEMBER_PHONE}',
			);

			// The shorttags will be changed to these values
			$values = array(
				0	=> esc_html( $member->get_name() ),
				1	=> tpl_kses( $member->get_excerpt() ),
				2	=> esc_html( $member->list_titles() ),
				3	=> $member->list_social_icons( true ),
				4	=> esc_url( $member->get_url() ),
				5	=> esc_url( $member->get_image_url() ),
				6	=> esc_html( $member->get_phone() ),
			);

			// Here we do the string replacements
			return str_replace( $shorttags, $values, $template );

		}


		// Otherwise use the normal (new) method
		$click_action =  tpl_get_option( 'a_staff_tile_click_action' ) ;

		ob_start();
		include a_staff_get_template_hierarchy( 'member-box.php' );
		$output = ob_get_contents();
		ob_end_clean();

		return $output;

	}


}
