<?php $siteData->titleTop = 'Покупатель (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbillbuyer/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/bill/buyer/one/edit']); ?>
</form>
