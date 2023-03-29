<?php 
$i = 0;
 foreach ($data['view::View_Shop_Comment\otzyvy']->childs as $value){
	 if($i == 0){
		 $value->str = str_replace('<div class="item">', '<div class="item active">', $value->str);
		 $i++;
	 }
echo $value->str;
}
?>