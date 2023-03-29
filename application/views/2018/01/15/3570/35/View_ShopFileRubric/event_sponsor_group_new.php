<div class="col-6">
    <a href="<?php echo $siteData->urlBasic;?>/event/sponsor?id=<?php echo $data->values['shop_id']; ?>&sponsor=<?php echo $data->id; ?>">
        <img src="<?php echo Arr::path($data->values['files'], '1.file', $data->values['image_path']); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" class="img-fluid">
    </a>
</div>