<?php

class fwp_admin_ui {
	static function el_div($id, $wrap_class = ''){
		$markup = '<div id="%s" class="%s">';
		return sprintf($markup, $id, $wrap_class);
	}
	static function el_div_close(){
		return '</div>';
	}

	static function el_textdisplay($id, $title='',  $description=''){
		$title = ($title != '')? sprintf('<h2 class="field-title">%s</h2>', $title): '';
		$markup = '<div id="%s" class="fwp-admin-field-wrap textdisplay">%s %s</div>';
		return sprintf($markup, $id, $title, $description);
	}

	static function el_colorpicker($id, $value = '', $title='',  $description='', $wrap_class = '', $changeAction = ''){
		$title = ($title != '')? sprintf('<h2 class="field-title">%s</h2>', $title): '';
		$markup = '<div class="fwp-admin-field-wrap text %s">%s<input type="text" name="_fwp_meta[%s]" id="_fwp_meta_field_%s" value="%s" class="fwp-color-field"><span class="fwp-desc">%s</span></div>';
		return self::getTextOrTextarea($id, $value, $title,  $description, $wrap_class, $changeAction, $markup);
	}

	static function el_text($id, $value = '', $title='',  $description='', $wrap_class = '', $changeAction = ''){
		$title = ($title != '')? sprintf('<h2 class="field-title">%s</h2>', $title): '';
		$markup = '<div class="fwp-admin-field-wrap text %s">%s<input type="text" name="_fwp_meta[%s]" id="_fwp_meta_field_%s" value="%s"><span class="fwp-desc">%s</span></div>';
		return self::getTextOrTextarea($id, $value, $title,  $description, $wrap_class, $changeAction, $markup);
	}
	
	static function el_textarea($id, $value = '', $title='',  $description='', $wrap_class = '', $changeAction = ''){
		$title = ($title != '')? sprintf('<h2 class="field-title">%s</h2>', $title): '';
		$markup = '<div class="fwp-admin-field-wrap textarea %s">%s<textarea name="_fwp_meta[%s]" id="_fwp_meta_field_%s">%s</textarea><span class="fwp-desc">%s</span></div>';
		return self::getTextOrTextarea($id, $value, $title,  $description, $wrap_class, $changeAction, $markup);
	}

	static function el_select($id, $values = '', $value = '', $title='',  $description='', $wrap_class = '', $changeAction = ''){
		$title = ($title != '')? sprintf('<h2 class="field-title">%s</h2>', $title): '';
		$markup = '<div class="fwp-admin-field-wrap select %s">%s<select name="_fwp_meta[%s]" id="_fwp_meta_field_%s">%s</select><span class="fwp-desc">%s</span></div>';
		if(!is_array($values)){ return '<small class="metabox-error">fastwp.system.metabox.select</small>'; }
		$content = '';
		$opt_markup = '<option value="%s" %s>%s</option>';
		foreach ($values as $key => $val) {
			$selected = (strval($key) == strval($value))?'selected="selected"':'';
			$content .= sprintf($opt_markup, $key, $selected, $val);
		}
		return sprintf($markup, $wrap_class, $title, $id, $id, $content, $description);
	}

	static function el_switch($id, $value = '0', $title='',  $description='', $wrap_class = '', $labels = ''){
		/* TODO: Implement custom labels in 1.1 */
		$selectedOff 	= (!isset($value) || empty($value) || $value == '0')? 'selected':'';
		$selectedOn 	= ($selectedOff == '')? 'selected':'';
		$labelOn		= __('On','fastwp');
		$labelOff		= __('Off','fastwp');
		if($title == ''){
			$wrap_class .= ' hide-title';
		}
		if($description == ''){
			$wrap_class .= ' hide-description';
		}
		$title = ($title != '')? sprintf('<h2 class="field-title">%s</h2>', $title): '';
		$markup = '<div class="fwp-admin-field-wrap switch %s">%s<div class="switch-options"><label class="cb-enable %s" data-id="_fwp_meta_field_%s"><span>%s</span></label><label class="cb-disable %s" data-id="_fwp_meta_field_%s"><span>%s</span></label><input type="hidden" class="checkbox checkbox-input" name="_fwp_meta[%s]" id="_fwp_meta_field_%s" value="%s"></div><span class="fwp-desc">%s</span></div>';
		return sprintf($markup, $wrap_class, $title,  $selectedOn, $id, $labelOn, $selectedOff, $id, $labelOff, $id, $id, $value, $description);
	}
	
	
	static function el_gallery($id, $value = '', $title='',  $description='', $wrap_class = ''){

		if($title == ''){
			$wrap_class .= ' hide-title';
		}
		if($description == ''){
			$wrap_class .= ' hide-description';
		}

		$items = array();

		$individual_markup = '
		<div class="gallery-item">
			<div class="preview crop-image"><img src="%s" class="full-width-image"></div>
			<div class="input-field">
			<input type="text" name="_fwp_meta[%s][]" value="%s" class="fwp-source"><ul class="tools">
			<li><a href="javascript:void(0)" class="fwp-action fwp-action-upload" data-action="choose"><i class="dashicons-before dashicons-media-default"></i></a></li>
			<li><a href="#" onclick="fwp_remove_item(this); return false;" class="fwp-action" data-action="remove"><i class="delete-red">X</i></a></li>
			</ul>
			</div>
		</div>';
		$item_tpl 	= sprintf('<div class="fwp-hidden empty-markup">%s</div>', str_replace('%s','', str_replace('[%s]',sprintf('[%s]', $id), $individual_markup)));
		$items[] 	= sprintf('<div class="fwp-no-results %s">%s</div>', ((is_array($value) && count($value) > 0)?'fwp-hidden':''), __('No items in gallery', 'fastwp'));
		if(is_array($value)){
			foreach($value as $item){
				if(empty($item) || strlen($item) < 5) continue; 
				$items[] = sprintf($individual_markup, $item, $id, $item);
			}
		}
// dashicons-plus-alt
 		$title = ($title != '')? sprintf('<h2 class="field-title">%s</h2>', $title): '';
		$markup = '<div class="fwp-admin-field-wrap gallery %s">%s<span class="fwp-desc">%s</span><div><a class="button-primary add-gallery-item">Add item</a></div>%s<div class="items-wrap fwp-sortable">%s</div></div>';
		$items_readable = implode("\r\n", $items);
		return sprintf($markup, $wrap_class, $title, $description, $item_tpl, $items_readable);
	}
	
	
	static function addButton($class, $text = 'New'){
		return sprintf('<a class="button button-primary %s" href="#!" >%s</a>', $class, $text);
	}
	static function separator($type, $class = ''){
		$markup = '<div class=""></div>';
		$class = sprintf('fwp-separator type-%s %s', $type, $class);
		return sprintf($markup, $class);
	}

	static function getTextOrTextarea($id, $value = '', $title='',  $description='', $wrap_class = '', $changeAction = '', $markup = ''){
		$wrap_class = '';
		if($title == ''){
			$wrap_class .= ' hide-title';
		}
		if($description == ''){
			$wrap_class .= ' hide-description';
		}

		return sprintf($markup, $wrap_class, $title, $id, $id, $value, $description);
	}
}