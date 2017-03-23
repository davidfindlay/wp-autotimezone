<?php

/*
Plugin Name: Autotimezone
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 0.1
Author: David Findlay
Author URI: http://www.davidfindlay.com.au
License: GPL2
*/

class AutoTimeZone {

	private static $instance = 0;

	public function __construct() {

		$output = "<script>var dfAtzUtcString = [];</script>\n";

		add_action( 'wp_enqueue_scripts', array($this, 'wporg_init') );
		add_shortcode( 'autotimezone', array($this, 'wporg_shortcode') );

		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

		return $output;

	}

	public function admin_menu() {

		$hook = add_management_page( 'Auto Timezone Configuration', 'Auto Timezone', 'install_plugins', 'dfatz', array( $this, 'admin_page' ), '' );
		add_action( "load-$hook", array( $this, 'admin_page_load' ) );

	}

	public function admin_page() {

		return;

	}

	public function wporg_init() {

		wp_enqueue_script( 'script', plugin_dir_url( __FILE__ ) . '/autotimezone.js', array ( 'jquery' ), 1.1, true);

	}

	function wporg_shortcode( $atts = [], $content = null, $tag = '' ) {

		// Normalise attribute case to lowercase
		$atts = array_change_key_case( (array) $atts, CASE_LOWER );

		// override default attributes with user attributes
		$wporg_atts = shortcode_atts( [
			'datetime' => 'now',
		], $atts, $tag );

		$sourceDateTime = $wporg_atts['datetime'];

		$gmtoffset = get_option( 'gmt_offset' );

		$sourceDT = new DateTime( $sourceDateTime );
		$sourceDT->sub( new DateInterval( 'PT' . $gmtoffset . 'H' ) );

		$utcString = $sourceDT->format( "Y-m-d h:i:s" );

		// do something to $content

		//$output = "<script>var dfAtzUtcString[" . self::$instance . "] = \"" . $utcString . "\";</script>";

		$output = "<span class=\"dfAtzString\" id=\"dfAtzString_" . self::$instance . "\">$utcString</span>\n";

		self::$instance++;

		// always return
		return $output;

	}

}

$dfAutoTimezone = new AutoTimeZone();