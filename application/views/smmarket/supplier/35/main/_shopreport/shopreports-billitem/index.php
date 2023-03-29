<?php 
$view = View::factory('cabinet/35/main/shopreports-day/filter');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>


<section class="content bg-white">
	<?php 
	$view = View::factory('cabinet/35/main/shopreports-day/table');
	$view->siteData = $siteData;
	$view->data = $data;
	echo Helpers_View::viewToStr($view);
	?>
</section>


<section class="content bg-white">
	<div class="row">
		<div class="col-md-12">
			
		</div>
	</div>
</section>

