<?php
/** 
 *------------------------------------------------------------------------------
 * @package       T3 Framework for Joomla!
 *------------------------------------------------------------------------------
 * @copyright     Copyright (C) 2004-2013 JoomlArt.com. All Rights Reserved.
 * @license       GNU General Public License version 2 or later; see LICENSE.txt
 * @authors       JoomlArt, JoomlaBamboo, (contribute to this project at github 
 *                & Google group to become co-author)
 * @Google group: https://groups.google.com/forum/#!forum/t3fw
 * @Link:         http://t3-framework.org 
 *------------------------------------------------------------------------------
 */


defined('_JEXEC') or die;
?>
<?php
if($this->getParam('responsive', 1)){
$pageclass_noresp = 'resp';}else {$pageclass_noresp = 'noresp ';}
$app = JFactory::getApplication();
$doc = JFactory::getDocument(); 
$lang = JFactory::getLanguage();
$dir = $lang->get('rtl');
$lang_tag =$lang->getTag();
$document = JFactory::getDocument();
$app = JFactory::getApplication();
$templateparams = $app->getTemplate(true)->params;
$layout = $templateparams->get('layout','boxed');
$boxedimage = $templateparams->get('boxedimage');
$googlefonts = $this->getParam('GoogleFonts');
$googlefontsH = $this->getParam('GoogleFontsH');

$header  = $this->params->get('header', 'normal');

?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction;?>" class='<jdoc:include type="pageclass" />'>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"  />
    <meta charset="utf-8">
    <!--<script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/jquery-migrate.min.js"></script>
    <script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/mod_cart.js"></script>-->


    <jdoc:include type="head" />

    <?php $this->loadBlock ('head') ?>
  </head>
