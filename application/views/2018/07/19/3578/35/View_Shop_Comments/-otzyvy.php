<?php 
$i = 1;
 foreach ($data['view::View_Shop_Comment\-otzyvy']->childs as $value){
	 if($i == 1){
		 $value->str = str_replace('<div class="item">', '<div class="item active">', $value->str);
		 $i++;
	 }
echo $value->str;
}
?>