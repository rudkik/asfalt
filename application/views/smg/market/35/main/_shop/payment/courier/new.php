<?php $siteData->titleTop = 'Выплата курьеру для закупа (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shoppaymentcourier/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/payment/courier/one/new']); ?>
</form>
