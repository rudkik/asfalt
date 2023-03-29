<?php echo trim($data['view::_shop/product/list/index']); ?>
<?php
$view = View::factory('tax/client/35/_shop/product/one/new');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>