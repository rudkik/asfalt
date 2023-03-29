<div class="col-lg-3 department">
    <div class="media-left">
        <img class="active" src="<?php echo $data->values['image_path']; ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
    </div>
    <div class="media-body">
        <div class="box-text"><a href="<?php echo $siteData->urlBasicLanguage; ?>/departments<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></div>
    </div>
</div>