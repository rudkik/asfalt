<?php 
$i = 1;
foreach ($data['view::View_Shop_New\-articles-slaider-na-glavnoi']->childs as $value){
	if($i == 1){
		$value->str = str_replace('<div class="item">', '<div class="item active">', $value->str);
		$i++;
	}
	echo $value->str;
}
?>