<?php
/**
 * Plugin Name: Specification BenignSource
 * Plugin URI: http://www.benignsource.com/
 * Description: Make Your WooCommerce Shop Professional Look, Full Specification Product, Delivery & Returns Policy
 * Author: BenignSource
 * Author URI: http://www.benignsource.com/
 * Version: 1.0
 * Tested up to: 5.9
 */

defined( 'ABSPATH' ) or exit;

// Check if WooCommerce is active and bail if it's not
if ( ! WooCommerceSpecificationProduct::is_woocommerce_active() ) {
	return;
}

class WooCommerceSpecificationProduct {

	private $tab_data = false;
	

	/** plugin version number */
	const VERSION = '1.0';

	/** @var WooCommerceSpecificationProduct single instance of this plugin */
	protected static $instance;
	

	/** plugin version name */
	const VERSION_OPTION_NAME = 'woocommerce_bsspecification_db_version';


	/*
	 * WooCommerce is known to be active and initialized
	 */
	public function __construct() {
		// Installation
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) $this->install();

		add_action( 'init',             array( $this, 'load_translation' ) );
		add_action( 'woocommerce_init', array( $this, 'init' ) );
	}


	/**
	 * Cloning instances is forbidden due to singleton pattern.
	 */
	public function __clone() {

		/* translators: Placeholders: %s - plugin name */
		_doing_it_wrong( __FUNCTION__, sprintf( esc_html__( 'You cannot clone instances of %s.', 'specification-benignsource' ), 'Specification BenignSource' ), '1.0' );
	}


	/*
	 * Unserializing instances is forbidden due to singleton pattern.
	 */
	public function __wakeup() {

		/* translators: Placeholders: %s - plugin name */
		_doing_it_wrong( __FUNCTION__, sprintf( esc_html__( 'You cannot unserialize instances of %s.', 'specification-benignsource' ), 'Specification BenignSource' ), '1.0' );
	}



	/**
	 * Init WooCommerce Specification Product extension once we know WooCommerce is active
	 */
	public function init() {
		// backend stuff
		add_action( 'woocommerce_product_write_panel_tabs', array( $this, 'product_write_panel_tab' ) );
		add_action( 'woocommerce_product_write_panels',     array( $this, 'product_write_panel' ) );
		add_action( 'woocommerce_process_product_meta',     array( $this, 'product_save_data' ), 10, 2 );
		

		// frontend stuff
		add_filter( 'woocommerce_product_tabs', array( $this, 'add_custom_product_tabs' ) );
       
		
	}

	/*
	 * Add the specification product
	 */
	
	public function add_custom_product_tabs( $tabs ) {
		global $product;

		if ( $this->product_has_specification( $product ) ) {
			foreach ( $this->tab_data as $tab ) {
				$tab_title = __( $tab['title'], 'woocommerce-specification-product' );
				$tabs[ $tab['id'] ] = array(
					'title'    => apply_filters( 'woocommerce_custom_product_tab_title', $tab_title, $product, $this ),
					'priority' => 25,
					'callback' => array( $this, 'specification_product_panel_manufacture' ),
					'manufacture'  => $tab['manufacture'],
					'selectone'  => $tab['selectone'],
					'selectonein'  => $tab['selectonein'],
					'selecttwo'  => $tab['selecttwo'],
					'selecttwoin'  => $tab['selecttwoin'],
					'selectthree'  => $tab['selectthree'],
					'selectthreein'  => $tab['selectthreein'],
					'selectfour'  => $tab['selectfour'],
					'selectfourin'  => $tab['selectfourin'],
					'selectfive'  => $tab['selectfive'],
					'selectfivein'  => $tab['selectfivein'],
					'selectsix'  => $tab['selectsix'],
					'selectsixin'  => $tab['selectsixin'],
					'selectseven'  => $tab['selectseven'],
					'selectsevenin'  => $tab['selectsevenin'],
					'selecteight'  => $tab['selecteight'],
					'selecteightin'  => $tab['selecteightin'],
					'dimensions'  => $tab['dimensions'],
					'weight'  => $tab['weight'],
					'warranty'  => $tab['warranty'],
					'features'  => $tab['features'],
		
					
				);
			}
		}

		return $tabs;
	}



	/**
	 * Render the specification product panel
	 */
	public function specification_product_panel_manufacture( $key, $tab ) {

		// allow shortcodes to function
		$features = apply_filters( 'the_features', $tab['features'] );
		$features = str_replace( ']]>', ']]&gt;', $features );
       
	   
		echo apply_filters( 'woocommerce_specification_product_benign_heading', '<div style="padding:10px; border-bottom:3px #433a3b solid;"><h2><i>' . $tab['title'] . '</i></h2></div>', $tab );
		
		
		if ($tab['manufacture']){
		echo apply_filters( 'woocommerce_specification_product_benign_manufacture','<div style="width:100%;display: inline-block;"><div style=" width:20%;display: inline-block;background: #edebeb; padding:5px; border-right:1px #CCCCCC solid;">Manufacture:</div><div style="display: inline-block;padding:5px;border-bottom:1px #CCCCCC solid; width:80%; border-right:1px #CCCCCC solid;">' . $tab['manufacture'] .'</div></div>' , $tab );
		}
		if ($tab['selectonein']){
		echo apply_filters( 'woocommerce_specification_product_benign_selectone','<div style="width:100%;display: inline-block;"><div style=" width:20%;display: inline-block;background: #edebeb; padding:5px; border-right:1px #CCCCCC solid;">' . $tab['selectone'] .':</div><div style="display: inline-block;padding:5px;border-bottom:1px #CCCCCC solid; width:80%; border-right:1px #CCCCCC solid;">' . $tab['selectonein'] .'</div></div>' , $tab );
		}
		if ($tab['selecttwoin']){
		echo apply_filters( 'woocommerce_specification_product_benign_selecttwo','<div style="width:100%;display: inline-block;"><div style=" width:20%;display: inline-block;background: #edebeb; padding:5px; border-right:1px #CCCCCC solid;">' . $tab['selecttwo'] .':</div><div style="display: inline-block;padding:5px;border-bottom:1px #CCCCCC solid; width:80%; border-right:1px #CCCCCC solid;">' . $tab['selecttwoin'] .'</div></div>' , $tab );
		}
		if ($tab['selectthreein']){
		echo apply_filters( 'woocommerce_specification_product_benign_selectthree','<div style="width:100%;display: inline-block;"><div style=" width:20%;display: inline-block;background: #edebeb; padding:5px; border-right:1px #CCCCCC solid;">' . $tab['selectthree'] .':</div><div style="display: inline-block;padding:5px;border-bottom:1px #CCCCCC solid; width:80%; border-right:1px #CCCCCC solid;">' . $tab['selectthreein'] .'</div></div>' , $tab );
		}
		if ($tab['selectfourin']){
		echo apply_filters( 'woocommerce_specification_product_benign_selectfour','<div style="width:100%;display: inline-block;"><div style=" width:20%;display: inline-block;background: #edebeb; padding:5px; border-right:1px #CCCCCC solid;">' . $tab['selectfour'] .':</div><div style="display: inline-block;padding:5px;border-bottom:1px #CCCCCC solid; width:80%; border-right:1px #CCCCCC solid;">' . $tab['selectfourin'] .'</div></div>' , $tab );
		}
		if ($tab['selectfivein']){
		echo apply_filters( 'woocommerce_specification_product_benign_selectfive','<div style="width:100%;display: inline-block;"><div style=" width:20%;display: inline-block;background: #edebeb; padding:5px; border-right:1px #CCCCCC solid;">' . $tab['selectfive'] .':</div><div style="display: inline-block;padding:5px;border-bottom:1px #CCCCCC solid; width:80%; border-right:1px #CCCCCC solid;">' . $tab['selectfivein'] .'</div></div>' , $tab );
		}
		if ($tab['selectsixin']){
		echo apply_filters( 'woocommerce_specification_product_benign_selectsix','<div style="width:100%;display: inline-block;"><div style=" width:20%;display: inline-block;background: #edebeb; padding:5px; border-right:1px #CCCCCC solid;">' . $tab['selectsix'] .':</div><div style="display: inline-block;padding:5px;border-bottom:1px #CCCCCC solid; width:80%; border-right:1px #CCCCCC solid;">' . $tab['selectsixin'] .'</div></div>' , $tab );
		}
		if ($tab['selectsevenin']){
		echo apply_filters( 'woocommerce_specification_product_benign_selectseven','<div style="width:100%;display: inline-block;"><div style=" width:20%;display: inline-block;background: #edebeb; padding:5px; border-right:1px #CCCCCC solid;">' . $tab['selectseven'] .':</div><div style="display: inline-block;padding:5px;border-bottom:1px #CCCCCC solid; width:80%; border-right:1px #CCCCCC solid;">' . $tab['selectsevenin'] .'</div></div>' , $tab );
		}
		if ($tab['selecteightin']){
		echo apply_filters( 'woocommerce_specification_product_benign_selecteight','<div style="width:100%;display: inline-block;"><div style=" width:20%;display: inline-block;background: #edebeb; padding:5px; border-right:1px #CCCCCC solid;">' . $tab['selecteight'] .':</div><div style="display: inline-block;padding:5px;border-bottom:1px #CCCCCC solid; width:80%; border-right:1px #CCCCCC solid;">' . $tab['selecteightin'] .'</div></div>' , $tab );
		}
		if ($tab['dimensions']){
		echo apply_filters( 'woocommerce_specification_product_benign_dimensions','<div style="width:100%;display: inline-block;"><div style=" width:20%;display: inline-block; background: #edebeb; padding:5px; border-right:1px #CCCCCC solid;">Dimensions:</div><div style="display: inline-block;padding:5px; border-bottom:1px #CCCCCC solid;width:80%; border-right:1px #CCCCCC solid;">' . $tab['dimensions'] .'</div></div>', $tab );
		}
		if ($tab['weight']){
		echo apply_filters( 'woocommerce_specification_product_benign_weight','<div style="width:100%;display: inline-block;"><div style=" width:20%;display: inline-block; background: #edebeb; padding:5px; border-right:1px #CCCCCC solid;">Weight:</div><div style="display: inline-block;padding:5px; border-bottom:1px #CCCCCC solid;width:80%; border-right:1px #CCCCCC solid;">' . $tab['weight'] .'</div></div>', $tab );
		}
		if ($tab['warranty']){
		echo apply_filters( 'woocommerce_specification_product_benign_warranty','<div style="width:100%;display: inline-block;"><div style=" width:20%;display: inline-block; background: #edebeb; padding:5px; border-right:1px #CCCCCC solid;">Warranty:</div><div style="display: inline-block;padding:5px; border-bottom:1px #CCCCCC solid;width:80%; border-right:1px #CCCCCC solid;">' . $tab['warranty'] .'</div></div>', $tab );
		}
		if ($tab['features']){
		echo apply_filters( 'woocommerce_specification_product_benign_features','<div style="width:100%;display: inline-block;"><div style=" width:100%; background: #edebeb; padding:5px; border-right:1px #CCCCCC solid;">Features:</div><div style="padding:5px; border-bottom:1px #CCCCCC solid;width:100%; border-right:1px #CCCCCC solid;">' . $tab['features'] .'</div></div>', $tab );
	}
}

	/**
	 * Adds specification Product Data postbox in the admin product interface
	 */
	public function product_write_panel_tab() {
		echo "<li class=\"product_tabs_lite_tab\"><a href=\"#woocommerce_specification_product_benignsource\">" . __( 'Specification', 'woocommerce-specification-product' ) . "</a></li>";
		echo "<li class=\"product_tabs_lite_tab\"><a href=\"#woocommerce_product_delivery_benignsource\">" . __( 'Delivery & Returns', 'woocommerce-specification-product' ) . "</a></li>";
	}


	/**
	 * Adds specification Product Data postbox in the product interface
	 */
	public function product_write_panel() {
		global $post;
		// the product

		// pull the custom tab data out of the database
		$tab_data = maybe_unserialize( get_post_meta( $post->ID, 'spbs_woo_specification_tab', true ) );
		

		if ( empty( $tab_data ) ) {
			$tab_data[] = array( 'title' => '', 'manufacture' => '', 'selectone' => '', 'selectonein' => '', 'selecttwo' => '', 'selecttwoin' => '','selectthree' => '', 'selectthreein' => '', 'selectfour' => '', 'selectfourin' => '', 'selectfive' => '', 'selectfivein' => '', 'selectsix' => '', 'selectsixin' => '','selectseven' => '', 'selectsevenin' => '', 'selecteight' => '', 'selecteightin' => '','dimensions' => '', 'weight' => '', 'warranty' => '', 'features' => '' );
		}

		foreach ( $tab_data as $tab ) {
		
			echo '<div id="woocommerce_specification_product_benignsource" class="panel wc-metaboxes-wrapper woocommerce_options_panel">';
			
			?>
<ul class="tabbs">
<li><a href="javascript:void(0)" class="tablinks" onclick="openBsjava(event, 'Hardware')">Hardware</a></li>
<li><a href="javascript:void(0)" class="tablinks" onclick="openBsjava(event, 'Clothing')">Clothing & Shoes</a></li>
<li><a href="javascript:void(0)" class="tablinks" onclick="openBsjava(event, 'Sport')">Sport Goods</a></li>
<li><a href="javascript:void(0)" class="tablinks" onclick="openBsjava(event, 'Traveling')">Traveling and Hobby</a></li>
<li><a href="javascript:void(0)" class="tablinks" onclick="openBsjava(event, 'Jewelry')">Jewelry and Watches</a></li>
<li style="float:right;"><?php echo '<img src="' . esc_attr( plugins_url( 'logo_spefi.jpg', __FILE__ ) ) . '" alt="Product Specification BenignSource" border="0px"> ';?></li></ul>
<?php 
echo '<div style="padding:15px;">';

	        woocommerce_wp_select( array( 'id' => '_spbs_specification_product_title', 'label' => __( 'Select Tab Title', 'woocommerce-specification-product' ), 'name' => $tab['title[]'], 'options' => array(
        '' . $tab['title'] . ''  => $tab['title'],
		'Specification' => 'Specification',
		'Product Info' => 'Product Info',
		'Product Details' => 'Product Details',
    ), 'style' => 'width:70%;' ) );
			
			woocommerce_wp_text_input( array( 'id' => '_spbs_specification_product_manufacture', 'label' => __( 'Manufacture', 'woocommerce-specification-product' ), 'placeholder' => __( 'Manufacture to display.', 'woocommerce-specification-product' ), 'value' => $tab['manufacture'], 'style' => 'width:70%;' ) );

echo '</div>';		
echo '<div id="Hardware" class="tabbscontent">';			
		
			woocommerce_wp_select( array( 'id' => '_spbs_specification_product_selectone', 'label' => __( 'Select option', 'woocommerce-specification-product' ), 'name' => $tab['selectone[]'], 'options' => array(
        '' . $tab['selectone'] . ''  => $tab['selectone'],
		'Processor' => 'Processor',
        'Operating System' => 'Operating System',
        'Chipset' => 'Chipset',
		'Memory' => 'Memory',
		'Display' => 'Display',
		'Graphic' => 'Graphic',
		'Storage' => 'Storage',
		'Battery' => 'Battery',
		'Network' => 'Network',
		'SIM' => 'SIM',
		'Comms' => 'Comms',
		'Display' => 'Display',
		'Platform' => 'Platform',
		'Sound' => 'Sound',
		'Camera' => 'Camera',
    ), 'style' => 'width:70%;' ) );
			
			woocommerce_wp_text_input( array( 'id' => '_spbs_specification_product_selectonein', 'placeholder' => __( 'Describe specification.', 'woocommerce-specification-product' ), 'value' => $tab['selectonein'], 'style' => 'width:70%;' ) );
			
			woocommerce_wp_select( array( 'id' => '_spbs_specification_product_selecttwo', 'label' => __( 'Select option', 'woocommerce-specification-product' ), 'name' => $tab['selecttwo[]'], 'options' => array(
        '' .$tab['selecttwo']. ''  => $tab['selecttwo'],
		'Processor' => 'Processor',
        'Operating System' => 'Operating System',
        'Chipset' => 'Chipset',
		'Memory' => 'Memory',
		'Display' => 'Display',
		'Graphic' => 'Graphic',
		'Storage' => 'Storage',
		'Battery' => 'Battery',
		'Network' => 'Network',
		'SIM' => 'SIM',
		'Comms' => 'Comms',
		'Display' => 'Display',
		'Platform' => 'Platform',
		'Sound' => 'Sound',
		'Camera' => 'Camera',
    ), 'style' => 'width:70%;' ) );
			
			woocommerce_wp_text_input( array( 'id' => '_spbs_specification_product_selecttwoin', 'placeholder' => __( 'Describe specification.', 'woocommerce-specification-product' ), 'value' => $tab['selecttwoin'], 'style' => 'width:70%;' ) );
			
			woocommerce_wp_select( array( 'id' => '_spbs_specification_product_selectthree', 'label' => __( 'Select option', 'woocommerce-specification-product' ), 'name' => $tab['selectthree[]'], 'options' => array(
		'' .$tab['selectthree']. ''  => $tab['selectthree'],
        'Processor' => 'Processor',
        'Operating System' => 'Operating System',
        'Chipset' => 'Chipset',
		'Memory' => 'Memory',
		'Display' => 'Display',
		'Graphic' => 'Graphic',
		'Storage' => 'Storage',
		'Battery' => 'Battery',
		'Network' => 'Network',
		'SIM' => 'SIM',
		'Comms' => 'Comms',
		'Display' => 'Display',
		'Platform' => 'Platform',
		'Sound' => 'Sound',
		'Camera' => 'Camera',
    ), 'style' => 'width:70%;' ) );
			
			woocommerce_wp_text_input( array( 'id' => '_spbs_specification_product_selectthreein', 'placeholder' => __( 'Describe specification.', 'woocommerce-specification-product' ), 'value' => $tab['selectthreein'], 'style' => 'width:70%;' ) );
			
			woocommerce_wp_select( array( 'id' => '_spbs_specification_product_selectfour', 'label' => __( 'Select option', 'woocommerce-specification-product' ), 'name' => $tab['selectfour[]'], 'options' => array(
		''.$tab['selectfour'].'' => $tab['selectfour'],
        'Processor' => 'Processor',
        'Operating System' => 'Operating System',
        'Chipset' => 'Chipset',
		'Memory' => 'Memory',
		'Display' => 'Display',
		'Graphic' => 'Graphic',
		'Storage' => 'Storage',
		'Battery' => 'Battery',
		'Network' => 'Network',
		'SIM' => 'SIM',
		'Comms' => 'Comms',
		'Display' => 'Display',
		'Platform' => 'Platform',
		'Sound' => 'Sound',
		'Camera' => 'Camera',
    ), 'style' => 'width:70%;' ) );
			
			woocommerce_wp_text_input( array( 'id' => '_spbs_specification_product_selectfourin', 'placeholder' => __( 'Describe specification.', 'woocommerce-specification-product' ), 'value' => $tab['selectfourin'], 'style' => 'width:70%;' ) );
			
			woocommerce_wp_select( array( 'id' => '_spbs_specification_product_selectfive', 'label' => __( 'Select option', 'woocommerce-specification-product' ), 'name' => $tab['selectfive[]'], 'options' => array(
		''.$tab['selectfive'].'' => $tab['selectfive'],
        'Processor' => 'Processor',
        'Operating System' => 'Operating System',
        'Chipset' => 'Chipset',
		'Memory' => 'Memory',
		'Display' => 'Display',
		'Graphic' => 'Graphic',
		'Storage' => 'Storage',
		'Battery' => 'Battery',
		'Network' => 'Network',
		'SIM' => 'SIM',
		'Comms' => 'Comms',
		'Display' => 'Display',
		'Platform' => 'Platform',
		'Sound' => 'Sound',
		'Camera' => 'Camera',
    ), 'style' => 'width:70%;' ) );
			
			woocommerce_wp_text_input( array( 'id' => '_spbs_specification_product_selectfivein', 'placeholder' => __( 'Describe specification.', 'woocommerce-specification-product' ), 'value' => $tab['selectfivein'], 'style' => 'width:70%;' ) );
			
			woocommerce_wp_select( array( 'id' => '_spbs_specification_product_selectsix', 'label' => __( 'Select option', 'woocommerce-specification-product' ), 'name' => $tab['selectsix[]'], 'options' => array(
		''.$tab['selectsix'].'' => $tab['selectsix'],
        'Processor' => 'Processor',
        'Operating System' => 'Operating System',
        'Chipset' => 'Chipset',
		'Memory' => 'Memory',
		'Display' => 'Display',
		'Graphic' => 'Graphic',
		'Storage' => 'Storage',
		'Battery' => 'Battery',
		'Network' => 'Network',
		'SIM' => 'SIM',
		'Comms' => 'Comms',
		'Display' => 'Display',
		'Platform' => 'Platform',
		'Sound' => 'Sound',
		'Camera' => 'Camera',
    ), 'style' => 'width:70%;' ) );
			
			woocommerce_wp_text_input( array( 'id' => '_spbs_specification_product_selectsixin', 'placeholder' => __( 'Describe specification.', 'woocommerce-specification-product' ), 'value' => $tab['selectsixin'], 'style' => 'width:70%;' ) );
			
			woocommerce_wp_select( array( 'id' => '_spbs_specification_product_selectseven', 'label' => __( 'Select option', 'woocommerce-specification-product' ), 'name' => $tab['selectseven[]'], 'options' => array(
		''.$tab['selectseven'].'' => $tab['selectseven'],
        'Processor' => 'Processor',
        'Operating System' => 'Operating System',
        'Chipset' => 'Chipset',
		'Memory' => 'Memory',
		'Display' => 'Display',
		'Graphic' => 'Graphic',
		'Storage' => 'Storage',
		'Battery' => 'Battery',
		'Network' => 'Network',
		'SIM' => 'SIM',
		'Comms' => 'Comms',
		'Display' => 'Display',
		'Platform' => 'Platform',
		'Sound' => 'Sound',
		'Camera' => 'Camera',
    ), 'style' => 'width:70%;' ) );
			
			woocommerce_wp_text_input( array( 'id' => '_spbs_specification_product_selectsevenin', 'placeholder' => __( 'Describe specification.', 'woocommerce-specification-product' ), 'value' => $tab['selectsevenin'], 'style' => 'width:70%;' ) );
			
			woocommerce_wp_select( array( 'id' => '_spbs_specification_product_selecteight', 'label' => __( 'Select option', 'woocommerce-specification-product' ), 'name' => $tab['selecteight[]'], 'options' => array(
		''.$tab['selecteight'].'' => $tab['selecteight'],
        'Processor' => 'Processor',
        'Operating System' => 'Operating System',
        'Chipset' => 'Chipset',
		'Memory' => 'Memory',
		'Display' => 'Display',
		'Graphic' => 'Graphic',
		'Storage' => 'Storage',
		'Battery' => 'Battery',
		'Network' => 'Network',
		'SIM' => 'SIM',
		'Comms' => 'Comms',
		'Display' => 'Display',
		'Platform' => 'Platform',
		'Sound' => 'Sound',
		'Camera' => 'Camera',
    ), 'style' => 'width:70%;' ) );
			
			woocommerce_wp_text_input( array( 'id' => '_spbs_specification_product_selecteightin', 'placeholder' => __( 'Describe specification.', 'woocommerce-specification-product' ), 'value' => $tab['selecteightin'], 'style' => 'width:70%;' ) );
			echo '</div>';
			echo '<div id="Clothing" class="tabbscontent">';
			
			echo '<div style=" text-align:center; font-size:16px; color:#e96656; padding:10px;">This is Demo version if you like it support us and take <a href="http://www.benignsource.com/product/specification-benignsource/" target="_blank" title="Premium Version">Premium Version</a></div>';
			
			echo '</div>';
			echo '<div id="Sport" class="tabbscontent">';
			
			echo '<div style=" text-align:center; font-size:16px; color:#e96656; padding:10px;">This is Demo version if you like it support us and take <a href="http://www.benignsource.com/product/specification-benignsource/" target="_blank" title="Premium Version">Premium Version</a></div>';
			
			
			echo '</div>';
			echo '<div id="Traveling" class="tabbscontent">';
			
			echo '<div style=" text-align:center; font-size:16px; color:#e96656; padding:10px;">This is Demo version if you like it support us and take <a href="http://www.benignsource.com/product/specification-benignsource/" target="_blank" title="Premium Version">Premium Version</a></div>';
			
			echo '</div>';
			echo '<div id="Jewelry" class="tabbscontent">';
			
			echo '<div style=" text-align:center; font-size:16px; color:#e96656; padding:10px;">This is Demo version if you like it support us and take <a href="http://www.benignsource.com/product/specification-benignsource/" target="_blank" title="Premium Version">Premium Version</a></div>';
			
			echo '</div>';
			echo '<div style="padding:15px;">';
			
			woocommerce_wp_text_input( array( 'id' => '_spbs_specification_product_dimensions', 'label' => __( 'Dimensions', 'woocommerce-specification-product' ), 'placeholder' => __( '435 x 180 x 464 mm / 17-1/8 x 7-1/8 x 18-1/4', 'woocommerce-specification-product' ), 'value' => $tab['dimensions'], 'style' => 'width:70%;' ) );
			
			woocommerce_wp_text_input( array( 'id' => '_spbs_specification_product_weight', 'label' => __( 'Weight', 'woocommerce-specification-product' ), 'placeholder' => __( '24.6 kg; 54.2 lbs.', 'woocommerce-specification-product' ), 'value' => $tab['weight'], 'style' => 'width:70%;' ) );
			
			woocommerce_wp_text_input( array( 'id' => '_spbs_specification_product_warranty', 'label' => __( 'Warranty', 'woocommerce-specification-product' ), 'placeholder' => __( '2-year', 'woocommerce-specification-product' ), 'value' => $tab['warranty'], 'style' => 'width:70%;' ) );
			
			woocommerce_wp_textarea_input( array( 'id' => '_spbs_specification_product_features', 'label' => __( 'Features', 'woocommerce-specification-product' ), 'placeholder' => __( 'HTML and text to display.', 'woocommerce-specification-product' ), 'value' => $tab['features'], 'style' => 'width:70%;height:21.5em;' ) );
			echo '</div>';
			
			echo '</div>';
			
		}
		
$tab_delivery = maybe_unserialize( get_post_meta( $post->ID, 'spbs_woo_deliveryinfo_tab', true ) );

if ( empty( $tab_delivery ) ) {
			$tab_delivery[] = array( 'deliverytitle' => '', 'deliveryinfo' => '');
		}

foreach ( $tab_delivery as $tabdeli ) {
		
			echo '<div id="woocommerce_product_delivery_benignsource" class="panel wc-metaboxes-wrapper woocommerce_options_panel">';?>
<ul class="tabbs">
<li style="color:#FFFFFF; padding:10px;">Delivery & Returns</li>
<li style="float:right;"><?php echo '<img src="' . esc_attr( plugins_url( 'logo_spefi.jpg', __FILE__ ) ) . '" alt="Product Specification BenignSource" border="0px"> ';?></li></ul>
<?php
            echo '<div style=" text-align:center; font-size:16px; color:#e96656; padding:10px;">This is Demo version if you like it support us and take <a href="http://www.benignsource.com/product/specification-benignsource/" target="_blank" title="Premium Version">Premium Version</a></div></div>';
}
		
	}


	/**
	 * Saves the data inputed into the product boxes, as post meta data
	 */
	public function product_save_data( $post_id, $post ) {

		$tab_title = stripslashes( $_POST['_spbs_specification_product_title'] );
		$tab_manufacture = stripslashes( $_POST['_spbs_specification_product_manufacture'] );
		$tab_selectone = stripslashes( $_POST['_spbs_specification_product_selectone'] );
		$tab_selectonein = stripslashes( $_POST['_spbs_specification_product_selectonein'] );
		$tab_selecttwo = stripslashes( $_POST['_spbs_specification_product_selecttwo'] );
		$tab_selecttwoin = stripslashes( $_POST['_spbs_specification_product_selecttwoin'] );
		$tab_selectthree = stripslashes( $_POST['_spbs_specification_product_selectthree'] );
		$tab_selectthreein = stripslashes( $_POST['_spbs_specification_product_selectthreein'] );
		$tab_selectfour = stripslashes( $_POST['_spbs_specification_product_selectfour'] );
		$tab_selectfourin = stripslashes( $_POST['_spbs_specification_product_selectfourin'] );
		$tab_selectfive = stripslashes( $_POST['_spbs_specification_product_selectfive'] );
		$tab_selectfivein = stripslashes( $_POST['_spbs_specification_product_selectfivein'] );
		$tab_selectsix = stripslashes( $_POST['_spbs_specification_product_selectsix'] );
		$tab_selectsixin = stripslashes( $_POST['_spbs_specification_product_selectsixin'] );
		$tab_selectseven = stripslashes( $_POST['_spbs_specification_product_selectseven'] );
		$tab_selectsevenin = stripslashes( $_POST['_spbs_specification_product_selectsevenin'] );
		$tab_selecteight = stripslashes( $_POST['_spbs_specification_product_selecteight'] );
		$tab_selecteightin = stripslashes( $_POST['_spbs_specification_product_selecteightin'] );
		$tab_dimensions = stripslashes( $_POST['_spbs_specification_product_dimensions'] );
		$tab_weight = stripslashes( $_POST['_spbs_specification_product_weight'] );
		$tab_warranty = stripslashes( $_POST['_spbs_specification_product_warranty'] );
		$tab_features = stripslashes( $_POST['_spbs_specification_product_features'] );
		

		if ( empty( $tab_title ) && empty( $tab_manufacture ) && get_post_meta( $post_id, 'spbs_woo_specification_tab', true ) ) {
			// clean up if the custom tabs are removed
			delete_post_meta( $post_id, 'spbs_woo_specification_tab' );
		} elseif ( ! empty( $tab_title ) || ! empty( $tab_manufacture ) ) {
			$tab_data = array();

			$tab_id = '';
			if ( $tab_title ) {
				if ( strlen( $tab_title ) != strlen( utf8_encode( $tab_title ) ) ) {
					// can't have titles with utf8 characters as it breaks the tab-switching javascript
					$tab_id = "tab-custom";
				} else {
					// convert the tab title into an id string
					$tab_id = strtolower( $tab_title );
					$tab_id = preg_replace( "/[^\w\s]/", '', $tab_id );
					// remove non-alphas, numbers, underscores or whitespace
					$tab_id = preg_replace( "/_+/", ' ', $tab_id );
					// replace all underscores with single spaces
					$tab_id = preg_replace( "/\s+/", '-', $tab_id );
					// replace all multiple spaces with single dashes
					$tab_id = 'tab-' . $tab_id;
					// prepend with 'tab-' string
				}
			}

			// save the data to the database
			$tab_data[] = array( 'title' => $tab_title, 'id' => $tab_id, 'manufacture' => $tab_manufacture,'selectone' => $tab_selectone,'selectonein' => $tab_selectonein,'selecttwo' => $tab_selecttwo,'selecttwoin' => $tab_selecttwoin,'selectthree' => $tab_selectthree,'selectthreein' => $tab_selectthreein,'selectfour' => $tab_selectfour,'selectfourin' => $tab_selectfourin, 'selectfive' => $tab_selectfive,'selectfivein' => $tab_selectfivein,'selectsix' => $tab_selectsix,'selectsixin' => $tab_selectsixin,'selectseven' => $tab_selectseven,'selectsevenin' => $tab_selectsevenin,'selecteight' => $tab_selecteight,'selecteightin' => $tab_selecteightin, 'dimensions' => $tab_dimensions, 'weight' => $tab_weight, 'warranty' => $tab_warranty, 'features' => $tab_features );

update_post_meta( $post_id, 'spbs_woo_specification_tab', $tab_data );	
		}
	}

	/*
	 * @return WooCommerceSpecificationProduct
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/*
	 * @return true if there is custom tab data, false otherwise
	 */
	private function product_has_specification( $product ) {
		if ( false === $this->tab_data ) {
			$this->tab_data = maybe_unserialize( get_post_meta( $product->id, 'spbs_woo_specification_tab', true ) );
			
		}
		// tab must at least have a title to exist
		return ! empty( $this->tab_data ) && ! empty( $this->tab_data[0] ) && ! empty( $this->tab_data[0]['title'] );
		
	}


	/*
	 * Checks if WooCommerce is active
	 */
	public static function is_woocommerce_active() {

		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
		}

		return in_array( 'woocommerce/woocommerce.php', $active_plugins ) || array_key_exists( 'woocommerce/woocommerce.php', $active_plugins );
	}
	/**
	 * Run every time.  Used since the activation hook is not executed when updating a plugin
	 */
	private function install() {

		global $wpdb;

		$installed_version = get_option( self::VERSION_OPTION_NAME );

		// installed version lower than plugin version?
		if ( -1 === version_compare( $installed_version, self::VERSION ) ) {
			// new version number
			update_option( self::VERSION_OPTION_NAME, self::VERSION );
		}
	}

}


/*
 * @return \WooCommerceSpecificationProduct
 */
function spbs_specification_product_benign() {
	return WooCommerceSpecificationProduct::instance();
}

function load_specification_product_admin_style() {
       
        wp_enqueue_style( 'specification_product_admin_css', plugins_url('style.css', __FILE__) );
		wp_enqueue_script( 'specification_product_admin_css', plugins_url('tabs.js', __FILE__) );
}
add_action( 'admin_enqueue_scripts', 'load_specification_product_admin_style' );
/**
 * The WooCommerceSpecificationProduct global object
 */
$GLOBALS['woocommerce_specification_product_benignsource'] = spbs_specification_product_benign();
$GLOBALS['woocommerce_product_delivery_benignsource'] = spbs_specification_product_benign();