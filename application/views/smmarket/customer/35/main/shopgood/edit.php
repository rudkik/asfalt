<?php
$view = View::factory($siteData->shopShablonPath.'/35/find');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>

<div class="body-goods-shop">
    <div class="container">
        <?php echo trim($data['view::shopgood/edit']); ?>
    </div>
</div>