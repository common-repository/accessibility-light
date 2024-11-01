<?php
/*
Plugin Name: Accessibility Lite - SEO Friendly Super Lightweight WordPress Plugin
Description: Accessibility Lite  ♿  is a lightweight SEO Friendly, WCAG compliant accessibility plugin that makes your website accessible for people with disabilities.
Version: 3.8.4
Plugin URI: https://wordpress.org/plugins/accessibility-light/
Author: Sitelinx
Author URI: https://seo.sitelinx.co.il
Text Domain: accessibility-light
*/

/**
 * Main File
 * Template is written by Sitelinx
 * @Version: 3.8.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // only can be accessed through wp
} 
 
final class ACL_Sitelinx{
	
	/**
	 * The single instance of the class.
	 *
	 * @private
	 */
	protected static $_instance = null;
	
	/**
	 * Stored all plugin configurations.
	 *
	 * @private
	 */
	// private $configuration;
	public $configurations;
	public $ACL_Sitelinx_Toolbar;
	public $ACL_Sitelinx_Settings;

	 
	/**
	 * Plugin Instance.
	 *
	 * Ensures only one instance of this plugin is loaded or can be loaded.
	 *
	 * @static
	 * @return plugin - Main instance.
	 */
	 
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * Plugin Constructor.
	 */
	 
	public function __construct(){
		
		$this->apply_configuration();
		$this->init();
	}
	
	/**
	 * Apply plugin Configuration
	 * All configurations is written in includes/configurations.hp
	 */
	 
	public function apply_configuration(){
		require_once "includes/configurations.php";
		
		$this->configurations = $configurations;
	}
	
	/**
	 * Plugin first init
	 */
	 
	public function init(){
		$this->defined();		
		add_action( 'wp_enqueue_scripts', array($this, 'scripts' ) );
		add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts' ) );
		add_action( 'plugins_loaded', array( $this, 'language_setting' ) );
		$this->includes();
		$this->classes();
		
		/* plugin activation */
		register_activation_hook( __FILE__, array( $this, 'activation' ) );
		
		/* plugin deactivation */
		register_deactivation_hook( __FILE__, array( $this, 'deactivation' ) );
	}
	
	/**
	 * define constant variables
	 */

	private function defined(){
		define( $this->configurations['path'], dirname( __FILE__ ) );
		define( $this->configurations['url'], plugins_url( '/', __FILE__ ) );
	}
	
	/**
	 * include public scripts
	 */

	public function scripts(){
		$styles = isset( $this->configurations['styles'] ) ? $this->configurations['styles'] : array();
		$scripts = isset( $this->configurations['scripts'] ) ? $this->configurations['scripts'] : array();
		
		//enqueue styles
		if( sizeof( $styles ) ){
			foreach( $styles as $style ){
				$handle = isset( $style['handle'] ) ? $style['handle'] : '';
				$src = isset( $style['src'] ) ? ( file_exists( dirname( __FILE__ ) . '/assets/css/' . $style['src'] ) ? plugins_url( '/', __FILE__ ) . 'assets/css/' . $style['src'] : $style['src'] ) : false;
				$deps = isset( $style['deps'] ) ? $style['deps'] : array();
				$ver = isset( $style['ver'] ) ? $style['ver'] : false;
				$media = isset( $style['media'] ) ? $style['media'] : 'all';
				wp_enqueue_style( $handle, $src, $deps, $ver, $media );
			}
		}
		
		//enqueue scripts
		
			if( sizeof( $scripts ) ){
				foreach( $scripts as $script ){
					$handle = isset( $script['handle'] ) ? $script['handle'] : '';
					$src = isset( $script['src'] ) ? ( file_exists( dirname( __FILE__ ) . '/assets/js/' . $script['src'] ) ? plugins_url( '/', __FILE__ ) . 'assets/js/' . $script['src'] : $script['src'] ) : false;
					$deps = isset( $script['deps'] ) ? $script['deps'] : array();
					$ver = isset( $script['ver'] ) ? $script['ver'] : false;
					$in_footer = isset( $script['in_footer'] ) ? $script['in_footer'] : false;
					wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
				}
			}
		
	}
	
	/**
	 * include admin scripts
	 */

	public function admin_scripts(){
		$styles = isset( $this->configurations['admin_styles'] ) ? $this->configurations['admin_styles'] : array();

		$scripts = isset( $this->configurations['admin_scripts'] ) ? $this->configurations['admin_scripts'] : array();
		
			if( sizeof( $styles ) ){
				foreach( $styles as $style ){
					$handle = isset( $style['handle'] ) ? $style['handle'] : '';
					$src = isset( $style['src'] ) ? ( file_exists( dirname( __FILE__ ) . '/assets/admin/css/' . $style['src'] ) ? plugins_url( '/', __FILE__ ) . 'assets/admin/css/' . $style['src'] : $style['src'] ) : false;
					$deps = isset( $style['deps'] ) ? $style['deps'] : array();
					$ver = isset( $style['ver'] ) ? $style['ver'] : false;
					$media = isset( $style['media'] ) ? $style['media'] : 'all';
					wp_enqueue_style( $handle, $src, $deps, $ver, $media );
				}
			}

		//enqueue scripts
		$current_screen = get_current_screen();
		/* Check wether this page is accessiblity or not if yes please add the scripts */
		if( $current_screen->id === "toplevel_page_accessible-sitelinx" ){
			if( sizeof( $scripts ) ){
				foreach( $scripts as $script ){
					$handle = isset( $script['handle'] ) ? $script['handle'] : '';
					$src = isset( $script['src'] ) ? ( file_exists( dirname( __FILE__ ) . '/assets/admin/js/' . $script['src'] ) ? plugins_url( '/', __FILE__ ) . 'assets/admin/js/' . $script['src'] : $script['src'] ) : false;
					$deps = isset( $script['deps'] ) ? $script['deps'] : array();
					$ver = isset( $script['ver'] ) ? $script['ver'] : false;
					$in_footer = isset( $script['in_footer'] ) ? $script['in_footer'] : false;
					wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
				}
			}
		}
	}
	
	/**
	 * enable plugin translation
	 */	
	public function language_setting() {
		load_plugin_textdomain( $this->plugin_textdomain(), false,  basename( __DIR__ ) . '/languages' );
	}
	
	/**
	 * Get plugin textdomain
	 * @return: plugin_textdomain
	 */	 
	 public function plugin_textdomain(){
		 
		 return $this->configurations['plugin_textdomain'];
	 }
	 
	/**
	 * include support files
	 */	
	private function includes(){
		$includes = isset( $this->configurations['includes'] ) ? $this->configurations['includes'] : array();
		
		if( sizeof( $includes ) ){
			foreach( $includes as $include ){
				require_once dirname( __FILE__ ) . '/includes/' . $include;
			}
		}
	}
	
	/**
	 * declare classes
	 */	
	private function classes(){
		$classes = isset( $this->configurations['classes'] ) ? $this->configurations['classes'] : array();
		
		if( sizeof( $classes ) ){
			foreach( $classes as $class_name=>$path ){
				require_once dirname( __FILE__ ) . '/includes/' . $path;
				
				$this->$class_name = new $class_name();
			}
		}
	}
	
	/**
	 * get template file
	 */	
	public function get_template( $template_path ){
		
		$template_path = apply_filters( $this->plugin_name() . '_template_path', $template_path );
		
		include dirname( __FILE__ ) . '/templates/' . $template_path;
	}
	
	/**
	 * Get plugin name
	 * @return: plugin_name
	 */
	 
	 public function plugin_name(){
		 
		 return $this->configurations['plugin_name'];
	 }
	 
	/**
	 * Plugin Activation
	 * @return: void
	 */	 
	 public function activation(){
		
		//write your codes here...
		$sitelinx_option = get_option( 'sitelinx' );
	 
		if (  $sitelinx_option  ) {
		 
			// The option already exists, so update it.
			update_option( 'sitelinx', '' );
		 
		}
	 }
	 
	/**
	 * Plugin Deactivation
	 * @return: void
	 */	 
	 public function deactivation(){
		
		//write your codes here...
	 }

}

