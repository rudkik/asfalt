<div class="col-1-3">
    <div class="wrap-col">
        <a href="<?php echo $siteData->urlBasicLanguage; ?>/transportation<?php echo $data->values['name_url']; ?>">
            <img src="<?php echo $data->values['image_path']; ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"/><br />
            <noindex><?php echo $data->values['name']; ?></noindex>
        </a>
    </div>
</div>