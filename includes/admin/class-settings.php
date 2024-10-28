<?php
/*
 * class-settings.php
 * Settings Backend
 * @Version: 1.0
 * @author: Sitelinx
 */ 
class ACL_Sitelinx_Settings {

    private $options;
	
	public function __construct() {
		
        add_action( 'admin_menu', array( $this, 'register_panel_page' ) );
        add_action( 'admin_init', array( $this, 'sitelinx_page_init' ) );
    }
	
	public function register_panel_page() {
		
	    add_menu_page( 'Accessibility', __('Accessibility', 'accessibility-light'), 'manage_options', 'accessible-sitelinx', array( $this, 'accessible_sitelinx_setting' ), ACL_SITELINX_URL . 'assets/admin/img/wheelchair.png', 59 );

    }
	
	public function accessible_sitelinx_setting() {
        $this->options = get_option( 'sitelinx' );
        ?>
        <div id="accessible-sitelinx-panel">
	        <div id="sitelinx-admin-row">
		        <div id="sitelinx-panel-content">
			        <form method="post" action="options.php">
				        <?php settings_fields( 'sitelinx_group' );?>
					    <div class="tabs-container tab-content" class="tab-content">
							<?php acl_sitelinx_header(); ?>
							<?php acl_sitelinx_sections( 'accessible-sitelinx' );?>
						</div>
			        </form>
		        </div>
	        </div>
	        
        </div>
        <?php	
    }

    public function sitelinx_page_init() {
        register_setting('sitelinx_group', 'sitelinx', array($this, 'sanitize'));

        $sections = array(
            'sitelinx_general' => __('General', 'accessibility-light'),
            'sitelinx_toolbar' => __('Toolbar', 'accessibility-light'),
            // 'sitelinx_skiplinks' => __('Skiplinks', 'accessibility-light'),
        );

        foreach ($sections as $section_key => $section_name) {
            add_settings_section($section_key, $section_name, array($this, 'empty_section_info'), 'accessible-sitelinx');
        }

        $fields = array(
            'accessibility_enable' => 'sitelinx_general',
            'focus' => 'sitelinx_general',
            'link_underline' => 'sitelinx_general',
            'empty_alt' => 'sitelinx_general',
            'toolbar' => 'sitelinx_toolbar',
            'toolbar_customization' => 'sitelinx_toolbar',
            'toolbar_visibility' => 'sitelinx_toolbar',
            'toolbar_skin' => 'sitelinx_toolbar',
            'toolbar_fontsizer' => 'sitelinx_toolbar',
            'toolbar_additional_buttons' => 'sitelinx_toolbar',
            'toolbar_important' => 'sitelinx_toolbar',
            // 'skiplinks' => 'sitelinx_skiplinks',
            // 'skiplinks_action' => 'sitelinx_skiplinks',
            // 'skiplinks_side' => 'sitelinx_skiplinks',
        );

        foreach ($fields as $field_key => $field_section) {
            add_settings_field($field_key, '', array( $this, $field_key . '_callback' ), 'accessible-sitelinx', $field_section);
        }
    }

    public function sanitize($input) {

        $new_input = array();

        foreach ($input as $key => $value) {
            $new_input[$key] = $value;
        }

        return $new_input;
    }

    /********** SECTIONS CALLBACKS **********/

    public function empty_section_info() {}

    /********** FIELDS CALLBACKS ***********/

    /*
     * Add alt attribute to images without alt
     *
     * @type    checkbox
     * @id      empty_alt
     */
    public function empty_alt_callback() {

        $field = '<div class="sitelinx-op-group">';
        
        	$field .= '<h3>' . __('Images', 'accessibility-light') . '</h3>';
			$field .= '<label class="checkbox"><input type="checkbox" id="empty_alt" name="sitelinx[empty_alt]" value="1" ' . checked( '1', isset( $this->options['empty_alt'] ), false ) . '> ' . __('Fix missing ALT attrributes on IMG tags', 'accessibility-light') . '</label>';
			
        $field  .= '</div>';

        printf($field,isset( $this->options['image_alt'] ) ? esc_attr( $this->options['image_alt']) : '');
    
    }

