<div class="row">
<?php
$n = 5;
$i = 1;
foreach ($data['view::View_Shop_New\-nasha-komanda']->childs as $value){
    if($i == $n + 1){
        echo '</div><div class="row">';
        $i = 1;
    }
	if (($i == 2) || ($i == 4)){
		$value->str = str_replace('<div class="box-img">', '<div class="box-img" style="margin-top: 127px">', $value->str);
	}
	
    $i++;
    echo $value->str;
}
?>
</div>