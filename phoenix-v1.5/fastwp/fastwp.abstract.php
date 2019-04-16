<?php
if(!function_exists('UI_getMenu')){
	function UI_getMenu($id = '', $class = 'menu', $echo = true){
		return FastWP_UI::getMenu($id, $class, $echo);
	}
}
if(!function_exists('UI_displayBorder')){
	function UI_displayBorder($echo = true){
		return FastWP_UI::displayBorder($echo);
	}
}

if(!function_exists('UI_getAffixSize')){
	function UI_getAffixSize(){
		return FastWP_UI::getAffixSize();
	}
}
if(!function_exists('UI_displayMenu')){
	function UI_displayMenu($id = '', $class = 'menu', $echo = true){
		return FastWP_UI::displayMenu($id, $class, $echo);
	}                    
}
if(!function_exists('UI_getFaviconUrl')){
	function UI_getFaviconUrl($echo = false){
		return FastWP_UI::getFaviconUrl($echo);
	}
}
if(!function_exists('UI_getPreloaderMarkup')){
	function UI_getPreloaderMarkup(){
		return FastWP_UI::getPreloaderMarkup();
	}
}
if(!function_exists('UI_showPreloader')){
	function UI_showPreloader($forceVisible = false){
		return FastWP_UI::showPreloader($forceVisible);
	}
}
if(!function_exists('UI_getPreloaderStatusForCurrentPage')){
	function UI_getPreloaderStatusForCurrentPage(){
		return FastWP_UI::getPreloaderStatusForCurrentPage();
	}
}
if(!function_exists('UI_getNavMenuItems')){
	function UI_getNavMenuItems($showHome = '0'){
		return FastWP_UI::getNavMenuItems($showHome);
	}
}
if(!function_exists('UI_alert')){
	function UI_alert($type, $message){
		return FastWP_UI::alert($type, $message);
	}
}