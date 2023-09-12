<?php 
/**
 * @package		JMS Youtube for Virtuemart plugin
 * @version		1.0
 * @copyright	Copyright (C) 2009 - 2013 Joommasters. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @Website: http://www.joommasters.com
 * @Email: joommasters@gmail.com
 **/
defined('_JEXEC') or 	die(); 
//
$product = $viewData[0];
$params = $viewData[1];
//$video_id = $this->getVideoID($params->youtube_link);
$video_id = $params->youtube_link;

$link_video = 'http://www.youtube.com/watch?v='.$video_id;
?>

<div class="product-title-youtube">
    <?php 
    if($params->new_title !="" && $params->field_select =="2"){
        echo $params->new_title;
    }elseif($params->field_select !="3"){
        echo $this->getVideoTitle($video_id);
    }
    ?>
</div>
<div class="product-desc-youtube">
    <?php 
    if($params->new_desc !=""){
        echo html_entity_decode($params->new_desc);
    }
    ?>
</div>

<?php if($params->youtube_link){?>
<div class="show-video">
<embed width="<?php echo $params->width?>" height="<?php echo $params->height?>" src="http://www.youtube.com/v/<?php echo $video_id;?>?autoplay=<?php echo $params->autoplay?>&theme=<?php echo $params->youtube_theme?>&rel=<?php echo $params->relate_video?>&autohide=<?php echo $params->fade_control?>&showinfo=<?php echo $params->youtube_title?>&color=<?php echo $params->progress_color?>&color1=<?php echo $params->border_color?>&control=<?php echo $params->controlbar?>&color=<?php echo $params->progress_color;?>" allowscriptaccess="never" type="application/x-shockwave-flash" />

</div>
<?php }?>
<?php if(!empty($params->youtube_desc)){?>
<div class="product-desc-youtube">
    <?php       
            echo $this->getVideoDescription($video_id);
    ?>
</div>
<?php }?>

