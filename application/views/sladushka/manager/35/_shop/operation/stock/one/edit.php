<h3>Заказ №<?php echo $data->id; ?></h3>
<ul class="products-list product-list-in-box">
    <?php echo trim($siteData->globalDatas['view::_shop/operation/stock/item/list/index']); ?>
</ul>
<h3 style="margin: 0px;text-align: right; font-size: 18px;"><span>Итого: </span><label class="text-red"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></label></h3>
<h3 style="margin: 0px;text-align: right;"><span>Остаток: </span><label class="text-red"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount_first']); ?></label></h3>
