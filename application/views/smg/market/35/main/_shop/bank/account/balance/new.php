<?php $siteData->titleTop = 'Баланс банковского счета (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbankaccountbalance/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bank/account/balance/one/new']); ?>
</form>
