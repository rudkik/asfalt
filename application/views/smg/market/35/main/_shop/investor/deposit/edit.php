<?php $siteData->titleTop = 'Вклад инвестора (редактироваине)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopinvestordeposit/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/investor/deposit/one/edit']); ?>
</form>
