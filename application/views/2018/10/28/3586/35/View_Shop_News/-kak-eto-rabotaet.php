<?php 
$i = 1;
foreach ($data['view::View_Shop_New\-kak-eto-rabotaet']->childs as $value){
	echo str_replace('#index#', $i, $value->str);
	$i++;
}
?>