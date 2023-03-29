<section class="content-header">
	<h1>Типы данных <label style="color: gray; font-size: 18px; font-weight: 400;">(список)</label> </h1>
</section>

<?php
$view = View::factory('cabinet/35/main/shopinformationdatacatalog/filter');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>


<section class="content bg-white">
	<?php
	$view = View::factory('cabinet/35/main/shopinformationdatacatalog/table');
	$view->siteData = $siteData;
	$view->data = $data;
	echo Helpers_View::viewToStr($view);
	?>
</section>