<?php
$humanExtra = 0;
$childExtra = 0;
$human = 0;
foreach ($data['view::View_Hotel_Shop_Bill_Item\bill_client']->childs as $key => $value){
    echo $value->str;

    $humanExtra += $value->values['human_extra'];
    $childExtra += $value->values['child_extra'];
    $human += intval($value->getElementValue('shop_room_id', 'human'));
}
$siteData->globalDatas['view::total_human'] = '<td>'.$human.'</td><td>'.$humanExtra.'</td><td>'.$childExtra.'</td>'
?>