<?php $siteData->titleTop = 'Способ оплаты (добавление)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbillpaymenttype/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bill/payment-type/one/new']); ?>
</form>
