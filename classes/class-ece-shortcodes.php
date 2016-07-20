<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

interface I_ECE_Shortcodes {

}

class ECE_Shortcodes {
/**
* Enqueue scripts
*/
	private $ece_settings = '';


	public function __construct() {

		global $poop;

		add_action('wp_footer', array( $this,'ece_scripts' ),5 );
		//add_action('wp_footer', array( $this,'ece_styles' ),5 );

		//var_dump($poop);
	}
	public function ece_shortcodes() {

	}
}
$esh = new ECE_Shortcodes();