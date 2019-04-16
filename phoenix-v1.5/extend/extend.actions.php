<?php


class fwp_custom_actions {

	static function after_page_content($page_id = 0, $selector = '#page-content'){
		global $fwp__meta, $fwp_custom_shortcode_css;
		$private_meta = $fwp__meta;
		if(is_page()){
			if($page_id == 0) $page_id = get_the_ID();
			if(!isset($private_meta['section_bg'])){
				$private_meta  		= get_post_meta($page_id , '_fwp_meta', true );
			}
			if(isset($private_meta['section_bg']) && !empty($private_meta['section_bg'])){
				
				$fwp_custom_shortcode_css .= sprintf('%s { background-color:%s; }', $selector, $private_meta['section_bg']);
			}
			if(isset($private_meta['s_padding_override'])){
				$css_declaration = '';
				foreach($private_meta['s_padding_override'] as $k=>$v){
					if(empty($v)) continue;
					$css_declaration .= sprintf(' padding-%s:%s !important;', $k, $v);
				}
				$fwp_custom_shortcode_css .= sprintf('%s > .container, %s .vc_row.container { %s }', $selector, $selector, $css_declaration);
			}
		}
	}
}

add_action('fwp_after_page_content',array('fwp_custom_actions','after_page_content'),10, 2);
