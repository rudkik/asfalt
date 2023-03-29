<?php $siteData->titleTop = 'Должность(изменение)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopposition/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/position/one/edit']); ?>
</form>
