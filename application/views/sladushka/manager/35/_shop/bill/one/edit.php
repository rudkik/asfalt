<h3>Заказ №<?php echo $data->id; ?></h3>
<ul class="products-list product-list-in-box">
    <?php echo trim($siteData->globalDatas['view::_shop/bill/item/list/index']); ?>
</ul>
<h3 style="margin: 0px;text-align: right;"><span>Итого: </span><label class="text-red"><?php echo Func::getPriceStr($siteData->currency, $data->values['amount']); ?></label></h3>
<div class="text-center" style="width: 100%">
    <a href="<?php echo $siteData->urlBasic; ?>/manager/shopcart/repair_bill" class="btn btn-danger btn-flat">Повторить заказ</a>
</div>