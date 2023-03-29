<?php $siteData->titleTop = 'Компания (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopcompany/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/company/one/edit']); ?>
</form>
