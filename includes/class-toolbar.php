<?php
/* 
 * class-toolbar.php
 * Display toolbar on frontend
 * @Version: 1.0
 * @author: Sitelinx
 */
class ACL_Sitelinx_Toolbar {
	
	private $options;
	
	public function __construct() {
		
		$this->options = get_option( 'sitelinx' );
		
		if(!isset($this->options['accessibility_enable'])) {
			
			if(!isset($this->options['hide_toolbar_mobile'])) {
				if( !wp_is_mobile() ) {
					add_action('wp_footer', array($this, 'toolbar_btn'));
					add_action('wp_footer', array($this, 'black_screen'));
					add_action('wp_footer', array($this, 'the_toolbar'));
				}
			} else {
				add_action('wp_footer', array($this, 'toolbar_btn'));
				add_action('wp_footer', array($this, 'black_screen'));
				add_action('wp_footer', array($this, 'the_toolbar'));
			}
			
		}
    }
	
	public function toolbar_btn() {
	    $icon_size			= (isset($this->options['icon_size'])) ? $this->options['icon_size'] : 'normal';
	    $toolbar_side		= isset($this->options['toolbar_side']) ? $this->options['toolbar_side'] : 'right';

	    $image_icon			= (isset($this->options['replacetoggle_icon'])) ? true : false;

	    //check if it not buttom.
	    if( $toolbar_side == "lower-left" || $toolbar_side == "lower-right" ){

			$toolbar_position	= !empty($this->options['toolbar_position']) ? $this->options['toolbar_position'] : 1;
	    }else{
	    	$toolbar_position	= !empty($this->options['toolbar_position']) ? $this->options['toolbar_position'] : 200;
	    }

	    
	    $toolbar_position_side	= !empty($this->options['toolbar_position_side']) ? $this->options['toolbar_position_side'] : 1;

	    if( isset( $this->options['toolbar_icon_height'] )  && $this->options['toolbar_icon_height'] != "" ){

	    	$icon_height = $this->options['toolbar_icon_height'];

	    }else{

	    	$icon_height = "34";
	    }

	    if( isset( $this->options['toolbar_icon_width'] ) &&  $this->options['toolbar_icon_width'] != "" ){

	    	$icon_width = $this->options['toolbar_icon_width'];
	    }else{
	    	
	    	$icon_width = "34";
	    }
	    

	    //$icon_shape	= (!empty($this->options['icon_shape'] == 'circle')) ? '50%' : '2px';
	    if( isset( $this->options['icon_shape'] ) ){
	    	$icon_shape_check = $this->options['icon_shape'];
	    }
	    else{
	    	$icon_shape_check = array();
	    }

	    $icon_shape	= ( !empty( $icon_shape_check == 'circle' ) ) ? '50%' : '2px';
	    
		
		$style_side = $toolbar_side . ': ' .  $toolbar_position_side . 'px;';

		// $img_size = isset( $this->options['img_size'] ) ? $this->options['img_size'] : '';
		// switch( $img_size ){
		// 	case "1":
		// 	    $default_icon = ACL_SITELINX_URL . 'assets/img/wheelchair24.png';
		// 	    break;
		// 	case "2":
		// 	     $default_icon = ACL_SITELINX_URL . 'assets/img/wheelchair.png';
		// 	      break;
		// 	case "3":
		// 	    $default_icon = ACL_SITELINX_URL . 'assets/img/wheelchair64.png';
		// 	    break;
		// 	default:
		// 	    $default_icon = ACL_SITELINX_URL . 'assets/img/wheelchair.png';
		// }
		
		$default_icon = ACL_SITELINX_URL . 'assets/img/wheelchair.png';

		$external_link = (!empty($this->options['toolbar_icon'])) ? $this->options['toolbar_icon'] : $default_icon;
		if (@getimagesize($external_link)) {
			$toolbar_icon = $external_link;
		} else {


			//$img_t_size = isset( $this->options['img_size'] ) ? $this->options['img_size'] : '';
			// switch( $img_t_size ){
			// 	case "1":
			// 	    $toolbar_icon = ACL_SITELINX_URL . 'assets/img/wheelchair24.png';
			// 	    break;
			// 	case "2":
			// 	     $toolbar_icon = ACL_SITELINX_URL . 'assets/img/wheelchair.png';
			// 	      break;
			// 	case "3":
			// 	    $toolbar_icon = ACL_SITELINX_URL . 'assets/img/wheelchair64.png';
			// 	    break;
			// 	default:
			// 	   $toolbar_icon = ACL_SITELINX_URL . 'assets/img/wheelchair.png';
			// }
			$toolbar_icon = ACL_SITELINX_URL . 'assets/img/wheelchair.png';
		}
		$color_icon = (isset($this->options['color_icon'])) ? $this->options['color_icon'] : '#0a76be';

	    if( $toolbar_side == "lower-left" || $toolbar_side == "lower-right" ){

	    	if( $toolbar_side == "lower-left" ){

	    		$toolbar_side = "left";
	    		$style_side = $toolbar_side . ': ' .  $toolbar_position_side . 'px;';
	    	}
	    	if( $toolbar_side == "lower-right" ){

	    		$toolbar_side = "right";

	    		$style_side = $toolbar_side . ': ' .  $toolbar_position_side . 'px;';
	    	}

		    $output  = '<button type="button" id="sitelinx-toggle-toolbar" class="' . $icon_size . ' toolbar-'.$toolbar_side.'" style="bottom: ' . $toolbar_position . 'px;' . $style_side . 'background-color: '.$color_icon.'!important;border-radius: '.$icon_shape.' !important;">';
		}else{

			$output  = '<button type="button" id="sitelinx-toggle-toolbar" class="' . $icon_size . ' toolbar-'.$toolbar_side.'" style="top: ' . $toolbar_position . 'px;' . $style_side . 'background-color: '.$color_icon.'!important;border-radius: '.$icon_shape.' !important;">';

		}

	    $output .= '<img src="' . $toolbar_icon . '" alt="' . __('Accessibility Icon', 'accessibility-light') . '" style="background-color: '.$color_icon.';border-radius: '.$icon_shape.' !important;">';
	    $output .= '</button>';
	    
	    echo $output;
    }
	
