<?php
// Template: Single team member page structure
// Since 1.2



// Setting up the Staff Member object
global $post;
$member = a_staff_get_member( $post->ID );



// Here is the possibility to hook in default theme opening tags
do_action( 'a_staff_before_main_content', $member );


if ( has_post_thumbnail() ) { ?>
	<div class="a-staff-single-thumbnail alignleft">
		<img src="<?php echo $member->get_image_url( true ); ?>" alt="<?php printf( __( 'Photo of %s', 'a-staff' ), $member->get_name() ); ?>">
	</div>
<?php }


// Do this before the member name
do_action( 'a_staff_before_single_name', $member );

?>
<h1 class="entry-title a-staff-single-member-name"><?php echo $member->get_name(); ?></h1>
<?php


// Do this after the member name
do_action( 'a_staff_after_single_name', $member );


?>
<p class="a-staff-single-member-titles">
	<?php echo $member->list_titles(); ?>
</p>
<?php


// The opening markup before the content
do_action( 'a_staff_before_inner_content', $member );

?>
<div class="a-staff-single-description">
	<?php echo wpautop( $member->get_full_description() ); ?>
</div>
<?php

// The closing markup after the content
do_action( 'a_staff_after_inner_content', $member );


// Optionally show phone numbers - if enabled
if ( tpl_get_option( 'a_staff_enable_phone_numbers' ) ) { ?>
	<p class="a-staff-member-phone">
		<?php echo $member->get_phone(); ?>
	</p>
<?php }


if ( !empty( $member->get_social_icons() ) ) { ?>
<div class="a-staff-single-social-icons">
	<?php echo $member->list_social_icons(); ?>
</div>
<?php }



// Here is the possibility to hook in default theme closing tags
do_action( 'a_staff_after_main_content', $member );
