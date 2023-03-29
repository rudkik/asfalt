<?php $siteData->titleTop = 'Бренд (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopbrand/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/brand/one/edit']); ?>
</form>