	public function black_screen() {
	    if( !isset($this->options['disable_blackscreen']) )
		    echo '<div id="sitelinx-black-screen"></div>';
    }
	
	public function the_toolbar() {
	    $toolbar_position	= (isset($this->options['toolbar_position'])) ? $this->options['toolbar_position'] : 25;
	    $skin = (isset($this->options['toolbar_skin'])) ? $this->options['toolbar_skin'] : 1;
	    ?>
		<!-- Commenting this line to fix the css error by Ashish -->
	    <!-- <style>#sitelinx-toggle-toolbar{top:<?php //echo $toolbar_position;?>px;}</style> -->
	     <!-- This for bottom left and right position -->
	    <?php
	    // $toolbar_side = "";
	    // $toolbar_side =  $this->options['toolbar_side'];
	    // if( $toolbar_side == ){

	    // }
	     $toolbar_side	= (isset($this->options['toolbar_side'])) ? $this->options['toolbar_side'] : "";

	    	if( $toolbar_side == "lower-left" || $toolbar_side == "lower-right" ){
	    		
		    	if( $toolbar_side == "lower-left" ){

		    		$side = "left";
		    		
		    	} if( $toolbar_side == "lower-right" ){

		    		$side = "right";
		    		
		    	}

		    	?> 

				<div id="sitelinx-toolbar" class="sitelinx-toolbar sitelinx-toolbar-skin-<?php echo $skin;?> toolbar-<?php echo $side;?>" aria-hidden="true">
			    	<button id="sitelinx-close-toolbar">
			    		<span class="sr-only"><?php _e('Close the accessibility toolbar', 'accessibility-light');?></span>
			    		<span class="sitelinx-close-icon" aria-hidden="true"></span>
			    	</button>
		            <div class="sitelinx-toolbar-heading">
						<p><?php _e('Accessibility', 'accessibility-light');?></p>
		            </div>
			    	<ul class="sitelinx-main-nav" style="<?php if( $side == "left" ){ echo "padding-right:30px"; } else{ echo "padding-left:30px"; } ?>">
				    	<?php
					    	echo $this->section_general();
					    	if(!isset($this->options['disable_zoom'])) {
						    	echo $this->section_resolution();
					    	}
					    	if(!isset($this->options['disable_fontzoom']) || !isset($this->options['hide_readable'])) {
						    	echo $this->section_font();
					    	}
					    	if(!isset($this->options['hide_contrast'])) {
						    	echo $this->section_contrast();
					    	}
					    	if(!isset($this->options['hide_underline']) || !isset($this->options['hide_linkmarks'])) {
						    	echo $this->section_links();
					    	}
						    echo $this->section_additional();
					    ?>
			    	</ul>
			    </div>
		    	<?php 
	    	} else{

	    ?>
	    <!-- End of bottom right and left positions -->

	    <div id="sitelinx-toolbar" class="sitelinx-toolbar sitelinx-toolbar-skin-<?php echo $skin;?> toolbar-<?php echo $this->options['toolbar_side'];?>" aria-hidden="true">
	    	<button id="sitelinx-close-toolbar">
	    		<span class="sr-only"><?php _e('Close the accessibility toolbar', 'accessibility-light');?></span>
	    		<span class="sitelinx-close-icon" aria-hidden="true"></span>
	    	</button>
            <div class="sitelinx-toolbar-heading">
				<h2 class="toolbar-heading-text"><?php _e('Accessibility Bar', 'accessibility-light');?></h2>
            </div>
	    	<ul class="sitelinx-main-nav" style="<?php if( $toolbar_side == "left" ){ echo "padding-right:30px"; } if(  $toolbar_side == "right" ){ echo "padding-left: 30px"; } else{ echo "padding-left:30px"; } ?>" >
		    	<?php
			    	echo $this->section_general();
			    	if(!isset($this->options['disable_zoom'])) {
				    	echo $this->section_resolution();
			    	}
			    	if(!isset($this->options['disable_fontzoom']) || !isset($this->options['hide_readable'])) {
				    	echo $this->section_font();
			    	}
			    	if(!isset($this->options['hide_contrast'])) {
				    	echo $this->section_contrast();
			    	}
			    	if(!isset($this->options['hide_underline']) || !isset($this->options['hide_linkmarks'])) {
				    	echo $this->section_links();
			    	}
				    echo $this->section_additional();
			    ?>
	    	</ul>
	    </div>
		<?php }
    }
	