<?php if ($layout =='boxed'){ ?>
  <style>
    .body-boxed {
      background:url(<?php echo JURI::base(true) . '/' . $boxedimage ?>) center top repeat fixed;
      background-size: cover;
    }
  </style>
<?php } ?>
  <body class="<?php echo $header.'container '; ?><?php echo $pageclass_noresp;?> <?php if ($layout =='boxed'){ echo "body-boxed"; }else{echo "body-wide";} if($googlefonts =='Noto Serif'){echo " Noto Serif"; }?>">
  <div class="t3-wrapper boxed-version"> <!-- Need this wrapper for off-canvas menu. Remove if you don't use of-canvas -->
  
  <div class="boxed <?php if ($layout =='boxed'){ echo "layout-boxed"; }else{echo "layout-wide";} ?>">
      <div class="top-block notFix">
        <?php $this->loadBlock ('topheader'); ?>
 	      <?php $this->loadBlock ('header'); ?>
       </div>
       <div class="center-block">
        <?php $this->loadBlock ('slider') ?>
        <?php $this->loadBlock ('breadcrumbs') ?>
        <?php $this->loadBlock ('spotlight-1') ?>
    	<div class="MainRow">
     		 <?php $this->loadBlock ('mainbody') ?>
      </div>
      <?php $this->loadBlock ('spotlight-2') ?>
       		 
        </div>
        <div class="bottom-block">
       		<?php $this->loadBlock ('footer'); ?>
        </div>
    </div>
    </div>
    <script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/allscripts.js"></script>
    <script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/linescript.js"></script>
  </body>
  <?php 
  switch($googlefontsH){
   case "Noto Serif": 
     echo  "<link href='https://fonts.googleapis.com/css?family=Noto+Serif:300,400,400i,600,700' rel='stylesheet' type=text/css'><link href='https://fonts.googleapis.com/css?family=Noto+Serif+Armenian:400,700' rel='stylesheet' type=text/css'>"; ?>  
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title , .Price , .name-blog , .spacer_div , .price , .all .tot3 , .all .tot4 , .all .total  {
        font-family: 'Noto Serif Armenian', 'Noto Serif', sans-serif!important; 
      }
    </style>
  <?php
   break;
   case "Roboto": 
   echo  "<link href='//fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title , .Price , .name-blog , .spacer_div, .price, .all .tot3 , .all .tot4 , .all .total {
        font-family: 'Roboto', sans-serif!important; 
      }
    </style>
  <?php
   break;
   case "Lato": 
   echo  "<link href='//fonts.googleapis.com/css?family=Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
     h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title , .Price , .name-blog , .spacer_div, .price, .all .tot3 , .all .tot4 , .all .total {
        font-family: 'Lato', sans-serif!important; 
      }
    </style>
  <?php
   break;
   case "Ubuntu":
   echo  "<link href='//fonts.googleapis.com/css?family=Ubuntu:400,300,500,700' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title , .Price , .name-blog , .spacer_div, .price, .all .tot3 , .all .tot4 , .all .total {
        font-family: 'Ubuntu', sans-serif!important; 
      }
    </style>
  <?php 
   break;
   case "Open Sans": 
   echo  "<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title , .Price , .name-blog , .spacer_div, .price, .all .tot3 , .all .tot4 , .all .total {
        font-family: 'Open Sans', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Source Sans Pro": 
   echo  "<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,200,600,700,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title , .Price , .name-blog , .spacer_div, .price, .all .tot3 , .all .tot4 , .all .total  {
        font-family: '<?php echo $googlefonts ?>', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Raleway": 
   echo  "<link href='//fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title, .Price , .name-blog , .spacer_div, .price, .all .tot3 , .all .tot4 , .all .total {
        font-family: 'Raleway', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Roboto Slab": 
   echo  "<link href='//fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title, .Price , .name-blog , .spacer_div, .price, .all .tot3 , .all .tot4 , .all .total {
        font-family: 'Roboto Slab', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Droid Serif": 
   echo  "<link href='//fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?>
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title, .Price , .name-blog , .spacer_div, .price, .all .tot3 , .all .tot4 , .all .total {
        font-family: 'Droid Serif', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Merriweather": 
   echo  "<link href='//fonts.googleapis.com/css?family=Merriweather:400,300,700,900&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title, .Price , .name-blog , .spacer_div, .price, .all .tot3 , .all .tot4 , .all .total {
        font-family: 'Merriweather', sans-serif!important; 
      }
    </style>
    <?php  
   break;
   case "Merriweather Sans": 
   echo  "<link href='//fonts.googleapis.com/css?family=Merriweather+Sans:400,300,700,900&display=swap&subset=latin' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title, .Price , .name-blog , .spacer_div, .price, .all .tot3 , .all .tot4 , .all .total {
        font-family: 'Merriweather Sans', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Playfair Display": 
   echo  "<link href='//fonts.googleapis.com/css?family=Playfair+Display:400,700,900&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title, .Price , .name-blog , .spacer_div, .price, .all .tot3 , .all .tot4 , .all .total {
        font-family: 'Playfair Display', sans-serif!important; 
      }
    </style>
  <?php  
   break;
}
?>
    <?php 
  switch($googlefonts){
   case "Noto Serif": 
     echo  "<link href='https://fonts.googleapis.com/css?family=Noto+Serif:300,400,400i,600,700' rel='stylesheet' type=text/css'><link href='https://fonts.googleapis.com/css?family=Noto+Serif+Armenian:400,700' rel='stylesheet' type=text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body , #refreshbutton {
        font-family: 'Noto Serif Armenian', 'Noto Serif', sans-serif!important; 
      }
    </style>
  <?php
   break;
   case "Roboto": 
   echo  "<link href='//fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body, body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body , #refreshbutton {
        font-family: 'Roboto', sans-serif!important; 
      }
    </style>
  <?php
   break;
   case "Lato": 
   echo  "<link href='//fonts.googleapis.com/css?family=Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body , #refreshbutton {
        font-family: 'Lato', sans-serif!important; 
      }
    </style>
  <?php
   break;
   case "Ubuntu":
   echo  "<link href='//fonts.googleapis.com/css?family=Ubuntu:400,300,500,700' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body , #refreshbutton {
        font-family: 'Ubuntu', sans-serif!important; 
      }
    </style>
  <?php 
   break;
   case "Open Sans": 
   echo  "<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body , #refreshbutton {
        font-family: 'Open Sans', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Source Sans Pro": 
   echo  "<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,200,600,700,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body , #refreshbutton {
        font-family: '<?php echo $googlefonts ?>', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Raleway": 
   echo  "<link href='//fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body , #refreshbutton {
        font-family: 'Raleway', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Roboto Slab": 
   echo  "<link href='//fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body , #refreshbutton {
        font-family: 'Roboto Slab', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Droid Serif": 
   echo  "<link href='//fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?>
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body , #refreshbutton {
        font-family: 'Droid Serif', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Merriweather": 
   echo  "<link href='//fonts.googleapis.com/css?family=Merriweather:400,300,700,900&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body , #refreshbutton {
        font-family: 'Merriweather', sans-serif!important; 
      }
    </style>
    <?php  
   break;
   case "Merriweather Sans": 
   echo  "<link href='//fonts.googleapis.com/css?family=Merriweather+Sans:400,300,700,900&display=swap&subset=latin' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body , #refreshbutton {
        font-family: 'Merriweather Sans', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Playfair Display": 
   echo  "<link href='//fonts.googleapis.com/css?family=Playfair+Display:400,700,900&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body , #refreshbutton {
        font-family: 'Playfair Display', sans-serif!important; 
      }
    </style>
  <?php  
   break;
}
?>
</html>

