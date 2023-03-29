<div class="row box-categories">
<?php	
$n = 4;
$i = 1;
$j = 0;
foreach ($data['view::View_Shop_Good\gruppy-tovarov']->childs as $value){
    if($i == $n + 1){
        echo '</div><div class="row box-categories">';
        $i = 1;
		$j++;
    }
    $i++;
	if($j == 1){
		$value->str = str_replace('<div class="col-xs-3', '<div class="col-xs-4', $value->str);
	}
    echo $value->str;
}
?>
</div>