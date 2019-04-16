<?php
class fastwp_debug {
	function __construct(){
		$this->debug_info = array(self::ts().'Loaded');
	}
	static function add_row($data){
		global $fwp_debug;
		$fwp_debug->debug_info[] = self::ts().$data;
	}
	static function show(){
		global $fwp_debug;
		if(fwp_debug === true && !is_admin()){
			global $wp,$wpdb, $query, $post, $wp_meta_boxes, $wp_rewrite  ;
			echo '<div class="debug" style="overflow:auto; height:400px; background:#FFFACD">';
			echo implode('<br>',$fwp_debug->debug_info);
			echo "</div>";
		}
	}

	static function ts(){
		 list($usec, $sec) = explode(" ", microtime());
		 $usec = intval($usec * 1000);
		return date('d/m/Y h:i:s.').$usec.': ';
	}
}
$fwp_debug = new fastwp_debug();

add_action('shutdown', array('fastwp_debug','show'));