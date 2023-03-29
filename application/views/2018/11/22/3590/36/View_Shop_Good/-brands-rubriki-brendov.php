<?php
$s = Request_RequestParams::getParamInt('brand');
if(!empty($s)){
    $s = '?brand='.$s;
}
?>
<li><a href="<?php echo $siteData->urlBasicLanguage; ?>/products<?php echo $data->values['name_url']; ?><?php echo $s; ?>"><?php echo $data->values['name']; ?></a></li>