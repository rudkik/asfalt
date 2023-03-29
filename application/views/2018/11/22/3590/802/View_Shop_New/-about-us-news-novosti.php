<?php if($data->values['shop_table_catalog_id'] == 3884){ ?>
    <div class="col-md-12 box-event">
        <div class="row">
            <div class="col-md-3">
                <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/news<?php echo $data->values['name_url']; ?>">
                    <img class="box" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"
                         src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 395, NULL); ?>"
                         alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" />
                </a>
            </div>
            <div class="col-md-9">
                <div class="box-title">
                    <h2>
                        <a href="<?php echo $siteData->urlBasicLanguage; ?>/about-us/news<?php echo $data->values['name_url']; ?>">
                            <?php echo $data->values['name']; ?>
                        </a>
                    </h2>
                    <span class="date"><?php echo Helpers_DateTime::getDateTimeDayMonth($siteData, $data->values['created_at'], TRUE); ?></span>
                </div>
                <div class="box_text">
                    <?php echo Func::trimTextNew($data->values['text'], 600); ?>
                </div>
            </div>
        </div>
    </div>
<?php }else{ ?>
    <div class="col-md-12 box-event">
        <div class="row">
            <div class="col-md-3">
                <a href="<?php echo $siteData->urlBasicLanguage; ?>/events/events-and-exhibitions<?php echo $data->values['name_url']; ?>">
                    <img class="box" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>"
                         src="<?php echo Helpers_Image::getPhotoPath($data->values['image_path'], 395, NULL); ?>"
                         alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" />
                </a>
            </div>
            <div class="col-md-9">
                <div class="box-title">
                    <h2>
                        <a href="<?php echo $siteData->urlBasicLanguage; ?>/events/events-and-exhibitions<?php echo $data->values['name_url']; ?>">
                            <?php echo $data->values['name']; ?>
                        </a>
                    </h2>
                    <span class="date"><?php echo Helpers_DateTime::getDateTimeDayMonth($siteData, Arr::path($data->values['options'], 'from_at', '')); ?> - <?php echo Helpers_DateTime::getDateTimeDayMonthRus(Arr::path($data->values['options'], 'to_at', ''), TRUE); ?></span>
                </div>
                <div class="box_text">
                    <?php echo Func::trimTextNew($data->values['text'], 600); ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>