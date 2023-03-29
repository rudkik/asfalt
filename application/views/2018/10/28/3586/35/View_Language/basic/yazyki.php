<?php if($data->id == Model_Language::LANGUAGE_RUSSIAN){?>
<a href="<?php echo $siteData->urlBasic.'/'.$siteData->url.URL::query(array('language_id' => $data->id)); ?>" <?php if($siteData->languageID == $data->id){?>class="langs--current"<?php } ?>><?php echo $data->values['code']; ?></a>
<?php }else{?>
    <a href="<?php echo $siteData->urlBasic.'/'.strtolower($data->values['code']).$siteData->url.URL::query(array('language_id' => $data->id)); ?>" <?php if($siteData->languageID == $data->id){?>class="langs--current"<?php } ?>><?php echo $data->values['code']; ?></a>
<?php }?>