<div class="language">
    <div class="media-left">
        <a href="<?php
        if ($data->id == Model_Language::LANGUAGE_RUSSIAN){
            echo $siteData->urlBasic.$siteData->url.URL::query(array('language_id' => $data->id));
        }else{
            echo $siteData->urlBasic.'/'.strtolower($data->values['code']).$siteData->url.URL::query();
        }
        ?>"><img src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/languages/<?php echo strtolower($data->values['code']); ?>.png"></a>
    </div>
</div>