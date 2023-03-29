<?php
$str = 'for="company-'.Request_RequestParams::getParamInt('id').'" class="';
foreach ($data['view::View_Shop_New\about-rubrikatciya']->childs as $value){
    echo str_replace($str, $str.'active ', $value->str);
}
?>