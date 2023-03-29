<div class="item">
    <a href="<?php echo $siteData->urlBasic; ?>/catalogs?brand=<?php echo $data->values['id']; ?>">
        <figure>
            <figcaption class="text-overlay">
                <div class="info">
                    <h4><?php echo $data->values['name']; ?></h4>
                </div>
            </figcaption>
            <img width="145" height="50" class="img-responsive desaturate" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 145, 50); ?>">
        </figure>
    </a>
</div>