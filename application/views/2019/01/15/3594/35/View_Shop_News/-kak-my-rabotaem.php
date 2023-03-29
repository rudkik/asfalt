<?php 
$i = 1;
 foreach ($data['view::View_Shop_New\-kak-my-rabotaem']->childs as $value){
echo str_replace('#index#', '0'.$i, $value->str);
	 $i++;
}
?>