<div class="promo_link_section_link">
    <div class="promo_link_section_bg_pic_cont">
        <div class="promo_link_section_bg_pic" style="background-image: url(<?php echo Func::addSiteNameInFilePath(Helpers_Image::getPhotoPathByImageType($data->values['files'], 'main_background'), $siteData); ?>);"></div>
    </div>
    <div class="promo_link_section_pic_cont">
        <img src="<?php echo Func::addSiteNameInFilePath(Helpers_Image::getPhotoPathByImageType($data->values['files'], 'main_image'), $siteData); ?>" class="promo_link_section_pic">
    </div>
    <div class="promo_link_section_text_cont">
        <a href="<?php echo 'http://'.$data->values['domain']; ?>/main" class="text"><?php echo Arr::path($data->values['options'], 'name_ru', ''); ?></a>
        <a href="<?php echo 'http://'.$data->values['domain']; ?>/en/main" class="text"><?php echo Arr::path($data->values['options'], 'name_en', ''); ?></a>
	</div>
</div>