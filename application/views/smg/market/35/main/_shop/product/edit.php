<?php $siteData->titleTop = 'Товар (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopproduct/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/product/one/edit']); ?>
</form>