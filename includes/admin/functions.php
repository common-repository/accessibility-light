<?php
/*
 * functions.php
 * Function for backand
 * @Version: 1.0
 * @author: Sitelinx
 */
 
add_filter( 'admin_body_class', 'acl_sitelinx_admin_body_class' );
function acl_sitelinx_admin_body_class( $classes ) {
	
    return "$classes admin-acl-sitelinx";
	// Or: return "$classes my_class_1 my_class_2 my_class_3";
}

function acl_sitelinx_header() {
	
    echo '<header id="sitelinx-panel-header">';
		echo '<h1>' . __('Accessibility', 'accessibility-light') . '</h1>';
		echo '<div class="sitelinx-logo"><img src="' . ACL_SITELINX_URL . 'assets/admin/img/accessibility-light-logo.png" alt="Accessibility Light"></div>';
		echo '<p>' . __('Opening WordPress sites to people with disabilites', 'accessibility-light') . '</p>';
    echo '</header>';
}

function acl_sitelinx_sections( $page ) {
	
    global $wp_settings_sections, $wp_settings_fields;

    if ( ! isset( $wp_settings_sections[$page] ) )
        return;

    foreach ( (array) $wp_settings_sections[$page] as $section ) {

        if ( $section['callback'] )
            call_user_func( $section['callback'], $section );

        if ( ! isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$page] ) || !isset( $wp_settings_fields[$page][$section['id']] ) )
            continue;
		
		$class = ($section['id'] === 'sitelinx_general') ? 'active' : '';
        echo '<div id="' . $section['id'] . '" class="tab-pane '.$class.'" role="tabpanel">';
        echo '<header class="page-header"><h2>' . $section['title'] . '</h2></header>';
        do_settings_fields( $page, $section['id'] );
        echo '</div>';
		echo '<div class="clearfix"></div>';
		
		submit_button();
    }
}

function acl_sitelinx_create_field($page, $section) {
	
	var_dump($page);
    global $wp_settings_fields;

    if ( ! isset( $wp_settings_fields[$page][$section] ) )
        return;

    foreach ( (array) $wp_settings_fields[$page][$section] as $field ) {
        $class = '';

        if ( ! empty( $field['args']['class'] ) ) {
            $class = ' class="' . esc_attr( $field['args']['class'] ) . '"';
        }

        echo "<div{$class}>";

        if ( ! empty( $field['args']['label_for'] ) ) {
            echo '<div scope="row"><label for="' . esc_attr( $field['args']['label_for'] ) . '">' . $field['title'] . '</label></div>';
        } else {
            echo '<div scope="row">' . $field['title'] . '</div>';
        }

        echo '<div>';
        call_user_func($field['callback'], $field['args']);
        echo '</div>';
        echo '</div>';
    }
}


add_action( 'admin_footer', 'acl_sitelinx_media_selector_print_scripts' );

function acl_sitelinx_media_selector_print_scripts() {

$current_screen = get_current_screen();
/* Check wether this page is accessiblity or not if yes please add the scripts */
if( $current_screen->id === "toplevel_page_accessible-sitelinx" ){

	$my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );

	?><script type='text/javascript'>
		jQuery( document ).ready( function( $ ) {
			// Uploading files
			var file_frame;
			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id
			var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this
			jQuery('#upload_image_button').on('click', function( event ){
				event.preventDefault();
				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					// Set the post ID to what we want
					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );
					// Open frame
					file_frame.open();
					return;
				} else {
					// Set the wp.media post id so the uploader grabs the ID we want when initialised
					wp.media.model.settings.post.id = set_to_post_id;
				}
				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: 'Select a image to upload',
					button: {
						text: 'Use this image',
					},
					multiple: false	// Set to true to allow multiple files to be selected
				});
				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = file_frame.state().get('selection').first().toJSON();
					// Do something with attachment.id and/or attachment.url here
					// $( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
					// $( '#image_attachment_id' ).val( attachment.id );
					var icon_sitelinx = '<img id="image-preview" src="' + attachment.url + '" style="max-height: 100px; width: auto;">';
					// $('.sitelinx-preview-logo').html(icon_sitelinx);
					$( '#toolbar_icon' ).val( attachment.url );
					// Restore the main post ID
					wp.media.model.settings.post.id = wp_media_post_id;
				});
					// Finally, open the modal
					file_frame.open();
			});
			// Restore the main ID when the add media button is pressed
			jQuery( 'a.add_media' ).on( 'click', function() {
				wp.media.model.settings.post.id = wp_media_post_id;
			});
		});
	</script>
	
	<?php
	}
}