    /*
     * General Settings
     */
	public function accessibility_enable_callback() {		
		
		$field = '<h3>' . __('Disable the Accessibility', 'accessibility-light') . '</h3>';
		$field .= '<div class="sitelinx-op-group">';
			$field .= '<label class="checkbox">
					<input type="checkbox" id="accessibility_enable" name="sitelinx[accessibility_enable]" value="1" ' . checked('1', isset( $this->options['accessibility_enable'] ), false) . '> ' .  __('Disable', 'accessibility-light') . '</label>';
		$field .= '</div><hr>';
		$field .= '<div style="display: none;">' . __('Enable/Disable', 'accessibility-light') . '</div>';
		$field .= '<div style="display: none;">' . __('Activate the Accessibility', 'accessibility-light') . '</div>';
		
        printf($field,isset( $this->options['accessibility_enable'] ) ? esc_attr( $this->options['accessibility_enable'] ) : '');
		
	}
	
	/*
     * Add effect to all focusable items
     */
    public function focus_callback() {

        $focus          = isset($this->options['focus']) ? $this->options['focus'] : '';
        $focus_type     = isset($this->options['focus_type']) ? $this->options['focus_type'] : '';
        $customColor    = isset($this->options['outline_color']) ? $this->options['outline_color'] : '';
		
		$field = '<h3>' . __('Focus', 'accessibility-light') . '</h3>
                  <div class="row sitelinx-op-group">';
        $field .= '   <div class="col-sm-3">';
        $field .= '     <div class="sitelinx-op-group">
                          <label for="focus">'. __('Add effect to items on focus mode:','accessibility-light').'</label>
                          <select name="sitelinx[focus]" id="focus">
                            <option value="">' . __('Don\'t do nothing', 'accessibility-light') . '</option>
                            <option value="toolbar"' . selected($focus, 'toolbar', false) . '>' . __('Only using the toolbar', 'accessibility-light') . '</option>
                            <option value="always"' . selected($focus, 'always', false) . '>' . __('Use always', 'accessibility-light') . '</option>
                          </select>
                        </div>';
        $field .= '   </div>';

        printf($field,isset($focus) ? esc_attr($focus) : '');

        $field  = '   <div class="col-sm-3">';
        $field .= '     <div class="sitelinx-op-group">
                          <label for="focus_type">'. __('Choose the type of effect for focus mode:','accessibility-light').'</label>
                          <select name="sitelinx[focus_type]" id="focus_type">
                            <option value="">' . __('-- None --', 'accessibility-light') . '</option>
                            <option value="red"' . selected($focus_type, 'red', false) . '>' . __('Red outline', 'accessibility-light') . '</option>
                            <option value="blue"' . selected($focus_type, 'blue', false) . '>' . __('Blue outline', 'accessibility-light') . '</option>
                            <option value="yellow"' . selected($focus_type, 'yellow', false) . '>' . __('Yellow background', 'accessibility-light') . '</option>
                            <option value="custom"' . selected($focus_type, 'custom', false) . '>' . __('Custom Outline', 'accessibility-light') . '</option>
                          </select>
                        </div>';
        $field .= '   </div>';
		$field .= '</div>';

        printf($field,isset( $focus_type ) ? esc_attr( $focus_type ) : '');

        $outline_color_class = ( $focus_type === 'custom' ) ? ' open' : '';

        $field = '<div class="sitelinx-op-group outline_color-group'.$outline_color_class.'">
                    <label for="outline_color">'.__('Choose custom outline color for focus mode', 'accessibility-light').':</label>
                    <input type="color" id="outline_color" name="sitelinx[outline_color]" value="' . $customColor . '"> 
                  </div>';
                  //code for custom colorpicker
                  
        printf($field,isset( $this->options['outline_color'] ) ? esc_attr( $this->options['outline_color']) : '');
        
        $field = '<div class="sitelinx-op-group" style="background-color: transparent;">
                    <label>
                        <input type="checkbox" id="outline_important" name="sitelinx[outline_important]" value="1" ' . checked( '1', isset( $this->options['outline_important'] ), false ) . '> ' .  __('Use <strong>!important</strong> for the outline CSS (check this only if it\'s does not work).', 'accessibility-light') . '
                    </label>';
        $field .= '</div>';
		$field .= '<hr>';
		
