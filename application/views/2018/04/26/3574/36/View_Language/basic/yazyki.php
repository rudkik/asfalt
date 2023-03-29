<div class="box-language">
    <div class="language">
        <a href="<?php echo $siteData->urlBasic.$siteData->url.'/'.strtolower($data->values['code']).URL::query(array('language_id' => $data->id)); ?>"><?php echo $data->values['name_short']; ?></a>
    </div>
</div>