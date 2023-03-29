<?php
$id = Request_RequestParams::getParamInt('rubric_id');
foreach ($data['view::View_Shop_Table_Rubric\-catalog-khlebnye-kroshki']->childs as $value){
    echo str_replace('class="breadcrumb-item" data-id="'.$id.'"', 'class="breadcrumb-item current" data-id="'.$id.'"', $value->str);
}
?>