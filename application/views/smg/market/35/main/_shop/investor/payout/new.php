<?php $siteData->titleTop = 'Выплата инвестора (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopinvestorpayout/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/investor/payout/one/new']); ?>
</form>
