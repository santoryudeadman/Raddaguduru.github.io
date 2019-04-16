<?php
class FastWP {
	static function debug(){
		define('fwp_debug', true);
	}

	static function getPostIdAndTitle($post_type = 'page', $value_first = false){
		global $wpdb;
		$sql = $wpdb->prepare("SELECT post_title, ID from $wpdb->posts WHERE `post_type` = '%s' AND `post_status`='publish' ORDER BY `post_title` ASC;",
			$post_type);
		$result = $wpdb->get_results( $sql, ARRAY_A );
		$output = array();
		if(isset($result) && is_array($result)){
			foreach($result as $item){
				if($value_first == true){
					$key = $item['post_title'];
					$value=$item['ID'];
				}else {
					$key = $item['ID'];
					$value=$item['post_title'];
				}
				$output[$key] = $value;
			}
		}
		return $output;
	}

	static function getPageContent($id, $filters = false){
		$page = get_page($id);
		if($page){
			if($filters == true){
				return do_shortcode($page->post_content);
			}else {
				return $page->post_content;
			}
		}
		return false;
	}

	static function getMenuSectionId($item){
			$corrected_section_id = (sanitize_title(trim($item->title)) == strtolower(trim(str_replace(' ', '-', $item->title))))? sanitize_title(trim($item->title)) : $item->object_id;
		return 's-' . $corrected_section_id;
	}

	static function getPageTemplate($id = 0){
		$id = ($id == 0)? get_the_ID() : $id;
		$template = get_post_meta( $id, '_wp_page_template', true );
		return $template;	
	}

	static function hex2rgba($color, $opacity = false) {

		$default = 'rgb(0,0,0)';

		//Return default if no color provided
		if(empty($color))
	          return $default; 

		//Sanitize $color if "#" is provided 
	        if ($color[0] == '#' ) {
	        	$color = substr( $color, 1 );
	        }

	        //Check if color has 6 or 3 characters and get values
	        if (strlen($color) == 6) {
	                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	        } elseif ( strlen( $color ) == 3 ) {
	                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	        } else {
	                return $default;
	        }

	        //Convert hexadec to rgb
	        $rgb =  array_map('hexdec', $hex);

	        //Check if opacity is set(rgba or rgb)
	        if($opacity){
	        	if(abs($opacity) > 1)
	        		$opacity = 1.0;
	        	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	        } else {
	        	$output = 'rgb('.implode(",",$rgb).')';
	        }

	        //Return rgb(a) color string
	        return $output;
	}

	static function deregisterPostType( $post_type ) {
	    global $wp_post_types;
	    if ( isset( $wp_post_types[ $post_type ] ) ) {
	        unset( $wp_post_types[ $post_type ] );
	        return true;
	    }
	    return false;
	}
}
