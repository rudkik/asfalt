<li>
    <a href="<?php
    $arr = array_merge($_GET);
    unset($arr['language_id']);
    $url = $siteData->url;
    switch ($url){
        case '/truck':
            $url = '/trucks';
            break;
    }
    if ($data->id == Model_Language::LANGUAGE_RUSSIAN){
        echo $siteData->urlBasic.$url.$siteData->urlSEO.URL::query(array_merge($arr, array('language_id' => $data->id)), FALSE);
    }else{
        echo $siteData->urlBasic.'/'.strtolower($data->values['code']).$url.$siteData->urlSEO.URL::query($arr, FALSE);
    }
    ?>">
        <img class="land" src="<?php echo $siteData->urlBasic;?>/css/<?php echo $siteData->shopShablonPath;?>/img/<?php echo strtolower($data->values['code']); ?>_f.png" alt="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>" title="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
        <?php echo Func::mb_ucfirst($data->values['name']); ?>
    </a>
</li>