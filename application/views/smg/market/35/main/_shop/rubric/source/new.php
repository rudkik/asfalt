<?php $siteData->titleTop = 'Рубрика (добавление)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shoprubricsource/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/rubric/source/one/new']); ?>
</form>
