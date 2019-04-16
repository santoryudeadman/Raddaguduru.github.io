<?php
add_filter('fastwp_filter_section_content', array('fastwp_extend_filters', 'section_content'),10,2);
add_filter('fwp_page_class', array('fastwp_extend_filters', 'page_class'),10,2);
add_filter('fwp_animation_enable', array('fastwp_extend_filters', 'animation_enable'));

class fastwp_extend_filters {
	/**
	Attach parallax letters to sections
	**/
	static function section_content($content, $object){
		global $fwp_custom_shortcode_css, $fwp_data;
		/* If disabled by admin return original content */
		if(isset($fwp_data['hide_parallax_letters']) && $fwp_data['hide_parallax_letters'] == '1') return $content;

		$id 		= (isset($object->object_id)) ? $object->object_id : $object->ID;
		$max 		= 4;
		$meta 		= get_post_meta( $id, '_fwp_meta', true );
		$addThisA 	= '';
		$addThisB 	= '';

		if(isset($meta['letter_parallax'])){
			$fwp__meta 	= $meta['letter_parallax'];
			for($i=1;$i<=$max;$i++){
				if(isset($fwp__meta['text'.$i]) && !empty($fwp__meta['text'.$i])){
					$_text 		= $fwp__meta['text'		.$i];
					$_offset 	= $fwp__meta['offset'	.$i];
					$_ratio 	= $fwp__meta['ratio'	.$i];
					$_id		= rand(1000,9999);
					$addThisTpl = '<h1 class="parallaxLetter letter%s" id="letter%s" data-stellar-ratio="%s" data-stellar-vertical-offset="%s">%s</h1>';
					if(isset($meta['lplacement_t'.$i]) && $meta['lplacement_t'.$i] == '1'){
						$addThisA 	.= sprintf($addThisTpl, $i, $_id, esc_attr($_ratio), esc_attr($_offset), esc_attr($_text));
					}else {
						$addThisB 	.= sprintf($addThisTpl, $i, $_id, esc_attr($_ratio), esc_attr($_offset), esc_attr($_text));
					}
					if(isset($fwp__meta['left'.$i]) && !empty($fwp__meta['left'.$i])){
						$fwp_custom_shortcode_css .= sprintf('#letter%s { left:%s%s; }', $_id, esc_attr($fwp__meta['left'.$i]),'%');
					}
					if(isset($meta['pcolor_t'.$i]) && !empty($meta['pcolor_t'.$i])){
						$fwp_custom_shortcode_css .= sprintf('#letter%s { color:%s; }', $_id, esc_attr($meta['pcolor_t'.$i]));
					}
				}
			}
		}
		return $addThisB . $content . $addThisA ;
	}

	static function page_class($objClass, $page_id = 0){
		global $fwp__meta, $fwp_custom_shortcode_css;
		$private_meta = $fwp__meta;
		
		if(is_page()){
			$page_id = ($page_id != 0)? $page_id : get_the_ID();
			if(!isset($private_meta['s_padding_tpl']))
				$private_meta  	= get_post_meta( $page_id, '_fwp_meta', true );
			$customClass 	= (isset($private_meta['s_padding_tpl']))? $private_meta['s_padding_tpl'] : 'none';
			$objClass 	   .= ($customClass != 'none')? ' fwp-'.esc_attr($customClass) : '';

			if(isset($private_meta['s_padding_override']['top'])){
				$customClassID = 'fwp_setting_class'.rand(1000,9999);
				$css = '';
				foreach(array('top','rigt','bottom','left') as $loc){
					if(!isset($private_meta['s_padding_override'][$loc]) || empty($private_meta['s_padding_override'][$loc])) continue;
					$css .= sprintf('padding-%s: %s;', $loc, $private_meta['s_padding_override'][$loc]);
				}
				$fwp_custom_shortcode_css .= sprintf(' .%s { %s }', $customClassID, $css); 
				$objClass .= ' '.$customClassID;
			}
		}
		return $objClass;
	}

	static function animation_enable($animated){
		global $fwp_data;
		/* If disabled by admin return false */
	//	$animated = (isset($fwp_data['dis_animation']) && $fwp_data['dis_animation'] == 1)? 'false' : $animated;
		return $animated;
	}

}
