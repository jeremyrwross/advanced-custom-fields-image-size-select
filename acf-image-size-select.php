<?php

/*
Plugin Name: Advanced Custom Fields: Image Size Select
Plugin URI: https://jereross.com/acf-image-size-select/
Description: Field to select registered image sizes within the WordPress dashboard.
Version: 1.0.3
Author: Jeremy Ross
Author URI: https://jereross.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// check if class already exists
if ( ! class_exists( 'AcfPluginImageSizeSelect' ) ) {

	class AcfPluginImageSizeSelect {

		var $settings;

		function __construct() {

			$this->settings = array(
				'version'	=> '1.0.3',
				'url'		=> plugin_dir_url( __FILE__ ),
				'path'		=> plugin_dir_path( __FILE__ ),
			);

			// include field
			add_action( 'acf/include_field_types', 	array( $this, 'include_field' ) ); // v5
		}


		/*
		*  include_field
		*
		*  This function will include the field type class
		*/

		function include_field() {

			include_once( 'fields/class-acf-field-image-size-select.php' );
		}
	}

	new AcfPluginImageSizeSelect();

}
