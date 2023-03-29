<?php $siteData->titleTop = 'Рубрика атрибутов продукци (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopattributerubric/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/attribute/rubric/one/edit']); ?>
</form>
