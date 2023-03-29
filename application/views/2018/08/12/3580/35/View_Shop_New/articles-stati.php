<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <div class="listar-themepost listar-post">
        <figure class="listar-featuredimg">
            <a href="<?php echo $siteData->urlBasic; ?>/articles<?php echo $data->values['name_url']; ?>"><img src="<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getOptimalSizePhotoPath($data->values['files'], 401, 299, $data->values['image_path']), 401, 299); ?>" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"></a>
            <?php if($data->values['shop_table_rubric_id'] > 0){ ?>
            <a class="listar-postcategory" href="<?php echo $siteData->urlBasic; ?>/articles<?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name_url', ''); ?>"><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', ''); ?></a>
            <?php } ?>
        </figure>
        <div class="listar-postcontent">
            <figure class="listar-authorimg"><img src="<?php echo Helpers_Image::getPhotoPath(Helpers_Image::getOptimalSizePhotoPath($data->values['files'], 54, 54, $data->values['image_path']), 54, 54); ?>" alt="image description"></figure>
            <h2><a href="<?php echo $siteData->urlBasic; ?>/articles<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></h2>
            <div class="listar-themepostfoot">
                <time datetime="<?php echo $data->values['created_at']; ?>">
                    <i class="icon-clock4"></i>
                    <span><?php echo Helpers_DateTime::getDateTimeDayMonthRus($data->values['created_at'], TRUE); ?></span>
                </time>
                <span class="listar-postcomment">
                    <i class="icon-comment"></i>
                    <span><?php echo Arr::path($data->values, Model_Basic_BasicObject::FIELD_ELEMENTS.'.shop_table_rubric_id.name', ''); ?></span>
                </span>
            </div>
        </div>
    </div>
</div>