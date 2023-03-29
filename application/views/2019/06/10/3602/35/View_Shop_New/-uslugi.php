<?php if(!empty($data->values['text'])){?>
    <li><a href="<?php echo $siteData->urlBasicLanguage; ?>/service<?php echo $data->values['name_url']; ?>"><?php echo $data->values['name']; ?></a></li>
<?php }else{?>
    <li><a><?php echo $data->values['name']; ?></a></li>
<?php } ?>