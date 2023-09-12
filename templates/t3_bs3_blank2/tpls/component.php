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

if(!defined('T3_TPL_COMPONENT')){
  define('T3_TPL_COMPONENT', 1);
}
$googlefonts = $this->getParam('GoogleFonts');
$googlefontsH = $this->getParam('GoogleFontsH');

?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
  <head>
    <script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/jquery-migrate.min.js"></script>
    <script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/mod_cart.js"></script>
    <script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/script.js"></script>
    <link rel="stylesheet" href="<?php echo T3_TEMPLATE_URL ?>/css/quick/scrollcustom.css" type="text/css" media="screen,projection" />
    <?php 
  switch($googlefontsH){
   case "Noto Serif": 
    echo  "<link href='https://fonts.googleapis.com/css?family=Noto+Serif:300,400,400i,600,700' rel='stylesheet' type='text/css'><link href='https://fonts.googleapis.com/css?family=Noto+Serif+Armenian:400,700' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title , .Price , .name-blog {
        font-family: 'Noto Serif Armenian', 'Noto Serif', sans-serif!important; 
      }
    </style>
  <?php
   break;
   case "Roboto": 
   echo  "<link href='//fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title , .Price , .name-blog {
        font-family: 'Roboto', sans-serif!important; 
      }
    </style>
  <?php
   break;
   case "Lato": 
   echo  "<link href='//fonts.googleapis.com/css?family=Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
     h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title , .Price , .name-blog {
        font-family: 'Lato', sans-serif!important; 
      }
    </style>
  <?php
   break;
   case "Ubuntu":
   echo  "<link href='//fonts.googleapis.com/css?family=Ubuntu:400,300,500,700' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title , .Price , .name-blog {
        font-family: 'Ubuntu', sans-serif!important; 
      }
    </style>
  <?php 
   break;
   case "Open Sans": 
   echo  "<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title , .Price , .name-blog {
        font-family: 'Open Sans', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Source Sans Pro": 
   echo  "<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,200,600,700,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title , .Price , .name-blog {
        font-family: '<?php echo $googlefonts ?>', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Raleway": 
   echo  "<link href='//fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title, .Price , .name-blog {
        font-family: 'Raleway', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Roboto Slab": 
   echo  "<link href='//fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title, .Price , .name-blog {
        font-family: 'Roboto Slab', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Droid Serif": 
   echo  "<link href='//fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?>
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title, .Price , .name-blog {
        font-family: 'Droid Serif', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Merriweather": 
   echo  "<link href='//fonts.googleapis.com/css?family=Merriweather:400,300,700,900&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title, .Price , .name-blog {
        font-family: 'Merriweather', sans-serif!important; 
      }
    </style>
    <?php  
   break;
   case "Merriweather Sans": 
   echo  "<link href='//fonts.googleapis.com/css?family=Merriweather+Sans:400,300,700,900&display=swap&subset=latin' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title, .Price , .name-blog {
        font-family: 'Merriweather Sans', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Playfair Display": 
   echo  "<link href='//fonts.googleapis.com/css?family=Playfair+Display:400,700,900&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      h1,h2,h3,h4,h5,h6 ,.moduleItemTitle, .Title, .Price , .name-blog {
        font-family: 'Playfair Display', sans-serif!important; 
      }
    </style>
  <?php  
   break;
}
?>
    <?php 
  switch($googlefonts){
   case "Poppins": 
     echo  "<link href='https://fonts.googleapis.com/css?family=Noto+Serif:300,400,400i,600,700' rel='stylesheet' type=text/css'><link href='https://fonts.googleapis.com/css?family=Noto+Serif+Armenian:400,700' rel='stylesheet' type=text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body {
        font-family: 'Noto Serif Armenian', 'Noto Serif', sans-serif!important; 
      }
    </style>
  <?php
   break;
   case "Roboto": 
   echo  "<link href='//fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body, body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body {
        font-family: 'Roboto', sans-serif!important; 
      }
    </style>
  <?php
   break;
   case "Lato": 
   echo  "<link href='//fonts.googleapis.com/css?family=Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body {
        font-family: 'Lato', sans-serif!important; 
      }
    </style>
  <?php
   break;
   case "Ubuntu":
   echo  "<link href='//fonts.googleapis.com/css?family=Ubuntu:400,300,500,700' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body {
        font-family: 'Ubuntu', sans-serif!important; 
      }
    </style>
  <?php 
   break;
   case "Open Sans": 
   echo  "<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body {
        font-family: 'Open Sans', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Source Sans Pro": 
   echo  "<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,200,600,700,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body {
        font-family: '<?php echo $googlefonts ?>', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Raleway": 
   echo  "<link href='//fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body {
        font-family: 'Raleway', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Roboto Slab": 
   echo  "<link href='//fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body {
        font-family: 'Roboto Slab', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Droid Serif": 
   echo  "<link href='//fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?>
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body {
        font-family: 'Droid Serif', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Merriweather": 
   echo  "<link href='//fonts.googleapis.com/css?family=Merriweather:400,300,700,900&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body {
        font-family: 'Merriweather', sans-serif!important; 
      }
    </style>
    <?php  
   break;
   case "Merriweather Sans": 
   echo  "<link href='//fonts.googleapis.com/css?family=Merriweather+Sans:400,300,700,900&display=swap&subset=latin' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body {
        font-family: 'Merriweather Sans', sans-serif!important; 
      }
    </style>
  <?php  
   break;
   case "Playfair Display": 
   echo  "<link href='//fonts.googleapis.com/css?family=Playfair+Display:400,700,900&subset=latin,cyrillic' rel='stylesheet' type='text/css'>"; ?> 
    <style>
      body , body #jc , body #jc .button , #jc #comments .comments-buttons , #comments-form p, 
      #comments-report-form p, #comments-form span, #comments-form .counter, #jc #comments .comment-body {
        font-family: 'Playfair Display', sans-serif!important; 
      }
    </style>
  <?php  
   break;
}
?>
    <jdoc:include type="head" />
    <?php $this->loadBlock ('head') ?>  
    <script>
    var notAnimate = '<?php echo $animate ?>';
    var notPoliteLoading = '<?php echo $politeloading ?>';
    var notstickynavigation = '<?php echo $stickynavigation ?>';
    </script>
  </head>

  <body class='component <jdoc:include type="pageclass" />'>
    <section id="t3-mainbody" class="t3-mainbody component">
      <div class="roww">
        <div id="t3-content" class="t3-content">
          <jdoc:include type="component" />    
        </div>
      </div>
    </section>
    <script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/allscripts.js"></script>
    <script type="text/javascript" src="<?php echo T3_TEMPLATE_URL ?>/js/linescript.js"></script>
  </body>
</html>