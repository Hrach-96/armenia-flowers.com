<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
//var_dump($this->getParam('responsive', 1));
?>

<!-- META FOR IOS & HANDHELD -->

<?php if ($this->getParam('responsive', 1)==1): ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<style type="text/stylesheet">
		@-webkit-viewport   { width: device-width; }
		@-moz-viewport      { width: device-width; }
		@-ms-viewport       { width: device-width; }
		@-o-viewport        { width: device-width; }
		@viewport           { width: device-width; }
	</style>
	<script type="text/javascript">
		//<![CDATA[
		if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
			var msViewportStyle = document.createElement("style");
			msViewportStyle.appendChild(
				document.createTextNode("@-ms-viewport{width:auto!important}")
			);
			document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
		}
		//]]>
	</script>
<?php endif ?>
<meta name="HandheldFriendly" content="true"/>
<meta name="apple-mobile-web-app-capable" content="YES"/>

<!-- //META FOR IOS & HANDHELD -->

<?php
// SYSTEM CSS
$this->addStyleSheet(JURI::base(true) . '/templates/system/css/system.css');
?>

<?php
// T3 BASE HEAD
$this->addHead();
?>

<?php
// CUSTOM CSS
if (is_file(T3_TEMPLATE_PATH . '/css/custom.css')) {
	$this->addStyleSheet(T3_TEMPLATE_URL . '/css/custom.css');
}
if (is_file(T3_TEMPLATE_PATH . '/css/style.css')) {
	//$this->addStyleSheet(T3_TEMPLATE_URL . '/css/style.css');
}
if (is_file(T3_TEMPLATE_PATH . '/css/edit.css')) {
	$this->addStyleSheet(T3_TEMPLATE_URL . '/css/edit.css');
}
if($this->getParam('responsive', 1)==1): 

if(is_file(T3_TEMPLATE_PATH . '/css/custom-responsive.css')) {
	$this->addStyleSheet(T3_TEMPLATE_URL.'/css/custom-responsive.css'); 
}
endif;
if(is_file(T3_TEMPLATE_PATH . '/css/fancybox/jquery.fancybox.css')) {
	$this->addStyleSheet(T3_TEMPLATE_URL.'/css/fancybox/jquery.fancybox.css'); 
}
if(is_file(T3_TEMPLATE_PATH . '/css/animate.css')) {
	$this->addStyleSheet(T3_TEMPLATE_URL.'/css/animate.css'); 
}
//if(is_file(T3_TEMPLATE_PATH . '/js/vmprices2.js')) {
	//$this->addscript(T3_TEMPLATE_URL.'/js/vmprices2.js'); 
//}
$preloader = $this->getParam('preloader');
$preloaderbg = $this->getParam('preloaderbg');
//print_r($preloaderbg);
if ($preloader){
	if(is_file(T3_TEMPLATE_PATH . '/js/queryloader2.min.js')) {
		$this->addscript(T3_TEMPLATE_URL.'/js/queryloader2.min.js'); 
	}
}
$animate = $this->getParam('animate');
$politeloading = $this->getParam('politeloading');
$stickynavigation = $this->getParam('stickynavigation');

?>
<script>
var notAnimate = '<?php echo $animate ?>';
var notPoliteLoading = '<?php echo $politeloading ?>';
var notstickynavigation = '<?php echo $stickynavigation ?>';
var preloader = '<?php echo $preloader ?>';
var preloaderbg = '<?php echo $preloaderbg ?>';
</script>
<!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo T3_TEMPLATE_URL ?>/css/custom_ie8.css" />
<![endif]-->

<!-- Le HTML5 shim and media query for IE8 support -->
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<script type="text/javascript" src="<?php echo T3_URL ?>/js/respond.min.js"></script>
<![endif]-->
<!--[if lt IE 9]>
    <div style=' clear: both; text-align:center; position: relative; z-index:9999;'>
        <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="<?php echo T3_TEMPLATE_URL ?>/images/old_browser.jpg" border="0" &nbsp;alt="" /></a>
    </div>
<![endif]-->

<!-- You can add Google Analytics here or use T3 Injection feature -->
