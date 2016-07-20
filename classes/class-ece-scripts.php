<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

interface I_ECE_Script_Handler {

}

class ECE_Script_Handler {
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
	public function ece_scripts() { ?>

		    <script type="text/javascript">
		        
		        //jQuery(document).ready(function($) {
		        jQuery(document).ready(function($){
		        	$('.flexslider').flexslider();/*{
				        animation: "slide",
				        animationLoop: false,
				        itemWidth: 210,
				        itemMargin: 5,
				        pausePlay: true,
				        start: function(slider){
				          $('body').removeClass('loading');
				        }
			      	});*/

				});

			</script>


	<?php }

	public function ece_styles() {  ?>

		    <style type="text/css">
		        
		       

			</style>


	<?php }
}
$esh = new ECE_Script_Handler();