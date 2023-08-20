<?php

/*
 * Plugin Name:       My Test Plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Atikul Islam
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-test-plugin
 * Domain Path:       /languages
 */

/*================
 Activation hook
==================*/

function my_test_plugin_activate() { 

	global $wpdb;

	$student_table = $wpdb->prefix . 'student_list';

	$teacher_table = $wpdb->prefix . 'teacher_list';

    if ($wpdb->get_var("SHOW TABLES LIKE '$student_table'") != $student_table) {
        
		$student = "CREATE TABLE $student_table (
			id INT NOT NULL AUTO_INCREMENT,
			name VARCHAR(255) NOT NULL,
			class VARCHAR(255) NOT NULL,
			age INTEGER(3),
			PRIMARY KEY (id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($student);
    }


	if ($wpdb->get_var("SHOW TABLES LIKE '$teacher_table'") != $teacher_table) {

		$teacher = "CREATE TABLE $teacher_table (
			id INT NOT NULL AUTO_INCREMENT,
			tname VARCHAR(255) NOT NULL,
			department VARCHAR(255) NOT NULL,
			tage INTEGER(3),
			PRIMARY KEY (id)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($teacher);

	}

}
register_activation_hook( __FILE__, 'my_test_plugin_activate');

/*=================
 Deactivation hook
===================*/

function my_test_plugin_deactivate() {
	
	global $wpdb;

	$student_table = $wpdb->prefix . 'student_list';

	$teacher_table = $wpdb->prefix . 'teacher_list';

	$wpdb->query( "DROP TABLE IF EXISTS $student_table, $teacher_table" );
}
register_deactivation_hook( __FILE__, 'my_test_plugin_deactivate' );

/*==============
 Menu Page
================*/

function custom_menu_page(){
	add_menu_page(
		'Custom Menu Page',
		'Custom Menu',
		'manage_options',
		'custom-menu',
		'custom_menu_callback',
		'dashicons-admin-generic',
		30
	);
	add_submenu_page( 'custom-menu', 'Custom Menu Subpage', 'Custom Submenu', 'manage_options', 'custom-submenu', 'custom_submenu_callback' );
}
add_action('admin_menu', 'custom_menu_page');

function custom_menu_callback(){
	include('inc/welcome.php');
}
function custom_submenu_callback(){
	echo "hi";
}

/*==============
 Enqueue Script
================*/

function my_enqueue($hook) {

	if ($hook == 'toplevel_page_custom-menu') {

		wp_enqueue_style('bootstrap', plugins_url( '/css/bootstrap.min.css', __FILE__ ));

	}
	

    $current_screen = get_current_screen();

    if ($current_screen->id == 'custom-menu_page_custom-submenu') {
        wp_enqueue_style('bootstrap', plugins_url( '/css/bootstrap.min.css', __FILE__ ));
    }



	wp_enqueue_script('jquery');


}
add_action( 'admin_enqueue_scripts', 'my_enqueue' );







function loadAdminSetings(){
    
    wp_enqueue_script('ajax-script', plugins_url( '/js/script.js', __FILE__ ), array('jquery'), null, false);
    wp_localize_script(
        'ajax-script',
        'ajax_object',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'author' => 'Atikul Islam',
            'serverTime' => date('Y-m-d h:i:s'),
        )
    );

}
add_action('admin_init', 'loadAdminSetings');


/*==============
 Ajax handler
================*/

function my_ajax_data_handler() {

	global $wpdb;
	$student_table = $wpdb->prefix . 'student_list';

	$name_sanitize = sanitize_text_field( $_POST['name'] );
	$class_sanitize = sanitize_text_field( $_POST['class'] );
	$age_sanitize = sanitize_text_field( $_POST['age'] );

	$success =  $wpdb->insert(
		$student_table,
		array(
			'name' => $name_sanitize,
			'class' => $class_sanitize,
			'age' => $age_sanitize,
		),
		array(
			'%s',
			'%s',
			'%d',
		)
	);
	wp_send_json(['success' => true, 'id' => $wpdb->insert_id]);
	wp_die();
}
add_action('wp_ajax_stored-value', 'my_ajax_data_handler');


function ajax_data_handler_teacher() {

	global $wpdb;
	$teacher_table = $wpdb->prefix . 'teacher_list';
	
	$success_teacher =  $wpdb->insert(
		$teacher_table,
		array(
			'name' => $_POST['tname'],
			'department' => $_POST['department'],
			'age' => $_POST['tage'],
		),
		array(
			'%s',
			'%s',
			'%d',
		)
	);
	wp_send_json(['success_teacher' => true, 'id' => $wpdb->insert_id]);
	wp_die();
}
add_action('wp_ajax_stored-value-teacher', 'ajax_data_handler_teacher');


