<li>
	<a href="<?php
    $arr = array_merge($_POST, $_GET);
    unset($arr['rubric_id']);
    unset($arr['id']);
    unset($arr['language_id']);
    $url = $siteData->url;
    switch ($url){
        case '/brand':
            $url = '/brands';
            unset($arr['brand']);
            break;
        case '/product':
            $url = '/products';
            break;
        case '/about-us/partners/show':
            $url = '/about-us/partners';
            break;
        case '/about-us/job-positions/show':
            $url = '/about-us/job-positions';
            break;
        case '/events/events-and-exhibitions/show':
            $url = '/events/events-and-exhibitions';
            break;
        case '/about-us/news/show':
            $url = '/about-us/news';
            break;
        case '/about-us/addition':
            $url = '/about-us';
            break;
    }
    $isUtEc = strpos($siteData->urlBasic, 'ut-ec.com');
    if((($isUtEc !== FALSE) && ($data->id == Model_Language::LANGUAGE_ENGLISH)) || (($isUtEc === FALSE) && ($data->id == Model_Language::LANGUAGE_RUSSIAN))){
        echo $siteData->urlBasic.$url.$siteData->urlSEO.URL::query(array_merge($arr, array('language_id' => $data->id)), FALSE);
    }else{
        echo $siteData->urlBasic.'/'.strtolower($data->values['code']).$url.$siteData->urlSEO.URL::query($arr, FALSE);
    }
    ?>"><?php echo Func::mb_ucfirst($data->values['name']); ?></a>
</li>