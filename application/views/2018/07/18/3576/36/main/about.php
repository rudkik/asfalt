<?php echo trim($siteData->globalDatas['view::View_Shop_News\about-o-nas']); ?>
<?php
$view = View::factory($siteData->shopShablonPath.'/36/maps');
$view->siteData = $siteData;
echo Helpers_View::viewToStr($view);
?>