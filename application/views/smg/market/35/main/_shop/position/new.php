<?php $siteData->titleTop = 'Должность (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopposition/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/position/one/new']); ?>
</form>
