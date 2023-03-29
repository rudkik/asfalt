<div>
<?php
$n = 2;
$i = 1;
foreach ($data['view::View_Shop_Good/-programmy-na-glavnoi']->childs as $value){
    if($i == $n){
        $value->str = str_replace('<div class="col-md-4 box-meditation">', '<div class="col-md-4 box-meditation popular"><div class="box-top">Популярное</div>', $value->str);
    }
    $i++;
    echo $value->str;
}
?>
</div>