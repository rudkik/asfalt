<div class="col-md-3">
	<ul class="box-menu">
		<?php
		$n = ceil(count($data['view::View_Shop_Good\basic\rubriki-v-snizu']->childs) / 3);
		$i = 1;
		foreach ($data['view::View_Shop_Good\basic\rubriki-v-snizu']->childs as $value){
			if($i == $n + 1){
				echo '</ul></div><div class="col-md-3"><ul class="box-menu">';
				$i = 1;
			}
			$i++;
			echo $value->str;
		}
		?>
		</ul>
</div>