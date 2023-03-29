<div class="col-xs-2 category">
    <a href="<?php echo $siteData->urlBasicLanguage; ?>/trucks<?php echo $data->values['name_url']; ?>">
        <img src="<?php echo $data->values['image_path']; ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        <p><?php echo $data->values['name']; ?></p>
    </a>
</div>