/**
 * Main instance of Plugin.
 *
 * Returns the main instance of plugin class to prevent the need to use globals.
 *
 * @return Your_Plugin_Name
 */
function ACL_Sitelinx() {
	return ACL_Sitelinx::instance();
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'acl_sitelinx_add_action_links' );

function acl_sitelinx_add_action_links ( $links ) {
	
	$mylinks = array('<a href="' . admin_url( 'admin.php?page=accessible-sitelinx' ) . '">'. __('Settings', 'accessibility-light') .'</a>');
	
	$addLink = array('<a target="_blank" href="https://seo.sitelinx.co.il">'. __('<b style="color:red;">FREE SEO AUDIT</b>', 'accessibility-light') .'</a>');
	return array_merge(  $mylinks, $links, $addLink );
}

// Global for backwards compatibility.
$GLOBALS[ACL_Sitelinx()->plugin_name()] = ACL_Sitelinx();

//Genral plugin notification for ratings. 
function tbs_acl_rating_admin_notice(){
    global $pagenow;
    $user_id = get_current_user_id();
    if ( !get_user_meta( $user_id, 'acl_notice_dismissed' ) ){
    ?>
    	<div id="rate-us-wp" class="notice updated is-dismissible">
			<p><?php echo __( " <b>  Limited Offer: Discounted Expert Google / Maps SEO For Your Website & Google Business Profile!</b>", "accessibility-light");?></p>
			<p><?php echo __( "For examples of our SEO results, visit the website:", "accessibility-light");?> <a href="https://seo.sitelinx.co.il" target="_blank"> https://seo.sitelinx.co.il</a></p>
			<div class="seo-mail-box">
			  <span class="seo-form-design" >
				<svg style="padding-top: 10px;" height="64px" width="64px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle style="fill:#21D0C3;" cx="256" cy="256" r="256"></circle> <g> <path style="fill:#FFFFFF;" d="M62.959,178.471c0-13.316,3.172-23.538,9.516-30.667c6.346-7.129,15.863-10.692,28.553-10.692 c12.688,0,22.206,3.563,28.551,10.692c6.346,7.128,9.517,17.35,9.517,30.667v5.169h-24.439v-6.815 c0-5.952-1.137-10.143-3.406-12.572c-2.273-2.428-5.444-3.642-9.517-3.642c-4.074,0-7.246,1.214-9.518,3.642 c-2.271,2.429-3.406,6.62-3.406,12.572c0,5.639,1.253,10.613,3.759,14.922c2.507,4.309,5.64,8.383,9.401,12.22 c3.759,3.837,7.793,7.676,12.101,11.515c4.31,3.839,8.344,8.028,12.102,12.572c3.761,4.543,6.894,9.713,9.401,15.509 c2.506,5.797,3.759,12.611,3.759,20.444c0,13.316-3.25,23.538-9.752,30.667c-6.502,7.128-16.096,10.692-28.787,10.692 c-12.689,0-22.284-3.565-28.787-10.692c-6.502-7.128-9.753-17.35-9.753-30.667v-10.103h24.44v11.749 c0,5.954,1.214,10.105,3.641,12.455c2.429,2.35,5.679,3.524,9.753,3.524c4.073,0,7.324-1.174,9.752-3.524 c2.428-2.349,3.644-6.501,3.644-12.455c0-5.639-1.255-10.613-3.761-14.921c-2.507-4.309-5.64-8.383-9.401-12.22 c-3.759-3.839-7.793-7.677-12.101-11.515c-4.309-3.839-8.342-8.029-12.102-12.572c-3.761-4.544-6.894-9.713-9.401-15.509 C64.212,193.119,62.959,186.305,62.959,178.471L62.959,178.471z"></path> <path style="fill:#FFFFFF;" d="M179.984,208.314h35.483v23.501h-35.483v48.172h44.648v23.5h-70.496V138.993h70.496v23.498h-44.648 V208.314z"></path> </g> <path style="fill:#15BDB2;" d="M289.612,129.448l-2.702-17.898l28.336-7.749l6.792,16.805c6.368-0.643,12.786-0.672,19.156-0.105 l6.62-16.868l28.417,7.454l-2.517,17.929c5.766,2.595,11.339,5.771,16.639,9.51l14.162-11.301l20.883,20.665l-11.156,14.279 c3.797,5.26,7.025,10.802,9.686,16.541l17.901-2.697l7.747,28.333l-16.801,6.797c0.634,6.368,0.669,12.782,0.097,19.153 l16.874,6.623l-7.456,28.414l-17.925-2.517c-2.603,5.766-5.776,11.343-9.513,16.638l11.302,14.165l-20.665,20.878l-14.282-11.15 c-5.26,3.792-10.802,7.02-16.543,9.686l2.702,17.895l-28.334,7.752l-6.796-16.804c-6.369,0.639-12.785,0.669-19.154,0.103 l-6.621,16.868l-28.416-7.454l2.515-17.927c-5.767-2.604-11.343-5.774-16.642-9.512l-14.162,11.303l-20.88-20.67l11.152-14.277 c-3.788-5.261-7.019-10.805-9.68-16.548l-17.898,2.707l-7.75-28.336l16.805-6.793c-0.642-6.37-0.672-12.787-0.103-19.159 l-16.875-6.616l7.456-28.416l17.93,2.513c2.6-5.767,5.771-11.341,9.509-16.641l-11.302-14.16l20.669-20.883l14.278,11.16 C278.329,135.338,283.875,132.111,289.612,129.448L289.612,129.448z M332.14,145.528c41.814,0,75.713,33.898,75.713,75.713 c0,41.814-33.899,75.713-75.713,75.713c-41.815,0-75.713-33.899-75.713-75.713C256.427,179.426,290.325,145.528,332.14,145.528z"></path> <g> <path style="fill:#666666;" d="M338.834,314.134v20.893h-13.392v-20.893c2.218,0.048,4.45,0.076,6.697,0.076 C334.386,314.21,336.617,314.183,338.834,314.134z"></path> <circle style="fill:#666666;" cx="332.141" cy="221.497" r="93.517"></circle> </g> <circle style="fill:#FAD24D;" cx="332.141" cy="221.497" r="84.834"></circle> <path style="fill:#FFFFFF;" d="M332.141,145.926c5.039,0,9.97,0.497,14.744,1.443c4.89,0.969,9.624,2.416,14.144,4.288 c4.604,1.907,8.979,4.256,13.068,6.989c4.135,2.765,7.977,5.923,11.473,9.418c3.496,3.496,6.655,7.34,9.42,11.474 c2.735,4.09,5.083,8.465,6.989,13.071c1.872,4.519,3.32,9.252,4.289,14.142c0.945,4.774,1.443,9.707,1.443,14.748 c0,5.04-0.497,9.973-1.443,14.746c-0.969,4.889-2.416,9.621-4.289,14.14c-1.906,4.607-4.254,8.981-6.987,13.068 c-2.77,4.145-5.928,7.99-9.416,11.478h-0.005c-3.495,3.494-7.338,6.653-11.473,9.419c-4.089,2.733-8.464,5.082-13.068,6.987 c-4.519,1.87-9.253,3.319-14.144,4.288c-4.774,0.946-9.705,1.443-14.744,1.443c-5.04,0-9.973-0.496-14.745-1.443 c-4.891-0.969-9.624-2.415-14.144-4.288c-4.605-1.906-8.981-4.254-13.068-6.987c-4.136-2.766-7.979-5.924-11.474-9.419l-0.005-0.005 c-3.494-3.495-6.652-7.339-9.418-11.473c-2.733-4.089-5.082-8.463-6.989-13.068c-1.872-4.519-3.319-9.253-4.288-14.144 c-0.946-4.773-1.443-9.704-1.443-14.743c0-5.04,0.496-9.972,1.443-14.745c0.969-4.89,2.415-9.624,4.288-14.146 c1.907-4.604,4.257-8.979,6.99-13.07c5.523-8.262,12.632-15.37,20.895-20.892c4.088-2.735,8.464-5.082,13.068-6.989 c4.519-1.87,9.252-3.319,14.144-4.288C322.169,146.424,327.1,145.926,332.141,145.926L332.141,145.926z M272.613,248.65h18.818 c-0.493-1.387-0.946-2.782-1.356-4.177c-0.593-2.01-1.106-4.025-1.535-6.039c-0.453-2.136-0.821-4.314-1.1-6.522 c-0.226-1.776-0.389-3.554-0.493-5.331h-20.024c0.122,1.575,0.3,3.144,0.535,4.705c0.307,2.045,0.709,4.051,1.192,6.008 c0.519,2.088,1.14,4.148,1.857,6.166C271.137,245.227,271.841,246.96,272.613,248.65L272.613,248.65z M302.286,248.65h24.77v-22.068 h-29.954c0.105,1.549,0.262,3.097,0.471,4.638c0.268,1.987,0.629,3.975,1.075,5.954c0.464,2.063,1.031,4.125,1.695,6.174 C300.917,245.129,301.565,246.899,302.286,248.65z M337.225,248.65h24.768c0.724-1.758,1.369-3.522,1.941-5.288 c0.664-2.055,1.231-4.121,1.698-6.187c0.445-1.978,0.805-3.963,1.075-5.948c0.21-1.544,0.367-3.094,0.473-4.644h-29.954V248.65 L337.225,248.65z M372.85,248.65h18.816c0.775-1.693,1.478-3.426,2.108-5.196c0.718-2.014,1.34-4.071,1.855-6.159 c0.483-1.953,0.883-3.957,1.19-6.001c0.235-1.562,0.415-3.134,0.536-4.712h-20.024c-0.103,1.775-0.266,3.55-0.492,5.325 c-0.279,2.21-0.649,4.39-1.102,6.528c-0.427,2.01-0.937,4.024-1.53,6.03C373.796,245.863,373.343,247.259,372.85,248.65 L372.85,248.65z M385.863,258.821h-17.39c-0.373,0.732-0.777,1.49-1.205,2.275v0.005c-0.523,0.955-1.093,1.947-1.702,2.968 c-0.66,1.105-1.367,2.229-2.117,3.367c-0.744,1.128-1.51,2.24-2.294,3.327c-1.391,1.929-2.858,3.815-4.396,5.649 c-1.538,1.833-3.17,3.644-4.887,5.423c-0.939,0.972-1.906,1.935-2.896,2.884c1.138-0.301,2.264-0.637,3.377-0.997 c2.659-0.864,5.249-1.895,7.746-3.079c3.398-1.608,6.64-3.504,9.691-5.656c4.225-2.979,8.09-6.456,11.504-10.334l0.002,0.002 c0.929-1.057,1.831-2.155,2.702-3.286c0.551-0.714,1.1-1.459,1.645-2.232L385.863,258.821L385.863,258.821z M356.892,258.821 h-19.667v22.833c0.802-0.68,1.591-1.366,2.364-2.062c1.447-1.301,2.827-2.616,4.14-3.937c1.737-1.749,3.36-3.514,4.868-5.286 c1.535-1.802,2.981-3.647,4.337-5.526c0.574-0.793,1.154-1.632,1.737-2.505c0.547-0.822,1.105-1.695,1.667-2.609l0.002,0.002 L356.892,258.821L356.892,258.821z M327.055,258.821h-19.668l0.554,0.912l0.002-0.002c1.07,1.744,2.206,3.455,3.402,5.113 c1.355,1.877,2.801,3.72,4.335,5.522c1.509,1.773,3.133,3.539,4.869,5.289c1.313,1.323,2.698,2.641,4.147,3.944 c0.772,0.692,1.558,1.379,2.358,2.057V258.821L327.055,258.821z M295.805,258.821h-17.387l0.22,0.311 c0.545,0.775,1.096,1.523,1.648,2.239c0.85,1.103,1.753,2.2,2.702,3.281v0.006c3.383,3.856,7.337,7.392,11.505,10.331 c5.341,3.769,11.223,6.716,17.439,8.735c1.114,0.362,2.241,0.696,3.378,0.998c-2.73-2.622-5.347-5.399-7.778-8.299 c-1.542-1.836-3.013-3.726-4.406-5.659c-0.782-1.083-1.547-2.192-2.288-3.316c-0.753-1.142-1.46-2.271-2.123-3.378 c-0.588-0.983-1.157-1.975-1.702-2.973C296.582,260.311,296.18,259.551,295.805,258.821L295.805,258.821z M278.422,184.172h17.755 c0.354-0.69,0.712-1.367,1.076-2.032v-0.006c0.503-0.917,1.031-1.843,1.583-2.774c0.592-0.998,1.249-2.055,1.966-3.166v-0.005 c0.696-1.075,1.398-2.118,2.102-3.12c1.38-1.96,2.869-3.915,4.462-5.86c1.577-1.923,3.235-3.807,4.966-5.638 c1.07-1.132,2.181-2.258,3.327-3.368l0.033-0.032c-1.214,0.316-2.415,0.664-3.6,1.046c-2.687,0.863-5.307,1.901-7.843,3.099 c-3.41,1.61-6.666,3.51-9.726,5.668c-3.084,2.174-5.972,4.607-8.63,7.265l-0.005,0.006c-1.654,1.653-3.225,3.398-4.696,5.222 C280.229,181.672,279.303,182.907,278.422,184.172L278.422,184.172z M307.781,184.172h19.274v-22.676 c-0.802,0.698-1.591,1.405-2.362,2.116c-1.464,1.35-2.862,2.716-4.19,4.088c-1.719,1.778-3.355,3.606-4.908,5.477 c-1.561,1.881-3.025,3.797-4.387,5.731c-0.541,0.769-1.077,1.56-1.604,2.364c-0.543,0.828-1.05,1.628-1.513,2.389L307.781,184.172 L307.781,184.172z M337.225,184.172h19.275l-0.306-0.512l-0.004,0.002c-0.462-0.76-0.965-1.556-1.509-2.383 c-0.528-0.806-1.066-1.597-1.609-2.37c-1.365-1.938-2.832-3.856-4.395-5.742c-1.549-1.867-3.183-3.692-4.894-5.461v-0.006 c-1.295-1.339-2.694-2.702-4.187-4.081c-0.773-0.714-1.564-1.423-2.37-2.123V184.172L337.225,184.172z M368.105,184.172h17.757 l-0.222-0.316c-0.545-0.773-1.094-1.517-1.643-2.229c-0.842-1.098-1.745-2.19-2.696-3.273c-0.946-1.076-1.919-2.112-2.911-3.101 l-0.005-0.006c-2.656-2.658-5.545-5.091-8.628-7.265c-3.061-2.157-6.317-4.057-9.728-5.668c-2.535-1.198-5.155-2.236-7.84-3.099 c-1.186-0.382-2.385-0.73-3.6-1.044c1.145,1.082,2.272,2.254,3.354,3.399h0.005c1.732,1.831,3.389,3.716,4.967,5.64 c1.593,1.942,3.08,3.897,4.46,5.858c0.684,0.975,1.389,2.023,2.112,3.14h0.005c0.673,1.042,1.325,2.094,1.949,3.151 C366.381,180.942,367.264,182.539,368.105,184.172L368.105,184.172z M391.666,194.345h-19.124c0.501,1.381,0.965,2.776,1.392,4.18 c0.608,1.998,1.141,4.015,1.594,6.042c0.487,2.173,0.881,4.348,1.183,6.512c0.247,1.773,0.432,3.553,0.56,5.332h20.085 c-0.122-1.576-0.301-3.147-0.536-4.711v-0.006c-0.305-2.035-0.705-4.036-1.19-5.996c-0.515-2.086-1.138-4.143-1.855-6.158 C393.144,197.772,392.441,196.038,391.666,194.345L391.666,194.345z M361.661,194.345h-24.435v22.066h29.882 c-0.125-1.522-0.301-3.051-0.53-4.581c-0.293-1.972-0.678-3.958-1.151-5.945c-0.504-2.128-1.095-4.21-1.771-6.235 C363.063,197.87,362.396,196.099,361.661,194.345z M327.055,194.345H302.62c-0.736,1.754-1.401,3.527-1.996,5.31 c-0.675,2.024-1.264,4.104-1.77,6.231c-0.473,1.993-0.857,3.98-1.152,5.955c-0.228,1.529-0.404,3.053-0.529,4.571h29.882V194.345 L327.055,194.345z M291.738,194.345h-19.126c-0.772,1.691-1.476,3.423-2.104,5.189c-0.718,2.018-1.339,4.076-1.857,6.165 c-0.483,1.958-0.884,3.963-1.192,6.009c-0.235,1.561-0.415,3.13-0.535,4.703h20.089c0.126-1.783,0.313-3.566,0.561-5.343 c0.299-2.163,0.693-4.334,1.179-6.502c0.454-2.03,0.987-4.05,1.595-6.05C290.774,197.116,291.238,195.725,291.738,194.345 L291.738,194.345z"></path> <path style="fill:#666666;" d="M321.884,452.28h20.505c2.851,0,5.184-2.393,5.184-5.314V345.291c0-2.919-2.337-5.314-5.184-5.314 h-20.505c-2.846,0-5.185,2.398-5.185,5.314v101.674C316.699,449.881,319.033,452.28,321.884,452.28z"></path> <path style="fill:#FEFEFE;" d="M347.573,349.471v-9.129c0-2.919-2.336-5.314-5.184-5.314h-20.505c-2.847,0-5.185,2.396-5.185,5.314 v9.129H347.573z"></path> <path style="fill:#ECF0F1;" d="M347.573,349.471v-9.128c0-2.796-2.141-5.109-4.824-5.301v14.429H347.573z M321.523,335.043 c-2.682,0.193-4.824,2.506-4.824,5.301v9.128h4.824V335.043z"></path> <path style="fill:#15BDB2;" d="M407.312,329.822c2.331-0.372,4.67-0.487,6.986-0.363l3.271-6.926l16.547,5.8l-2.037,7.427 c1.874,1.359,3.621,2.921,5.201,4.68l7.209-2.587l7.597,15.799l-6.69,3.811c0.372,2.331,0.488,4.674,0.363,6.986l6.929,3.273 l-5.802,16.547l-7.425-2.037c-1.359,1.879-2.921,3.622-4.677,5.202l2.584,7.203l-15.8,7.603l-3.809-6.69 c-2.331,0.373-4.676,0.488-6.987,0.36l-3.27,6.929l-16.547-5.799l2.033-7.426c-1.875-1.359-3.621-2.927-5.198-4.681l-7.207,2.586 l-7.599-15.799l6.688-3.811c-0.371-2.332-0.487-4.674-0.363-6.985l-6.927-3.273l5.799-16.548l7.426,2.037 c1.361-1.877,2.923-3.622,4.682-5.2l-2.586-7.207l15.801-7.602L407.312,329.822L407.312,329.822z M412.537,337.85 c13.713,0,24.833,11.119,24.833,24.833c0,13.717-11.12,24.836-24.833,24.836c-13.717,0-24.833-11.118-24.833-24.836 C387.703,348.969,398.82,337.85,412.537,337.85z"></path> </g></svg>
				 <span class="form-section">
					<form action="" method="post">
					<p><?php echo __( "<b>Fill out this form for a free audit and quote.</b>", "accessibility-light");?> </p>
						<input type="email" name="emailadid" id="email" required placeholder="<?php echo __("Your Email Address","accessibility-light") ?>">
						<input name="url" placeholder="<?php echo __("Your Website URL..","accessibility-light") ?>" type="text" required >
						<input type="text" id="websitesla" name="website"/>
						<input type="email" id="websitesla" name="email"/>
						<Button class="sln-send-mail-btn"><?php echo __("SEND", "accessibility-light"); ?></Button>
					</form>
					<a style='padding-top: 36px;' href="https://wordpress.org/support/plugin/accessibility-light/reviews/?filter=5#new-post" target="_blank" ><button class="sl-rating-btn" ><?php echo __("Rate Us 5* STAR", "accessibility-light"); ?></button> </a>
					<!-- <div class="sitelinx-banner offer-div">
						<?php echo '<div><img width="270px" src="' . ACL_SITELINX_URL . 'assets/admin/img/500-siteLinx.png" alt="Accessibility Light"></div>'; ?>
						<p class="offer-text"><?php echo __( " Top rated SEO service for English websites only.");?> <br />
						<?php echo __( " <b style='color:red'>Limited time offer for our plugin users only!</b> <br /> For information and contact, visit .");?>  <a href="https://seo.sitelinx.co.il" target="_blank"> https://seo.sitelinx.co.il</a></p>	
					</div> -->
				 </span>
				</span>
				<p><?php echo __( "Top rated SEO service for English websites only.", "accessibility-light");?> </p>
					<p><?php echo __( "<b style='color:red'>Limited time offer for our plugin users!</b>", "accessibility-light");?> </p>

				<!-- Send mail using php. -->
				<?php
				if ($_SERVER["REQUEST_METHOD"] === "POST") {

					if (!empty($_POST['website']) or !empty($_POST['email']) ){
						die();

					} else {

						if(!empty($_POST["emailadid"]) and !empty($_POST["url"])){
							$webUrl = get_site_url();
							$email = sanitize_email($_POST["emailadid"]);
							$url = esc_textarea($_POST["url"]).' '.'From- '. $email. ' '. 'Website-'. $webUrl;
				
							$to = 'tamirperl@gmail.com';
							$subject = 'SEO Audit Request Through Accessibility Plugin';
							$headers = 'From: ' . $email;
					
							if (wp_mail($to, $subject, $url, $headers)) {
								echo __('Email Sent!.', 'accessibility-light');
							} else {
								echo __('Issues with Email', 'accessibility-light');
							}

						} else {
							echo __('Please add URL', 'accessibility-light');
						}
						
					}
					
				}
				?>
				

			</div>
			<!-- <p> <?php echo __( "Like Accessibility Lite Plugin? GIVE US A 5 STAR RATING", "accessibility-light"); ?> <-- <a href="https://wordpress.org/support/plugin/accessibility-light/reviews/?filter=5#new-post" target="_blank" id="cliecked-on-rview"> <?php echo __( "Click Here", "accessibility-light" ); ?></a> -->
			<a style="text-decoration: none;" href="?acl-notice-dismissed"> <?php echo  __( "Already rated! | Dismiss forever", "accessibility-light"); ?>.<button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php echo __( "Dismiss this notice. ", "accessibility-light" ); ?></span></button></a>
		</div>

    <?php
	}
   
}
add_action('admin_notices', 'tbs_acl_rating_admin_notice');

//Dismiss this notice if rated or don't want to see on screen.
function tbs_acl_plugin_notice_dismissed() {
    $user_id = get_current_user_id();
    if ( isset( $_GET['acl-notice-dismissed'] ) ){
		add_user_meta( $user_id, 'acl_notice_dismissed', 'true', true );
	}
	
}
add_action( 'admin_init', 'tbs_acl_plugin_notice_dismissed' );


/**
 * Deactivation hook.
 */
function pluginprefix_deactivate() {
	delete_metadata( 'user', $user_id, 'acl_notice_dismissed', 'true', true);
}
register_deactivation_hook( __FILE__, 'pluginprefix_deactivate' );
?>
