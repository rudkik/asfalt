<?php if($siteData->branchID > 0){ ?>
	<div class="body-bills">
		<div class="container">
			<?php
			$view = View::factory('smmarket/sadmin/35/main/shopgood/index-branch');
			$view->siteData = $siteData;
			$view->data = $data;
			echo Helpers_View::viewToStr($view);
			?>
		</div>
	</div>
<?php }else{ ?>
	<div class="body-bills">
		<div class="container">
			<h1>Товары</h1>
			<?php
			$view = View::factory('smmarket/sadmin/35/main/shopgood/index-not-branch');
			$view->siteData = $siteData;
			$view->data = $data;
			echo Helpers_View::viewToStr($view);
			?>
		</div>
	</div>
<?php } ?>