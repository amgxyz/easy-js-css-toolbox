<?php
/*
* Plugin Name: Easy JS CSS Effects
* Plugin URI: http://andrewgunn.xyz
* Description: Easy CSS Effects
* Version: 1.0
* Author: Andrew M. Gunn
* Author URI: http://andrewmgunn.com
* Text Domain: easy-scroll-depth
* License: GPL2
*********
*/
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

/**
* Constants
*/
define( 'ECE_NAME', 'Easy CSS Effects' );
define( 'ECE_BASENAME', plugin_basename(__FILE__) );
define( 'ECE_URL', plugins_url( __FILE__ ) );
define( 'ECE_DIR', plugins_url( __DIR__ ));
define( 'ECE_CLASS', __CLASS__ );
define( 'ECE_VERSION', '1.0' );
define( 'ECE_TEXT_DOMAIN', 'easy-css-effects' );
define( 'ECE_SETTINGS', 'ece_settings' );
define( 'ECE_MENU', 'easy-css-effects' );
define( 'ECE_AMG', 'http://andrewgunn.xyz' );
define( 'ECE_JS', 'inc/js/' );
define( 'ECE_CSS', 'inc/css/' );

interface I_ECE_Toolbox {

}
/**
* Classes and interfaces
*/
class ECE_Toolbox {


	private $var = '';
	private $ece_settings = '';
	private $ece_init = '';

	public function __construct() {
		global $poop;
		$poop = 'hoop';

		include_once('classes/class-ece-data.php');
		include_once('classes/class-ece-settings.php');
		include_once('classes/class-ece-cpt.php');
		include_once('classes/class-ece-scripts.php');
		include_once('classes/class-ece-reset.php');
		include_once('classes/class-ece-shortcodes.php');

		register_activation_hook( __FILE__, array( $this, 'ece_flush_rewrite_rules' ));
		register_deactivation_hook( __FILE__, array( $this, 'ece_flush_rewrite_rules' ) );

		add_action( 'admin_init', array( $this, 'ece_admin_init' ) );

		add_action( 'init', array( $this, 'ece_init' ) );
		add_action( 'init', array( $this, 'ece_register_cpt' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'ece_register_includes' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'ece_register_flexslider' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'ece_register_fontawesome' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'ece_register_scrolldepth' ) );

		add_filter( 'plugin_action_links', array( $this, 'ece_settings_link' ), 10, 5 );

		$this->ece_settings = get_option( ECE_SETTINGS );
		$this->ece_init = $this->ece_settings['init'];

	}
	 public function ece_init() {
		global $poop;
		//var_dump($poop);


	}
	public function ece_admin_init() {
		$settings = $this->ece_settings;
		$init = $this->ece_init;

		if ( $settings === false || $settings == null ) {
			add_option( ECE_SETTINGS, array( 'init' => 'true' ) );
		} else {

			if ( $init === true || $init == 'true') {//( $init == 'true' || $init == true  ) {
				add_action( 'admin_notices', array( $this, 'ece_notice' ) );
				update_option( ECE_SETTINGS, array( 'init' => 'false' ) ); 
			} else {
				update_option( ECE_SETTINGS, array( 'init' => 'true' ) ); 
			}
		}
	}

	public function ece_flush_rewrite_rules() {
		flush_rewrite_rules();
	}

	public function ece_register_cpt() {
		$cpt = new ECE_Post_Type();
		$this->ece_flush_rewrite_rules();
	}

