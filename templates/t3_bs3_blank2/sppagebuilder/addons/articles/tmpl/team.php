<?php 

      $output  .= '<div class="sppb-addon sppb-addon-articles ' . $class . '">';

      if($title) {
        $output .= '<'.$heading_selector.' class="sppb-addon-title">' . $title . '</'.$heading_selector.'>';
      }

      $output .= '<div class="sppb-addon-content">';
      if(!$used_masonry){
        $output .= '<div class="sppb-row team">';
      }else {
        $output .= '<div class="grid">';
      }
      
      foreach ($items as $key => $item) {
          require_once(JPATH_SITE.'/components/com_k2/models/item.php');
          $model = K2Model::getInstance('Item', 'K2Model');
        $item->text = '';
          $app = JFactory::getApplication();
          $params = JFactory::getApplication( 'site' )->getParams();
        $app->triggerEvent('onContentPrepare', array ('com_content.article', &$item, &$params, 0));

        $results                 = $app->triggerEvent('onContentAfterTitle', array('com_content.article', &$item, &$params, 0));
        $item->afterDisplayTitle = trim(implode("\n", $results));

        $results                    = $app->triggerEvent('onContentBeforeDisplay', array('com_content.article', &$item, &$params, 0));
        $item->beforeDisplayContent = trim(implode("\n", $results));

        $results                   = $app->triggerEvent('onContentAfterDisplay', array('com_content.article', &$item, &$params, 0));
        $item->afterDisplayContent = trim(implode("\n", $results));
        //$item->link = JRoute::_('?option=com_k2&view=item&tmpl=component&id=7&Itemid=139');
        $item->link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($item->id.':'.urlencode($item->alias), $item->catid.':'.urlencode($item->categoryalias)).'&tmpl=component'));

        //print_r($item->link);

        if(!$used_masonry){
          $output .= '<div class="sppb-col-sm-'. round(12/$columns) .'">';
        }else {
          if($columns > 0) {
           $output .= '<div class="sppb-col-sm-'. round(12/$columns) .' grid-item">';
          }else {
           $output .= '<div class="sppb-col-sm-0 grid-item">';
          }
        }
        $output .= '<div class="addon-article">';

        if(!$hide_thumbnail) {
        $image = '';
          if ($resource == 'k2') {
            if(isset($item->image_medium) && $item->image_medium){
              $image = $item->image_medium;
            } elseif(isset($item->image_large) && $item->image_large){
              $image = $item->image_medium;
            }
          } else {
            $image = $item->image_thumbnail;
          }
            if(isset($image) && $image) {  


            $output .= '<div class="image-box">';  
           if($show_tags) {
              $tags = $model->getItemTags($item->id);
            // print_r($tags);
              $output .= '<ul class="sppb-tag">';
              foreach ($tags as $tag){ 
                if($tag->name != ''){           
                 $output .= '<li><span class="list-tag">'.$tag->name.'</span></li>';
                }
              }
              $output .= '</ul>';
             // 
            }  
            $output .= '<a class="iframe fancybox.iframe" href="'. $item->link .'" itemprop="url"><img class="sppb-img-responsive" src="'. $image .'" alt="'. $item->title .'" itemprop="thumbnailUrl"></a>';
            $output .= '</div>'; 
            }
        }

        $output .= '<div class="name-team"><a class="iframe fancybox.iframe" href="'. $item->link .'" itemprop="url">' . $item->title . '</a></div>';
        $output .= $item->beforeDisplayContent;
        $output .= $item->afterDisplayTitle;
        $item->extra_f = $model->getItemExtraFields($item->extra_fields, $item);
        if($item->extra_f){
          foreach ($item->extra_f as $extraField){
          if($extraField->value != ''){
        
            $output .= '<span class="moduleItemExtraFieldsValue">'.$extraField->value.'</span>';
          }
         }
        }
        
        $item->numOfComments = $model->countItemComments($item->id);
          
        if($show_author || $show_category || $show_date || $show_tags) {
          $output .= '<div class="sppb-article-meta">';

          if($show_category) {

            if ($resource == 'k2') {
              $item->catUrl = urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($item->catid.':'.urlencode($item->category_alias))));
            } else {
              $item->catUrl = JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug));
            }

            $output .= '<span class="sppb-meta-category"><i class="fa fa-folder-o"></i>' . $item->category . '</span>';
          }
          if($show_date) {
            $output .= '<span class="sppb-meta-date" itemprop="dateCreated"><i class="fa fa-calendar"></i>' . Jhtml::_('date', $item->created, 'DATE_FORMAT_LC3') . '</span>';
          }

          if($show_author) {
              if($item->created_by_alias) {
                $output .= '<span class="sppb-meta-author" itemprop="name"><i class="fa fa-user-o"></i>' . $item->created_by_alias . '</span>';
              }
          }
          $output .= '<span class="komento">';
          $output .= '<i class="fa fa-comment-o"></i>'.$item->numOfComments;
          $output .= '</span>';
          $output .= '<span class="hits">';
          $output .= '<i class="fa fa-heart-o"></i>'.$item->hits;
          $output .= '</span>';

          $output .= '</div>';
        }
        if($show_intro) {
          $item->introtext = strip_tags($item->introtext);
          $output .= '<div class="sppb-article-introtext">'. Jhtml::_('string.truncate', ($item->introtext), $intro_limit) .'</div>';
        }
        $output .= $item->afterDisplayContent;
        if($show_readmore) {
           $output .= '<div class="btn-pos">';
          if($show_readmore) {
            $output .= '<a class="iframe fancybox.iframe sppb-readmore sppb-btn sppb-btn-link" href="'. $item->link .'" itemprop="url">'. $readmore_text .' </a>';
          }
          $output .= '</div>';
       }

        $output .= '</div>';
        $output .= '</div>';
      }

      $output  .= '</div>';

      // See all link
      if($link_articles) {

        if($all_articles_btn_icon_position == 'left') {
          $all_articles_btn_text = ($all_articles_btn_icon) ? '<i class="fa ' . $all_articles_btn_icon . '"></i> ' . $all_articles_btn_text : $all_articles_btn_text;
        } else {
          $all_articles_btn_text = ($all_articles_btn_icon) ? $all_articles_btn_text . ' <i class="fa ' . $all_articles_btn_icon . '"></i>' : $all_articles_btn_text;
        }

        //$output  .= '<a href="' . JRoute::_(ContentHelperRoute::getCategoryRoute($catid)) . '" id="btn-' . $this->addon->id . '" class="sppb-btn' . $all_articles_btn_class . '">' . $all_articles_btn_text . '</a>';

        if ($resource == 'k2') {
          $output  .= '<a href="' . urldecode(JRoute::_(K2HelperRoute::getCategoryRoute($catid.':'.urlencode($catid)))) . '" " id="btn-' . $this->addon->id . '" class="sppb-btn' . $all_articles_btn_class . '">' . $all_articles_btn_text . '</a>';
        } else{
          $output  .= '<div class="clearfix"></div><a href="' . $item->catUrl . '" id="btn-' . $this->addon->id . '" class="sppb-btn' . $all_articles_btn_class . '">' . $all_articles_btn_text . '</a>';
        }

      }

      $output  .= '</div>';
      $output  .= '</div>';
?>