<?php $siteData->titleTop = 'Атрибут продукции (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopattribute/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/attribute/one/edit']); ?>
</form>
