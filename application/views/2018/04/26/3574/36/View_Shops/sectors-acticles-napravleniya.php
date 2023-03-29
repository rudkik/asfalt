<div class="sectors-4">
	<div class="sectors-2">
<?php
$n = 4;
$i = 1;
foreach ($data['view::View_Shop\sectors-acticles-napravleniya']->childs as $value){
	if($i == 2 + 1){
        echo '</div><div class="sectors-2">';		
	}
    if($i == $n + 1){
        echo '</div></div><div class="sectors-4"><div class="sectors-2">';
        $i = 1;
    }
    $i++;
    echo $value->str;
}
?>
</div>
</div>