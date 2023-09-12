<?php // no direct access
defined('_JEXEC') or die('Restricted access');
?>
<div class="mod-currencies">

<!-- Currency Selector Module -->
<?php echo $text_before ?>
<!-- Currency Selector Module -->
<div id="cur-lang" class="header-button-currency">
        <div class="heading">
        <?php foreach ($currencies as $currency) { ?>
            <?php if ($currency->virtuemart_currency_id == $virtuemart_currency_id) { ?>
            <span><?php echo $currency->currency_symbol; ?></span>
             <span><?php echo $currency->currency_code_3; ?></span>
        <?php } } ?>
        </div>
        <ul>
        <i class="fa fa-sort-desc"></i>
            <form action="<?php echo vmURI::getCleanUrl() ?>" method="post" >
            <div>
            <?php foreach ($currencies as $currency) { ?>
                <?php if ($currency->virtuemart_currency_id == $virtuemart_currency_id) { ?>
                    <li><a  class="act" title="<?php echo $currency->currency_txt; ?>"><?php echo $currency->currency_symbol; ?>&nbsp;<span><?php echo $currency->currency_txt; ?></span></a></li>
                <?php } else { ?>
                <li><a title="<?php echo $currency->currency_txt; ?>" onClick="jQuery('input[name=\'virtuemart_currency_id\']').attr('value', '<?php echo $currency->virtuemart_currency_id; ?>').submit(); jQuery(this).parent().parent().parent().submit();"><?php echo $currency->currency_symbol; ?>&nbsp;<span><?php echo $currency->currency_txt; ?></span></a></li>
                <?php } ?>
            <?php } ?>
            </div>
            <input type="hidden" name="virtuemart_currency_id" value="" />
            </form>
        </ul>
            
    </div>
</div>