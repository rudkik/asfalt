<figure class="listar-featuredimg">
    <img src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 1900, 0); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
    <figcaption>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="listar-postcontent">
                        <div class="listar-postcontent">
                            <h1><?php echo $data->values['name']; ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </figcaption>
</figure>
<div class="clearfix"></div>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-push-1 col-md-10 col-lg-push-1 col-lg-10">
            <div id="listar-detailcontent" class="listar-detailcontent">
                <div class="listar-description box_text">
                    <?php echo $data->values['text']; ?>
                </div>
            </div>
        </div>
    </div>
</div>