	public function section_general() {
	    $get_focus = isset( $this->options['focus'] ) ? $this->options['focus'] : '';
	    $focus = ( $get_focus === 'toolbar') ? true : false;
	    $disable_flashes = isset($this->options['hide_flashes']);
	    $disable_hemarks = isset($this->options['hide_headingmarks']);
	    $disable_background = isset($this->options['hide_background']);
	    
	    
	    $output = '';
	    
	    if( !$disable_flashes || $focus || !$disable_hemarks ) {
		    $output .= '<li>';
		    	// $output .= '<p class="sitelinx-label" id="sitelinx-label-general">' . __('General', 'accessibility-light') . '</p>';
				$output .= '<ul class="ul-sub">';
				
				if( !$disable_flashes ) {
					$output .= '<li>';   
						$output .= '<p id="sitelinx_disable_animation" tabindex="-1" aria-label="sitelinx-label-general">';
							$output .= '<i class="material-icons" aria-hidden="true">visibility_off</i>';
							$output .= '<span>' . __('Disable flashes', 'accessibility-light') . '</span>';	
						$output .= '</p>';
					$output .= '</li>';
				}
					
				if( $focus ) {
					$output .= '<li>';
						$output .= '<p id="sitelinx_keys_navigation" tabindex="-1" aria-labelledby="sitelinx-label-general">';
							$output .= '<i class="material-icons" aria-hidden="true">keyboard</i>';
							$output .= '<span>' . __('Keyboard navigation', 'accessibility-light') . '</span>';
						$output .= '</p>';
					$output .= '</li>';
				}
				if( !$disable_hemarks ) {
					$output .= '<li>';
						$output .= '<p id="sitelinx_headings_mark" tabindex="-1" aria-label="sitelinx-label-general">';
							$output .= '<i class="material-icons" aria-hidden="true">title</i>';
							$output .= '<span>' . __('Mark headings', 'accessibility-light') . '</span>';
						$output .= '</p>';
					$output .= '</li>';
				}
				if( !$disable_background ) {
					$output .= '<li>';
						$output .= '<p id="sitelinx_background_color" tabindex="-1" aria-label="sitelinx-label-general">';
							$output .= '<i class="material-icons" aria-hidden="true">settings</i>';
							$output .= '<span>' . __('Background Color', 'accessibility-light') . '</span>';
						$output .= '</p>';
						$output .= "<p class=\"sitelinx_background_color\" style=\"display: none;\"><input class=\"jscolor\" value='66ccff'></p>";
					$output .= '</li>';
				}
					
				$output .= '</ul>';
			$output .= '</li>';
	    }
		
		return $output;
    }
	
