<?php $siteData->titleTop = 'Тип атрибутов продукции (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopattributetype/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/attribute/type/one/edit']); ?>
</form>
