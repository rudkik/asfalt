<?php
$i = 0;
 foreach ($data['view::View_ShopFileRubric\event_programma-dni']->childs as $value){
  if($i > 0){
   $value->str = str_replace('class="tz-open"', '', $value->str);
  }
  $i++;
echo $value->str;
}
?>