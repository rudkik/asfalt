<div class="col-md-4">
    <a href="<?php echo $siteData->urlBasic;?>/event/sponsor?id=<?php echo $data->values['shop_id']; ?>&sponsor=<?php echo $data->id; ?>">
	    <img class="exhibition__sponsor__logo" src="<?php echo Func::getPhotoPath($data->values['image_path'], 192, 100); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
	</a>
</div>