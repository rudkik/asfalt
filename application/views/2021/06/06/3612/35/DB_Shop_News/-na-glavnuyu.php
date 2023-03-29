<div class="content__container row">
<?php
$n = 4;
$i = 1;
foreach ($data['view::DB_Shop_New\-na-glavnuyu']->childs as $value){
    if($i == $n + 1){
        echo '</div><div class="content__container row">';
        $i = 1;
    }
    $i += intval(Arr::path($value->values['options'], 'column', 1));
    echo $value->str;
}
?>
</div>