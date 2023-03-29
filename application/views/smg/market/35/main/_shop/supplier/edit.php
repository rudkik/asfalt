<?php $siteData->titleTop = 'Поставщик (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopsupplier/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/supplier/one/edit']); ?>
</form>