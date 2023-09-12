<?php

    /**
    * VirtueMart Categories Module
    */

?>
<div class="serchline">
<div class="<?php echo $moduleclass_sfx; ?> sp-vmsearch" id="sp-vmsearch-<?php echo $module_id ?>">
    <form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&search=true&limitstart=0&virtuemart_category_id=0' ); ?>" method="post">
       <div class="search-input-wrapper">
            <input type="text" name="keyword" autocomplete="off" class="sp-vmsearch-box" value="<?php echo JRequest:: getVar('keyword') ?>" />
        </div>
        <div class="sp-vmsearch-categorybox">
            <select name="virtuemart_category_id" class="sp-vmsearch-categories">
                <option value="0" data-name="<?php echo JText::_('SP_VMSEARCH_ALL_CATEGORIES') ?>"><?php echo JText::_('SP_VMSEARCH_ALL_CATEGORIES') ?></option>
                <?php
                    echo $modSPVMSearchHelper->getTree();
                ?>
            </select>
        </div>
         <div class="search-button-wrapper">
            <button type="submit" class="search-button button"><?php echo JText::_('SP_VMSEARCH_SEARCH_BUTTON') ?></button>
        </div>  
        <div class="clearfix"></div>
        <input type="hidden" name="limitstart" value="0" />
        <input type="hidden" name="option" value="com_virtuemart" />
        <input type="hidden" name="view" value="category" />
        <input id="cat_search" type="hidden" name="virtuemart_category_id" value="0"/>
        <div class="srclose"><i class="fa fa-times"></i></div>
    </form>
</div>
      <div class="ac_result" style="display:none;"></div>
      <div class="sropen"><i class="fa fa-search"></i></div>
      

</div>

<script type="text/javascript">
    jQuery(function($){
            
            $(".sp-vmsearch .sp-vmsearch-categories").change(function(){
                var $nameval = $(this).val();
                $('#cat_search').val($nameval);
            });
            // change event
            $('#sp-vmsearch-<?php echo $module_id ?> .sp-vmsearch-categories').on('change', function(event){
                    var $name = $(this).find(':selected').attr('data-name');
                    $('#sp-vmsearch-<?php echo $module_id ?> .sp-vmsearch-category-name .category-name').text($name);

            });


            // typeahed
            $('#sp-vmsearch-<?php echo $module_id ?> .sp-vmsearch-box').typeahead({
                    items  : '<?php echo $max_search_suggest; ?>',
                    source : (function(query, process){
                            return $.post('<?php echo JURI::current() ?>', 
                                { 
                                    'module_id': '<?php echo $module_id; ?>',
                                    'char': query,
                                    'category': $('#sp-vmsearch-<?php echo $module_id ?> .sp-vmsearch-categories').val()
                                }, 
                                function (data) {
                                    return process(data);
                                },'json');
                    }),
            }); 
    });
    </script>