	public function ece_notice() {
		$settings = $this->ece_settings;
		$init = $this->ece_init;

		$class = 'notice notice-error';
		$message = __( 'Irks! An error has occurred.', 'sample-text-domain' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
	}

	public function ece_register_includes() {
		wp_register_script( 'admin_ece_js', plugins_url( ECE_JS . 'admin_ece.js', __FILE__ ), array('jquery'));
		wp_register_script( 'admin_ece_min_js', plugins_url( ECE_JS . 'admin_ece.min.js', __FILE__ ), array('jquery'));
		wp_register_script( 'ece_js', plugins_url( ECE_JS . 'ece.js', __FILE__ ), array('jquery'));
		wp_register_script( 'ece_min_js', plugins_url( ECE_JS . 'ece.min.js', __FILE__ ), array('jquery'));
	    
	    wp_register_style( 'admin_ece_css', plugins_url( ECE_CSS . 'admin_ece.css', __FILE__ ));
	    wp_register_style( 'admin_ece_css_min', plugins_url( ECE_CSS . 'admin_ece.min.css', __FILE__ ));
	    wp_register_style( 'ece_css', plugins_url( ECE_CSS . 'ece.css', __FILE__ ));
	    wp_register_style( 'ece_css_min', plugins_url( ECE_CSS . 'ece.min.css', __FILE__ ));
	    wp_register_style( 'ece_effects_css', plugins_url( ECE_CSS . 'ece_effects.css', __FILE__ ));	    
	    wp_register_style( 'ece_effects_min', plugins_url( ECE_CSS . 'ece_effects.min.css', __FILE__ ));
	    
	    wp_enqueue_script( 'admin_ece_js' );
	    wp_enqueue_script( 'admin_ece_min_js' );
	    wp_enqueue_script( 'ece_js' );
	    wp_enqueue_script( 'ece_min_js' );
	   
	    wp_enqueue_style( 'admin_ece_css' );
		wp_enqueue_style( 'admin_ece_css_min' );
		wp_enqueue_style( 'ece_css' );
		wp_enqueue_style( 'ece_css_min' );
		wp_enqueue_style( 'ece_effects_css' );
		wp_enqueue_style( 'ece_effects_min' );		
	}

	public function ece_register_flexslider() {
		wp_register_script( 'flexslider_js', plugins_url(  'inc/flexslider/jquery.flexslider.js', __FILE__ ), array('jquery'));
		wp_register_script( 'flexslider_min_js', plugins_url( 'inc/flexslider/jquery.flexslider-min.js', __FILE__ ), array('jquery'));
	    wp_register_style( 'flexslider_css', plugins_url( 'inc/flexslider/flexslider.css', __FILE__ ));
	    wp_register_style( 'flexslider_min_css', plugins_url( 'inc/flexslider/flexslider.min.css', __FILE__ ));
	    wp_register_style( 'flexslider_less', plugins_url( 'inc/flexslider/flexslider.less', __FILE__ ));
	    
	    wp_enqueue_script( 'flexslider_js' );
	    wp_enqueue_script( 'flexslider_min_js' );
		
		wp_enqueue_style( 'flexslider_css' );		
		wp_enqueue_style( 'flexslider_min_css' );		
		wp_enqueue_style( 'flexslider_less' );		
	}

	public function ece_register_fontawesome() {
		wp_register_style( 'fontawesome_scss', plugins_url( 'inc/fontawesome/scss/font-awesome.scss', __FILE__ ));
	    wp_register_style( 'fontawesome_css', plugins_url( 'inc/fontawesome/css/font-awesome.css', __FILE__ ));
	    wp_register_style( 'fontawesome_min_css', plugins_url( 'inc/fontawesome/css/font-awesome.min.css', __FILE__ ));
		
		wp_enqueue_style( 'fontawesome_scss' );
		wp_enqueue_style( 'fontawesome_css' );		
		wp_enqueue_style( 'fontawesome_min_css' );
	}

	public function ece_register_scrolldepth() {
		wp_register_script( 'scrolldepth_js', plugins_url(  'inc/scrolldepth/jquery.scrolldepth.js', __FILE__ ), array('jquery'));
		wp_register_script( 'scrolldepth_min_js', plugins_url( 'inc/scrolldepth/jquery.scrolldepth.min.js', __FILE__ ), array('jquery'));
	    
	    wp_enqueue_script( 'scrolldepth_js' );
	    wp_enqueue_script( 'scrolldepth_min_js' );
	}

	public function ece_settings_link( $actions, $plugin_file ) {
		static $plugin;

		if ( !isset( $plugin ) ) {
			$plugin = plugin_basename(__FILE__);

			if ($plugin == $plugin_file) {

				$settings = array(
							'settings' => '<a href="tools.php?page='.ECE_MENU.'">' . __('Settings', 'General') . '</a>',
							'support' => '<a target="_blank" href="'.ECE_AMG.'">' . __('Support', 'General') . '</a>'
							);
	    			$actions = array_merge($settings, $actions);
			}

			return $actions;
		}
	}

}

$ece = new ECE_Toolbox();
//$ece->ece_init();