<?php $siteData->titleTop = 'Источник (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopsource/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/source/one/edit']); ?>
</form>