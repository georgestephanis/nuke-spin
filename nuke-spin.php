<?php
/*
 * Plugin Name: Nuke Spin
 * Plugin URI: http://github.com/georgestephanis/nuke-spin/
 * Description: This plugin temporarily disables Jetpack's spinner script due to a conflict with MooTools.
 * Author: George Stephanis
 * Version: 1.0
 * Author URI: http://stephanis.info
 */

add_action( 'wp_loaded', 'nuke_spin', 11 );
function nuke_spin() {
	wp_deregister_script( 'jquery.spin' );
	wp_deregister_script( 'spin' );
}

add_action( 'admin_bar_menu', 'nuke_spin_deactivate_reminder' );
function nuke_spin_deactivate_reminder( $wp_admin_bar ) {
	if( ! current_user_can( 'activate_plugins' ) )
		return;

	$plugin_file = plugin_basename( __FILE__ );
	$query_args = array(
		'action'        => 'deactivate',
		'plugin'        => $plugin_file,
	);
	$wp_admin_bar->add_node( array(
		'id'     => 'nuke-spin-deactivate-reminder',
		'title'  => __('Re-enable Jetpack Spin', 'nuke_spin'),
		'href'   => wp_nonce_url( add_query_arg( $query_args, admin_url( 'plugins.php' ) ), "deactivate-plugin_{$plugin_file}" ),
		'parent' => 'top-secondary',
	) );
}

add_action( 'admin_head', 'nuke_spin_deactivate_reminder_style' );
add_action( 'wp_head', 'nuke_spin_deactivate_reminder_style' );
function nuke_spin_deactivate_reminder_style() {
	if( ! current_user_can( 'activate_plugins' ) )
		return;

	echo '<style>#wpadminbar #wp-admin-bar-nuke-spin-deactivate-reminder a{background:#a00}</style>';
}
