<?php echo trim($data['view::_shop/confidant/list/index']); ?>
<?php
$view = View::factory('tax/client/35/_shop/confidant/one/new');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>