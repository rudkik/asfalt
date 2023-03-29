<?php $siteData->titleTop = 'Маршрут курьера (редактирование)'; ?>
<form class="form-horizontal" action="<?php echo Func::getFullURL($siteData, '/shopcourierroute/save'); ?>" method="post" style="padding-right: 5px;">
    <?php echo trim($data['view::_shop/courier/route/one/edit']); ?>
</form>
