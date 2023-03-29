<section class="content-header">
	<h1>E-mail сообщения</h1>
</section>

<?php
$view = View::factory('cabinet/35/main/shopemail/filter');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>


<section class="content bg-white">
	<?php 
	$view = View::factory('cabinet/35/main/shopemail/table');
	$view->siteData = $siteData;
	$view->data = $data;
	echo Helpers_View::viewToStr($view);
	?>
</section>


