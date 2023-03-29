<?php
$view = View::factory($siteData->shopShablonPath.'/35/find');
$view->siteData = $siteData;
$view->data = $data;
echo Helpers_View::viewToStr($view);
?>
<div class="body-title">
	<div class="container">
		<?php if(Request_RequestParams::getParamBoolean('is_discount')){ ?>
			<h1>Акции</h1>
		<?php }elseif(Request_RequestParams::getParamBoolean('good_select_type_id') == 3723){ ?>
			<h1>Новинки</h1>
		<?php } ?>
	</div>
</div>
<div class="body-goods">
	<div class="container">
		<?php echo trim($data['view::shopgoods/index']); ?>
	</div>
</div>

