<?php $siteData->titleTop = 'Закуп товаров курьером (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shoppreorde/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/pre/orde/one/new']); ?>
</form>