        printf($field,isset( $this->options['outline_important'] ) ? esc_attr( $this->options['outline_important']) : '');
    }

    public function link_underline_callback() {
        $tbs_focus_only = isset($this->options['link_underline']) ? $this->options['link_underline'] : '';

        $focus_only = ( $tbs_focus_only == 'focus') ? ' selected' : '';
        $focus_hover = ( $tbs_focus_only == 'hover') ? ' selected' : '';
	    $on_all = ( $tbs_focus_only == 'all') ? ' selected' : '';

        $field = '<div class="sitelinx-op-group">';
        	$field .= '<h3>' . __('Links', 'accessibility-light') . '</h3>';
			$field .= '<label for="link_underline">'. __('Links Underline','accessibility-light').'</label>';
			$field .= '<select name="sitelinx[link_underline]" id="outline">';
				$field .= '<option value="none">' . __('-- None --', 'accessibility-light') . '</option>';
				$field .= ' <option value="focus"' . $focus_only . '>' . __('On focus mode only', 'accessibility-light') . '</option>';
				$field .= ' <option value="hover"' . $focus_hover . '>' . __('On focus and hover mode', 'accessibility-light') . '</option>';
				$field .= ' <option value="all"' . $on_all . '>' . __('Always', 'accessibility-light') . '</option>';
			$field .= '</select>';
        $field .= '</div>';
        printf($field,isset( $this->options['link_underline'] ) ? esc_attr( $this->options['link_underline']) : '');
        
        $field = '<div class="sitelinx-op-group">';
        	$field .= '<label><input type="checkbox" id="underline_important" name="sitelinx[underline_important]" value="1" ' . checked( '1', isset( $this->options['underline_important'] ), false ) . '> ' .  __('Use <strong>!important</strong> for the underline CSS (check this only if the underline does not work).', 'accessibility-light') . '</label>';
        $field .= '</div>';
		$field .= '<hr>';
		
        printf($field,isset( $this->options['underline_important'] ) ? esc_attr( $this->options['underline_important']) : '');
    }
	
    /*
     * Toolbar Settings
     */
	 
    public function toolbar_callback() {

        $get_toolbar_side = isset($this->options['toolbar_side']) ? $this->options['toolbar_side'] : '';
        $right = ($get_toolbar_side == 'right') ? ' selected' : '';
        $left = ( $get_toolbar_side == 'left') ? ' selected' : '';
        $lower_right = ($get_toolbar_side == 'lower-right') ? ' selected' : '';
        $lower_left = ( $get_toolbar_side == 'lower-left') ? ' selected' : '';
        $toolbar_icon = (isset($this->options['toolbar_icon'])) ? $this->options['toolbar_icon'] : '';
        $color_icon = (isset($this->options['color_icon'])) ? $this->options['color_icon'] : '#0a76be';

		$fields = array(
        	'disable_blackscreen' => __("Disable the black screen", 'accessibility-light'),
        	'hide_toolbar_mobile' => __("Show the toolbar for mobile users", 'accessibility-light'),
    	);

		$i = 0;
		foreach($fields as $key => $value) {
			
			$output = '';
			if($i == 0) {
	        	$output .= '<h3>' . __('Toolbar Settings', 'accessibility-light') . '</h3>';
	        	
	        	$output .= '<div class="row sitelinx-op-group"><div class="col-sm-4">';
        	}
			
			$output .= '<div class="'.$key.'">';
        	$output .= '<label class="checkbox"><input type="checkbox" id="'.$key.'" name="sitelinx['.$key.']" value="1" ' . checked( '1', isset( $this->options[$key] ), false ) . '> ' .  $value . '</label>';
			$output .= '</div>';
			
			printf($output,isset( $this->options[$key] ) ? esc_attr( $this->options[$key]) : '');
        	
        	$i++;
        }
		
        $field = '</div>';
		$field .= '<div class="col-sm-8">';
			$field .= '<div class="select">';
				$field .= '<label for="toolbar_side">' . __('Toolbar Side', 'accessibility-light') . ': ';
					$field .= '<select name="sitelinx[toolbar_side]" id="toolbar_side">';
                        
						$field .= '<option value="right"' . $right . '>' . __('Right side', 'accessibility-light') . '</option>';
						$field .= '<option value="left"' . $left . '>' . __('Left side', 'accessibility-light') . '</option>';
                        $field .= '<option value="lower-right"' . $lower_right . '>' . __('Bottom right', 'accessibility-light') . '</option>';
                        $field .= '<option value="lower-left"' . $lower_left . '>' . __('Bottom left', 'accessibility-light') . '</option>';
                        
					$field .= '</select>';
				$field .= '</label>';
			$field .= '</div>';
		
		printf($field,isset( $this->options['toolbar_side'] ) ? esc_attr( $this->options['toolbar_side']) : '');
		
			$field = '<div class="toolbar-icon">';
				$field .= '<label for="toolbar_side">' . __('Toolbar Icon', 'accessibility-light') . ': ';
						
					wp_enqueue_media();
					$field .= '<input type="text" name="sitelinx[toolbar_icon]" id="toolbar_icon" value="' . $toolbar_icon . '">';
					$field .= '<input id="upload_image_button" type="button" class="button" value="' . __( "Upload Icon", "accessibility-light") .'" />';	
				$field .= '</label>';
				
				$field .= '<div class="sitelinx-preview-logo">';
				$field .= '</div>';
				$field .= '<small class="img-info">' . __("Max size", "accessibility-light") . ': 300px &times; 300px ' . __("proporsional", "accessibility-light") . ': 64px &times; 64px</small>';
						
			$field .= '</div>';
			
		printf($field,isset( $this->options['toolbar_icon'] ) ? esc_attr( $this->options['toolbar_icon']) : '');
		
			$field = '<div class="color-icon">';
				$field .= '<label for="toolbar_side">' . __('Background color Icon', 'accessibility-light') . ': ';
				$field .= '<input type="color" id="color_icon" name="sitelinx[color_icon]" value="'.$color_icon.'">';	
				$field .= '</label>';
			$field .= '</div>';
        $field .= '</div></div><hr />';
        ?>
        <?php 

        printf($field,isset( $this->options['color_icon'] ) ? esc_attr( $this->options['color_icon']) : '');
    }

    
	/*
     * Show/Hide Toolbar List
     */
    public function toolbar_visibility_callback() {
	    
	    $fields = array(
        	
        	'hide_flashes' => __("Hide the button to disable flashes", 'accessibility-light'),
        	'hide_headingmarks' => __("Hide the button to to mark heading", 'accessibility-light'),
        	'hide_background' => __("Hide the button to change background color", 'accessibility-light'),
        	
        	'disable_zoom' => __("Hide the screen zoom buttons", 'accessibility-light'),
        	'disable_fontzoom' => __("Hide the font resize buttons", 'accessibility-light'),
        	'hide_readable' => __("Hide the button that change to readable font", 'accessibility-light'),
        	
        	'hide_contrast' => __("Hide the contrast buttons", 'accessibility-light'),
        	
        	'hide_underline' => __("Hide the underline button", 'accessibility-light'),
        	'hide_linkmarks' => __("Hide the button to mark links", 'accessibility-light'),
            'remove_link' => __("Remove promotional link", 'accessibility-light'),

    	);
    	
    	$i = 0;
    	
    	
    	foreach($fields as $key => $value) {
        	$i++;
        	
        	$output = '';
        	
        	if($i == 1) {
	        	$output .= '<h3>' . __('Toolbar Menu', 'accessibility-light') . '</h3>';
	        	
	        	$output .= '<div class="sitelinx-op-group">';
        	}
        	
        	$output .= '<label class="checkbox"><input type="checkbox" id="'.$key.'" name="sitelinx['.$key.']" value="1" ' . checked( '1', isset( $this->options[$key] ), false ) . '> ' .  $value . '</label>';
        	
        	if($i == 10) {
				
	        	$output .= '</div><hr />';
        	}
        	
        	printf($output,isset( $this->options[$key] ) ? esc_attr( $this->options[$key]) : '');
        	
        }
    }
    
    public function toolbar_important_callback() {
        	
    	$fields = array(
        	'mheading_important' => __("Mark headings mode", 'accessibility-light'),
        	'readable_important' => __("Readable font mode", 'accessibility-light'),
        	'contrast_important' => __("Contrast modes", 'accessibility-light'),
        	'underline_important' => __("Underline mode", 'accessibility-light'),
        	'mlinks_important' => __("Mark links mode", 'accessibility-light'),
    	);
        	
    	$i = 0;
    	foreach($fields as $key => $value) {
        	$i++;
        	$field_output = '';
	        	
	        	if($i == 1) {
		        	$field_output .= '<h3>' . __('CSS Important (Advanced)', 'accessibility-light') . '</h3>';
					$field_output .= '<p>' . __('You can hardened the effect of some toolbar button with the use of CSS important. this is not the best way, the best way is to implement a better CSS by yourself with Accessible sitelinx set of classes.', 'accessibility-light') . '</p>';
					$field_output .= '<div class="sitelinx-op-group">';
	        	}
	        	$field_output .= '<label class="checkbox">';
	        	$field_output .= '<input type="checkbox" id="'.$key.'" name="sitelinx['.$key.']" value="1" '.checked( '1',isset($this->options[$key]), false ).'> ';
				$field_output .= $value;
				$field_output .= '</label>';
				
				if($i == count($fields)) {
					$field_output .= '</div>';
				}
				printf($field_output,isset( $this->options[$key] ) ? esc_attr( $this->options[$key]) : '');
        	}
    }
	
    public function toolbar_customization_callback() {

        /// icon size
        
        $icon_size = isset( $this->options['icon_size'] ) ? $this->options['icon_size'] : '';
        
        $small = ($icon_size == 'small') ? ' selected' : '';
        $normal = ($icon_size == 'normal') ? ' selected' : '';
        $big = ($icon_size == 'big') ? ' selected' : '';

        $field  = '<h3>' . __('Customization', 'accessibility-light') . '</h3>';
        $field  .= '<h4>' . __('Customize Toolbar Icon', 'accessibility-light') . '</h4>';

        $field  .= '<div class="sitelinx-op-group">';
        $field .= '<div class="select">';
        $field .= '<label for="icon_size">' . __('Icon Size', 'accessibility-light') . '</label>';
        $field .= '<select name="sitelinx[icon_size]" id="icon_size">';
        $field .= '<option value="normal"' . $normal . '>' . __('Normal size (default)', 'accessibility-light') . '</option>';
        $field .= '<option value="small"' . $small . '>' . __('Small size', 'accessibility-light') . '</option>';
        $field .= '<option value="big"' . $big . '>' . __('Big size', 'accessibility-light') . '</option>';
        $field .= '</select>';
        $field .= '</div>';
        $field .= '</div>';


        printf($field, isset( $this->options['icon_size'] ) ? esc_attr( $this->options['icon_size']) : '');
        $icon_shape = isset( $this->options['icon_shape'] ) ? $this->options['icon_shape'] : '';

        $circle = ($icon_shape == 'circle') ? ' selected' : '';
        $square = ($icon_shape == 'square') ? ' selected' : '';

        $field = '<div class="sitelinx-op-group">';
        $field .= '<div class="select">';
        $field .= '<label for="icon_shape">' . __('Icon Shape', 'accessibility-light') . '</label>';
        $field .= '<select name="sitelinx[icon_shape]" id="icon_shape">';
        $field .= '<option value="square"' . $square . '>' . __('Square', 'accessibility-light') . '</option>';
        $field .= '<option value="circle"' . $circle . '>' . __('Circle', 'accessibility-light') . '</option>';
        $field .= '</select>';
        $field .= '</div>';
        $field .= '</div>';


        printf($field, isset( $this->options['icon_shape'] ) ? esc_attr( $this->options['icon_shape']) : '');
		
		/// toolbar position

        $field = '<div class="sitelinx-op-group">';
        $field .= '<label for="toolbar_position">' . __('From Top (default: 35)', 'accessibility-light') . '</label>';
        $field .= '<input type="number" min="0" max="500" value="%s" name="sitelinx[toolbar_position]" id="toolbar_position"><span class="px">px</span>';
        $field .= '</div>';

        printf($field, isset( $this->options['toolbar_position'] ) ? esc_attr( $this->options['toolbar_position']) : '');

        $field = '<div class="sitelinx-op-group">';
        $field .= '<label for="toolbar_position_side">' . __('From Side (default: 25)', 'accessibility-light') . '</label>';
        $field .= '<input type="number" min="0" max="250" value="%s" name="sitelinx[toolbar_position_side]" id="toolbar_position_side"><span class="px">px</span>';
        $field .= '</div><hr>';

        printf($field, isset( $this->options['toolbar_position_side'] ) ? esc_attr( $this->options['toolbar_position_side']) : '');

        $fiel = "";
        $img_size = isset( $this->options['img_size'] ) ? $this->options['img_size'] : '';
        
        $x1 = ($img_size == '1') ? ' selected' : '';
        $x2 = ($img_size == '2') ? ' selected' : '';
        $x3 = ($img_size == '3') ? ' selected' : '';

        $fiel .= '<div class="sitelinx-op">';
        $fiel .= '<div class="">';
        $fiel .= '<label for="icon_size">' . __('Images Size', 'accessibility-light') . '</label>';
        $fiel .= '<select name="sitelinx[img_size]" id="images_size">';
        $fiel .= '<option value="1"' . $x1 . '>1</option>';
        $fiel .= '<option value="2"' . $x2 . '>2</option>';
        $fiel .= '<option value="3"' . $x3  . '>3</option>';
        $fiel .= '</select>';
        $fiel .= '</div>';
        $fiel .= '</div><hr>';
        // /printf($fiel, isset( $this->options['img_size'] ) ? esc_attr( $this->options['img_size']) : '');

    }

    
    /*
     * Additional Buttons
     */
    public function toolbar_additional_buttons_callback() {
	    
	    $sitelinx_statement = ( isset($this->options['sitelinx_statement']) ) ? $this->options['sitelinx_statement'] : '';
        
        $field = '<h3>' . __('Additional Buttons', 'accessibility-light') . '</h3>';
		$field .= '<div class="row sitelinx-op-group">';
		$field .= '<div class="col-sm-4">';
			$field .= '<label for="sitelinx_statement">' . __('To display a link to your Accessibility Statement page, select your Accessibility Statement page', 'accessibility-light') . '</label>';
			$field .= '<select name="sitelinx[sitelinx_statement]" id="sitelinx_statement">';
				$field .= '<option value="">' . esc_attr( __( 'Select page', 'accessibility-light' ) ) . '</option>';
				$pages = get_pages(); 
				foreach ( $pages as $page ) {
					$selected = ( $sitelinx_statement == $page->ID ) ? 'selected' : '';
					
					$option = '<option value="' . $page->ID . '" ' . $selected . '>';
					$option .= $page->post_title;
					$option .= '</option>';
					$field .= $option;
				}
			$field .= '</select>';
		$field .= '</div>';

        printf($field,isset( $this->options['toolbar_statement'] ) ? esc_attr( $this->options['toolbar_statement']) : '');
        
        $sitelinx_feedback = ( isset($this->options['sitelinx_feedback']) ) ? $this->options['sitelinx_feedback'] : '';
        
		$field = '<div class="col-sm-3">';
			$field .= '<label for="toolbar_feedback">' . __('To display a link to your Feedback page, select your Feedback page', 'accessibility-light') . '</label>';
			$field .= '<select name="sitelinx[sitelinx_feedback]" id="sitelinx_feedback">';
				$field .= '<option value="">' . esc_attr( __( 'Select page', 'accessibility-light' ) ) . '</option>';
				$pages = get_pages(); 
				foreach ( $pages as $page ) {
					$selected = ( $sitelinx_feedback == $page->ID ) ? 'selected' : '';
					
					$option = '<option value="' . $page->ID . '" ' . $selected . '>';
					$option .= $page->post_title;
					$option .= '</option>';
					$field .= $option;
				}
			$field .= '</select>';
		$field .= '</div>';
		$field .= '</div>';
		$field .= '<hr />';
		printf($field,isset( $this->options['sitelinx_feedback'] ) ? esc_attr( $this->options['sitelinx_feedback']) : '');
    }
    
    /*
     * Font Sizer
     */
    public function toolbar_fontsizer_callback() {
	    
	    $fontsizer_inc = (isset($this->options['fontsizer_inc'])) ? $this->options['fontsizer_inc'] : '';
		
        $field = '<div class="sitelinx-op-group sitelinx-op-font-sizer">';
        
        	$field .= '<h3>' . __('Font Size Modifier', 'accessibility-light') . '</h3>';
			$field .= '<label for="fontsizer_inc">' . __('Include additional elements that should be affected with the font size modifier (default is: body, p, h1, h2, h3, h4, h5, h6, label, input, a, button, textarea)', 'accessibility-light') . '</label>';
			$field .= '<textarea name="sitelinx[fontsizer_inc]" id-"fontsizer_inc">'.$fontsizer_inc.'</textarea>';
			
        $field  .= '</div>';

        printf($field,isset( $this->options['fontsizer_inc'] ) ? esc_attr( $this->options['fontsizer_inc']) : '');
        
        $fontsizer_exc = (isset($this->options['fontsizer_exc'])) ? $this->options['fontsizer_exc'] : '';
		
        $field = '<div class="sitelinx-op-group sitelinx-op-font-sizer">';
        
			$field .= '<label for="fontsizer_exc">' . __('Exclude additional elements from the effect of the font size modifier', 'accessibility-light') . '</label>';
			$field .= '<textarea name="sitelinx[fontsizer_exc]" id-"fontsizer_exc">' . $fontsizer_exc . '</textarea>';
			
        $field  .= '</div><hr>';

        printf($field,isset( $this->options['fontsizer_exc'] ) ? esc_attr( $this->options['fontsizer_exc']) : '');
    }
	
	public function toolbar_skin_callback(){}
    
    /*
     * Activate Skiplinks
     */
    public function skiplinks_callback() {
        $field = '<h3>' . __('Skiplinks', 'accessibility-light') . '</h3>';
        $field .= '<div class="sitelinx-op-group">';
        	$field .= '<label><input type="checkbox" id="skiplinks" name="sitelinx[skiplinks]" value="1" ' .checked('1',isset($this->options['skiplinks']),false). '>';
        $field .= __('Activate skiplinks menus', 'accessibility-light') . '</label>';
        $field .= '</div>';

        printf($field,isset( $this->options['skiplinks'] ) ? esc_attr( $this->options['skiplinks']) : '');
    }
    
    /*
     * Skiplinks side
     */
    public function skiplinks_side_callback() {

        $left = ($this->options['skiplinks_side'] == 'left') ? ' selected' : '';
        $right = ($this->options['skiplinks_side'] == 'right') ? ' selected' : '';

        $field = '<div class="sitelinx-op-group select">';
        $field .= '<label for="skiplinks_side">' . __('Skiplinks Side', 'accessibility-light') . '</label>';
        $field .= ' <select name="sitelinx[skiplinks_side]" id="skiplinks_side">';
        $field .= '     <option value="left"' . $left . '>' . __('Left', 'accessibility-light') . '</option>';
        $field .= '     <option value="right"' . $right . '>' . __('Right', 'accessibility-light') . '</option>';
        $field .= ' </select>';
        $field .= '</div>';

        printf($field,isset( $this->options['skiplinks_side'] ) ? esc_attr( $this->options['skiplinks_side']) : '');
    }

    /*
     * Skiplinks action
     */
    public function skiplinks_action_callback() {

        $footer = ($this->options['skiplinks_action'] == 'footer') ? ' selected' : '';
        $body = ($this->options['skiplinks_action'] == 'body') ? ' selected' : '';

        $field = '<div class="sitelinx-op-group select">';
        $field .= '<label for="skiplinks_action">' . __('Skiplinks Action', 'accessibility-light') . '</label>';
        $field .= ' <select name="sitelinx[skiplinks_action]" id="skiplinks_action">';
        $field .= '     <option value="footer"' . $footer . '>' . __('Fire in footer', 'accessibility-light') . '</option>';
        $field .= '     <option value="body"' . $body . '>' . __('Fire after body (advanced)', 'accessibility-light') . '</option>';
        $field .= ' </select>';
        $field .= '</div>';

        printf($field,isset( $this->options['skiplinks_action'] ) ? esc_attr( $this->options['skiplinks_action']) : '');
    }
	
}
