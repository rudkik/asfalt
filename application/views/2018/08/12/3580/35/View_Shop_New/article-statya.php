<?php
Helpers_SEO::setSEOHeader(Model_Shop_New::TABLE_NAME, $data, $siteData);
$siteData->siteImage = $data->values['image_path'];
?>
<figure class="listar-featuredimg">
    <img src="<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getOptimalSizePhotoPath($data->values['files'], 1900, 406, $data->values['image_path']), 1900, 406); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES); ?>">
    <figcaption>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="listar-postcontent">
                        <time datetime="<?php echo $data->values['created_at']; ?>">
                            <i class="icon-clock4"></i>
                            <span><?php echo Helpers_DateTime::getDateTimeDayMonthRus($data->values['created_at'], TRUE); ?></span>
                        </time>
                        <span class="listar-postcomment">
                            <i class="icon-comment"></i>
                            <a class="box_rubric" href="<?php echo $siteData->urlBasic; ?>/articles<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name_url', ''); ?>"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', ''); ?></a>
                        </span>
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