	public function section_resolution() {
	    $output  = '<li class="sitelinx-li-zoom">';
	    	// $output .= '<p class="sitelinx-label" id="sitelinx-label-resolution">' . __('Resolution', 'accessibility-light') . '</p>';
	    	$output .= '<ul class="ul-sub">';
				$output .= '<li>';
					$output .= '<p id="sitelinx_screen_down" tabindex="-1" aria-label="sitelinx-label-resolution">';
						$output .= '<i class="material-icons" aria-hidden="true">zoom_out</i>';
						$output .= '<span>' . __('Zoom out', 'accessibility-light') . '</span>';
					$output .= '</p>';
				$output .= '</li>';
	    		$output .= '<li>';
	    			$output .= '<p id="sitelinx_screen_up" tabindex="-1" aria-label="sitelinx-label-resolution">';
						$output .= '<i class="material-icons" aria-hidden="true">zoom_in</i>';
						$output .= '<span>' . __('Zoom in', 'accessibility-light') . '</span>';	
					$output .= '</p>';
				$output .= '</li>';

			$output .= '</ul>';
		$output .= '</li>';
		
		return $output;
    }
	
	public function section_font() {
	    $output  = '<li class="sitelinx-li-fonts">';
	    	// $output .= '<p class="sitelinx-label" id="sitelinx-label-fonts">' . __('Fonts', 'accessibility-light') . '</p>';

	    	if(!isset($this->options['disable_fontzoom'])) {
                $output .= '<ul class="ul-sub">';

					$output .= '<li>';
						$output .= '<p id="sitelinx_fontsize_down" tabindex="-1" aria-label="sitelinx-label-fonts">';
							$output .= '<i class="material-icons" aria-hidden="true">remove_circle_outline</i>';
							$output .= '<span>' . __('Decrease font', 'accessibility-light') . '</span>';
						$output .= '</p>';
					$output .= '</li>';
					$output .= '<li>';
						$output .= '<p id="sitelinx_fontsize_up" tabindex="-1" aria-label="sitelinx-label-fonts">';
							$output .= '<i class="material-icons" aria-hidden="true">add_circle_outline</i>';
							$output .= '<span>' . __('Increase font', 'accessibility-light') . '</span>';
						$output .= '</p>';
					$output .= '</li>';
                $output .= '</ul>';
	    	}
	    	if(!isset($this->options['hide_readable'])) {
                $output .= '<ul class="ul-sub">';
					$output .= '<li>';
						$output .= '<p id="sitelinx_readable_font" tabindex="-1" aria-label="sitelinx-label-fonts">';
							$output .= '<i class="material-icons" aria-hidden="true">spellcheck</i>';
							$output .= '<span>' . __('Readable font', 'accessibility-light') . '</span>';
						$output .= '</p>';
					$output .= '</li>';
                $output .= '</ul>';
	    	}
				

	    $output .= '</li>';
		
		return $output;
    }
	
	public function section_contrast() {
	     $output  = '<li class="sitelinx-li-contrast">';
	    	// $output .= '<p class="sitelinx-label" id="sitelinx-label-contrast">' . __('Color Contrast', 'accessibility-light') . '</p>';
	    	$output .= '<ul class="ul-sub">';
	    		$output .= '<li>';
	    			$output .= '<p id="sitelinx_contrast_bright" tabindex="-1" aria-label="sitelinx-label-contrast">';
		    			$output .= '<i class="material-icons" aria-hidden="true">brightness_high</i>';
		    			$output .= '<span>' . __('Bright contrast', 'accessibility-light') . '</span>';
					$output .= '</p>';
				$output .= '</li>';
				$output .= '<li>';
	    			$output .= '<p id="sitelinx_contrast_dark" tabindex="-1" aria-label="sitelinx-label-contrast">';
		    			$output .= '<i class="material-icons" aria-hidden="true">brightness_low</i>';
		    			$output .= '<span>' . __('Dark contrast', 'accessibility-light') . '</span>';
					$output .= '</p>';
				$output .= '</li>';
			$output .= '</ul>';
	    $output .= '</li>';
		
		return $output;
    }
	
	public function section_links() {

		$get_ul = isset( $this->options['link_underline'] ) ? $this->options['link_underline'] : '';

	    $ul_classes = ( $get_ul != 'all') ? 'ul-2-items' : '';
	    
	    $output  = '<li>';
	    	// $output .= '<p class="sitelinx-label" id="sitelinx-label-links">' . __('Links', 'accessibility-light') . '</p>';
	    	$output .= '<ul class="ul-sub ' . $ul_classes . '">';
	    	$get_link_underline = isset($this->options['link_underline']) ? $this->options['link_underline'] : '';
    		if( $get_link_underline != 'all' && !isset($this->options['hide_underline']) ) {
	    		$output .= '<li>';
	    			$output .= '<p id="sitelinx_links_underline" tabindex="-1" aria-label="sitelinx-label-links">';
		    			$output .= '<i class="material-icons" aria-hidden="true">format_underlined</i>';
		    			$output .= '<span>' . __('Underline links', 'accessibility-light') . '</span>';
					$output .= '</p>';
				$output .= '</li>';
    		}
    		if( !isset($this->options['hide_linkmarks']) ) {
	    		$output .= '<li>';
	    			$output .= '<p id="sitelinx_links_mark" tabindex="-1" aria-label="sitelinx-label-links">';
		    			$output .= '<i class="material-icons" aria-hidden="true">font_download</i>';
						$output .= '<span>' . __('Mark links', 'accessibility-light') . '</span>';
					$output .= '</p>';
				$output .= '</li>';
    		}
			$output .= '</ul>';
	    $output .= '</li>';

		return $output;
    }
	
