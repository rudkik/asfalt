<?php
$id = Request_RequestParams::getParamInt('sector');
if ($id > 0) {
    $s = '';
    foreach ($data['view::View_Shop\basic\napravleniya-tekst']->childs as $value) {
        $s .= $value->str;
    }
    echo str_replace('class="box-direction-info" data-id="'.$id.'"', 'class="box-direction-info active" data-id="'.$id.'"', $s);
}else{
    $i = 1;
    foreach ($data['view::View_Shop\basic\napravleniya-tekst']->childs as $value) {
        if ($i == 1){
            $value->str = str_replace('class="box-direction-info"', 'class="box-direction-info active"', $value->str);
            $i++;
        }
        echo $value->str;
    }
}
?>