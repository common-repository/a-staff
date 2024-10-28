<?php
// Template: Team member box used by the shortcode
// Since 1.2


?>
<div class="a-staff-member-box-wrapper">

	<div class="a-staff-member-box">

		<?php if ( $click_action == 'single' ) { ?><a href="<?php echo $member->get_url(); ?>"><?php } ?>

			<img class="a-staff-member-image" src="<?php echo $member->get_image_url(); ?>" alt="<?php printf( __( 'Photo of %s', 'a-staff' ), $member->get_name() ); ?>">

		<?php if ( $click_action == 'single' ) { ?></a><?php } ?>

		<h3 class="a-staff-member-name">
			<?php if ( $click_action == 'single' ) { ?><a href="<?php echo $member->get_url(); ?>"><?php } ?>
				<?php echo $member->get_name(); ?>
			<?php if ( $click_action == 'single' ) { ?></a><?php } ?>
		</h3>

		<p class="a-staff-member-title">
			<?php echo $member->list_titles(); ?>
		</p>

		<p class="a-staff-member-bio">
			<?php echo $member->get_excerpt(); ?>
		</p>

		<?php if ( tpl_get_option( 'a_staff_enable_phone_numbers' ) ) { ?>
			<p class="a-staff-member-phone">
				<?php echo $member->get_phone(); ?>
			</p>
		<?php } ?>

		<?php echo $member->list_social_icons(); ?>

	</div>

</div>
