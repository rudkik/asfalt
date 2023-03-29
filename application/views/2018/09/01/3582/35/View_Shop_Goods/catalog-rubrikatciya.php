<?php
$str = '" for="radio-'.(intval(Request_RequestParams::getParamInt('rubric_id')));
 foreach ($data['view::View_Shop_Good\catalog-rubrikatciya']->childs as $value){
     echo str_replace($str, ' active'.$str, $value->str);
}
?>