<?php $siteData->titleTop = 'Счета (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbankaccount/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bank/account/one/new']); ?>
</form>
