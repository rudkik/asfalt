<?php
$view = View::factory('sladushka/manager/35/main/shop/filter');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>

<section class="content bg-white">
	<?php
	$view = View::factory('sladushka/manager/35/main/shop/table');
	$view->siteData = $siteData;
	$view->data = $data;
	echo Helpers_View::viewToStr($view);
	?>
</section>

