<h3>Возврат №<?php echo $data->id; ?></h3>
<ul class="products-list product-list-in-box">
    <?php echo trim($siteData->globalDatas['view::_shop/return/item/list/index']); ?>
</ul>
<h3 style="margin: 0px;text-align: right;"><span>Итого: </span><label class="text-red"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></label></h3>