<?php $siteData->titleTop = 'Рубрика (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shoprubric/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/rubric/one/edit']); ?>
</form>