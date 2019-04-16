<?php
/* Core file */
class FastWPAdminMetabox {
	static function buildMetaboxes(){
		global $fwp_metaboxes;
		foreach($fwp_metaboxes as $post_type=>$boxes){
			foreach ($boxes as $box_settings) {
				add_meta_box(
					$box_settings['id'],
					$box_settings['title'],
					array('FastWPAdminMetabox', 'outputMetaBox'),
					$post_type,
					$box_settings['position'],
					$box_settings['priority'],
					array($post_type, $box_settings)
				);
			}
		}
	}

	static function outputMetaBox($post, $settings){
		$current_section_settings = get_post_meta( $post->ID, '_fwp_meta', true);
		$fields 	= $settings['args'][1]['fields'];
		$fieldsUI 	= array();
		foreach ($fields as $field) {
			$field['title'] = (isset($field['title']))? $field['title'] : '';
			$field['desc'] 	= (isset($field['desc']))? 	$field['desc'] : '';
			$field['class'] = (isset($field['class']))? $field['class'] : '';
			$id 			= isset($field['id'])? $field['id'] : '';
			$currentValue 	= (isset($current_section_settings[$id]))? $current_section_settings[$id] : '';
			switch($field['type']){
				case 'text':
					$fieldsUI[] = fwp_admin_ui::el_text($id, esc_attr($currentValue), $field['title'], $field['desc'], $field['class']);
				break;
				case 'colorpicker':
					$fieldsUI[] = fwp_admin_ui::el_colorpicker($id, esc_attr($currentValue), $field['title'], $field['desc'], $field['class']);
				break;
				case 'select':
					$fieldsUI[] = fwp_admin_ui::el_select($id, $field['values'], esc_attr($currentValue), $field['title'], $field['desc'], $field['class']);
				break;
				case 'multi_text':
					$had_title 	= false;
					$title 		= (isset($field['title']))? $field['title'] : '';
					$description= (isset($field['desc']))? $field['desc'] : '';
					if(is_array($field['keys']) && count($field['keys']) > 0){
						
						foreach($field['keys'] as $key=>$desc){
							$fieldID 		= $id . ']['.$key;
							$defaultValue = (isset($field['defaults'][$key]))? $field['defaults'][$key] : '';
							$currentValue 	= (isset($current_section_settings[$id][$key]))? $current_section_settings[$id][$key] : $defaultValue;
							$fieldsUI[] 	= fwp_admin_ui::el_text($fieldID, esc_attr($currentValue), $title, $desc, $field['class']);
							if($had_title == false){
								$had_title 	= true;
								$title 		= '';
							}
						}
					} elseif($field['keys'] == 'auto'){
						$currentValues 	= (isset($current_section_settings[$id]))? $current_section_settings[$id] : array();
						$fieldsUI[] = fwp_admin_ui::el_div('my_tpl','is-hidden js-input-template');
						$fieldsUI[] = fwp_admin_ui::el_text($id . '^][field', '', $title, $description, 'no-class');
						$fieldsUI[] = fwp_admin_ui::addButton('js-add-multi');
						$fieldsUI[] = fwp_admin_ui::el_div_close();
						$fieldsUI[] = fwp_admin_ui::el_div('field-wrap','js-input-holder');
						if(count($currentValues) > 0){
							$i = 0;
							
							foreach($currentValues as $val){
								if($val == '') continue;
								$fieldID	= $id . '][field'.$i;
								$fieldsUI[] = fwp_admin_ui::el_text($fieldID, esc_attr($val), '', '', $field['class']);
								$i++;
							}
						}	
						$fieldsUI[] = fwp_admin_ui::el_div_close();
					}
				break;
				case 'textarea':
					$fieldsUI[] = fwp_admin_ui::el_textarea($id, esc_html($currentValue), $field['title'], $field['desc'], $field['class']);
				break;
				case 'switch':
					$fieldsUI[] = fwp_admin_ui::el_switch($id, esc_attr($currentValue), $field['title'], $field['desc'], $field['class']);
				break;
				case 'gallery':
					$fieldsUI[] = fwp_admin_ui::el_gallery($id, $currentValue, $field['title'], $field['desc'], $field['class']);
				break;
				case 'div':
					$fieldsUI[] = fwp_admin_ui::el_div($id, $field['class']);
				break;
				case 'div-close':
					$fieldsUI[] = fwp_admin_ui::el_div_close();
				break;
				case 'text-display':
					$fieldsUI[] = fwp_admin_ui::el_textdisplay($id, $field['title'], $field['desc']);
				break;

			}
		}
		echo sprintf('<div class="fastwp_metabox">%s</div>', implode("\r\n",$fieldsUI));
	}

	static function saveMetaboxData($post_id = null){
/*		if ( ! isset( $_POST['fwp_admin_nonce'] ) )
			return $post_id;

		$nonce = $_POST['fwp_admin_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'fwp_admin_nonce' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;
*/
		if (isset( $_POST['post_type']) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}
		if(isset( $_POST['_fwp_meta'] )) {
			update_post_meta( $post_id, '_fwp_meta', $_POST['_fwp_meta'] );
		}
	}

	static function enqueueScriptsAndStyles(){
		wp_enqueue_style('fwp-metabox', fwp_lib_url.'css/admin.metabox.css');
		wp_enqueue_script('fwp-metabox', fwp_lib_url.'js/admin.metabox.js');
		$current_page_path = explode('/',$_SERVER['PHP_SELF']);
		$current_page = end($current_page_path);
		if($current_page == 'post-new.php' || $current_page == 'edit.php'){

			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-sortable');

		}

	}

}



add_action( 'add_meta_boxes', array( 'FastWPAdminMetabox', 'buildMetaboxes' ) );
add_action( 'save_post', array( 'FastWPAdminMetabox', 'saveMetaboxData' ) );
add_action( 'admin_enqueue_scripts', array( 'FastWPAdminMetabox', 'enqueueScriptsAndStyles' ) );

//echo 'I`m a little test :)';