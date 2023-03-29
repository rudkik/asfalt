<?php $siteData->titleTop = 'Закуп товаров курьером'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shoppreorder/save_buy'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/pre-order/one/show']); ?>
</form>