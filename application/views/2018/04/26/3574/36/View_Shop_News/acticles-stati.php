<div class="row">
<?php
$n = 3;
$i = 0;
foreach ($data['view::View_Shop_New\acticles-stati']->childs as $value){
	if ($i == 0){
		$i++;
		continue;
	}
		
    if($i == $n + 1){
        echo '</div><div class="row">';
        $i = 1;
    }
    $i++;
    echo $value->str;
}
?>
</div>