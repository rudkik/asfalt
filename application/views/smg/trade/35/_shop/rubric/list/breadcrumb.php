<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/trade/general/index">Главная</a></span> /
<?php
foreach ($data['view::_shop/rubric/one/breadcrumb']->childs as $value) {
    echo $value->str;
}
?>
<?php if(Request_RequestParams::getParamInt('id') < 1){ ?>
    <span typeof="v:Breadcrumb" class="active"><a rel="v:url" property="v:title" href="<?php echo $siteData->urlBasic; ?>/trade/catalog/index">Продукция</a></span>
<?php } ?>