	public function section_additional() {
	    $statement = (isset($this->options['sitelinx_statement'])) ? $this->options['sitelinx_statement'] : '';
	    $feedback = (isset($this->options['sitelinx_feedback'])) ? $this->options['sitelinx_feedback'] : '';
        $this->section_general();
	    
	    
	     $output  = '<li class="sitelinx-li-reset">';
	    	// $output .= '<p class="sitelinx-label">' . __('Additional Options', 'accessibility-light') . '</p>';
	    	$output .= '<ul class="ul-sub ul-general">';
	    	
	    		$output .= '<li><p id="sitelinx-reset" tabindex="-1" title="'.__('Reset all options', 'accessibility-light').'">';
		    	$output .= '<span class="sr-only">' . __('Reset all options', 'accessibility-light') . '</span>';
		    	$output .= '<i class="material-icons" aria-hidden="true">cached</i>';
		    	$output .= '</p></li>';

		    	// if( $feedback ) {
				   //  $output .= '<li><a href="'.get_page_link($feedback).'" id="sitelinx_feedback" tabindex="-1" title="' . __('Leave feedback', 'accessibility-light') . '">';
			    // 		$output .= '<i class="material-icons" aria-hidden="true">flag</i>';
			    // 		$output .= '<span class="sr-only">' . __('Leave feedback', 'accessibility-light') . '</span>';
			    // 	$output .= '</a></li>';
			    // }

			    if( $feedback ) {
				    $output .= '<li><a href="'.get_page_link($feedback).'" id="sitelinx_feedback" class="feedback-links"  title="' . __('Leave feedback', 'accessibility-light') . '">';
			    		$output .= '<i class="material-icons" id="show-ho-feed" aria-hidden="true" style="display:none;">flag</i>';
			    		$output .= '<span class="text-leavefeed hide-on-feed">' . __('Leave feedback', 'accessibility-light') . '</span>';
			    	$output .= '</a></li>';
			    }

			    if( $statement ) {
				    $output .= '<li><a href="'.get_page_link($statement).'" id="sitelinx_statement" class="feedback-links"  title="' . __('Accessibility statement', 'accessibility-light') . '">';
			    		$output .= '<i class="material-icons hide-on" id ="show-on-ho" aria-hidden="" style="display:none;">flag</i>';
			    		$output .= '<span class="text-leavefeed hide-on-hover-stat">' . __('Accessibility statement', 'accessibility-light') . '</span>';
			    	$output .= '</a></li>';
			    }
			    
			    // if( $statement ) {
				   //  $output .= '<li><a href="'.get_page_link($statement).'" id="sitelinx_statement" tabindex="-1" title="' . __('Accessibility statement', 'accessibility-light') . '">';
			    // 		$output .= '<i class="material-icons" aria-hidden="true">accessibility</i>';
			    // 		$output .= '<span class="sr-only">' . __('Accessibility statement', 'accessibility-light') . '</span>';
			    // 	$output .= '</a></li>';
			    // }

				$output .= '<li class="sitelinx-logolight">';
                if(!isset($this->options['remove_link'])) {
                    $output .= '<a href="https://sitelinx.co.il" rel="noreferrer noopener" target="_blank">';
                    $output .= '<img class="hover-off" src="' . ACL_SITELINX_URL . 'assets/img/accessibility-light-logolight80.png" alt="' . __('Accessibility Light', 'accessibility-light') . '" height="21" width="80">';
                    $output .= '</a>';
                }else{
                    $output .= '<img class="hover-off" src="' . ACL_SITELINX_URL . 'assets/img/accessibility-light-logolight80.png" alt="' . __('Accessibility Light', 'accessibility-light') . '" height="21" width="80">';
                }
		    	$output .= '</li>';
				
			$output .= '</ul>';
	    $output .= '</li>';
		
		return $output;
    }
	
}

?>