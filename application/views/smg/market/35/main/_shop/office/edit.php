<?php $siteData->titleTop = 'Офис компании (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopoffice/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/office/one/edit']); ?>
</form>
