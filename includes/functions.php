<?php
/*
 * functions.php
 * Function for frontend
 * @Version: 1.0
 * @author: Sitelinx
 */
function acl_sitelinx_body_classes( $classes ) {
	$sitelinx = get_option('sitelinx');
	// underline
	
	$classes[] = 'acl-sitelinx';
	
	if( isset($sitelinx['underline_important']) ) {
		$classes[] = 'sitelinx-underline-important';
	}
	
	// mlinks
	
	if( isset($sitelinx['mlinks_important']) ) {
		$classes[] = 'sitelinx-mlinks-important';
	}
	
	$get_link_underl = isset($sitelinx['link_underline']) ? $sitelinx['link_underline'] : '';
	if( $get_link_underl === 'focus' ) {
		$classes[] = 'sitelinx-underline-focus';

	} elseif( $get_link_underl === 'hover' ) {
		$classes[] = 'sitelinx-underline-hover';

	} elseif( $get_link_underl === 'all' ) {
		$classes[] = 'sitelinx-underline-all';
	}
	
	if( isset($sitelinx['underline_important']) ) {
		$classes[] = 'sitelinx-underline-important';
	}
	
	// contrast
	
	if( isset($sitelinx['contrast_important']) ) {
		$classes[] = 'sitelinx-contrast-important';
	}
	
	// heading marks
	
	if( isset($sitelinx['mheading_important']) ) {
		$classes[] = 'sitelinx-mheading-important';
	}
	
	// readable
	
	if( isset($sitelinx['readable_important']) ) {
		$classes[] = 'sitelinx-readable-important';
	}
	
	// outline
	$get_focus = isset( $sitelinx['focus'] ) ? $sitelinx['focus'] : '';
	if( $get_focus === 'toolbar' ) {

		$get_focus_type = isset($sitelinx['focus_type']) ? $sitelinx['focus_type'] : '';

		if( $get_focus_type === 'custom' ) {
			$classes[] = 'sitelinx-outline-custom';
		} elseif( $get_focus_type === 'red' ) {
			$classes[] = 'sitelinx-outline-red';
		} elseif( $get_focus_type === 'blue' ) {
			$classes[] = 'sitelinx-outline-blue';
		} elseif( $get_focus_type === 'yellow' ) {
			$classes[] = 'sitelinx-outline-yellow';
		}
		if( isset($sitelinx['outline_important']) ) {
			$classes[] = 'sitelinx-outline-important';
		}
	} elseif( $get_focus === 'always' ) {
		$classes[] = 'sitelinx-outline-always';
		
		if( $get_focus_type === 'custom' ) {
			$classes[] = 'sitelinx-outline-custom';
		} elseif( $get_focus_type === 'red' ) {
			$classes[] = 'sitelinx-outline-red';
		} elseif( $get_focus_type === 'blue' ) {
			$classes[] = 'sitelinx-outline-blue';
		}
		if( isset($sitelinx['outline_important']) ) {
			$classes[] = 'sitelinx-outline-important';
		}
	}
	
	
	// empty alt
    
    if( isset($sitelinx['empty_alt']) ) {
		$classes[] = 'sitelinx-alt';
	}
	
    return $classes;
}
add_filter( 'body_class', 'acl_sitelinx_body_classes' );

function acl_sitelinx_head() {
	$sitelinx = get_option('sitelinx');
	$color = ( isset($sitelinx['outline_color']) ) ? $sitelinx['outline_color'] : '';
	$important = ( isset($sitelinx['outline_important']) ) ? ' !important' : '';
	
	echo '<style>body.sitelinx-outline-always.sitelinx-outline-custom *:focus, body.sitelinx-outline.sitelinx-outline-custom *:focus {outline: 1px solid '.$color.$important.';}</style>';
}

$sitelinx = get_option('sitelinx');
if( isset($sitelinx) && isset($sitelinx['focus']) && $sitelinx['focus'] != 'none' && $sitelinx['focus_type'] === 'custom' && $sitelinx['outline_color'] != '' ) {
	add_filter( 'wp_head', 'acl_sitelinx_head' );
}

