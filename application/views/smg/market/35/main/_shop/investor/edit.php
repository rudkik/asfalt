<?php $siteData->titleTop = 'Инвестор (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopinvestor/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/investor/one/edit']); ?>
</form>
