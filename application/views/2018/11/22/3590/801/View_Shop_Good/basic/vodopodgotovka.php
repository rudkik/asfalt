<?php
echo Json::json_encode(
    array(
        'one' => '
<li class="active" data-action="select-panel" data-children="#panel-'.$data->id.'">
    <a href="'.$siteData->urlBasicLanguage.'/products'.$data->values['name_url'].'">'.$data->values['name'].'</a>
    <div class="line-g"></div>
</li>
        ',
        'list' => '
<div data-action="find-panel" id="panel-'.$data->id.'" class="row box-menu-child-list active">
    '.$data->additionDatas['view::View_Shop_Goods\group\basic\vodopodgotovka'].'
</div>        
        ',
    )
);
?>