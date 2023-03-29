<?php if (Request_RequestParams::getParamInt('id') == $data->values['id']){?>
<span typeof="v:Breadcrumb" class="active"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/trade/catalog/index?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a></span>
<?php } else{ ?>
<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/trade/catalog/index?id=<?php echo $data->values['id']; ?>"><?php echo $data->values['name']; ?></a></span> /
<?php } ?>