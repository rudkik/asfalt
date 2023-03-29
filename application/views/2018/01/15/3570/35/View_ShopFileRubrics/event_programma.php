<?php
$i = 0;
 foreach ($data['view::View_ShopFileRubric\event_programma']->childs as $value){
  if($i === 0){
   $value->str = str_replace(' tz-hidden"', '" style="display: block;"', $value->str);
   $i++;
  }
echo $value->str;
}
?>