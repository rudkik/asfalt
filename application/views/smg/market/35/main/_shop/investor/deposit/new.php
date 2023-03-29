<?php $siteData->titleTop = 'Вклад инвестора (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopinvestordeposit/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/investor/deposit/one/new']); ?>
</form>
