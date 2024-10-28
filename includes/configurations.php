<?php
/*
 * Configuration.php
 * All plugin configuration need to be written here
 * @Version: 1.0
 * @author: Sitelinx
 */

if( ! defined( 'ABSPATH' ) ) exit(); //protect this file
 
/**
 * Declare $configurations 
 * @type: array()
 */

$configurations = array();
 
/**
 * Plugin Info
 */
 
/* plugin name :: write your plugin name (without space) */
$configurations['plugin_name'] = 'accessibility-light';

/* plugin textdomain :: write your plugin textdomain (must be the same as plugin dir base name) */
$configurations['plugin_textdomain'] = 'accessibility-light';

/* plugin path name :: write your plugin path constant variable name */
$configurations['path'] = 'ACL_SITELINX_PATH';

/* plugin path name :: write your plugin url constant variable name */
$configurations['url'] = 'ACL_SITELINX_URL';

/**
 * Public Styles
 * the files need to placed in 'assets/css/'
 * Example:
 * $configurations['styles'][0]['handle']	= 'style';
 * $configurations['styles'][0]['src']		= 'style.css';
 * $configurations['styles'][0]['deps']		= array();
 * $configurations['styles'][0]['ver']		= false;
 * $configurations['styles'][0]['media']	= 'all';
 */
 
$styles[] = array(
			'handle' => 'accessibility-light',
			'src'	 => 'accessibility-light.css'
		);
$configurations['styles'] = $styles;
 
/* put code up here */
 
/**
 * Public Scripts
 * the files need to placed in 'assets/js/'
 * Example:
 * $configurations['scripts'][0]['handle']		= 'script';
 * $configurations['scripts'][0]['src']			= 'scripts.css';
 * $configurations['scripts'][0]['deps']		= array();
 * $configurations['scripts'][0]['ver']			= false;
 * $configurations['scripts'][0]['in_footer']	= false;
 */
 
$scripts[] = array(
			'handle' => 'accessibility-light',
			'src'	 => 'accessibility-light.js',
			'deps'	 => array('jquery')
		);
$scripts[] = array(
			'handle' => 'jscolor',
			'src'	 => 'jscolor.js',
			'deps'	 => array('jquery')
		);
$configurations['scripts'] = $scripts;
 
/* put code up here */

/**
 * Admin Styles
 * the files need to placed in 'assets/admin/css/'
 * Example:
 * $configurations['admin_styles'][0]['handle']	= 'style';
 * $configurations['admin_styles'][0]['src']	= 'style.css';
 * $configurations['admin_styles'][0]['deps']	= array();
 * $configurations['admin_styles'][0]['ver']	= false;
 * $configurations['admin_styles'][0]['media']	= 'all';
 */

$admin_styles[] = array(
			'handle' => 'admin-accessibility-light',
			'src'	 => 'admin-accessibility-light.css'
		);
$admin_styles[] = array(
			'handle' => 'admin-accessibility-light-spectrum',
			'src'	 => 'spectrum.css'
		);
$configurations['admin_styles'] = $admin_styles; 
 
/* put code up here */
 
/**
 * Admin Scripts
 * the files need to placed in 'assets/admin/js/'
 * Example:
 * $configurations['admin_scripts'][0]['handle']	= 'script';
 * $configurations['admin_scripts'][0]['src']		= 'scripts.css';
 * $configurations['admin_scripts'][0]['deps']		= array();
 * $configurations['admin_scripts'][0]['ver']		= false;
 * $configurations['admin_scripts'][0]['in_footer']	= false;
 */

$admin_scripts[] = array(
			'handle' => 'admin-accessibility-light',
			'src'	 => 'admin-accessibility-light.js'
		);
$admin_scripts[] = array(
			'handle' => 'admin-accessibility-color-picker',
			'src'	 => 'spectrum.js'
		);
$admin_scripts[] = array(
			'handle' => 'admin-accessibility-toc',
			'src'	 => 'toc.js'
		);
$admin_scripts[] = array(
			'handle' => 'admin-accessibility-docs',
			'src'	 => 'docs.js'
		);
$configurations['admin_scripts'] = $admin_scripts; 
 
/* put code up here */

/**
 * Include files
 * the files need to placed in 'includes/'
 * Example:
 * $configurations['includes'][] = 'file.php';
 */

$configurations['includes'][] = 'functions.php';
$configurations['includes'][] = 'admin/functions.php'; 

/* put code up here */


/**
 * Include Classes
 * the files need to placed in 'includes/'
 * Example:
 * $configurations['classes']['Class_Name'] = 'class-file.php';
 */

$configurations['classes']['ACL_Sitelinx_Toolbar'] = 'class-toolbar.php'; 
$configurations['classes']['ACL_Sitelinx_Settings'] = 'admin/class-settings.php'; 
 
/* put code up here */
?>