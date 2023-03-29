<?php
echo Json::json_encode(
    array(
        'one' => '
<li class="" data-action="select-panel" data-children="#panel-'.$data->id.'">
    <a href="'.$siteData->urlBasicLanguage.'/products'.$data->values['name_url'].'">'.$data->values['name'].'</a>
    <div class="line-g"></div>
</li>
        ',
        'list' => '
<div data-action="find-panel" id="panel-'.$data->id.'" class="row box-menu-child-list">
    '.$data->additionDatas['view::View_Shop_Goods\group\basic\menyu-child'].'
</div>        
        ',
    )
);
?>

