<?php $siteData->titleTop = 'Рубрика атрибутов продукци (создание)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopattributerubric/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/attribute/rubric/one/new']); ?>
</form>
