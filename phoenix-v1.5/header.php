<?php
    global $fwp_do_skip_menu;
	if(is_page()){
		$currentTemplate = FastWP::getPageTemplate();
		if($currentTemplate === 'template-one-page.php') $fwp_do_skip_menu = true;
	}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php UI_getFaviconUrl(true); ?>" type="image/vnd.microsoft.icon"/>
<link rel="icon" href="<?php UI_getFaviconUrl(true); ?>" type="image/x-ico"/>
<?php wp_head(); ?>
</head>

<body <?php body_class();?> data-spy="scroll" data-target=".navbar-default" data-offset="100" id="bigWrapper"><?php UI_displayBorder();?>
<?php
if(!isset($fwp_do_skip_menu) || $fwp_do_skip_menu != true){
	?>
<header>
<?php UI_displayMenu('', 'nav navbar-nav', true); ?>
</header>
<?php 
}
do_action('fwp_after_menu');
UI_showPreloader();



