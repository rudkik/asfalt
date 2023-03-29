<?php
if($data->id > 0) {
    $siteData->siteTitle = $data->values['name'] . ' ' . $siteData->siteTitle;
}
?>
<main id="listar-main" class="listar-main listar-haslayout">
    <div id="listar-twocolumns" class="listar-twocolumns">
        <div class="listar-themepost listar-post listar-detail listar-postdetail">
            <figure class="listar-featuredimg">
                <img src="<?php if(($data->id < 1) || (empty($data->values['image_path']))){?><?php echo $siteData->urlBasic.'/css/'.$siteData->shopShablonPath.'/images/parallax/bgparallax-111.jpg'; ?><?php }else{ echo Helpers_Image::getPhotoPath(Helpers_Image::getOptimalSizePhotoPath($data->values['files'], 1900, 406, $data->values['image_path']), 1900, 406); } ?>" alt="<?php if($data->id < 1){?>Статьи<?php }else{ echo htmlspecialchars($data->values['name'], ENT_QUOTES);}?>">
                <figcaption>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="listar-postcontent">
                                    <h1><?php if($data->id < 1){?>Статьи<?php }else{ echo $data->values['name'];}?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </figcaption>
            </figure>
        </div>
    </div>
</main>